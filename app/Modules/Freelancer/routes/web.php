<?php

Route::group(['module' => 'Freelancer', 'middleware' => ['web'], 'namespace' => 'App\Modules\Freelancer\Controllers'], function () {

//    Route::get('/', function(){
//        return redirect('/login');
//    });
    Route::get('/', 'FreelancerController@login');

    // login..
//    Route::get('/login', 'FreelancerController@login');
    Route::post('/login', 'FreelancerController@login');

    // register
//    Route::get('/register', 'FreelancerController@register');
    Route::post('/register', 'FreelancerController@register');

    // user logout..
    Route::get('/logout', 'FreelancerController@UserLogout');

    Route::group(['middleware' => 'checkSession'], function () {

        // for notifications
        Route::get('/notifications', 'FreelancerController@notifications');

        // check freelancer feedback..
        Route::get('/my-feedback', 'FreelancerController@myFeedback');

        // user profile..
        Route::get('/profile', 'FreelancerController@profile');

        // fetch and display all job posted by employer..
        Route::get('/jobs-listed', 'FreelancerController@jobslisted');

        // check the progress of the job assigned to freelancer
        Route::get('/check-progress', 'FreelancerController@checkProgress');

        // for displaying all task for a job..
        Route::get('/check-tasks/{id}', 'FreelancerController@checkTheTasks');

        // all ajax requests..
        Route::post('/freelancer-ajaxHandler', 'FreelancerController@freelancerAjaxHandler');

    });
});
