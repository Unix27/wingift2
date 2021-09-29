<?php

use Illuminate\Support\Facades\Route;
use App\Models\Traffic;

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

    if(\Auth::user())
        return redirect(url('/account'));

    return view('welcome');
});





Route::get('/cancelsubscription', function () {

    if(\Auth::user())
        return redirect(url('/account/subscription'));

    return redirect(url('/login'));
});


Route::get('/privacy', function () {
    return view('static/privacy');
});


Route::get('/terms', function () {
    return view('static/terms');
});

Route::get('/offer', function () {
    return view('static/offer');
});


Route::get('/help', function () {
    return view('static/help');
});




Route::post('/', 'App\Http\Controllers\CloudPaymentsController@cloudCurl');

Route::get('/courses/{theme?}', 'App\Http\Controllers\CourseController@index')->name('courses');
Route::get('/courses/{theme}/{slug}', 'App\Http\Controllers\CourseController@show')->middleware('course.check')->name('course');

Route::get('/draws/{slug}', 'App\Http\Controllers\DrawController@show')->middleware('draw.check')->name('draw');

Route::get('/land/{slug}', 'App\Http\Controllers\LandController@show')->middleware('land.check')->name('land');


Route::get('/account', 'App\Http\Controllers\AccountController@settings')->middleware('logged.check')->name('account');
Route::get('/account/subscription', 'App\Http\Controllers\AccountController@settingsSubscription')->middleware('logged.check')->name('account.settings.subscription');
Route::get('/account/course-list', 'App\Http\Controllers\AccountController@courseList')->middleware('logged.check')->name('account.course.list');
Route::get('/account/draw-list', 'App\Http\Controllers\AccountController@drawList')->middleware('logged.check')->name('account.draw.list');

Route::post('/account/update', 'App\Http\Controllers\AccountController@update')->middleware('logged.check')->name('account.update');
Route::post('/account/subscription', 'App\Http\Controllers\CloudPaymentsController@toggleSubscription')->middleware('logged.check')->name('account.subscription');


Route::get('/account/courses/{theme?}', 'App\Http\Controllers\AccountController@courseList')->middleware('logged.check')->name('account.course.list2');


Route::get('/payexpiredsubscription', 'App\Http\Controllers\CloudPaymentsController@payExpired')->name('payexpiredsubscription');
Route::get('/payexpiredsubscription2', 'App\Http\Controllers\CloudPaymentsController@payExpired2')->name('payexpiredsubscription2');


Route::post('/account/password-reset', 'App\Http\Controllers\AccountController@passwordReset');

Route::get('change-password', function() {
	\Auth::logout();

	return redirect(route('password.request'));
});

Route::get('/logout', function(){
	\Auth::logout();

	return redirect(url('/'));
});

Route::post('/feedback/send', 'App\Http\Controllers\Admin\FeedbackCrudController@create');

// AJAX ROUTES WITHOUT LOCATION SEGMENT
Route::group(['prefix' => 'ajax'], function ($router) {
	// CloudPayments
	Route::post('subscription/cancel', 'App\Http\Controllers\Ajax\CloudPaymentsController@cancel');
}); 

// CLOUD PAYMENT CALLBACKS
Route::group(['prefix' => 'callback'], function(){
    // Route::get('test-payment', 'App\Http\Controllers\CloudPaymentsController@test');
	Route::post('payed', 'App\Http\Controllers\CloudPaymentsController@payed');
	Route::post('fail', 'App\Http\Controllers\CloudPaymentsController@fail');
	// Route::post('recurrent', 'App\Http\Controllers\CloudPaymentsController@recurrent');
});


use App\Models\CloudPaymentsSubscription;
use App\Models\User;
// Route::get('test33', function () {
//     $payments = CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Failed')->get();
//         // $payment = CloudPaymentsSubscription::select('accountId')->get();
//     dd($payments->count());

//     foreach($payments as $payment){
//        if($payment) {
//             $data = [
//                 'token' => $payment->cloudpayments_id,
//                 'email' => $payment->accountId,
//                 'accountid' => $payment->accountId,
//                 'Description' => 'Оформление подписки на сайте https://wingifts.net',
//                 'amount' => (float)config('cloud-payments.subscription_amount_rub'),
//                 // 'amount' => 1,
//                 'currency' => 'RUB',
//             ];



//             $curl = curl_init();

//             curl_setopt_array($curl, array(
//               CURLOPT_URL => 'https://api.cloudpayments.ru/payments/tokens/charge',
//               CURLOPT_RETURNTRANSFER => true,
//               CURLOPT_ENCODING => '',
//               CURLOPT_MAXREDIRS => 10,
//               CURLOPT_TIMEOUT => 0,
//               CURLOPT_FOLLOWLOCATION => true,
//               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//               CURLOPT_CUSTOMREQUEST => 'POST',
//                 CURLOPT_POSTFIELDS => json_encode($data),
//               CURLOPT_HTTPHEADER => array(
//                 'Authorization: Basic cGtfMzFkZDAxM2JkNDRhM2ZkZWM4ODM0MzJkOTNiMTI6NTJhNzlkMWI5YTVlZTNlMTVkNjFhNTE5ZDE0OWFhNzY=',
//                 'Content-Type: application/json'
//               ),
//             ));

         

//             $result = curl_exec($curl);
//             curl_close($curl);


//             $result = json_decode($result,true);
//             $user = User::where('email',$payment->accountId)->first();
         
//             $traffic = Traffic::where('us_id',$user->id)->first();
//             $uniq = uniqid();

//             if (isset($result['Model']['Status']) && $result['Model']['Status'] == 'Completed') {
//                 dump(1);

//                 $user->history()->create([
//                     'user_id' => $user->id,
//                     'action' => 'renewed'
//                 ]);

//                 $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(15);
//                 $payment->status = 'Active';
//                 $payment->save();

                

//                 if($traffic) {
//                     $curl = curl_init();
//                     curl_setopt_array($curl, array(
//                         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=2&actionid='.$uniq,
//                         CURLOPT_RETURNTRANSFER => true,
//                         CURLOPT_ENCODING => '',
//                         CURLOPT_MAXREDIRS => 10,
//                         CURLOPT_TIMEOUT => 0,
//                         CURLOPT_FOLLOWLOCATION => true,
//                         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                         CURLOPT_CUSTOMREQUEST => 'GET',
//                     ));

//                     $response = curl_exec($curl);

//                      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
//                     curl_close($curl);
//                      // return 1;

//                 }
              

//             Log::info('cloudPayments success payment: ' . print_r($payment, true));

                
//             } else {
//                 dump(2);

//                 $user->history()->create([
//                     'user_id' => $user->id, 
//                     'action' => 'unrenew'
//                 ]);

//                 $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(6);
//                 $payment->status = 'Failed';
//                 $payment->save();

//                 if($traffic) {
//                     $curl = curl_init();
//                     curl_setopt_array($curl, array(
//                         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=3&actionid='.$uniq,
//                         CURLOPT_RETURNTRANSFER => true,
//                         CURLOPT_ENCODING => '',
//                         CURLOPT_MAXREDIRS => 10,
//                         CURLOPT_TIMEOUT => 0,
//                         CURLOPT_FOLLOWLOCATION => true,
//                         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                         CURLOPT_CUSTOMREQUEST => 'GET',
//                     ));

//                     $response = curl_exec($curl);

//                      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
//                     curl_close($curl);
//                      // return 1;
//                 }

//                 Log::info('cloudPayments failed payment: ' . print_r($payment, true));

//             }


       
 
//             $dataRes = [
//                 'result' => $result,
//                 'payment' => $payment,
//                 'data' => $data
//             ];
//             Log::info('cloudPayments fail payment: ' . print_r($dataRes, true));


           

//             // return response()->json([
//             //     'result' => $result,
//             //     'nextDate' => $payment->nextTransactionDate,
//             // ]);
//         }
//     }
// });

// Route::get('/test22', 'App\Http\Controllers\CloudPaymentsController@chargeToken');



Route::get('/test/test1222', function () {
	dd(1);
	$subscriptions = \App\Models\CloudPaymentsSubscription::where('status','Cancelled')->get();
	dd($subscriptions);
 //    foreach($subscriptions as $subscription){
 //        $subscription->status = 'Active';
 //        $subscription->nextTransactionDate = '2021-07-29 08:26:08';
 //        $subscription->save();
 //    }
 //    dd($subscription);

 //    dd(12);
    // $subscriptions = \App\Models\CloudPaymentsSubscription::where('status','Failed')->get();
    // foreach($subscriptions as $subscription){
    //     $subscription->status = 'Active';
    //     $subscription->nextTransactionDate = '2021-07-29 08:26:08';
    //     $subscription->save();
    // }
    // dd($subscription);
    // dd(1);
//    $file = asset('storage/token.csv');
    $file = asset('remove.csv'); 

    $file_handle = fopen($file, 'r');

    $filterRows = [];
    while (!feof($file_handle)) {
        $line_of_text[] = fgetcsv($file_handle, 0, ';');
        // return $line_of_text[0][;
    }
    fclose($file_handle);

    foreach($line_of_text as $row){
        
       $subscription = \App\Models\CloudPaymentsSubscription::where('accountId',$row[0])->first();
       if($subscription){
       $subscription->status = 'Cancelled';
       $subscription->save();
       }
    }
    dd(1);


    foreach($filterRows as $key => $row){
        if($key == 'AccountId'){
            $subscription = \App\Models\CloudPaymentsSubscription::where('accountId',$row[0])->first();
            dd($subscription);
            continue;
        } else{

            $user =  \App\Models\User::where('email', '=', $row[0][1])->first();
            if($user){
                // return $user;
                continue;
            } else{
                $new_user = new  \App\Models\User();
                $new_user->email = $row[0][1];
                $new_user->name = $row[0][1];
                $new_user->card_token = $row[0][0];
                $new_user->is_new = true;
                // $new_user->use_subscription = true;
                $new_user->password = bcrypt($row[0][1]);
                $new_user->save();

                $subscription = new \App\Models\CloudPaymentsSubscription();
                $subscription->user_id = $new_user->id;
                $subscription->currency = 'RUB';
                $subscription->accountId =  $row[0][1];
                $subscription->status = 'Active';
                $subscription->start_at = \Carbon\Carbon::now();
                $subscription->nextTransactionDate = \Carbon\Carbon::now()->addDays(3);
                $subscription->cloudpayments_id = $row[0][0];


                $subscription->amount = 625;
                $subscription->save();
            }
        }
    }


    return $filterRows;




});