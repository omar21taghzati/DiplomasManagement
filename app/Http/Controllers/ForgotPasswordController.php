<?php 

namespace App\Http\Controllers; 

//use App\Http\Controllers\Controller;

use App\Models\User; 

use Carbon\Carbon; 

use DB; 

use Hash;

use Illuminate\Http\Request; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Mail; 

  

class ForgotPasswordController extends Controller

{

      /**

       * Write code on Method

       *

       * @return response()

       */

      public function showForgetPasswordForm()

      {
              
         return view('auth.forgetPassword');

      }

  

      /**

       * Write code on Method

       *

       * @return response()

       */

      public function submitForgetPasswordForm(Request $request)

      {

          $request->validate([

              'email' => 'required|email|exists:users',

          ]);

  

          $token = Str::random(64);

  

          DB::table('password_reset')->insert([

              'email' => $request->email, 

              'token' => $token, 

              'created_at' => Carbon::now()

            ]);

  

          Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){

              $message->to($request->email);

              $message->subject('Reset Password');

          });
        //   $request->session()->regenerate();
  

          return back()->with('message', 'We have e-mailed your password reset link!');

      }

      /**

       * Write code on Method

       *

       * @return response()

       */

      public function showResetPasswordForm($token) { 

         return view('auth.forgetPasswordLink', ['token' => $token]);

      }

  

      /**

       * Write code on Method

       *

       * @return response()

       */

      public function submitResetPasswordForm(Request $request)

      {

          $request->validate([

              'email' => 'required|email|exists:users',

              'password' => 'required|string|min:8|confirmed',

              'password_confirmation' => 'required'

          ]);

  

          $updatePassword = DB::table('password_reset')

                              ->where([

                                'email' => $request->email, 

                                'token' => $request->token

                              ])

                              ->first();

  

          if(!$updatePassword){

              return back()->withInput()->with('error', 'Invalid token!');

          }

  

          $user = User::where('email', $request->email)

                      ->update(['password' => Hash::make($request->password)]);

 

          DB::table('password_reset')->where(['email'=> $request->email])->delete();

  

          return redirect('/login')->with('message', 'Your password has been changed!');

      }

}