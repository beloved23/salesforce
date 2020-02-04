<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use App\Models\User;

use Illuminate\Support\Facades\Validator;

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

Route::get('/message', function (Request $request) {
    return "Am done";
});
Route::get('/retrieve/countries', 'ApiController@getCountries');
Route::get('/retrieve/regions', 'ApiController@getRegions');
Route::get('/retrieve/zones', 'ApiController@getZones');
Route::get('/retrieve/states', 'ApiController@getStates');
Route::get('/retrieve/areas', 'ApiController@getAreas');
Route::get('/retrieve/lgas', 'ApiController@getLgas');
Route::get('/retrieve/territories', 'ApiController@getTerritories');
Route::get('/retrieve/sites', 'ApiController@getSites');

Route::get('/action/custom', 'ApiController@custom');
Route::get('/simulate/auth', 'ADController@simulate');
Route::get('/application/user/{auuid}', 'ADController@authenticate');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
