<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Apikeys;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class ApiKeyController extends Controller
{
    //

    public function index(Request $request){

        $user_id = Utils::getUser($request);
       // Log::error($user_id);
        if ($user_id){
            try{
                $keys = ApiKeys::where('user_id', $user_id)->get();
                //$keys = ApiKeys::all();

                foreach ($keys as $key){
                    $status = $key->status;
                    switch ($status){
                        case 1:
                            $key->status = "Active";
                            break;
                        case 2:
                            $key->status = "Not Active";
                            break;
                        default:
                            $key->status = "Status not set";

                    }
                }
                return response()->json(['success'=>true, "code"=>200, 'data'=>$keys]);
            }
            catch(ModelNotFoundException $exception){
                //Log::error($exception);
            }

        }
    }
    public function getKey(Request $request){
       // Log::error($request);
        $validator = Validator::make($request->all(), [
            'token_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            //Log::error($validator->errors()->all());
            $errors = $validator->errors()->all();
            Log::error($errors);
           return response()->json(['success'=>true,"errors"=>$errors]);
        }
        else{
            try{
                $user_id = Utils::getUser($request);
                $request = $request->all();

                if($user_id){
                    $token = Str::random(60);
                    $key = Apikeys::create([
                        'api_token' => hash('sha256', $token),
                        'user_id' => $user_id,
                        'token_name' => $request['token_name'],
                    ]);

                    $key->save();

                    return response()->json(['success'=>true, "code"=>200, 'data'=>$token]);
                }
            }
            catch(Throwable $exception){
               // Log::error($exception);
                return response()->json(['success'=>true,"code" => 404, "errors"=>'User does not exist.']);
            }
        }

    }
    public function apiKeyGen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            //Log::error($validator->errors()->all());
            $errors = $validator->errors()->all();

           return response()->json(['success'=>true,"message"=>$errors]);
        }
        else{
            try{
                $request = $request->all();
                $user_id = $request['user_id'];
                $user = User::where('id', $user_id)->firstOrFail();

                if($user){
                    $token = Str::random(60);
                    $key = Apikeys::create([
                        'api_token' => hash('sha256', $token),
                        'user_id' => $user_id,
                        'token_name' => $request['token_name'],
                    ]);

                    $key->save();

                    return response()->json(['success'=>true, "code"=>200, 'data'=>$token]);
                }
            }
            catch(ModelNotFoundException $exception){
               // Log::error($exception);
                return response()->json(['success'=>true,"code" => 500, "errors"=>'User does not exist.']);
            }

        }

    }


}
