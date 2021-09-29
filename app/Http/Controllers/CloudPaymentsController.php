<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Traffic;
use App\Models\Affice;

use App\Models\CloudPaymentsSubscription;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;

class CloudPaymentsController extends Controller
{
    private $public_id;
    private $api_key;
    private $client;

    public function __construct()
    {
        $this->public_id = config('services.cloud_payments.public_id');
        $this->api_key = config('services.cloud_payments.api_key');

        $this->client = new \AvtoDev\CloudPayments\Client(
            new \GuzzleHttp\Client,
            new \AvtoDev\CloudPayments\Config($this->public_id, $this->api_key)
        );
    }

    public function payed(Request $request)
    {
        Log::info('payed: ' . print_r($request->all(), true));

        $email = $request->Email;
        if (!isset($email) || empty($email))
            $email = $request->AccountId;

        if (!$email)
            throw new \Exception('No Email');

        $user = User::where('email', $email)->first();


        $tran = CloudPaymentsSubscription::getTransaction($request->TransactionId);

        if (!$user)
            $user = $this->createUser($email, $tran->FirstName, $tran->LastName, $tran->Phone, $request->Token);

        if ($request->Amount == config('cloud-payments.verify_amount_rub')) {

            // Saving to DB
            $user->cloudSubscriptions()->create([
                'cloudpayments_id' => $request->Token,
                'invoiceId' => $request->InvoiceId,
                'amount' => (float)config('cloud-payments.subscription_amount_rub'),
                'currency' => config('cloud-payments.subscription_currency_rub'),
                'accountId' => $request->AccountId,
                'status' => 'Subscribed',
                'description' => 'Free 3 days',
                'start_at' => \Carbon\Carbon::now(),
                'nextTransactionDate' => \Carbon\Carbon::now()->addDays(3)
            ]);
            $user->history()->create([
                'user_id' => $user->id,
                'action' => 'subscribed'
            ]);

        }

        $user->assignRole('subscriber');


        if ($request->Amount == config('cloud-payments.verify_amount_rub')) {
            sleep(3);
            // Creating refund transaction of varification payment
            $refund = CloudPaymentsSubscription::createRefund($request->TransactionId, $request->Amount);
        }


        $traffic = Traffic::latest()->first();
        if(!$traffic->user){
            $traffic->us_id = $user->id;
            $traffic->save();
        }

        return response()->json(['code' => 0]);
    }


    public function fail(Request $request)
    {

        Log::info('cloudPayments fail payment: ' . print_r($request->all(), true));

        return response()->json(['code' => 0]);

    }


    private function createUser($email, $firstName, $lastName, $phone, $token)
    {
        $password = Str::random(8);

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $firstName,
            'lastname' => $lastName,
            'phone' => $phone,
            'card_token' => $token
        ]);

        Mail::to($email)->send(new WelcomeMail(['password' => $password, 'login' => $email]));

        return $user;
    }

    public function charge(Request $request)
    {
        $url = 'https://api.cloudpayments.ru/payments/cards/charge';
        $data = [
            'action' => 'sendCryptogram',
            'amount' => 1.00,
            'currency' => 'RUB',
            'PublicID' => $this->public_id,
            'APISecret' => $this->api_key
        ];


        $data = array_merge($data, $request->input());

        $data['Payer'] = [
            'FirstName' => $data['name'],
            'LastName' => $data['lastname'],
            'Phone' => $data['phone']
        ];


        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];

        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];

        $data['name'] = str_replace($cyr, $lat, $data['name'] . ' ' . $data['lastname']);


        $data['JsonData'] = json_encode($data['Payer']);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($this->buildPostFields($data))
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);


    

        return response()->json($result);
    }

    public function buildPostFields($data, $existingKeys = '', &$returnArray = [])
    {
        if (($data instanceof CURLFile) or !(is_array($data) or is_object($data))) {
            $returnArray[$existingKeys] = $data;
            return $returnArray;
        } else {
            foreach ($data as $key => $item) {
                $this->buildPostFields($item, $existingKeys ? $existingKeys . "[$key]" : $key, $returnArray);
            }
            return $returnArray;
        }
    }


    public function cloudCurl(Request $request)
    {
        $params = $request->all();
        if (count($params) && isset($params['PaRes']) && isset($params['MD'])) {
            $data = ['PaRes' => $params['PaRes'], 'TransactionId' => $params['MD']];
            $payload = json_encode($data);

            $ch = curl_init('https://api.cloudpayments.ru/payments/cards/post3ds');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $this->public_id . ":" . $this->api_key);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);

            sleep(5);

            $user = User::where('email', json_decode($result)->Model->Email)->first();

            if ($user) {
                Auth::login($user);
            }
        }

        session()->flash('thanks', true);

        return redirect(url('/'));
    }

    public function toggleSubscription(Request $request)
    {
        $user = \Auth::user();

        if ($user->cloudSubscriptions()->activeSubscription()->first())
            CloudPaymentsSubscription::cancelSubscription($user->id);
        else
            $this->reSubscrube($user);

        return response('success', 200);
    }

    private function reSubscrube($user)
    {
        $active = $user->cloudSubscriptions()->first();

        if ($active->status == 'Active' || $active->status == 'Failed') {
            $active->update([
                'status' => 'Cancelled'
            ]);

            // $user->assignRole('subscriber');
        }else{
        	 $active->update([
                'status' => 'Active'
            ]);
        }
        exit(json_encode($active));

        return;

        $subs = $user->cloudSubscriptions()->first();

        if ($subs) {
                exit(json_encode($this->paySubscription($subs)));

            if ($this->paySubscription($subs)) {
                $user->assignRole('subscriber');
                return;
            }
            throw new \Exception('Cannot activate subscriptions');
        }

        throw new \Exception('Active subscriptions not found');
    }

    public function payExpired(Request $request)
    {
        $subs = CloudPaymentsSubscription::getExpiredSubsriptions();
        $this->paySubscription($subs);
    }

    private function paySubscription($subs)
    {
        if ($subs) {
            $payToken = CloudPaymentsSubscription::payExpired($subs->amount, $subs->currency, $subs->accountId, $subs->cloudpayments_id);

            if ($payToken->Success) {
                $subs->nextTransactionDate = \Carbon\Carbon::now()->addSeconds(((int)config('cloud-payments.subscription_days')) * 60 * 60 * 24);
                $subs->status = 'Active';
                $subs->update();

                return true;
            } else {
                $subs->nextTransactionDate = \Carbon\Carbon::now()->addSeconds(((int)config('cloud-payments.subscription_retry_days')) * 60 * 60 * 24);
                $subs->status = 'Failed';
                $subs->update();

                return false;
            }

            //dd($payToken);
        } else {
            dd("not expired subscription");
        }
    }


    public function payExpired2(Request $request)
    {
//            $payToken = CloudPaymentsSubscription::getTokens2('pk_44e5bb5c25c802f9dcb57f9e48b4e', '5226c78433e95b954c1b3ffde7e6f6c7');
//            $payToken = CloudPaymentsSubscription::getTokens2('pk_31dd013bd44a3fdec883432d93b12', '52a79d1b9a5ee3e15d61a519d149aa76');

            $payToken = CloudPaymentsSubscription::payExpired2('pk_44e5bb5c25c802f9dcb57f9e48b4e', '5226c78433e95b954c1b3ffde7e6f6c7', 312.50, 'RUB', 'tonigoryachev990@gmail.com', '745878056');
            dd($payToken);
    }

 public function chargeToken(Request $request){
        $payment = CloudPaymentsSubscription::getExpiredSubsriptions();


        // $payment = CloudPaymentsSubscription::select('accountId')->get();
        // return 1;

        if($payment) {
            $data = [
                'token' => $payment->cloudpayments_id,
                'email' => $payment->accountId,
                'accountid' => $payment->accountId,
                'Description' => 'Оформление подписки на сайте https://wingifts.net',
                'amount' => (float)config('cloud-payments.subscription_amount_rub'),
                // 'amount' => 1,
                'currency' => 'RUB',
            ];



            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.cloudpayments.ru/payments/tokens/charge',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cGtfMzFkZDAxM2JkNDRhM2ZkZWM4ODM0MzJkOTNiMTI6NTJhNzlkMWI5YTVlZTNlMTVkNjFhNTE5ZDE0OWFhNzY=',
                'Content-Type: application/json'
              ),
            ));

         

            $result = curl_exec($curl);
            curl_close($curl);


            $result = json_decode($result,true);
         

            if (isset($result['Model']['Status']) && $result['Model']['Status'] == 'Completed') {
                $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(15);
                $payment->status = 'Active';
                $payment->save();

                 $user = User::where('email',$payment->accountId)->first();
                // $user = User::find(4945);
                $traffic = Traffic::where('us_id',$user->id)->first();
                if($traffic) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://your-free-prize.xyz/callback.php?clickid=' . $traffic->clickid . '&action=rebil',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                     Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                    curl_close($curl);
                     // return 1;

                }
                $affice = Affice::where('us_id',$user->id)->first();
                if($affice) {
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://your-free-prize.xyz/callback.php?affice_id=' . $affice->affice_id . '&action=rebil',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);   

                     Log::info('affice rebil: ' . print_r([$affice,$response], true));
                    curl_close($curl);
                     // return 1;

                }

            Log::info('cloudPayments success payment: ' . print_r($payment, true));

                
            } else {
                $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(6);
                $payment->status = 'Failed';
                $payment->save();

                Log::info('cloudPayments failed payment: ' . print_r($payment, true));

            }


       
 
            $dataRes = [
                'result' => $result,
                'payment' => $payment,
                'data' => $data
            ];
            Log::info('cloudPayments fail payment: ' . print_r($dataRes, true));


           

            return response()->json([
                'result' => $result,
                'nextDate' => $payment->nextTransactionDate,
            ]);
        }
    }


    public function test(){

        $traffic = Traffic::latest()->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => ' https://your-free-prize.xyz/callback.php?clickid='.$traffic->clickid.'&action=subscribe',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $info = curl_getinfo($curl);
        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        exit(json_encode([
            'post' => $_POST,
            'info' => $info,
            'response' => $response,
            'error' => $err
        ]));
    }

 
       public function chargeTokenFailed(Request $request){
         $payments = CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Failed')->orderBy('nextTransactionDate','asc')->take(10)->get();
        // $payment = CloudPaymentsSubscription::select('accountId')->get();
        if($payments){
            foreach($payments as $payment){
               if($payment) {
                    $data = [
                        'token' => $payment->cloudpayments_id,
                        'email' => $payment->accountId,
                        'accountid' => $payment->accountId,
                        'Description' => 'Оформление подписки на сайте https://wingifts.net',
                        'amount' => (float)config('cloud-payments.subscription_amount_rub'),
                        // 'amount' => 1,
                        'currency' => 'RUB',
                    ];



                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.cloudpayments.ru/payments/tokens/charge',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($data),
                      CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic cGtfMzFkZDAxM2JkNDRhM2ZkZWM4ODM0MzJkOTNiMTI6NTJhNzlkMWI5YTVlZTNlMTVkNjFhNTE5ZDE0OWFhNzY=',
                        'Content-Type: application/json'
                      ),
                    ));

                 

                    $result = curl_exec($curl);
                    curl_close($curl);


                    $result = json_decode($result,true);
                    $user = User::where('email',$payment->accountId)->first();
                 
                    // $traffic = Traffic::where('us_id',$user->id)->first();
                    $uniq = uniqid();

                    if (isset($result['Model']['Status']) && $result['Model']['Status'] == 'Completed') {

                        // if($user->history){
                        //     $user->history()->create([
                        //         'user_id' => $user->id,
                        //         'action' => 'renewed'
                        //     ]);
                        // }

                        $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(15);
                        $payment->status = 'Active';
                        $payment->save();

                        

                        // if($traffic) {
                        //     $curl = curl_init();
                        //     curl_setopt_array($curl, array(
                        //         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=2&actionid='.$uniq,
                        //         CURLOPT_RETURNTRANSFER => true,
                        //         CURLOPT_ENCODING => '',
                        //         CURLOPT_MAXREDIRS => 10,
                        //         CURLOPT_TIMEOUT => 0,
                        //         CURLOPT_FOLLOWLOCATION => true,
                        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //         CURLOPT_CUSTOMREQUEST => 'GET',
                        //     ));

                        //     $response = curl_exec($curl);

                        //      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                        //     curl_close($curl);
                        //      // return 1;

                        // }
                      

                    Log::info('cloudPayments success payment: ' . print_r($payment, true));

                        
                    } else {

                        // if($user->history){
                        //     $user->history()->create([
                        //         'user_id' => $user->id, 
                        //         'action' => 'unrenew'
                        //     ]);
                        // }

                        $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(6);
                        $payment->status = 'Failed';
                        $payment->save();

                        // if($traffic) {
                        //     $curl = curl_init();
                        //     curl_setopt_array($curl, array(
                        //         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=3&actionid='.$uniq,
                        //         CURLOPT_RETURNTRANSFER => true,
                        //         CURLOPT_ENCODING => '',
                        //         CURLOPT_MAXREDIRS => 10,
                        //         CURLOPT_TIMEOUT => 0,
                        //         CURLOPT_FOLLOWLOCATION => true,
                        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //         CURLOPT_CUSTOMREQUEST => 'GET',
                        //     ));

                        //     $response = curl_exec($curl);

                        //      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                        //     curl_close($curl);
                        //      // return 1;
                        // }

                        Log::info('cloudPayments failed payment: ' . print_r($payment, true));

                    }


               
         
                    $dataRes = [
                        'result' => $result,
                        'payment' => $payment,
                        'data' => $data
                    ];
                    Log::info('cloudPayments fail payment: ' . print_r($dataRes, true));


                    

                    // return response()->json([
                    //     'result' => $result,
                    //     'nextDate' => $payment->nextTransactionDate,
                    // ]);
                }
            }
        }

        return true;

    }

    public function chargeTokenActive(Request $request){
        $payments = CloudPaymentsSubscription::where('nextTransactionDate', '<', \Carbon\Carbon::now())->where('status', '=','Active')->take(10)->get();
        // $payment = CloudPaymentsSubscription::select('accountId')->get();
        if($payments){
            foreach($payments as $payment){
                // $payment = CloudPaymentsSubscription::select('accountId')->get();
               if($payment) {
                    $data = [
                        'token' => $payment->cloudpayments_id,
                        'email' => $payment->accountId,
                        'accountid' => $payment->accountId,
                        'Description' => 'Оформление подписки на сайте https://wingifts.net',
                        'amount' => (float)config('cloud-payments.subscription_amount_rub'),
                        // 'amount' => 1,
                        'currency' => 'RUB',
                    ];



                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.cloudpayments.ru/payments/tokens/charge',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($data),
                      CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic cGtfMzFkZDAxM2JkNDRhM2ZkZWM4ODM0MzJkOTNiMTI6NTJhNzlkMWI5YTVlZTNlMTVkNjFhNTE5ZDE0OWFhNzY=',
                        'Content-Type: application/json'
                      ),
                    ));

                 

                    $result = curl_exec($curl);
                    curl_close($curl);


                    $result = json_decode($result,true);

                    $user = User::where('email',$payment->accountId)->first();

                 
                    $uniq = uniqid();

                    if (isset($result['Model']['Status']) && $result['Model']['Status'] == 'Completed') {


                        // if($user){
                        //     $traffic = Traffic::where('us_id',$user->id)->first();

                            $user->history()->create([
                                'user_id' => $user->id,
                                'action' => 'renewed'
                            ]);
                        // }

                        $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(15);
                        $payment->status = 'Active';
                        $payment->save();

                        // $user = User::find(4945);
                        // if($traffic) {
                        //     $curl = curl_init();
                        //     curl_setopt_array($curl, array(
                        //         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=2&actionid='.$uniq,
                        //         CURLOPT_RETURNTRANSFER => true,
                        //         CURLOPT_ENCODING => '',
                        //         CURLOPT_MAXREDIRS => 10,
                        //         CURLOPT_TIMEOUT => 0,
                        //         CURLOPT_FOLLOWLOCATION => true,
                        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //         CURLOPT_CUSTOMREQUEST => 'GET',
                        //     ));
                        //     $response = curl_exec($curl);

                        //      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                        //     curl_close($curl);
                        //      // return 1;

                        // }

                    Log::info('cloudPayments success payment: ' . print_r($payment, true));

                        
                    } else {

                        if($user){
                            $traffic = Traffic::where('us_id',$user->id)->first();

                            $user->history()->create([
                                'user_id' => $user->id,
                                'action' => 'unrenew'
                            ]);
                        }

                        $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(6);
                        $payment->status = 'Failed';
                        $payment->save();

                        // if($traffic) {
                        //     $curl = curl_init();
                        //     curl_setopt_array($curl, array(
                        //         CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=3&actionid='.$uniq,
                        //         CURLOPT_RETURNTRANSFER => true,
                        //         CURLOPT_ENCODING => '',
                        //         CURLOPT_MAXREDIRS => 10,
                        //         CURLOPT_TIMEOUT => 0,
                        //         CURLOPT_FOLLOWLOCATION => true,
                        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //         CURLOPT_CUSTOMREQUEST => 'GET',
                        //     ));

                        //     $response = curl_exec($curl);

                        //      Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                        //     curl_close($curl);
                        //      // return 1;
                        // }

                        Log::info('cloudPayments failed payment: ' . print_r($payment, true));

                    }


               
         
                    $dataRes = [
                        'result' => $result,
                        'payment' => $payment,
                        'data' => $data
                    ];
                    Log::info('cloudPayments fail payment: ' . print_r($dataRes, true));


                   

                    // return response()->json([
                    //     'result' => $result,
                    //     'nextDate' => $payment->nextTransactionDate,
                    // ]);
                }
            }
        }


        return true;
    }

    public function chargeTokenSubscribed(Request $request){
        $payment = CloudPaymentsSubscription::getExpiredSubsriptionsSubscribed();
        // $payment = CloudPaymentsSubscription::select('accountId')->get();

       if($payment) {
            $data = [
                'token' => $payment->cloudpayments_id,
                'email' => $payment->accountId,
                'accountid' => $payment->accountId,
                'Description' => 'Оформление подписки на сайте https://wingifts.net',
                'amount' => (float)config('cloud-payments.subscription_amount_rub'),
                // 'amount' => 1,
                'currency' => 'RUB',
            ];



            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.cloudpayments.ru/payments/tokens/charge',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cGtfMzFkZDAxM2JkNDRhM2ZkZWM4ODM0MzJkOTNiMTI6NTJhNzlkMWI5YTVlZTNlMTVkNjFhNTE5ZDE0OWFhNzY=',
                'Content-Type: application/json'
              ),
            ));

         

            $result = curl_exec($curl);
            curl_close($curl);


            $user = User::where('email',$payment->accountId)->first();

           
            $traffic = Traffic::where('us_id',$user->id)->first();
            $uniq = uniqid();

            $result = json_decode($result,true);

            if (isset($result['Model']['Status']) && $result['Model']['Status'] == 'Completed') {

                $user->history()->create([
                    'user_id' => $user->id,
                    'action' => 'renewed'
                ]);

                $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(15);
                $payment->status = 'Active';
                $payment->save();

                // $user = User::find(4945);
                if($traffic) {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=2&actionid='.$uniq,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                     Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                    curl_close($curl);
                     // return 1;

                }

            Log::info('cloudPayments success payment: ' . print_r($payment, true));

                
            } else {

                $user->history()->create([
                    'user_id' => $user->id,
                    'action' => 'unrenew'
                ]);

                $payment->nextTransactionDate = \Carbon\Carbon::now()->addDays(6);
                $payment->status = 'Failed';
                $payment->save();

                Log::info('cloudPayments failed payment: ' . print_r($payment, true));

                if($traffic) {
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=2&actionid='.$uniq,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                    ));

                    $response = curl_exec($curl);

                     Log::info('traffic rebil: ' . print_r([$traffic,$response], true));
                    curl_close($curl);
                     // return 1;
                }

            }


       
 
            $dataRes = [
                'result' => $result,
                'payment' => $payment,
                'data' => $data
            ];
            Log::info('cloudPayments fail payment: ' . print_r($dataRes, true));


           

            return response()->json([
                'result' => $result,
                'nextDate' => $payment->nextTransactionDate,
            ]);
        }
    }




}
