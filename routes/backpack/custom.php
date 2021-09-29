<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::post('subscription/filterSubscribeChangeLabel','SubscriptionCrudController@filterSubscribeChangeLabel');
    
    Route::crud('course', 'CourseCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('file', 'FileCrudController');
    Route::crud('draw', 'DrawCrudController');
    Route::crud('review', 'ReviewCrudController');
    Route::crud('feedback', 'FeedbackCrudController');
    Route::crud('subscription', 'SubscriptionCrudController');
}); // this should be the absolute last line of this file