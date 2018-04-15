<?php

Route::group(['module' => 'Employer', 'middleware' => ['web'], 'namespace' => 'App\Modules\Employer\Controllers'], function () {

    // to pass all route with prefix /employer..
    Route::prefix('employer')->group(function () {

        Route::group(['middleware' => 'checkSession'], function () {
            // after login user profile..
            Route::get('/profile', 'EmployerController@profile');

            // for displaying all jobs..
            Route::get('/my-jobs', 'EmployerController@myJobs');

            // for displaying all task for a job..
            Route::get('/check-tasks/{id}', 'EmployerController@checkTheTasks');

            // for displaying all notifications..
            Route::get('/notifications', 'EmployerController@notifications');

            // give a feedback..
            Route::get('/post-feedback/{id}', 'EmployerController@postFeedback');
            Route::post('/post-feedback/{id}', 'EmployerController@postFeedback');

            // check the bidding details for jobs..
            Route::get('/check-bids/{id}', 'EmployerController@checkBiddetails');

            // all ajax requests
            Route::post('/employer-ajaxHandler', 'EmployerController@employerAjaxHandler');

            // add or upload a job.
            Route::get('/add-a-job', 'EmployerController@createJob');
            Route::post('/add-a-job', 'EmployerController@createJob');

            // user logout..
            Route::get('/logout', 'EmployerController@UserLogout');

        });
    });

});
