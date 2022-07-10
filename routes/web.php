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

Route::get('/', 'HomeController@index')->name('home');

Route::resource('makes', 'VehicleMakeController')->middleware('auth');
Route::resource('models', 'VehicleModelController')->middleware('auth');
Route::resource('electric', 'ElectricVehicleController')->middleware('auth');
Route::get('electric-json', 'ElectricVehicleController@json')->middleware('auth');
Route::get('electric-json/makes', 'ElectricVehicleController@jsonMakes')->middleware('auth');
Route::post('makes/create','VehicleMakeController@save')->middleware('auth');
Route::post('models/create','VehicleModelController@save')->middleware('auth');
Route::post('electric/create','ElectricVehicleController@save')->middleware('auth');

Route::get('image', 'ImageController@index');
Route::get('electric-image', 'ElectricImageController@index');
Route::post('image/store', 'ImageController@store');
Route::post('electric-image/store', 'ElectricImageController@store');
Route::post('/image/delete','ImageController@delete');

Auth::routes();
