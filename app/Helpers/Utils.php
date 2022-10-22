<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Utils{

	static public  function getUser($request)
	{
		[$id, $user_token] = explode('|', $request->header('authorization'), 2);
		$token_data = DB::table('personal_access_tokens')->where('token', hash('sha256', $user_token))->first();
		$user_id = $token_data->tokenable_id;

		return $user_id;
	}

    static public  function getApiUser($request)
	{
		//[$id, $user_token] = explode('|', $request->header('authorization'), 2);
        $user_token = $request->bearerToken();
        //dd($user_token);
		$token_data = DB::table('api_keys')->where('api_token', hash('sha256', $user_token))->first();
        //dd($token_data);
		$user_id = $token_data->user_id;

		return $user_id;
	}

}
	?>
