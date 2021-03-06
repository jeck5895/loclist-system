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
// Route::get('login', array('as' => 'login'),function(){
//   return redirect('/');
// });

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*
/ Redirect Login route to Google OAuth
*/
//Route::get('/login','Auth\LoginController@redirectToProvider');

Route::get('/main','MainController@index');

Route::get('/','Auth\LoginController@redirectToProvider')->name('login');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
//it can also be auth/{provider}/fallback then delcare a parameter in controller
Route::get('auth/google/fallback','Auth\LoginController@handleProviderCallback');

Route::get('auth/sri-loclist/callback', 'Auth\LoginController@handleLoclistCallback');

Route::get('auth/logout','Auth\LoginController@logout');



Route::get('reports/prospective-clients', 'Reports\KPIAnalysisReportController@index');

Route::get('/{vue_capture?}', function () {
    return view('home');
  })->where('vue_capture', '[\/\w\.-]*');