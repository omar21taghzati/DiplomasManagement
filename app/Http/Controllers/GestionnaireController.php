<?php

namespace App\Http\Controllers;

use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GestionnaireController extends Controller
{
     public function index()
    {
      
         $query = Stagiaire::with(['user', 'diploma.certificat', 'group.filier']);
   
        $stagiaires = $query->paginate(10);
         
        $layout = Session::get('role') === 'directeur' ? 'layouts.directeur' : 'layouts.gestionnaire';
               
       return view('diplomas.index', compact('stagiaires','layout'));
    }
}