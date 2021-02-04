<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::get('/you-wsp', 'HomeController@panel')->name('you-wsp');
Route::get('/excel', 'HomeController@excel')->name('excel');
Route::get('/you-wsp/tomorrow', 'HomeController@tomorrow')->name('tomorrow');
Route::get('/you-wsp/training', 'HomeController@training')->name('training');
Route::get('/medilink', 'HomeController@medilink')->name('medilink');
Route::get('/canceled', 'HomeController@canceled')->name('canceled');
Route::get('/excel', 'HomeController@excel')->name('excel');

Route::get('/excel/ocuppation/{type}', 'ExcelController@occupation')->name('excel-download');
Route::get('/excel/professional', 'ExcelController@professionals')->name('excel-professionals');
Route::get('/excel/professional/{name}', 'ExcelController@professional')->name('excel-professional');

// No view
Route::get('/agreement/history', 'AgreementController@history')->name('agreement-history');

Route::get('/scraping', 'ScrapingController@carbon');
Route::get('/scraping-appointments', 'ScrapingController@appointments')->name('scraping-appointments');
Route::get('/scraping-actions', 'ScrapingController@actions')->name('scraping-actions');

Route::get('/professional', 'ProfessionalController@index')->name('professional.index');
Route::get('/professional/{name}', 'ProfessionalController@show')->name('professional.show');

Route::get('/occupation/{type}/{fday?}/{lday?}', 'OccupationController@occupation')->name('occupation');

// Route::get('/actions', 'ActionController@index');
// Route::post('/actions', 'ActionController@store');
// Route::get('/actions/{action}/edit', 'ActionController@edit');
// Route::patch('/actions/{action}', 'ActionController@update');

// Route::get('/appointments', 'AppointmentController@index');
// Route::post('/appointments', 'AppointmentController@store');
// Route::get('/appointments/{appointment}/edit', 'AppointmentController@edit');
// Route::patch('/appointments/{appointment}', 'AppointmentController@update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
