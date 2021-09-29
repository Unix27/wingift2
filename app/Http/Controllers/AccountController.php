<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AccountController extends Controller
{
    public function settings(Request $request)
    {
        $user = \Auth::user();

	    return view('account.settings', ['user' => $user]);
    }

    public function settingsSubscription(Request $request)
    {
        $user = \Auth::user();

        return view('account.subscription', ['user' => $user,
            'subscription_amount_rub' => config('cloud-payments.subscription_amount_rub'),
            'subscription_free_days' => ((int)config('cloud-payments.start_date_add_seconds')) / (60*60*24),
            'subscription_days' => ((int)config('cloud-payments.subscription_days')) ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        \Auth::user()->update([
            'name' => $request->name,
            'lastname' => $request->lastname
        ]);

        return redirect(route('account'));
    }

    public function passwordReset(Request $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === 'passwords.throttled')
            return response('Пожалуйста, подождите, прежде чем повторить попытку.');

        return response('На Вашу почту было отправлено письмо для сброса пароля.', 200);
    }

    public function courseList(Request $request, $slug = null)
    {
        $data = [];

        $data['category'] = $slug? Category::where('slug', $slug)->firstOrFail() : null;
        $data['categories'] = Category::get()->keyBy('id');

        return view('account.courses', $data);
    }



    public function courseShow(Request $request, $category_slug, $slug)
    {
        $data = [];

        $category = Category::where('slug', $category_slug)->firstOrFail();

        $data['course'] = Course::where('slug', $slug)->firstOrFail();

        return view('courses.show', $data);
    }

    public function drawList(Request $request, $slug = null)
    {
        return view('account.draws');
    }

}
