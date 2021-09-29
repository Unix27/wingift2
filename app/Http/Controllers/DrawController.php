<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draw;

//use App\Models\CloudPaymentsSubscription;


class DrawController extends Controller
{
   
    public function show(Request $request, $slug)
    {
        $data = [];

        
        $data['draw'] = Draw::where('slug', $slug)->firstOrFail();

//         $tran = CloudPaymentsSubscription::getTransaction(652442630);

//         dd($tran->Phone);

        
	    return view('draws.show', $data);
    }
}
