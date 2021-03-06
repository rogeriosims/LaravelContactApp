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

//add extension to render pure html alongside with php
View::addExtension('html', 'php');

Route::group(['middleware' => ['web']], function () {
	//Homepage - Login
	Route::get('/', function () 
	{
		if(\Auth::check())
			return redirect('contacts');

		return view('auth.login');
	});
	Route::get('/login', function () 
	{
		if(\Auth::check())
			return redirect('contacts');
		
		return view('auth.login');
	})->name('login');
	
	//Auth scafollding
	Auth::routes();
	Route::get('/contacts', 'ContactController@index')->name('contacts');
	Auth::routes();
	Route::get('/contacts', 'ContactController@index')->name('contacts');

	//Auth routes for Social Lite Authentication
	Route::get('auth/{provider}', 'Auth\LoginController@redirectionToProvider');
	Route::get('auth/{provider}/callback', 'Auth\LoginController@handlingProviderCallback');

	/****************

	API routes for Contact CRUD features

	*****************/

	//Route group with prefix
	Route::group(['prefix'=>'contacts'],function()
	{
		//create
		Route::post('/create', 'ContactController@create');
		//delete
		Route::post('/delete', 'ContactController@delete');
		//update
		Route::post('/update', 'ContactController@update');
		//list all
		Route::get('/list', 'ContactController@getAll');
		//export contacts to vCard
		Route::post('/export', 'ContactController@exportToVdCard');
		//app audit
		Route::get('/audits', 'ContactController@listAppAudit');
		
	});
});


