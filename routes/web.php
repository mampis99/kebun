<?php

use Illuminate\Support\Facades\Route;
// use Auth;

// Route::get('/', function () {
//     return view('templates/index');
// })->name('dashboard');

// Route::get('login', 'LoginController@index')->name('login');

// Auth::routes();

Route::get('auth-google', 'LoginController@authGoogle')->name('auth-google');
Route::get('/google/redirect', 'LoginController@googleCallback')->name('auth-google-callback');

// Route::group(['middleware' => 'web'], function () {
Route::group(['middleware' => ['web']], function () {
    
Route::get('/', 'LoginController@index')->name('login');
Route::post('login-post', 'LoginController@postLogin')->name('login-post');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::prefix('users')->group(function () {
    Route::get('/', 'UsersController@index')->name('users');
    Route::get('data', 'UsersController@data')->name('users-datatable');
    Route::post('save', 'UsersController@add')->name('users-add');
    Route::post('delete', 'UsersController@delete')->name('users-delete');
});

Route::prefix('user-roles')->group(function () {
    Route::get('/', 'UserRolesController@index')->name('user-roles');
    Route::get('form', 'UserRolesController@form')->name('user-roles-form');
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('tes', 'DashboardController@tes')->name('teeeees');
});

Route::prefix('perusahaan')->group(function () {
    Route::get('/', 'PerusahaanController@index')->name('perusahaan');
    Route::post('add', 'PerusahaanController@add')->name('perusahaan-add');    
    Route::get('datatable', 'PerusahaanController@datatable')->name('perusahaan-datatable');
    Route::get('form-edit/{id}', 'PerusahaanController@formEdit')->name('perusahaan-form-edit');
    Route::post('update', 'PerusahaanController@update')->name('perusahaan-update');    
});

Route::prefix('kebun')->group(function () {
    Route::get('/', 'KebunController@index')->name('kebun');
    Route::get('data', 'KebunController@data')->name('kebun-data');
    Route::post('add', 'KebunController@add')->name('kebun-add');
    Route::post('edit', 'KebunController@edit')->name('kebun-edit');
    Route::get('delete', 'KebunController@delete')->name('kebun-delete');
    Route::post('datatable', 'KebunController@datatableKebun')->name('kebun-datatable');

    //chip
    Route::post('chip-datatable', 'KebunController@chipDatatable')->name('chip-datatable');
    Route::post('chip-add', 'KebunController@chipAdd')->name('chip-add');
    Route::post('chip-delete', 'KebunController@chipDelete')->name('chip-delete');

    //node
    Route::get('index-node', 'KebunController@indexNode')->name('node');
    Route::post('node-add', 'KebunController@nodeAdd')->name('node-add');
    Route::post('node-edit', 'KebunController@nodeEdit')->name('node-edit');
    Route::get('node-delete', 'KebunController@nodeDelete')->name('node-delete');
    Route::post('node-datatable', 'KebunController@nodeDatatable')->name('node-datatable');
    Route::post('node-delete', 'KebunController@deleteNode')->name('node-delete');
    

    Route::get('node-role-setting-datatable', 'KebunController@nodeRoleSettingDatatable')->name('node-role-setting-datatable');
    Route::post('map-setting-datatable', 'KebunController@mapSettingDatatable')->name('map-setting-datatable');
    Route::post('map-setting-add', 'KebunController@saveMapSettingDatatable')->name('map-setting-add');
    Route::post('map-setting-delete', 'KebunController@deleteMapSettingDatatable')->name('map-setting-delete');
});

Route::prefix('setting')->group(function () {
    Route::prefix('fitur')->group(function () {
        Route::get('/', 'FiturController@index')->name('fitur');
        Route::get('datatable', 'FiturController@datatable')->name('fitur-datatable');
        Route::get('list-datatable', 'FiturController@listFitur')->name('fitur-list-datatable');
        Route::post('add', 'FiturController@add')->name('fitur-add');
        Route::post('delete', 'FiturController@delete')->name('fitur-delete');        
        Route::get('tes', 'FiturController@tes')->name('tes');
    });
    Route::prefix('akses')->group(function () {
        Route::get('/', 'AksesController@index')->name('akses');
        Route::get('datatable', 'AksesController@datatable')->name('akses-datatable');
        Route::post('fitur-add', 'AksesController@aksesAdd')->name('akses-add');
        Route::post('list', 'AksesController@aksesList')->name('akses-list');
        Route::post('list-delete', 'AksesController@aksesListDelete')->name('akses-list-delete');
        Route::post('fiutr-list-delete', 'AksesController@fiturListDelete')->name('fitur-list-delete');
    });
});

});
//query
