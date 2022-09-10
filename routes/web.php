<?php

use Illuminate\Support\Facades\Route;
use App\http\controllers\companyController;
use App\Http\Controllers\SendEmailController; 
use Illuminate\Support\Facades\Mail;

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
Route::get("company",[companyController::class,'getData']);
Route::view("companyform","company");
