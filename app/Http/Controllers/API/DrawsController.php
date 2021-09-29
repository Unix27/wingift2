<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Draw;
use App\Http\Resources\DrawCollection;

class DrawsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function paginate(Request $request, $per_page)
    {
        if($request->free)
            $draws = Draw::where('is_person', 0)->where('is_land', 0)->orderBy('is_free', 'desc')->latest();
        else
            $draws = Draw::where('is_person', 0)->where('is_land', 0)->latest();

        $draws = $draws->paginate($per_page);

        return new DrawCollection($draws);
    }

    public function paginatePerson(Request $request, $per_page)
    {
        if($request->free)
            $draws = Draw::where('is_person', 1)->where('is_land', 0)->orderBy('is_free', 'desc')->latest();
        else
            $draws = Draw::where('is_person', 1)->where('is_land', 0)->latest();

        $draws = $draws->paginate($per_page);

        return new DrawCollection($draws);
    }
}
