<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ResidenceCategoryController;
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

Route::controller(CountryController::class)->group(function () {
    Route::prefix('/admin/countries')->group(function () {
        Route::get('', 'index')->name('admin.countries');
        Route::get('/create', 'create')->name('admin.countries.create');
        Route::post('/create', 'store');
        Route::get('/{country}/edit', 'edit')->name('admin.countries.country.edit');
        Route::patch('/{country}/edit', 'update');
        Route::get('/{country}/delete', 'delete')->name('admin.countries.country.delete');
        Route::delete('/{country}/delete', 'destroy');
    });
});

Route::controller(CityController::class)->group(function () {
    Route::prefix('/admin/cities')->group(function () {
        Route::get('/{country}', 'index')->name('admin.cities');
        Route::get('/create/{country}', 'create')->name('admin.cities.create');
        Route::post('/create/{country}', 'store');
        Route::get('/{city}/edit', 'edit')->name('admin.cities.city.edit');
        Route::patch('/{city}/edit', 'update');
        Route::get('/{city}/delete', 'delete')->name('admin.cities.city.delete');
        Route::delete('/{city}/delete', 'destroy');
    });
});

Route::prefix('/admin/residence/categories')->group(function () {
    Route::get('', fn() => view('admin.residence_categories.layout'))->name('admin.residence.categories.layout');
    Route::controller(ResidenceCategoryController::class)->group(function () {
        Route::get('/all', 'index')->name('admin.residence.categories');
        Route::get('/create', 'create')->name('admin.residence.categories.create');
        Route::post('/create', 'store');
        Route::get('/{category}/edit', 'edit')->name('admin.residence.categories.category.edit');
        Route::patch('/{category}/edit', 'update');
        Route::get('/{category}/delete', 'delete')->name('admin.residence.categories.category.delete');
        Route::delete('/{category}/delete', 'destroy');
    });
});
