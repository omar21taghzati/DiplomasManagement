<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use App\Models\Diploma;
use App\Models\Filier;
use App\Models\Group;
use App\Models\Secteur;
use App\Models\Stagiaire;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DiplomaController extends Controller
{
   public function index(Request $request)
   {
       $query = Stagiaire::with(['user', 'diploma.certificat', 'group.filier']);
   
       if ($request->filled('cef')) {
           $query->where('CEF', $request->input('cef'));
       }
   
       $stagiaires = $query->paginate(10);
       $layout = Session::get('role') === 'directeur' ? 'layouts.directeur' : 'layouts.gestionnaire';
               
       return view('diplomas.index', compact('stagiaires','layout'));
   }

   
  public function show($stagiaireId)
  {
      $data = Statistic::with('user')
          ->where('stagiaire_id', $stagiaireId)
          ->where('type_cerf', 'diploma')
          ->orderBy('taken_date', 'desc') // assuming 'date_taken' is the column name
          ->first(); // get only the latest one
     
     if (!$data) {
        return response()->json(['message' => 'No diploma statistic found.'], 404);
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
      ]);
  
      // Retrieve stagiaire (direct assginement doesn't need @fillable array in this modal)
      $stagiaire = Stagiaire::with('diploma.certificat')->findOrFail($id);
      $stagiaire->obtainDiplomaDate = $validated['taken_date'];
      $stagiaire->save();
  
      // // Update certificat (direct assginement doesn't need @fillable array in this modal)
      $certificat = $stagiaire->diploma->certificat;
      $certificat->status = 'delivered';
      $certificat->save();
  
      // // Create statistic (mass assginement  need @fillable array in this modal)
    //   Statistic::create([
    //       'stagiaire_id' => $stagiaire->id,
    //       'additional_notes' => $validated['additional_notes'],
    //       'taken_date' => $validated['taken_date'],
    //       'type_cerf' => 'diploma',
    //       'user_id' => session('user_id'),
    //       'certificat_id' => $certificat->id,
    //   ]);
       $statistic = Statistic::where('stagiaire_id', $id)
            ->where('certificat_id', $certificat->id)
            ->where('taken_date', null) // or any other relevant condition
            ->first(); // get only the latest one
            
        if (!$statistic) {
           return response()->json(['message' =>'No statistic found for this stagiaire and certificat.'.$id.' '.$certificat->id]);
        }

        $statistic->taken_date=$validated['taken_date'];
        $statistic->additional_notes=$validated['additional_notes'];
        $statistic->user_id=session('user_id');
        $statistic->save();
  
      return response()->json(['message' => 'Diploma delivered successfully.']);
  }
        

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
  
  
  public function statistics()
  {
    $secteurs = Secteur::get();

    $filiers = Filier::where('secteur_id', 1)->get();
    $groups = collect(); // default empty

    if ($filiers->isNotEmpty()) {
        $groups = Group::where('filier_id', $filiers[0]->id)->get();
    }

    $total = Diploma::count();

    $undelivered = Diploma::whereHas('certificat', function ($query) {
        $query->where('status', 'undelivered');
    })->count();

    $statistics=Statistic::where('type_cerf',"diploma")->paginate(5);
    
    $delivered = $total - $undelivered;
    return view('diplomas.statistics', compact('secteurs', 'filiers', 'groups', 'total', 'undelivered','delivered','statistics'));
  }

}