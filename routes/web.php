<?php

use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\CalculatorScreen;
use App\Orchid\Screens\PlatformScreen;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return "TEST";
// });

// Route::get('/calculator', function () {
//     return view('calculator');
// });

Route::screen('/calc', PlatformScreen::class)
    ->name('platform.main');

Route::redirect('/home', '/calc');
Route::redirect('/', '/calc');
