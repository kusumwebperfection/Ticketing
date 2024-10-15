<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\adminUserController;
use App\Http\Controllers\PermissionController;
// Route::get('/', function () {
//     return view('login');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('dashboard', 'DashboardController');
Route::post('locale/switch', 'App\Http\Controllers\LocaleController@switchLocale')->name('locale.switch');
Route::group(['middleware' => 'permission:Manage Roles'], function () {
    Route::resource('roles', RoleController::class);   
    Route::put('roles/{role}/permissions/{permission}', [RoleController::class, 'give_permission'])->name('roles.permissions.give');
});
Route::group(['middleware' => 'permission:Manage Permissions'], function () {
    Route::resource('permissions', PermissionController::class);
});
Route::group(['middleware' => 'permission:Manage Users'], function () {
    Route::resource('users', adminUserController::class);  
});


    // Route::group(['middleware' => ['auth', CheckPermission::class . ':permission1,permission2']], function () {
    //     Route::resource('roles', RoleController::class);
    //     Route::resource('permissions', PermissionController::class);
    //     Route::put('roles/{role}/permissions/{permission}', [RoleController::class, 'give_permission'])->name('roles.permissions.give');
    //     Route::resource('users', adminUserController::class);
    // });
