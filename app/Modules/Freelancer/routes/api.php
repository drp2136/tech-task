<?php

Route::group(['module' => 'Freelancer', 'middleware' => ['api'], 'namespace' => 'App\Modules\Freelancer\Controllers'], function() {

    Route::resource('Freelancer', 'FreelancerController');

});
