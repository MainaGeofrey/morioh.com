<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Tokens;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;


class AuthenticatedSessionController extends Controller
{


    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request = $request['_value'];
        //cast array to object
       // $request = (object)$request;

        $user = User::where(['email' => $request['email']])->first();
       // Log::error($user);
        // dd($user);
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        /*if ($user->last_login_at == null and Carbon::now()->subDays(30) > $user->created_at) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or not active or account is dormant comeeepletely' . $user->created_at . "|" . Carbon::now()->subDays(30)]
            ]);
        }
        if (($user->last_login_at != null and $user->last_login_at < Carbon::now()->subDays(30))) {
            //($user->last_login_at ==null and $user-> created_at > Carbon::now()->subDays(30) ) ){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect or not active or account is dormant completely']
            ]);
        }*/

        //$request = (array)($request);
        if (!Auth::attempt($request)) {
          ///  return response()->json([
          //   'message' => 'Login information is invalid.'
         //  ], 401);
           throw ValidationException::withMessages([
            'email' => ['Login information is invalid']
        ]);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
             $token = $user->createToken('authToken')->plainTextToken;

         return response()->json([
         'access_token' => $token,
         'token_type' => 'Bearer',
         ]);


    }

    /**
     * Handle an incoming api authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Verifies user token.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function apiVerifyToken(Request $request)
    {
      Auth::guard('api')->check();

        $user = User::where('api_token', $request->token)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'token' => ['Invalid token']
            ]);
        }
        return response($user);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
