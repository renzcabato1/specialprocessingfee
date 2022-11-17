<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::group(['middleware' => ['auth']], function () {

        Route::group(['middleware' => ['admin']], function () {
                //acounts
                Route::get('users', 'UserController@users');
                Route::post('new-account', 'UserController@new_account');
                Route::post('delete-account', 'UserController@delete_account');
                Route::post('change-password/{id}', 'UserController@changepassword');
                Route::post('deactivate-user', 'UserController@deactivate_user');
                Route::post('activate-user', 'UserController@activate_user');
                Route::post('edit-user/{id}', 'UserController@edit_user');

                //Projects
                Route::get('projects', 'ProjectController@project');
                Route::post('new-project', 'ProjectController@new_project');
                Route::post('deactivate-project/{id}', 'ProjectController@deactivate_project');
                Route::post('activate-project/{id}', 'ProjectController@activate_project');
                Route::post('edit-project/{id}', 'ProjectController@edit_project');
                //Companies
                Route::get('companies', 'CompanyController@companies');
                Route::post('edit-company/{id}', 'CompanyController@editCompany');
                //Dashboard
                Route::get('/', 'HomeController@index');
                Route::get('/home', 'HomeController@index')->name('home');
        });
        Route::group(['middleware' => ['requestor' || 'financeManager']], function () {
                Route::get('requests', 'RequestController@requests');
                Route::post('new-request', 'RequestController@new_request');
                Route::post('cancel-request/{id}', 'RequestController@cancel_request');
                Route::get('for-payment', 'RequestController@for_payment');
                Route::post('save-payment/{id}', 'RequestController@save_payment');
        });
        Route::group(['middleware' => ['corpSec']], function () {
                //for-review
                Route::get('for-review', 'RequestController@for_review');
                Route::post('reviewed-request/{id}', 'RequestController@reviewed_request');
                Route::post('declined-request/{id}', 'RequestController@declined_request');
        });
        Route::group(['middleware' => ['chairman']], function () {
                //for-verification
                Route::get('for-verification', 'RequestController@for_verification');
                Route::post('approved-request/{id}', 'RequestController@approved_request');
                Route::post('declined-request/{id}', 'RequestController@declined_request');
        });
});

// Route::group(['middleware' => 'admin'], function () {
// });
// Route::group(['middleware' => 'financeManager'], function () {
//Request
// });
// Route::group(['middleware' => 'corpSec'], function () {
// });
// Route::group(['middleware' => 'chairman'], function () {
//for-payment
