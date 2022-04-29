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
Route::group( ['middleware' => 'auth'], function()
{

        //acounts
Route::get('users','UserController@users');
Route::post('new-account','UserController@new_account');
Route::post('delete-account','UserController@delete_account');
Route::post('change-password/{id}','UserController@changepassword');
Route::post('deactivate-user','UserController@deactivate_user');
Route::post('activate-user','UserController@activate_user');
Route::post('edit-user/{id}','UserController@edit_user');



//Dashboard
Route::get('/','HomeController@index' );
Route::get('/home', 'HomeController@index')->name('home');



//Projects
Route::get('projects','ProjectController@project');
Route::post('new-project','ProjectController@new_project');
Route::post('deactivate-project','ProjectController@deactivate_project');
Route::post('activate-project','ProjectController@activate_project');
Route::post('edit-project/{id}','ProjectController@edit_project');


//Request
Route::get('requests','RequestController@requests');
Route::post('new-request','RequestController@new_request');


//for-review
Route::get('for-review','RequestController@for_review');
Route::post('approved-request/{id}','RequestController@approved_request');
Route::post('declined-request/{id}','RequestController@declined_request');


//for-verification
Route::get('for-verification','RequestController@for_verification');


//Companies
Route::get('companies','CompanyController@companies');
Route::post('edit-company/{id}','CompanyController@editCompany');

});
