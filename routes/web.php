<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;

use Illuminate\Http\Response;
use App\Http\Controllers\Api\User\ApiKeyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});


Route::post('/login', [AuthenticatedSessionController::class, 'login']);
Route::post('/verify_token', function (Request $request) {
return response([
    'id' => auth()->user()->id,
    "name" =>auth()->user()->name,
    'api_token' =>request()->bearerToken()
    ], Response::HTTP_OK);
})->middleware('auth:sanctum');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('email/verify/{hash}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
Route::get('user', 'AuthenticationController@user')->name('user');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::group(['middleware' => ['auth:sanctum']], function ()   {
    Route::prefix('settings')->group(function () {
        Route::post('key', [ApiKeyController::class, 'getKey'])->name('settings.key');
        Route::post('index', [ApiKeyController::class, 'index'])->name('settings.index');
    });

});
Route::fallback(function (){
	return response()->json([
        'message' => 'Web resource not found!'
],404);
 //return 'API resource not found';
//  abort(404, 'API resource not found');
});

