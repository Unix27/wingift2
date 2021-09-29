<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandController;
use App\Models\CloudPaymentsSubscription;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/cloudPayments/charge', 'App\Http\Controllers\CloudPaymentsController@charge');
Route::post('/cloudPayments/chargeTokens', 'App\Http\Controllers\CloudPaymentsController@chargeToken');



Route::post('/cloudPayments/chargeTokensFailed', 'App\Http\Controllers\CloudPaymentsController@chargeTokenFailed');
Route::post('/cloudPayments/chargeTokensActive', 'App\Http\Controllers\CloudPaymentsController@chargeTokenActive');

Route::post('/cloudPayments/chargeTokensSubscribed', 'App\Http\Controllers\CloudPaymentsController@chargeTokenSubscribed');

// Route::get('/cloudPayments/chargeTokensFailed', 'App\Http\Controllers\CloudPaymentsController@chargeTokenFailed');

// Route::get('/cloudPayments/chargeToken', 'App\Http\Controllers\CloudPaymentsController@chargeToken');

// Route::get('/cloudPayments/chargeToken', function(){
// 	 $payment = CloudPaymentsSubscription::getExpiredSubsriptions();
// 	 dd($payment);
// });

 

Route::apiResource('/cloudPayments', 'App\Http\Controllers\API\CloudPaymentsController')/* ->middleware(['api','cors']) */;
Route::post('/cloudPayments/is_subscribed', 'App\Http\Controllers\API\CloudPaymentsController@is_subscribed');

Route::post('/courses/paginate/{per_page}', 'App\Http\Controllers\API\CoursesController@paginate');

Route::post('/draws/paginate/{per_page}', 'App\Http\Controllers\API\DrawsController@paginate');
Route::post('/drawpersons/paginate/{per_page}', 'App\Http\Controllers\API\DrawsController@paginatePerson');

Route::post('/reviews/paginate/{per_page}', 'App\Http\Controllers\API\ReviewsController@paginate');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/land/{slug}', [LandController::class, 'showpost'])->name('landpost');

