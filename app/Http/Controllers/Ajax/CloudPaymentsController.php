<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CloudPaymentsSubscription;
use App\Models\User;

class CloudPaymentsController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
/*
	public function create(Request $request)
	{
		$data = $request->all();
		
		try {
			if(!$data['user_id'])
				throw new \Exception('Miss user_id attribute');
				
			if(!$data['invoiceId'])
				throw new \Exception('Miss invoiceId attribute');
				
			if(!$data['accountId'])
				throw new \Exception('Miss accountId attribute');
		}catch(\Exception $e){
			return response()->json(["success" => false, 'error' => $e->getMessage()]);
		}
		
		$subscription = CloudPaymentsSubscription::findSubscription((int)$data['user_id']);
		
		CloudPaymentsSubscription::create([
			'cloudpayments_id' => $subscription->Id,
			'invoiceId' => $data['invoiceId'],
			'user_id' => (int)$data['user_id'],
			'amount' => (float)$data['amount'],
			'currency' => $data['currency'],
			'accountId' => $data['accountId'],
			'status' => $subscription->Status,
			'description' => $data['description'],
			'start_at' => \Carbon\Carbon::parse($subscription->StartDateIso),
			'nextTransactionDate' => \Carbon\Carbon::parse($subscription->NextTransactionDateIso),
		]);

		$user = User::findOrFail((int)$data['user_id']);
		$user->assignRole('subscriber');
		
		return response()->json(['success' => true]);
	}
*/

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */	
	public function cancel(Request $request)
	{
		$data = $request->all();
		
		try {
			if(!$data['user_id'])
				throw new \Exception('Miss user_id attribute');
		}catch(\Exception $e){
			return response()->json(["success" => false, 'error' => $e->getMessage()]);
		}
		
		$was_cancelled = CloudPaymentsSubscription::cancelSubscription((int)$data['user_id']);
		
		if($was_cancelled){
			$user = User::findOrFail((int)$data['user_id']);
			$user->removeRole('subscriber');
		}
		
		return response()->json(['success' => true]);
	}

}
