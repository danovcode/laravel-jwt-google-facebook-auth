<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use socialaccount;
use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class FbLoginController extends Controller
{
     /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
      

   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
   
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        // dd($user);
        $userSocialAccount = User::where('facebook_id', $user->id)->first();

        if ($userSocialAccount) {

            // assign access token to user
            $token = JWTAuth::fromUser($userSocialAccount);
            $responseMessage = 'Successfully Log in.';
            $responseStatus = 201;
            // return access token & user data
            return response()->json([
                'token' => $token,
                'user'  => $userSocialAccount,
            ]);
        } else {
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'facebook_id'=> $user->id,
                'password' => $user->name
            ]);

            $token = JWTAuth::fromUser($user);
            $newUser = ($user);
            $responseMessage = 'Successfully Registered.';
            $responseStatus = 201;

            // return response
            return response()->json([
                'responseMessage'   => $responseMessage,
                'responseStatus'    => $responseStatus,
                'token' => $token,
                'user' => ($newUser)
            ]);
        }
    }
}
