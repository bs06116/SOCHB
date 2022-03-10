<?php

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
Route::get('/linkstorage', function () {
   // Artisan::call('storage:link');
   $exitCode = Artisan::call('config:cache');
   $exitCode = Artisan::call('cache:clear');


});

Route::group(['prefix' => 'admin'], function() {

Auth::routes(['verify'=>true]);

});

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/components', function(){
        return view('components');
    })->name('components');
    Route::resource('users', 'UserController');
    Route::get('/profile/{user}', 'UserController@profile')->name('profile.edit');
    Route::post('/profile/{user}', 'UserController@profileUpdate')->name('profile.update');
    Route::resource('roles', 'RoleController')->except('show');
    Route::resource('permissions', 'PermissionController')->except(['show','destroy','update']);
    Route::resource('category', 'CategoryController')->except('show');

    Route::resource('post', 'PostController');
    Route::resource('companies', 'CompanyController');
    Route::resource('locations', 'LocationController');
    Route::resource('locationstype', 'LocationTypeController');
    Route::resource('siem', 'SIEMController');
    Route::resource('siemtype', 'SIEMTypeController');
    Route::resource('vendors', 'VendorsController');
    Route::resource('assetcategorydetail', 'AssetCategoryDetailController');
    Route::resource('assetcategorymaintype', 'AssetCategoryMainTypeController');
    Route::resource('assetcategorysubtype', 'AssetCategorySubTypeController');
    Route::resource('assetresourcemaintype', 'AssetResourceMainTypeController');
    Route::resource('applicationresourcecategory', 'ApplicationResourceCategoryController');
    Route::resource('assetapplication', 'AssetApplicationController');
    Route::resource('assetmanagement', 'AssetManagementController');
    Route::get('/activity-log', 'SettingController@activity')->name('activity-log.index');
    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::post('/settings', 'SettingController@update')->name('settings.update');
    // Route::post('/AssetManagement/storeSIEMRef', 'AssetManagementController@storeSIEMRef')->name('storeSIEMRef');
    // Route::get('/AssetManagement/loadSIEMRef', 'AssetManagementController@loadSIEMRef')->name('assetmanagement.loadSIEMRef');
    // Route::delete('/AssetManagement/SIEMRefDestory', 'AssetManagementController@SIEMRefDestory')->name('assetmanagement.SIEMRefDestory');
    Route::post('load-subtype', 'AssetCategoryDetailController@loadSubType')->name('assetcategorydetail.loadSubType');
    Route::post('load-siem', 'AssetManagementController@loadSIEM')->name('assetmanagement.loadSIEM');
    Route::post('load-location', 'AssetManagementController@loadLocation')->name('assetmanagement.loadLocation');
    Route::post('load-assetapplication', 'AssetManagementController@loadAssetApplication')->name('assetmanagement.loadAssetApplication');






    // Route::get('media', function (){
    //     return view('media.index');
    // })->name('media.index');
});
