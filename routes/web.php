<?php

use App\Data;

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
    $usage = Data::latest()->take(1)->get()->first()->value;
    $status_options = ['primary','info', 'warning', 'danger'];
    // To do: Color of status
    // $status = $status_options[]
    return view('home')->with(compact('usage'));
});
