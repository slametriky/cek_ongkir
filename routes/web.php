<?php

use App\Http\Controllers\RajaOngkirController;
use Illuminate\Http\Request;
use App\Services\RajaOngkir\Ongkir;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/search/provinces', function (Request $request) {
//     if($request->get('id')){
//         $data = Ongkir::find(['province_id' => $request->id])->province()->get();
//     } else {
//         $data = Ongkir::province()->get();
//     }

//     return $data;
// });

Route::get('/search/provinces', [RajaOngkirController::class, 'getProvinces']);

Route::get('/search/cities', [RajaOngkirController::class, 'getCities']);

// Route::get('/search/provinces', function (Request $request) {
//     if($request->get('id')){
//         $data = Ongkir::find(['province_id' => $request->id])->province()->get();
//     } else {
//         $data = Ongkir::province()->get();
//     }

//     return $data;
// });
