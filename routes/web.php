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

Route::get('/', function () {
    return view('admin');
});
Route::get('/welcome', function () {
    return view('welcome');
});

Route::any('{slug}',function(){
    return view('admin');
});






// Admin Area

//category Crud
Route::post('/app/add_category', 'AdminController@addCategory');
Route::get('/app/all_categories', 'AdminController@allCategories');
Route::post('/app/edit_category', 'AdminController@editCategory');
Route::post('/app/delete_category', 'AdminController@deleteCategory');

//product CRUD
Route::post('/app/add_product','AdminController@addProduct');
Route::get('/app/all_products','AdminController@allProducts');
Route::post('/app/edit_product','AdminController@editProduct');
Route::post('/app/delete_product','AdminController@deleteProduct');

//Admin User CRUD
Route::post('/app/add_adminuser','AdminController@addAdminUser');
Route::get('/app/all_adminusers','AdminController@allAdminUsers');


Route::post('/app/upload_image','AdminController@uploadImage');
