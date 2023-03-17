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

Route::get('/', function () {
    return view('welcome');
});

Route::get('migrate/{key}', function ($key) {
    if ($key == 'Rejohn@1234') {
        try {
            \Artisan::call('migrate');
            echo 'Migrated Successfully!';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo 'Not matched!';
    }
});
