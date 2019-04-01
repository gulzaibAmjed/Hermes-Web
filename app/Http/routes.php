<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Routes for website which do not need authentication...
Route::get('/', 'FrontController@index');
Route::get('customer', 'FrontController@customer');
Route::get('manager', 'FrontController@manager');
Route::get('admin', 'FrontController@admin');

// Authentication Routes...
Route::get('logout', function () {
    return redirect('auth/logout');
});

Route::get('auth/login', function () {
    return redirect('/');
});
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::post('auth/check', 'Auth\AuthController@loginCheck');
Route::post('auth/forgot', 'Auth\AuthController@forgot');
Route::post('auth/check/forgot', 'Auth\AuthController@forgotCheck');
Route::post('contact', 'DashboardController@contact');

// Registration Routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::post('check/user', 'Auth\AuthController@checkUser');
Route::get('confirm/{code}', 'Auth\AuthController@confirmAccount');

// Route::get('restaurant','frontController@restaurant')

// Group of routes which need authentication.......
Route::group(['middleware' => 'auth'], function () {
    Route::post('notification/subscription','DashboardController@notificationSubscription');
    Route::get('dashboard', 'DashboardController@index');
    Route::post('search', 'SearchController@search');
    Route::get('search', 'SearchController@search');
    Route::get('customers/all', 'CustomerController@getAll');
    Route::resource('customers', 'CustomerController');
    Route::resource('orders', 'OrderController');
    Route::post('orders/approve', 'OrderController@approve');
    Route::post('orders/reject', 'OrderController@reject');
    Route::post('orders/acceptJob', 'OrderController@acceptJob');
    Route::post('orders/rejectJob', 'OrderController@rejectJob');
    Route::post('orders/changeStatus', 'OrderController@changeStatus');
    Route::post('orders/assignManager', 'OrderController@assignManager');
    Route::post('orders/setPriority', 'OrderController@setPriority');
    Route::post('orders/setDropPriority', 'OrderController@setDropPriority');
    Route::get('getOrderAdminCreate', 'OrderController@getOrderAdminCreate');
    Route::post('cancelStatus', 'OrderController@cancelStatus');
    // Route for profile...
    Route::get('profile', 'DashboardController@getProfile');
    Route::post('profile', 'DashboardController@updateProfile');

    // Routes of admin...
    Route::resource('managers', 'ManagerController');
    Route::post('managers/update', 'ManagerController@update');

    Route::get('startJobView', 'DashboardController@startJobView');
    Route::get('startJob', 'AttendanceController@startJob');
    Route::post('stopJob', 'AttendanceController@stopJob');
    Route::post('streets', 'DashboardController@getStreets');
    //reports routes...
    Route::get('employeeReport', 'DashboardController@employeeReport');

//location routes
    Route::resource('locations', 'LocationController');
    Route::post('locations/update', 'LocationController@update');
    Route::get('bulk/locations', 'LocationController@bulkLocationsView');
    Route::post('bulk/locations', 'LocationController@bulkLocationsUpload');
    Route::get('getManagerLocation', 'LocationController@getManagerLocation');
    Route::post('findLocation', 'LocationController@findLocation');
    Route::post('createSessionVariable', 'DashboardController@createSessionVariable');

    //pricing routes
    Route::get('prices', 'PricingController@index');
    Route::get('prices/{id}', 'PricingController@prices');
    Route::post('updatePrice', 'PricingController@update');
    //Candidates Routes
    Route::get('cus/search', 'CandidateController@index');

    //reports
    Route::post('employeesReport', 'DashboardController@employeesReport');
    Route::get('getOrdersReport', 'DashboardController@getOrdersReport');
    Route::post('postOrdersReport', 'DashboardController@postOrdersReport');
});


//Route for testing email/\..........
Route::get('testmail', function () {
    Mail::send('emails.account_confirmation', ['code' => '5478965478965478'], function ($mail) {
        $mail->from('admin@hermes.com', 'HERMES');
        $mail->to('m.mubasharsheikh@gmail.com', 'Mubashar')->subject('HERMES::Account Confirmation!');
    });
});