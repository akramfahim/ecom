<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;

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




// Admin Area

Route::prefix('app')->middleware([AdminCheck::class])->group(function(){

    //category Crud
    Route::post('add_category', 'AdminController@addCategory');
    Route::get('all_categories', 'AdminController@allCategories');
    Route::post('edit_category', 'AdminController@editCategory');
    Route::post('delete_category', 'AdminController@deleteCategory');

    //product CRUD
    Route::post('add_product','AdminController@addProduct');
    Route::get('all_products','AdminController@allProducts');
    Route::post('edit_product','AdminController@editProduct');
    Route::post('delete_product','AdminController@deleteProduct');

    //Admin User CRUD
    Route::post('add_adminuser','AdminController@addAdminUser');
    Route::get('all_adminusers','AdminController@allAdminUsers');
    Route::post('edit_adminuser','AdminController@editAdminUser');
    Route::post('delete_adminuser','AdminController@deleteAdminUser');
    // Photo Upload
    Route::post('upload_image','AdminController@uploadImage');

    // Admin Login
    Route::post('login_admin','AdminController@loginAdmin');

});

Route::get('/', 'AdminController@index');
Route::get('/logout', 'AdminController@logout');
Route::get('/welcome', function () {
    return view('welcome');
});

Route::any('{slug}','AdminController@index');





