<?php

use Illuminate\Support\Facades\Route;

// Done
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/youscrap/appointments', 'YouScrapController@appointment')->name('you-update-appointments');
Route::get('/youscrap/categories', 'YouScrapController@categories')->name('you-update-categories');
Route::get('/youscrap/treatments', 'YouScrapController@treatment')->name('you-update-treatments');
Route::get('/youscrap/payments', 'YouScrapController@payment')->name('you-update-payments');

Route::get('/you-wsp', 'HomeController@panel')->name('you-wsp');
Route::get('/you-wsp/tomorrow', 'HomeController@tomorrow')->name('tomorrow');
Route::get('/canceled', 'HomeController@canceled')->name('canceled');
Route::get('/training', 'HomeController@training')->name('training');
Route::get('/general', 'HomeController@general')->name('general');
Route::get('/excel', 'HomeController@excel')->name('excel');

Route::get('/occupation/{type}', 'OccupationController@occupation')->name('occupation');
Route::post('/occupation', 'OccupationController@form')->name('form-occupation');

Route::get('/professional', 'ProfessionalOcuppationController@index')->name('professional.index');
Route::get('/professional/{name}', 'ProfessionalOcuppationController@show')->name('professional.show');

Route::get('/occupation-professional/{type}', 'OccupationController@occupationprofessional')->name('occupation-professional');
Route::post('/occupation-professional', 'OccupationController@formprofessional')->name('form-occupation-professional');

// Not Yet


Route::get('/excel/ocuppation/{type}', 'ExcelController@occupation')->name('excel-download');
Route::get('/excel/professional', 'ExcelController@professionals')->name('excel-professionals');
Route::get('/excel/professional/{name}', 'ExcelController@professional')->name('excel-professional');

Route::get('/fintoc', 'FintocController@index')->name('fintoc');
Route::get('/transfers', 'TransfersController@index')->name('transfers');

Route::get('/agreement/history', 'AgreementController@history')->name('agreement-history');

Auth::routes();
