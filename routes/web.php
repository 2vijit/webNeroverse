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

    //Room
    Route::group(['prefix' => 'room', 'as' => 'room.'], function () {
        Route::get('/show', [RoomController::class, 'show'])->name('show');
        Route::post('/list', [RoomController::class, 'list'])->name('list');
        Route::get('create', [RoomController::class, 'create'])->name('create');
        Route::post('store', [RoomController::class, 'store'])->name('store');
        Route::get('edit/{id}', [RoomController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [RoomController::class, 'update'])->name('update');
        Route::post('delete', [RoomController::class, 'delete'])->name('delete');
    });




    //Food
    Route::group(['prefix' => 'food', 'as' => 'food.'], function () {
        Route::get('/show', [FoodController::class, 'show'])->name('show');
        Route::post('/list', [FoodController::class, 'list'])->name('list');
        Route::get('create', [FoodController::class, 'create'])->name('create');
        Route::post('store', [FoodController::class, 'store'])->name('store');
        Route::get('edit/{id}', [FoodController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [FoodController::class, 'update'])->name('update');
        Route::post('delete', [FoodController::class, 'delete'])->name('delete');
        Route::post('deleteFood', [FoodController::class, 'deleteFood'])->name('deleteFood');
    });

    //Gallery
    Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
        Route::get('/show', [GalleryController::class, 'show'])->name('show');
        Route::post('/list', [GalleryController::class, 'list'])->name('list');
        Route::get('create', [GalleryController::class, 'create'])->name('create');
        Route::post('store', [GalleryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [GalleryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [GalleryController::class, 'update'])->name('update');
        Route::post('delete', [GalleryController::class, 'delete'])->name('delete');
        Route::post('deleteGalleryImage', [GalleryController::class, 'deleteGalleryImage'])->name('deleteGalleryImage');
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

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('/show', [ReportController::class, 'index'])->name('show');
        Route::post('/list', [ReportController::class, 'list'])->name('list');
        Route::get('create', [MenuController::class, 'create'])->name('create');
        Route::post('store', [MenuController::class, 'store'])->name('store');
        Route::get('edit/{id}', [MenuController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [MenuController::class, 'update'])->name('update');
        Route::post('delete', [MenuController::class, 'delete'])->name('delete');
        Route::post('check-parent-type', [MenuController::class, 'checkParentType'])->name('checkParentType');
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
    // Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
    //     Route::get('/show', [BannerController::class, 'index'])->name('show');
    //     Route::post('/list', [BannerController::class, 'list'])->name('list');
    //     Route::get('create', [BannerController::class, 'create'])->name('create');
    //     Route::post('store', [BannerController::class, 'store'])->name('store');
    //     Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit');
    //     Route::post('update/{id}', [BannerController::class, 'update'])->name('update');
    //     Route::post('delete', [BannerController::class, 'delete'])->name('delete');
    // });

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

    //Report
    // Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    //     Route::get('/show', [ReportController::class, 'show'])->name('show');
    //     Route::post('/list', [ReportController::class, 'list'])->name('list');
    //     Route::get('create', [ReportController::class, 'create'])->name('create');
    //     Route::post('store', [ReportController::class, 'store'])->name('store');
    //     Route::get('edit/{id}', [ReportController::class, 'edit'])->name('edit');
    //     Route::post('update/{id}', [ReportController::class, 'update'])->name('update');
    //     Route::post('delete', [ReportController::class, 'delete'])->name('delete');
    // });

    //Customer
    // Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    //     Route::get('/show', [CustomerController::class, 'show'])->name('show');
    //     Route::post('/list', [CustomerController::class, 'list'])->name('list');
    //     Route::get('create', [ReportController::class, 'create'])->name('create');
    //     Route::post('store', [ReportController::class, 'store'])->name('store');
    //     Route::get('edit/{id}', [ReportController::class, 'edit'])->name('edit');
    //     Route::post('update/{id}', [ReportController::class, 'update'])->name('update');
    //     Route::post('delete', [ReportController::class, 'delete'])->name('delete');
    // });

    //Customer
    // Route::group(['prefix' => 'agent', 'as' => 'agent.'], function () {
    //     Route::get('/show', [AgentController::class, 'show'])->name('show');
    //     Route::post('/list', [AgentController::class, 'list'])->name('list');
    //     Route::get('create', [AgentController::class, 'create'])->name('create');
    //     Route::post('store', [AgentController::class, 'store'])->name('store');
    //     Route::get('edit/{id}', [AgentController::class, 'edit'])->name('edit');
    //     Route::post('update/{id}', [AgentController::class, 'update'])->name('update');
    //     Route::post('delete', [AgentController::class, 'delete'])->name('delete');
    // });

    // Route::get('/page/{id}', [HomeController::class, 'page'])->name('page');

    // Route::post('check_conflicts', [ReservationControlller::class, 'checkConflicts'])->name('checkConflicts');

});

Auth::routes();
