<?php

Route::group(['module' => 'Freelancer', 'middleware' => ['web'], 'namespace' => 'App\Modules\Freelancer\Controllers'], function() {

    Route::get('/', function(){
        return redirect('/login');
    });

    // login..
    Route::get('/login', 'FreelancerController@login');
    Route::post('/login', 'FreelancerController@login');

    // register
    Route::get('/register', 'FreelancerController@register');
    Route::post('/register', 'FreelancerController@register');

    // for notifications
    Route::get('/notifications', 'FreelancerController@notifications');

    // check freelancer feedback..
    Route::get('/my-feedback', 'FreelancerController@myFeedback');

    // user profile..
    Route::get('/profile', 'FreelancerController@profile');

    // fetch and display all job posted by employer..
    Route::get('/jobs-listed', 'FreelancerController@jobslisted');

    // all ajax requests..
    Route::post('/freelancer-ajaxHandler', 'FreelancerController@freelancerAjaxHandler');

    // user logout..
    Route::get('/logout', 'FreelancerController@UserLogout');

});
