<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', 'HomeController@index');
Route::get('/', function(){
	return Auth::user();
});

// Route::get('/you-wsp', 'HomeController@panel')->name('you-wsp');
// Route::get('/excel', 'HomeController@excel')->name('excel');
// Route::get('/you-wsp/tomorrow', 'HomeController@tomorrow')->name('tomorrow');
// Route::get('/you-wsp/training', 'HomeController@training')->name('training');
// Route::get('/medilink', 'HomeController@medilink')->name('medilink');
// Route::get('/canceled', 'HomeController@canceled')->name('canceled');
// Route::get('/excel', 'HomeController@excel')->name('excel');
// Route::get('/general', 'HomeController@general')->name('general');

// Route::get('/excel/ocuppation/{type}', 'ExcelController@occupation')->name('excel-download');
// Route::get('/excel/professional', 'ExcelController@professionals')->name('excel-professionals');
// Route::get('/excel/professional/{name}', 'ExcelController@professional')->name('excel-professional');

// Route::get('/fintoc', 'FintocController@index')->name('fintoc');
// Route::get('/transfers', 'TransfersController@index')->name('transfers');

// No view
// Route::get('/agreement/history', 'AgreementController@history')->name('agreement-history');

// Route::get('/scraping', 'ScrapingController@carbon');
// Route::get('/scraping-appointments', 'ScrapingController@appointments')->name('scraping-appointments');
// Route::get('/scraping-actions', 'ScrapingController@actions')->name('scraping-actions');
// Route::get('/scraping-treatments', 'ScrapingController@treatments')->name('scraping-treatments');
// Route::get('/scraping-payments', 'ScrapingController@payments')->name('scraping-payments');

Route::get('/youscrap', 'YouScrapController@carbon');
Route::get('/youscrap-appointments', 'YouScrapController@appointments')->name('youscrap-appointments');
Route::get('/youscrap-actions', 'YouScrapController@actions')->name('youscrap-actions');
Route::get('/youscrap-treatments', 'YouScrapController@treatments')->name('youscrap-treatments');
Route::get('/youscrap-payments', 'YouScrapController@payments')->name('youscrap-payments');



// Route::get('/professional', 'ProfessionalOcuppationController@index')->name('professional.index');
// Route::get('/professional/{name}', 'ProfessionalOcuppationController@show')->name('professional.show');

// Route::get('/occupation/{type}', 'OccupationController@occupation')->name('occupation');
// Route::post('/occupation', 'OccupationController@form')->name('form-occupation');
// Route::get('/occupation-professional/{type}', 'OccupationController@occupationprofessional')->name('occupation-professional');
// Route::post('/occupation-professional', 'OccupationController@formprofessional')->name('form-occupation-professional');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
