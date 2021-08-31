<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\VehicleModel;
use App\VehicleMake;
use App\Vehicle;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('makes/allMakes', 'VehicleMakeController@makes');
//Route::get('allMakes', function() {
//    $makes = VehicleMake::get(['name','slug'])->sortBy('name')->values()->all();
//    return $makes;
//});
//Route::get('/test', function(Request $request) {
//    return $request->id;
//});
//Route::get('getModels/byMake/{slug}', function($slug, Request $request) {
//
//    $make =  VehicleMake::where('slug', $slug)->with('models')->firstOrFail();
//    $models = $make->models;
//    if ($request->class) {
//        $models = $models->where('class', $request->class)->values()->all();
//    }
//    foreach ($models as $model) {
//        $model->makeName = $make->name;
//        $model->className = $model->class;
//        $model->makeSlug = $make->slug;
//        unset($model->vehicle_make_id);
//        unset($model->created_at);
//        unset($model->updated_at);
//        unset($model->class);
//    }
//    return $models;
//});
//Route::get('getModel/{make}/{model}', function($make, $model) {
//    $make = VehicleMake::where('slug', $make)->with('models')->first();
//    $model = $make->models->where('slug', $model)->first();
//    $vehicle = Vehicle::where([
//            ['vehicle_make_id', '=', $make->id],
//            ['vehicle_model_id', '=', $model->id],
//            ['vehicle_model_year_id', '=', 2]
//    ])->with('offers')->first();
//    unset($vehicle->created_at);
//    unset($vehicle->updated_at);
//    unset($vehicle->id);
//    unset($vehicle->vehicle_make_id);
//    unset($vehicle->vehicle_model_id);
//    unset($vehicle->vehicle_model_year_id);
//    foreach ($vehicle->offers as $offer) {
//        unset($offer->created_at);
//        unset($offer->updated_at);
//        unset($offer->vehicle_id);
//        unset($offer->id);
//    }
//    $vehicle->model = $model->name;
//    $vehicle->modelSlug = $model->slug;
//    $vehicle->make = $make->name;
//    $vehicle->makeSlug = $make->slug;
//    $vehicle->name = $make->name.' '.$model->name;
//    return $vehicle;
//});
//Route::get('allModels', function() {
//    $models = VehicleModel::inRandomOrder()->get();
//    foreach ($models as $model) {
//        $make = VehicleMake::where('id',$model->vehicle_make_id)->first();
//        $model->makeName = $make->name;
//        $model->className = $model->class;
//        $model->makeSlug = $make->slug;
//        unset($model->vehicle_make_id);
//        unset($model->created_at);
//        unset($model->updated_at);
//        unset($model->class);
//    }
//    return $models;
//});
Route::get('makes/allModels/{make}', 'VehicleModelController@models');
