<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Traffic;

use App\Models\User;
use App\Models\CloudPaymentsSubscription;
use App\Http\Requests\CloudPaymentsRequest;

class CloudPaymentsController extends Controller
{
	
	public function is_subscribed(Request $request){
		$user = User::where('email', $request->email)->first();
		
		if(!$user){

			// $traffic = Traffic::where('clickid',$request->clickid)->first();
	  //       if($traffic && !$traffic->user){

	  //           $curl = curl_init(); 

	  //           curl_setopt_array($curl, array(
	  //               CURLOPT_URL => 'https://your-free-prize.xyz/callback.php?clickid='.$traffic->clickid.'&action=subscribe',
	  //               CURLOPT_RETURNTRANSFER => true,
	  //               CURLOPT_ENCODING => '',
	  //               CURLOPT_MAXREDIRS => 10,
	  //               CURLOPT_TIMEOUT => 0, 
	  //               CURLOPT_FOLLOWLOCATION => true,
	  //               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  //               CURLOPT_CUSTOMREQUEST => 'GET',
	  //           ));

	  //           $response = curl_exec($curl);

	  //           curl_close($curl);
	  //           Log::info('traffic: ' . print_r([$traffic,$response], true));

	  //       }
			return response()->json(['success' => true, 'message' => 'No user in database'], 200);

		}
		
		$subsription = $user->cloudSubscriptions()->activeSubscription()->first();
		
		if(!$subsription)
                        return response()->json(['success' => false, 'error' => 'Аккаунт уже зарегистрирован, но подписка не активна'], 406); 
		
		return response()->json(['success' => false, 'error' => 'Подписка уже оформлена'], 406); 
	}
	
	public function store(CloudPaymentsRequest $request)
	{ 
		if(!$request->validated())
			return response()->json(['success' => false, 'error' => 'no valid']); 
		
/*
		$user = User::where('email', $request->input('accountId'))->first();
		
		if(!$user)
			$user = User::create([
				'email' => $request->input('accountId'),
			]);	
			
		CloudPaymentsSubscription::create([
			'cloudpayments_id' => $request->input('cloudpayments_id'),
			'invoiceId' => $request->input('invoiceId'),
			'user_id' => $user->id,
			'amount' => $request->input('amount'),
			'currency' => $request->input('currency'),
			'accountId' => $request->input('accountId'),
			'status' => $request->input('status'),
			'description' => $request->input('description'),
			'start_at' => \Carbon\Carbon::parse($request->input('start_at')),
			'nextTransactionDate' => \Carbon\Carbon::parse($request->input('nextTransactionDate')),			
		]);
*/
		return response()->json(['success' => 'DA']);
	}
}
