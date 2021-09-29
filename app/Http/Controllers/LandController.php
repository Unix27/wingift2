<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draw;
use App\Models\Traffic;
use Illuminate\Support\Facades\Log;
use App\Models\User;

//use App\Models\CloudPaymentsSubscription;


class LandController extends Controller
{

    public function show(Request $request, $slug)
    {

        $data = [];
        $input = $request->all();


        $data['draw'] = Draw::where('land_sub', $slug)->firstOrFail();

	    return view('land'.$data['draw']->land_theme.'.index', [
            'paymentPost' => false,
            'paymentSuccess' => null,
	       'draw' => $data['draw'],
            'subscription_amount_rub' => config('cloud-payments.subscription_amount_rub'),
            'subscription_free_days' => ((int)config('cloud-payments.start_date_add_seconds')) / (60*60*24),
            'subscription_days' => ((int)config('cloud-payments.subscription_days')) ]);
    }

    public function showpost(Request $request, $slug)
    {


        if($_POST && isset($_POST['PaRes']) && isset($_POST['MD'])) {
            $data = ['PaRes' =>  $_POST['PaRes'], 'TransactionId' => $_POST['MD']];
            $payload = json_encode($data);

            $ch = curl_init('https://api.cloudpayments.ru/payments/cards/post3ds');
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, "pk_31dd013bd44a3fdec883432d93b12:52a79d1b9a5ee3e15d61a519d149aa76" );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            curl_close($ch);

    //dd($result);
            $paymentSuccess = json_decode($result)->Success;

            Log::info('Last log: ' . print_r([$request->all(),$paymentSuccess], true));

            if($paymentSuccess){
                $input = $request->all();

                if(isset($input['affice_id'])){
                    $traffic = new Traffic();
                    $traffic->action = 'lead';
                    $traffic->clickid = $input['affice_id'];
                    $traffic->save();


                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://offers-wingifts.affise.com/postback?clickid='.$traffic->clickid.'&goal=1',
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

                    Log::info('Traffic subscribe: ' . print_r([$traffic], true));
                }
            }


        }

        // if(isset($input['clickid'])){
        //      $traffic = new Traffic();
        //      $traffic->action = 'lead';
        //      $traffic->clickid = $input['clickid'];
        //      $traffic->save();


        //       $curl = curl_init();

        //         curl_setopt_array($curl, array(
        //             CURLOPT_URL => 'https://your-free-prize.xyz/callback.php?clickid='.$traffic->clickid.'&action=subscribe',
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_ENCODING => '',
        //             CURLOPT_MAXREDIRS => 10,
        //             CURLOPT_TIMEOUT => 0,
        //             CURLOPT_FOLLOWLOCATION => true,
        //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //             CURLOPT_CUSTOMREQUEST => 'GET',
        //         ));

        //         $info = curl_getinfo($curl);
        //         $response = curl_exec($curl);
        //         $error = curl_error($curl);

        //         curl_close($curl);

        //         Log::info('Traffic subscribe: ' . print_r([$traffic], true));
        // }
      



        $data = [];

        $data['draw'] = Draw::where('land_sub', $slug)->firstOrFail();


	return view('land'.$data['draw']->land_theme.'.index', [
            'paymentPost' => true,
            'paymentSuccess' => $paymentSuccess,
	    'draw' => $data['draw'],
            'subscription_amount_rub' => config('cloud-payments.subscription_amount_rub'),
            'subscription_free_days' => ((int)config('cloud-payments.start_date_add_seconds')) / (60*60*24),
            'subscription_days' => ((int)config('cloud-payments.subscription_days')) ]);

    }
}
