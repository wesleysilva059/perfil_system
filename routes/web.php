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



Route::group(['middleware' => 'auth'], function () {

	Route::get('/', 'HomeController@index');
		Route::get('chart','HomeController@chartHome');

	Route::resource('clients', 'ClientsController');
	Route::resource('employees', 'EmployeesController');
	Route::resource('products','ProductsController');
	Route::resource('incomes','IncomesController');
	Route::resource('costs','CostsController');
	Route::resource('incomeLaunches','IncomeLaunchesController');
		Route::get('/get-income/{income_id}', 'IncomeLaunchesController@getIncome');
		Route::get('/incomeLaunchesReports', 'IncomeLaunchesController@historic');

	Route::resource('costLaunches','CostLaunchesController');
		Route::get('/get-cost/{cost_id}', 'CostLaunchesController@getCost');
		Route::get('/costLaunchesReports', 'CostLaunchesController@historic');
	
	Route::resource('sales', 'SalesController');
		Route::get('/get-product/{product_id}', 'SalesController@getProduct');
		Route::get('/salesReports', 'SalesController@historic');


	
});
