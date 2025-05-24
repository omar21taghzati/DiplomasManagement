<?php

namespace App\Http\Controllers;

use App\Models\Bac;
use App\Models\Filier;
use App\Models\Group;
use App\Models\Secteur;
use App\Models\Stagiaire;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BacController extends Controller
{
     public function index(Request $request)
   {
       $query = Stagiaire::with(['user', 'bac.certificat', 'group.filier']);
   
       if ($request->filled('cef')) {
           $query->where('CEF', $request->input('cef'));
       }
   
       $stagiaires = $query->paginate(10);
       $layout = Session::get('role') === 'directeur' ? 'layouts.directeur' : 'layouts.gestionnaire';
               
       return view('bacs.index', compact('stagiaires','layout'));
   }

    public function show($stagiaireId)
    {
        $data = Statistic::with('stagiaire.bac.certificat','user')
            ->where('stagiaire_id', $stagiaireId)
            ->where('type_cerf', 'bac')
            ->orderBy('taken_date', 'desc') // assuming 'date_taken' is the column name
            ->first(); // get only the latest one
       
       if (!$data) {
          return response()->json(['message' => 'No bac statistic found.'], 404);
        }
         return $data;
    
    }

  public function deliver(Request $request, $id)
  {
      if (!session()->has('user_id')) {
          return redirect()->route('login')->withErrors(['error' => 'you must register before deliver a diploma .']);
      }
      
      $validated = $request->validate([
          'taken_date' => ['required', 'date', 'before_or_equal:today'],
          'additional_notes' => ['nullable', 'string', 'max:255'],
          'taking_duration' => ['nullable','required_if:status,reserved', 'integer', 'max:30'],
          'status' => ['required', 'in:delivered,reserved'],
      ]);

      $stagiaire = Stagiaire::with('bac.certificat')->findOrFail($id);
     
      // // Update certificat (direct assginement doesn't need @fillable array in this modal)
      $certificat = $stagiaire->bac->certificat;
      $certificat->status = $validated['status'];
      $certificat->save();
  
      // // Create statistic (mass assginement  need @fillable array in this modal)
      Statistic::create([
          'stagiaire_id' => $stagiaire->id,
          'additional_notes' => $validated['additional_notes'],
          'taken_date' => $validated['taken_date'],
          'type_cerf' => 'bac',
          'user_id' => session('user_id'),
          'certificat_id' => $certificat->id,
          'taking_duration'=>$validated['taking_duration'],
      ]);
  
      return response()->json(['message' => 'Bac successfully marked as ' . $validated['status'] . '.']);


  }

    //download certificat image from url that is stored in database
    public function download($id)
    {
        $stagiaire = Stagiaire::with('diploma.certificat')->findOrFail($id);
        $certificat = $stagiaire->diploma->certificat;
    
        // Generate a new URL with PNG format and size
        $imageUrl = str_replace('/svg?', '/png?', $certificat->image) . '&size=2000';
        
        //disables SSL certificate verification (✅ works in local dev, ❌ not for production).
        //$response will hold the downloaded image content (or an error).
        $response = Http::withOptions(['verify' => false])->get($imageUrl);
    
        if (!$response->successful()) {
            abort(404, 'Certificate image not found.');
        }
    
        //Uses the stagiaire’s user name, slugified (spaces and special chars replaced with -)
        $filename = 'certificat_' . Str::slug($stagiaire->user->name) . '.png';
    
        return response($response->body(), 200, [
            'Content-Type' => 'image/png',//tells the browser this is a PNG image
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',// forces the download prompt in the browser with the given file name
        ]);
    }


      public function return(Request $request, $id)
  {
      if (!session()->has('user_id')) {
          return redirect()->route('login')->withErrors(['error' => 'you must register before deliver a diploma .']);
      }
      
      $validated = $request->validate([
          'return_date' => ['required', 'date', 'before_or_equal:today'],
          'additional_notes' => ['nullable', 'string', 'max:255'],
      ]);

      $stagiaire = Stagiaire::with('bac.certificat')->findOrFail($id);
     
      // // Update certificat (direct assginement doesn't need @fillable array in this modal)
      $certificat = $stagiaire->bac->certificat;
      $certificat->status = 'undelivered';
      $certificat->save();
  

       $statistic = Statistic::where('stagiaire_id', $id)
            ->where('certificat_id', $certificat->id)
            ->where('return_date', null) // or any other relevant condition
            ->orderBy('taken_date', 'desc') // assuming 'date_taken' is the column name
            ->first(); // get only the latest one
            
        if (!$statistic) {
           return response()->json(['message' =>'No statistic found for this stagiaire and certificat.'.$id.' '.$certificat->id]);
        }

        $statistic->return_date=$validated['return_date'];
        $statistic->additional_notes=$validated['additional_notes'];
        $statistic->user_id=session('user_id');
        $statistic->save();
    
      return response()->json(['message' => '123456']);
 
   }

    public function statistics()
  {
    $secteurs = Secteur::get();

    $filiers = Filier::where('secteur_id', 1)->get();
    $groups = collect(); // default empty

    if ($filiers->isNotEmpty()) {
        $groups = Group::where('filier_id', $filiers[0]->id)->get();
    }

    $total = Bac::count();

    $undelivered = Bac::whereHas('certificat', function ($query) {
        $query->where('status', 'undelivered');
    })->count();

    $reserved=Bac::whereHas('certificat',function($q){
        $q->where('status','reserved');
    })->count();
    
    $statistics=Statistic::where('type_cerf',"bac")->paginate(5);
    
    $delivered = $total - ($undelivered+$reserved);
    return view('bacs.statistics', compact('secteurs', 'filiers', 'groups', 'total', 'undelivered','delivered','reserved','statistics'));
  }
}