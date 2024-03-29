<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\HousingCategoryController;
use App\Http\Controllers\HousingController;
use App\Http\Controllers\HousingFormulaController;
use App\Http\Controllers\HousingPriceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResidenceCategoryController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
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

Route::view('/', 'home.index')->name('home');

Route::controller(RegisterController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store');
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'create')->name('login');
        Route::post('/login', 'store');
    });
    Route::post('/logout', 'destroy')->name('logout')->middleware('auth');
});

Route::controller(PasswordResetController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/forgot-password', 'create')->name('password.request');
        Route::post('/forgot-password', 'store')->name('password.email');
        Route::get('/reset-password/{token}', 'index')->name('password.reset');
        Route::post('/reset-password', 'update')->name('password.update');
    });
});

// Maybe I should separate this route to set one for registration with throttle and another one for orders without throttle
Route::post('/cities/get', [CityController::class, 'getActive'])->name('cities.get');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('user-profile');
        Route::post('/profile', 'update');
    });

    Route::controller(PasswordChangeController::class)->group(function () {
        Route::get('/change-password', 'create')->name('password-change');
        Route::post('/change-password', 'update');
    });

    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('/email/verify', 'create')->name('verification.notice');
        Route::post('/email/verification-notification', 'store')
            ->middleware('throttle:6,1')->name('verification.send');
        Route::get('/email/verify/{id}/{hash}', 'update')
            ->middleware('signed')->name('verification.verify');
    });

    Route::middleware('verified')->group(function () {
        Route::post('/residences/get', [ResidenceController::class, 'getActive'])->name('residences.get');
        Route::post('/housings/get', [HousingController::class, 'getActive'])->name('housings.get');
        Route::middleware('can:user')->group(function () {
            Route::prefix('/orders')->group(function () {
                Route::view('', 'home.orders.layout')->name('orders.layout');
                Route::controller(UserOrderController::class)->group(function () {
                    Route::get('/all', 'index')->name('orders');
                    Route::get('/create', 'create')->name('orders.create');
                    Route::post('/create', 'store');
                    Route::get('/{order}/edit', 'edit')->name('orders.order.edit');
                    Route::patch('/{order}/edit', 'update');
                    Route::get('/{order}/details', 'details')->name('orders.order.details');
                });
            });
        });

        Route::middleware('can:admin')->group(function () {
            Route::view('/admin', 'admin.dashboard.index')->name('admin');

            Route::view('/admin/countries-cities', 'admin.countries_cities.index')->name('admin.countries-cities');

            Route::prefix('/admin/countries')->group(function () {
                Route::controller(CountryController::class)->group(function () {
                    Route::get('', 'index')->name('admin.countries');
                    Route::get('/create', 'create')->name('admin.countries.create');
                    Route::post('/create', 'store');
                    Route::get('/{country}/edit', 'edit')->name('admin.countries.country.edit');
                    Route::patch('/{country}/edit', 'update');
                    Route::get('/{country}/delete', 'delete')->name('admin.countries.country.delete');
                    Route::delete('/{country}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/cities')->group(function () {
                Route::controller(CityController::class)->group(function () {
                    Route::get('/{country}', 'index')->name('admin.cities');
                    Route::post('/get', 'get')->name('admin.cities.get');
                    Route::get('/create/{country}', 'create')->name('admin.cities.create');
                    Route::post('/create/{country}', 'store');
                    Route::get('/{city}/edit', 'edit')->name('admin.cities.city.edit');
                    Route::patch('/{city}/edit', 'update');
                    Route::get('/{city}/delete', 'delete')->name('admin.cities.city.delete');
                    Route::delete('/{city}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/residences')->group(function () {
                Route::view('', 'admin.residences.layout')->name('admin.residences.layout');
                Route::controller(ResidenceController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.residences');
                    Route::post('/get', 'get')->name('admin.residences.get');
                    Route::get('/create', 'create')->name('admin.residences.create');
                    Route::post('/create', 'store');
                    Route::get('/{residence}/edit', 'edit')->name('admin.residences.residence.edit');
                    Route::patch('/{residence}/edit', 'update');
                    Route::get('/{residence}/delete', 'delete')->name('admin.residences.residence.delete');
                    Route::delete('/{residence}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/residence/categories')->group(function () {
                Route::view('', 'admin.residence_categories.layout')->name('admin.residence.categories.layout');
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

            Route::prefix('/admin/housings')->group(function () {
                Route::view('', 'admin.housings.layout')->name('admin.housings.layout');
                Route::controller(HousingController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.housings');
                    Route::post('/get', 'get')->name('admin.housings.get');
                    Route::get('/create', 'create')->name('admin.housings.create');
                    Route::post('/create', 'store');
                    Route::get('/{housing}/edit', 'edit')->name('admin.housings.housing.edit');
                    Route::patch('/{housing}/edit', 'update');
                    Route::get('/{housing}/delete', 'delete')->name('admin.housings.housing.delete');
                    Route::delete('/{housing}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/housing/categories')->group(function () {
                Route::view('', 'admin.housing_categories.layout')->name('admin.housing.categories.layout');
                Route::controller(HousingCategoryController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.housing.categories');
                    Route::get('/create', 'create')->name('admin.housing.categories.create');
                    Route::post('/create', 'store');
                    Route::get('/{category}/edit', 'edit')->name('admin.housing.categories.category.edit');
                    Route::patch('/{category}/edit', 'update');
                    Route::get('/{category}/delete', 'delete')->name('admin.housing.categories.category.delete');
                    Route::delete('/{category}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/housing/formulas')->group(function () {
                Route::view('', 'admin.housing_formulas.layout')->name('admin.housing.formulas.layout');
                Route::controller(HousingFormulaController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.housing.formulas');
                    Route::get('/create', 'create')->name('admin.housing.formulas.create');
                    Route::post('/create', 'store');
                    Route::get('/{formula}/edit', 'edit')->name('admin.housing.formulas.formula.edit');
                    Route::patch('/{formula}/edit', 'update');
                    Route::get('/{formula}/delete', 'delete')->name('admin.housing.formulas.formula.delete');
                    Route::delete('/{formula}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/housing/prices')->group(function () {
                Route::view('', 'admin.housing_prices.layout')->name('admin.housing.prices.layout');
                Route::controller(HousingPriceController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.housing.prices');
                    Route::get('/create', 'create')->name('admin.housing.prices.create');
                    Route::post('/create', 'store');
                    Route::get('/{price}/edit', 'edit')->name('admin.housing.prices.price.edit');
                    Route::patch('/{price}/edit', 'update');
                    Route::get('/{price}/delete', 'delete')->name('admin.housing.prices.price.delete');
                    Route::delete('/{price}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/seasons')->group(function () {
                Route::view('', 'admin.seasons.layout')->name('admin.seasons.layout');
                Route::controller(SeasonController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.seasons');
                    Route::get('/create', 'create')->name('admin.seasons.create');
                    Route::post('/create', 'store');
                    Route::get('/{season}/edit', 'edit')->name('admin.seasons.season.edit');
                    Route::patch('/{season}/edit', 'update');
                    Route::get('/{season}/delete', 'delete')->name('admin.seasons.season.delete');
                    Route::delete('/{season}/delete', 'destroy');
                });
            });

            Route::prefix('/admin/users')->group(function () {
                Route::view('', 'admin.users.layout')->name('admin.users.layout');
                Route::controller(UserController::class)->group(function () {
                    Route::get('/all', 'index')->name('admin.users');
                    Route::post('/get', 'get')->name('admin.users.get');
                    Route::post('/set', 'updateIsActive')->name('admin.users.set');
                    Route::get('/create', 'create')->name('admin.users.create');
                    Route::post('/create', 'store');
                    Route::get('/{user}/edit', 'edit')->name('admin.users.user.edit');
                    Route::patch('/{user}/edit', 'update');
                });
            });

            Route::prefix('/admin/orders')->group(function () {
                Route::view('', 'admin.orders.layout')->name('admin.orders.layout');
                Route::controller(OrderController::class)->group(function () {
                    Route::get('/{user?}', 'index')->name('admin.orders');
                    Route::get('/{user}/create', 'create')->name('admin.orders.create');
                    Route::post('/{user}/create', 'store');
                    Route::get('/{order}/edit', 'edit')->name('admin.orders.order.edit');
                    Route::patch('/{order}/edit', 'update');
                    Route::get('/{order}/details', 'details')->name('admin.orders.order.details');
                });
            });
        });
    });
});
