<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LatestNewsController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReservationControlller;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OurGoalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'service'])->name('service');
Route::get('/casestudy', [HomeController::class, 'casestudy'])->name('casestudy');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('downloadPdf/{id}', [SettingController::class, 'downloadPdf'])->name('downloadPdf');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //Settings
    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('show', [SettingController::class, 'index'])->name('show');
        Route::get('create', [SettingController::class, 'create'])->name('create');
        Route::post('store', [SettingController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::post('update-setting', [SettingController::class, 'update'])->name('update');
    });

    //Department
    Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
        Route::get('/show', [WorkController::class, 'show'])->name('show');
        Route::post('/list', [WorkController::class, 'list'])->name('list');
        Route::get('create', [WorkController::class, 'create'])->name('create');
        Route::post('store', [WorkController::class, 'store'])->name('store');
        Route::get('edit/{id}', [WorkController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [WorkController::class, 'update'])->name('update');
        Route::post('delete', [WorkController::class, 'delete'])->name('delete');
    });

    //Latest News
    Route::group(['prefix' => 'latestnews', 'as' => 'latestnews.'], function () {
        Route::get('/show', [LatestNewsController::class, 'show'])->name('show');
        Route::post('/list', [LatestNewsController::class, 'list'])->name('list');
        Route::get('create', [LatestNewsController::class, 'create'])->name('create');
        Route::post('store', [LatestNewsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [LatestNewsController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [LatestNewsController::class, 'update'])->name('update');
        Route::post('delete', [LatestNewsController::class, 'delete'])->name('delete');
    });

    //Our Goals
    Route::group(['prefix' => 'goals', 'as' => 'goals.'], function () {
        Route::get('/show', [OurGoalController::class, 'show'])->name('show');
        Route::post('/list', [OurGoalController::class, 'list'])->name('list');
        Route::get('create', [OurGoalController::class, 'create'])->name('create');
        Route::post('store', [OurGoalController::class, 'store'])->name('store');
        Route::get('edit/{id}', [OurGoalController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [OurGoalController::class, 'update'])->name('update');
        Route::post('delete', [OurGoalController::class, 'delete'])->name('delete');
    });

    //Our Team
    Route::group(['prefix' => 'team', 'as' => 'team.'], function () {
        Route::get('/show', [TeamController::class, 'show'])->name('show');
        Route::post('/list', [TeamController::class, 'list'])->name('list');
        Route::get('create', [TeamController::class, 'create'])->name('create');
        Route::post('store', [TeamController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TeamController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [TeamController::class, 'update'])->name('update');
        Route::post('delete', [TeamController::class, 'delete'])->name('delete');
    });

    //Our Service
    Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
        Route::get('/show', [ServiceController::class, 'show'])->name('show');
        Route::post('/list', [ServiceController::class, 'list'])->name('list');
        Route::get('create', [ServiceController::class, 'create'])->name('create');
        Route::post('store', [ServiceController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ServiceController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ServiceController::class, 'update'])->name('update');
        Route::post('delete', [ServiceController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'casestudy', 'as' => 'casestudy.'], function () {
        Route::get('/show', [CaseStudyController::class, 'show'])->name('show');
        Route::post('/list', [CaseStudyController::class, 'list'])->name('list');
        Route::get('create', [CaseStudyController::class, 'create'])->name('create');
        Route::post('store', [CaseStudyController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CaseStudyController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CaseStudyController::class, 'update'])->name('update');
        Route::post('delete', [CaseStudyController::class, 'delete'])->name('delete');
    });


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/show', [UserController::class, 'show'])->name('show');
        Route::post('/list', [UserController::class, 'list'])->name('list');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('delete', [UserController::class, 'delete'])->name('delete');
    });

    //Service
    Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
        Route::get('/show', [ServiceController::class, 'show'])->name('show');
        Route::post('/list', [ServiceController::class, 'list'])->name('list');
        Route::get('create', [ServiceController::class, 'create'])->name('create');
        Route::post('store', [ServiceController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ServiceController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ServiceController::class, 'update'])->name('update');
        Route::post('delete', [ServiceController::class, 'delete'])->name('delete');
    });


    //Contact
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::get('/show', [ContactController::class, 'show'])->name('show');
        Route::post('/list', [ContactController::class, 'list'])->name('list');
        Route::get('/detail/{id}', [ContactController::class, 'detail'])->name('detail');
        Route::get('create', [ContactController::class, 'create'])->name('create');
        Route::post('store', [ContactController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ContactController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ContactController::class, 'update'])->name('update');
        Route::post('delete', [ContactController::class, 'delete'])->name('delete');
    });

    //About
    Route::group(['prefix' => 'about', 'as' => 'about.'], function () {
        Route::get('/show', [AboutController::class, 'index'])->name('show');
        Route::post('/list', [AboutController::class, 'list'])->name('list');
        Route::get('create', [AboutController::class, 'create'])->name('create');
        Route::post('store', [AboutController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AboutController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AboutController::class, 'update'])->name('update');
        Route::post('delete', [AboutController::class, 'delete'])->name('delete');
    });


    //About
    Route::group(['prefix' => 'pricing', 'as' => 'pricing.'], function () {
        Route::get('/show', [PricingController::class, 'index'])->name('show');
        Route::post('/list', [PricingController::class, 'list'])->name('list');
        Route::get('create', [PricingController::class, 'create'])->name('create');
        Route::post('store', [PricingController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PricingController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PricingController::class, 'update'])->name('update');
        Route::post('delete', [PricingController::class, 'delete'])->name('delete');
    });


    //Menu
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
        Route::get('/show', [MenuController::class, 'index'])->name('show');
        Route::post('/list', [MenuController::class, 'list'])->name('list');
        Route::get('create', [MenuController::class, 'create'])->name('create');
        Route::post('store', [MenuController::class, 'store'])->name('store');
        Route::get('edit/{id}', [MenuController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [MenuController::class, 'update'])->name('update');
        Route::post('delete', [MenuController::class, 'delete'])->name('delete');
        Route::post('check-parent-type', [MenuController::class, 'checkParentType'])->name('checkParentType');
    });

    //Pages
    Route::group(['prefix' => 'page', 'as' => 'page.'], function () {
        Route::get('/show', [PageController::class, 'index'])->name('show');
        Route::post('/list', [PageController::class, 'list'])->name('list');
        Route::get('create', [PageController::class, 'create'])->name('create');
        Route::post('store', [PageController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PageController::class, 'update'])->name('update');
        Route::post('delete', [PageController::class, 'delete'])->name('delete');
        Route::post('check-parent-type', [PageController::class, 'checkParentType'])->name('checkParentType');
    });

    //Banner
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::get('/show', [ContactController::class, 'show'])->name('show');
        Route::post('/list', [ContactController::class, 'list'])->name('list');
        Route::get('create', [ContactController::class, 'create'])->name('create');
        Route::post('store', [ContactController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ContactController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ContactController::class, 'update'])->name('update');
        Route::post('delete', [ContactController::class, 'delete'])->name('delete');
    });

    //Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/edit_profile/{id}', [UserController::class, 'edit_profile'])->name('edit_profile');
        Route::post('/update_profile/{id}', [UserController::class, 'update_profile'])->name('update_profile');
    });




    // Route::get('/page/{id}', [HomeController::class, 'page'])->name('page');

    // Route::post('check_conflicts', [ReservationControlller::class, 'checkConflicts'])->name('checkConflicts');

});

Auth::routes();
