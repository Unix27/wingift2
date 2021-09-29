<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', [
            'subscription_amount_rub' => config('cloud-payments.subscription_amount_rub'),
            'subscription_free_days' => ((int)config('cloud-payments.start_date_add_seconds')) / (60*60*24),
            'subscription_days' => ((int)config('cloud-payments.subscription_days')) ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }

    public function import(){
        $file = asset('storage/token.csv');
        $file_handle = fopen($file, 'r');
        $filterRows = [];
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, ';');
            // return $line_of_text[0][;
        }
        fclose($file_handle);
        foreach($line_of_text as $row){
            $filterRows[$row[1]][] = $row;
        }

        

        foreach($filterRows as $key => $row){
            if($key == 'AccountId'){
                continue;
            } else{
                $user = User::where('email', '=', $row[0][1])->first();
                if($user){
                // return $user;
                    continue;
                } else{
                    $new_user = new User();
                    $new_user->email = $row[0][1];
                    $new_user->name = $row[0][1];
                    $new_user->card_token = $row[0][0];
                    $new_user->is_new = true;
                    // $new_user->use_subscription = true;
                    $new_user->password = bcrypt($row[0][1]);
                    $new_user->save();

                    $subscription = new CloudPaymentsSubscription();
                    $subscription->user_id = $new_user->id;
                    $subscription->currency = 'RUB';
                    $subscription->status = 'Failed';
                    $subscription->start_at = Carbon::now()->addDays(3);
                    $subscription->cloudpayments_id = $row[0][0];
                    $subscription->amount = 625;
                    $subscription->save();
                }
            }
        }


        return $filterRows;

        
    }
}
