<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $data = [];
        
        $data['category'] = $slug? Category::where('slug', $slug)->firstOrFail() : null;
        $data['categories'] = Category::get()->keyBy('id');
        
	    return view('courses.index', $data);
    }
    
    public function show(Request $request, $category_slug, $slug)
    {
        $data = [];

        $category = Category::where('slug', $category_slug)->firstOrFail();
        
        $data['course'] = Course::where('slug', $slug)->firstOrFail();
        
	    return view('courses.show', $data);
    }
}
