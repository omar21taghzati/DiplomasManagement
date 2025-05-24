<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class FilierController extends Controller
{
    public function selectGroups($id){
        $groups=Group::where('filier_id',$id)->get();
        return response()->json(['groups'=>$groups]);
    }

}