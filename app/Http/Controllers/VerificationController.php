<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use JWTAuth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Show the email verification notice.
     *
     */
    public function show()
    {
        //
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        try {
        $user = request()->token ? JWTAuth::parseToken()->authenticate() : request()->user() ? JWTAuth::parseToken()->authenticate() :'';

        if ($request->route('id') == $user->getKey() && $user->markEmailAsVerified()) {
            
            event(new Verified($user));

        }
        return response()->json([
            'success' => true,
            'message' => 'E-mail verificado com sucesso!',
            'user' =>$user
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao verificar e-mail!',
                'user' =>$user
            ]);
        }
        
//        return redirect($this->redirectPath());
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->hasVerifiedEmail()) {
            return response()->json(['success' => false,'message' =>'Este e-mail já foi verificado']);
//            return redirect($this->redirectPath());
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['success' => true,'message' =>'Foi reenviado o link para confirmação']);
//        return back()->with('resent', true);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
      //  $this->middleware('signed')->only('verify');
       // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
