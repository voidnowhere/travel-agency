<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
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
})->name('home');

Route::get('/admin', fn() => view('admin.dashboard.index'))->name('admin');

Route::get('/admin/countries-cities', fn() => view('admin.countries_cities.index'))->name('admin.countries-cities');

Route::get('/admin/countries', [CountryController::class, 'index'])->name('admin.countries');
Route::get('/admin/countries/create', [CountryController::class, 'create'])->name('admin.countries.create');
Route::post('/admin/countries/create', [CountryController::class, 'store']);
Route::get('/admin/countries/{country}/edit', [CountryController::class, 'edit'])->name('admin.countries.country.edit');
Route::patch('/admin/countries/{country}/edit', [CountryController::class, 'update']);
Route::delete('/admin/countries/{country}/edit', [CountryController::class, 'destroy']);

Route::get('/admin/cities/{country}', [CityController::class, 'index'])->name('admin.cities');
Route::get('/admin/cities/create/{country}', [CityController::class, 'create'])->name('admin.cities.create');
Route::post('/admin/cities/create/{country}', [CityController::class, 'store']);
Route::get('/admin/cities/{city}/edit', [CityController::class, 'edit'])->name('admin.cities.city.edit');
Route::patch('/admin/cities/{city}/edit', [CityController::class, 'update']);
Route::delete('/admin/cities/{city}/edit', [CityController::class, 'destroy']);
