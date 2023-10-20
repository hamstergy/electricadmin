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
Route::resource('bikes', 'ElectricBikeController')->middleware('auth');
Route::resource('posts', 'PostController')->middleware('auth');
Route::get('electric-json', 'ElectricVehicleController@json')->middleware('auth');
Route::get('electric-json/makes', 'ElectricVehicleController@jsonMakes')->middleware('auth');
Route::get('bikes-json', 'ElectricBikeController@json')->middleware('auth');
Route::get('bikes-json/makes', 'ElectricBikeController@jsonMakes')->middleware('auth');
Route::post('makes/create', 'VehicleMakeController@save')->middleware('auth');
Route::post('models/create', 'VehicleModelController@save')->middleware('auth');
Route::post('electric/create', 'ElectricVehicleController@save')->middleware('auth');
Route::post('bikes/create', 'ElectricBikeController@save')->middleware('auth');
Route::post('posts/create', 'PostController@save')->middleware('auth');

Route::get('image', 'ImageController@index');
Route::get('electric-image', 'ElectricImageController@index');
Route::post('image/store', 'ImageController@store');
Route::post('image/store-bike-content', 'ImageController@storeBikeContentImage');
Route::post('image/store-post-content', 'ImageController@storePostContentImage');
Route::post('electric-image/store', 'ElectricImageController@store');
Route::post('electric-image/store-bike', 'ElectricImageController@storeBike');
Route::post('electric-image/store-post', 'ElectricImageController@storePost');
Route::post('/image/delete', 'ImageController@delete');

Route::prefix('api')->group(function () {
    Route::get('cars', 'ElectricVehicleController@list');
    Route::get('cars/all', 'ElectricVehicleController@all');
    Route::get('cars/makes', 'ElectricVehicleController@jsonMakes');
    Route::get('cars/{ElectricVehicle:slug}', 'ElectricVehicleController@singleCar');
    // Route::get('cars/{electric_vehicle:slug}', function (App\ElectricVehicle $car) {
    //     return $car;
    // });
    Route::get('bikes', 'ElectricBikeController@list');
    Route::get('bikes/all', 'ElectricBikeController@all');
    Route::get('bikes/makes', 'ElectricBikeController@jsonMakes');
    Route::get('bikes/{ElectricBike:slug}', 'ElectricBikeController@singleBike');

    Route::get('used', 'UsedCarController@list');
});

Auth::routes();