<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
       public function showProfile()
    {
         $user= auth()->user();
         $layout = Session::get('role') === 'directeur' ? 'layouts.directeur' : 'layouts.gestionnaire';
               
       return view('profile.index', compact('user','layout'));
    }

     public function edit(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'min:5'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'photo' => ['nullable', 'image'],
            'about' => ['nullable', 'string'],
        ]);
        
        $user = auth()->user();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->about = $validated['about'] ?? null;
    
        if (isset($validated['photo'])) {
            $path = $validated['photo']->store('images', 'public');
            $user->photo = $path;
            Session::put('user_profile',$path);
        }
    
        $user->save();
    
        return response()->json(['message' => 'Profile edited successfully']);
    }


 public function changePassword(Request $request)
    {
         $validated = $request->validate([
        'current_password'      => ['required', 'string', 'min:8'],
        'new_password'          => ['required', 'string', 'min:8', 'confirmed'], // uses new_password_confirmation
        ]);

    $user = auth()->user();

    // Check if current password matches
    if (!Hash::check($validated['current_password'], $user->password)) {
        return response()->json(['error' => 'Current password is incorrect']);
    }

    // Update password with hashing
    $user->password = Hash::make($validated['new_password']);
    $user->save();

    return response()->json(['message' => 'Password changed successfully']);
    }

}