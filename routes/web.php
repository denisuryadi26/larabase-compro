<?php

use App\Http\Controllers\Generator\AboutController;
use App\Http\Controllers\Generator\ContactController;
use App\Http\Controllers\Generator\TeamController;
use App\Http\Controllers\Generator\ClientController;
use App\Http\Controllers\Generator\PortfolioController;
use App\Http\Controllers\Generator\TestimonialController;
use App\Http\Controllers\Generator\ServiceController;
use App\Http\Controllers\Generator\SliderController;

use App\Http\Controllers\AgiController;
use App\Http\Controllers\Generator\CategoryController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupConttroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

Auth::routes();

Route::group(['prefix' => 'administrator', 'middleware' => ['auth', 'roles']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cek-asterisk', [AgiController::class, 'asteriskCheckConnection'])->name('cek_asterisk_connection');
    Route::get('/test-call-sip', [AgiController::class, 'callToSip'])->name('cek_asterisk_connection');
    Route::get('/delete_file', [DashboardController::class, 'deleteFileContent'])->name('file_delete');


    Route::group(['prefix' => 'abouts'], function () {
        Route::get('/', [AboutController::class, 'index'])->name('dashboard_abouts');
        Route::get('/get', [AboutController::class, 'get'])->name('dashboard_abouts_detail');
        Route::get('/delete', [AboutController::class, 'destroy'])->name('dashboard_abouts_delete');
        Route::post('/', [AboutController::class, 'store'])->name('dashboard_abouts_post');
        Route::get('/datatable.json', [AboutController::class, '__datatable'])->name('dashboard_abouts_table');
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/', [ContactController::class, 'index'])->name('dashboard_contacts');
        Route::get('/get', [ContactController::class, 'get'])->name('dashboard_contacts_detail');
        Route::get('/delete', [ContactController::class, 'destroy'])->name('dashboard_contacts_delete');
        Route::post('/', [ContactController::class, 'store'])->name('dashboard_contacts_post');
        Route::get('/datatable.json', [ContactController::class, '__datatable'])->name('dashboard_contacts_table');
    });

    Route::group(['prefix' => 'teams'], function () {
        Route::get('/', [TeamController::class, 'index'])->name('dashboard_teams');
        Route::get('/get', [TeamController::class, 'get'])->name('dashboard_teams_detail');
        Route::get('/delete', [TeamController::class, 'destroy'])->name('dashboard_teams_delete');
        Route::post('/', [TeamController::class, 'store'])->name('dashboard_teams_post');
        Route::get('/datatable.json', [TeamController::class, '__datatable'])->name('dashboard_teams_table');
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', [ClientController::class, 'index'])->name('dashboard_clients');
        Route::get('/get', [ClientController::class, 'get'])->name('dashboard_clients_detail');
        Route::get('/delete', [ClientController::class, 'destroy'])->name('dashboard_clients_delete');
        Route::post('/', [ClientController::class, 'store'])->name('dashboard_clients_post');
        Route::get('/datatable.json', [ClientController::class, '__datatable'])->name('dashboard_clients_table');
    });

    Route::group(['prefix' => 'portfolios'], function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('dashboard_portfolios');
        Route::get('/get', [PortfolioController::class, 'get'])->name('dashboard_portfolios_detail');
        Route::get('/delete', [PortfolioController::class, 'destroy'])->name('dashboard_portfolios_delete');
        Route::post('/', [PortfolioController::class, 'store'])->name('dashboard_portfolios_post');
        Route::get('/datatable.json', [PortfolioController::class, '__datatable'])->name('dashboard_portfolios_table');
    });

    Route::group(['prefix' => 'testimonials'], function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('dashboard_testimonials');
        Route::get('/get', [TestimonialController::class, 'get'])->name('dashboard_testimonials_detail');
        Route::get('/delete', [TestimonialController::class, 'destroy'])->name('dashboard_testimonials_delete');
        Route::post('/', [TestimonialController::class, 'store'])->name('dashboard_testimonials_post');
        Route::get('/datatable.json', [TestimonialController::class, '__datatable'])->name('dashboard_testimonials_table');
    });

    Route::group(['prefix' => 'services'], function () {
        Route::get('/', [ServiceController::class, 'index'])->name('dashboard_services');
        Route::get('/get', [ServiceController::class, 'get'])->name('dashboard_services_detail');
        Route::get('/delete', [ServiceController::class, 'destroy'])->name('dashboard_services_delete');
        Route::post('/', [ServiceController::class, 'store'])->name('dashboard_services_post');
        Route::get('/datatable.json', [ServiceController::class, '__datatable'])->name('dashboard_services_table');
    });

    Route::group(['prefix' => 'sliders'], function () {
        Route::get('/', [SliderController::class, 'index'])->name('dashboard_sliders');
        Route::get('/get', [SliderController::class, 'get'])->name('dashboard_sliders_detail');
        Route::get('/delete', [SliderController::class, 'destroy'])->name('dashboard_sliders_delete');
        Route::post('/', [SliderController::class, 'store'])->name('dashboard_sliders_post');
        Route::get('/datatable.json', [SliderController::class, '__datatable'])->name('dashboard_sliders_table');
    });
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('dashboard_categories');
        Route::get('/get', [CategoryController::class, 'get'])->name('dashboard_categories_detail');
        Route::get('/delete', [CategoryController::class, 'destroy'])->name('dashboard_categories_delete');
        Route::post('/', [CategoryController::class, 'store'])->name('dashboard_categories_post');
        Route::get('/datatable.json', [CategoryController::class, '__datatable'])->name('dashboard_categories_table');

        Route::get('/get-sub', [CategoryController::class, 'getSub'])->name('dashboard_categories_get_sub');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('dashboard_profile');
        Route::post('/', [ProfileController::class, 'store'])->name('dashboard_profile_post');
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('/', [MenuController::class, 'index'])->name('dashboard_menu');
        Route::get('/get', [MenuController::class, 'get'])->name('dashboard_menu_detail');

        Route::get('/get-parent', [MenuController::class, 'getParent'])->name('dashboard_menu_get_parent');

        Route::get('/delete', [MenuController::class, 'destroy'])->name('dashboard_menu_delete');
        Route::post('/', [MenuController::class, 'store'])->name('dashboard_menu_post');
        Route::get('/datatable.json', [MenuController::class, '__datatable'])->name('dashboard_menu_table');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard_user');
        Route::get('/get', [UserController::class, 'get'])->name('dashboard_user_detail');
        Route::get('/delete', [UserController::class, 'destroy'])->name('dashboard_user_delete');
        Route::post('/', [UserController::class, 'store'])->name('dashboard_user_post');
        Route::get('/datatable.json', [UserController::class, '__datatable'])->name('dashboard_user_table');
    });

    Route::group(['prefix' => 'group'], function () {
        Route::get('/', [GroupConttroller::class, 'index'])->name('dashboard_group');
        Route::get('/get', [GroupConttroller::class, 'get'])->name('dashboard_group_detail');
        Route::get('/delete', [GroupConttroller::class, 'destroy'])->name('dashboard_group_delete');
        Route::post('/', [GroupConttroller::class, 'store'])->name('dashboard_group_post');
        Route::get('/changeAccess', [GroupConttroller::class, 'changeAccess'])->name('dashboard_group_change_access');
        Route::get('/datatable.json', [GroupConttroller::class, '__datatable'])->name('dashboard_group_table');
        Route::get('/menuAccess.json', [GroupConttroller::class, '__menuAccess'])->name('dashboard_group_menu_access');
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('dashboard_setting');
        Route::get('/get', [SettingController::class, 'get'])->name('dashboard_setting_detail');
        Route::get('/delete', [SettingController::class, 'destroy'])->name('dashboard_setting_delete');
        Route::post('/', [SettingController::class, 'store'])->name('dashboard_setting_post');
        Route::get('/datatable.json', [SettingController::class, '__datatable'])->name('dashboard_setting_table');
    });

    Route::group(['prefix' => 'permission'], function () {
        Route::get('/administrator/permission', [MenuController::class, 'index'])->name('dashboard_permission');
    });
});


Auth::routes();
