<?php

namespace App\Http\Controllers;

use App\Models\Filier;
use Illuminate\Http\Request;

class SecteurController extends Controller
{  
    public function selectBranches($id)
    {
        $branches = Filier::where('secteur_id', $id)->get();
        return response()->json(['branches'=>$branches]);
    }
}