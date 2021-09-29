<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class CloudPaymentsSubscription extends Model
{
    use CrudTrait;
    protected $table = 'cloudPaymentsSubscriptions';

    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    protected $dates = ['start_at','nextTransactionDate'];

    private $public_id;
	private $api_key;
	private $client;

    public function clearGlobalScopes()
    {
        static::$globalScopes = [];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(){
	    return $this->belongsTo(User::class);
    }

	public function getIsNewAttribute(){
        return $this->user->is_new;
    }

	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	public static function createRefund($TransactionId, $amount){
		try{
			$response = Http::withBasicAuth(config('services.cloud_payments.public_id'), config('services.cloud_payments.api_key'))
				->post('https://api.cloudpayments.ru/payments/refund', [
				    'TransactionId' => $TransactionId,
				    'Amount' => $amount
			]);
		}catch(\Exception $e) {
		    return $e->getMessage();
		}
	}



	public static function cancelSubscription($user_id){
		$user = User::findOrFail($user_id);

		$user_subscription = $user->cloudSubscriptions()->active()->latest();

		if(!$user_subscription)
			throw new \Exception('Active subscriptions no found');

			$user_subscription->update([
				'status' => 'Cancelled'
			]);

		$user->history()->create([
			'user_id' => $user->id,
			'action' => 'unsubscribed'
		]);

		return true;
	}


	public static function getClient(){
		return new \AvtoDev\CloudPayments\Client(
		    new \GuzzleHttp\Client,
		    new \AvtoDev\CloudPayments\Config(config('services.cloud_payments.public_id'), config('services.cloud_payments.api_key'))
		);
	}

	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
    public function scopeActiveSubscription($query)
    {
		return $query->whereIn('status', ['Active', 'Subscribed']);
	}

    public function scopeFailedSubscription($query)
    {
        return $query->where('status', 'Failed');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['Active', 'Subscribed'])->orWhere(function($q){
	        $q->where('status', 'Cancelled')->where('nextTransactionDate', '>', \Carbon\Carbon::now());
        });
    }

    public static function getExpiredSubsriptions()
    {
        return CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->whereIn('status', ['Active', 'Failed'])->first();
    }

       public static function getExpiredSubsriptionsFailed()
    {
    	return CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Failed')->first();	
    }

    public static function getExpiredSubsriptionsActive()
    {
    	return CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Active')->first();	
    }

    public static function getExpiredSubsriptionsSubscribed()
    {
    	return CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Subscribed')->first();	
    }


    public static function payExpired($Amount, $Currency, $AccountId, $Token)
    {
		$client = self::getClient();

		$request_builder = new \AvtoDev\CloudPayments\Requests\Payments\Tokens\TokensChargeRequestBuilder;

		$request_builder->setAmount($Amount);
		$request_builder->setCurrency($Currency);
		$request_builder->setAccountId($AccountId);
		$request_builder->setToken($Token);

		$request = $request_builder->buildRequest();

		try{
			$response = $client->send($request);
			return json_decode($response->getBody()->getContents());
		}catch(\Exception $e) {
		    return $e->getMessage();
		}
    }



	public static function getTransaction($TransactionId){
		try{
			$response = Http::withBasicAuth(config('services.cloud_payments.public_id'), config('services.cloud_payments.api_key'))
				->post('https://api.cloudpayments.ru/payments/get', [
				    'TransactionId' => $TransactionId
			]);

			$data = json_decode($response->json()["Model"]["JsonData"]);

			return $data;

		}
		catch(\Exception $e) {

		    return $e->getMessage();
		}
	}


	public static function getClient2($publicid, $publickey){
		return new \AvtoDev\CloudPayments\Client(
		    new \GuzzleHttp\Client,
		    new \AvtoDev\CloudPayments\Config($publicid, $publickey)
		);
	}


    public static function payExpired2($publicid, $publickey, $Amount, $Currency, $AccountId, $Token)
    {
		$client = self::getClient2($publicid, $publickey);

		$request_builder = new \AvtoDev\CloudPayments\Requests\Payments\Tokens\TokensChargeRequestBuilder;

		$request_builder->setAmount($Amount);
		$request_builder->setCurrency($Currency);
		$request_builder->setAccountId($AccountId);
		$request_builder->setToken($Token);

		$request = $request_builder->buildRequest();

		try{
			$response = $client->send($request);
			return json_decode($response->getBody()->getContents());
		}catch(\Exception $e) {
		    return $e->getMessage();
		}
    }


    public static function getTokens2($publicid, $publickey)
    {
		try{
			$response = Http::withBasicAuth($publicid, $publickey)
				->post('https://api.cloudpayments.ru/payments/tokens/list');
			return json_decode($response->getBody()->getContents());
		}catch(\Exception $e) {
		    return $e->getMessage();
		}

    }


    //
}
