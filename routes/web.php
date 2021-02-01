<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index');
Route::get('/action', 'HomeController@action');
Route::get('/appointment', 'HomeController@appointment');
Route::get('/you-wsp', 'HomeController@panel');
Route::get('/you-wsp/excel', 'HomeController@excel');
Route::get('/you-wsp/tomorrow', 'HomeController@tomorrow');
Route::get('/you-wsp/training', 'HomeController@training');
Route::get('/medilink', 'HomeController@medilink');

Route::get('/actions', 'ActionController@index');
Route::get('/actions/create', 'ActionController@create');
Route::get('/actions/{action}', 'ActionController@show');
Route::post('/actions', 'ActionController@store');
Route::get('/actions/{action}/edit', 'ActionController@edit');
Route::patch('/actions/{action}', 'ActionController@update');
Route::delete('/actions/{action})', 'ActionController@delete');

Route::get('/appointments', 'AppointmentController@index');
Route::get('/appointments/create', 'AppointmentController@create');
Route::get('/appointments/{appointment}', 'AppointmentController@show');
Route::post('/appointments', 'AppointmentController@store');
Route::get('/appointments/{appointment}/edit', 'AppointmentController@edit');
Route::patch('/appointments/{appointment}', 'AppointmentController@update');
Route::delete('/appointments/{appointment})', 'AppointmentController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
