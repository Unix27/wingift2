<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseCollection;

class CoursesController extends Controller
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
        $category_id = $request->category_id;

        
        if($request->free)
            $courses = Course::orderBy('is_free', 'desc')->latest();
        else
            $courses = Course::latest();

        if($category_id)
            $courses = $courses->where('category_id', $category_id);

        $courses = $courses->paginate($per_page);

        return new CourseCollection($courses);
    }
}
