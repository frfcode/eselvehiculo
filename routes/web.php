<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


//USER GLOBAL ROUTERS
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/lista/{category}', 'App\Http\Controllers\HomeController@searchCategory')->name('category');
Route::get('/vehiculo/{brand}', 'App\Http\Controllers\VehiculoController@index')->name('vehiculo');
Route::get('/vehiculo/details/{brand}', 'App\Http\Controllers\VehiculoController@compatible')->name('vehiculo');
Route::get('/catalog-exports', 'App\Http\Controllers\HomeController@exports');


//ADMIN ROUTERS
Auth::routes();

//MENU ADMIN ITEMS
Route::get('/admin', 'App\Http\Controllers\HomeController@admin')->middleware('auth');
//Route::get('/admin/vehiculos', 'App\Http\Controllers\AdminController@vehiculos')->middleware('auth');
Route::get('/admin/code', 'App\Http\Controllers\AdminController@code')->middleware('auth');
Route::get('/admin/products', 'App\Http\Controllers\AdminController@products')->middleware('auth');
Route::get('/admin/selling', 'App\Http\Controllers\AdminController@selling')->middleware('auth');
/* Route::get('/admin/history', 'App\Http\Controllers\AdminController@history')->middleware('auth'); */
Route::get('/admin/categories', 'App\Http\Controllers\AdminController@categories')->middleware('auth');
Route::get('/admin/clients', 'App\Http\Controllers\AdminController@clients')->name('home')->middleware('auth');
Route::get('/admin/change_password', 'App\Http\Controllers\AdminController@change_password')->name('home')->middleware('auth');



//CRUD CLIENTS
Route::post('/admin/add-client', 'App\Http\Controllers\ClientsController@createClient')->middleware('auth')->name('add-client');
Route::get('/admin/get-clients', 'App\Http\Controllers\ClientsController@getClients')->middleware('auth')->name('get-clients');
Route::delete('/admin/delete-client/{item}', 'App\Http\Controllers\ClientsController@deleteClient')->middleware('auth')->name('delete-client');

//CRUD CATEGORY
Route::post('/admin/add-category', 'App\Http\Controllers\CategoriesController@createCategory')->middleware('auth')->name('add-category');
Route::get('/admin/get-categories', 'App\Http\Controllers\CategoriesController@getCategories')->middleware('auth')->name('get-categories');
Route::delete('/admin/delete-category/{item}', 'App\Http\Controllers\CategoriesController@deleteCategory')->middleware('auth')->name('delete-category');

//CRUD CODES
Route::get('/admin/get-codes', 'App\Http\Controllers\CodesController@getCodes')->middleware('auth')->name('get-code');
Route::post('/admin/add-code', 'App\Http\Controllers\CodesController@createCode')->middleware('auth')->name('add-code');
Route::delete('/admin/delete-code/{item}', 'App\Http\Controllers\CodesController@deleteCode')->middleware('auth')->name('delete-code');

//CRUD PRODUCTS
Route::post('/admin/add-product', 'App\Http\Controllers\ProductsController@addProduct')->middleware('auth')->name('add-product');
Route::get('/admin/find-product/{item}', 'App\Http\Controllers\ProductsController@findProduct')->middleware('auth')->name('find-product');
Route::get('/admin/get-products', 'App\Http\Controllers\ProductsController@getProducts')->middleware('auth')->name('get-products');
Route::delete('/admin/delete-product/{item}', 'App\Http\Controllers\ProductsController@deleteProduct')->middleware('auth')->name('delete-product');
Route::get('/admin/get-products-distict', 'App\Http\Controllers\ProductsController@getProductsDistict')->middleware('auth')->name('get-products-distict');
Route::put('/admin/edit-product', 'App\Http\Controllers\ProductsController@editProduct')->middleware('auth')->name('edit-product');

//EXPORT PDF
Route::get('/admin/exports/{item}', 'App\Http\Controllers\AdminController@exports')->middleware('auth');

//MENU SAVE CONFIG
Route::post('/admin/save-config-menu', 'App\Http\Controllers\CategoriesController@configMenu')->middleware('auth')->name('save-config-menu');

//VEHICULOS
Route::get('/admin/get-vehicules', 'App\Http\Controllers\VehiculoController@getVehicules')->middleware('auth')->name('get-vehicules');

//SELLING
Route::post('/admin/generate-selling', 'App\Http\Controllers\BillingController@create')->middleware('auth')->name('generate-selling');
Route::get('/admin/facture/{id}', 'App\Http\Controllers\BillingController@generateFacture')->middleware('auth');
Route::get('/admin/sales-history', 'App\Http\Controllers\BillingController@historySales')->middleware('auth');
Route::delete('/admin/delete-selling/{item}', 'App\Http\Controllers\BillingController@deleteSales')->middleware('auth')->name('delete-selling');
