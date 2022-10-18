<?php

use Illuminate\Support\Facades\Route;;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CheckRolController;
use App\Http\Controllers\RedirectController;

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
//login - register - logout
Route::get('/', function () {return view('login');})->middleware('CheckLogin');
Route::post('/login-user',[LoginController::class,'loginUser'])->name('login-user')->middleware('CheckLogin');
Route::get('/registration', [RegisterController::class,'registration'])->middleware('CheckLogin');
Route::post('/register-user',[RegisterController::class, 'registerUser'])->name('register-user')->middleware('CheckLogin');
Route::get('/logout',[LoginController::class,'logout']);

//dashboards
Route::get('/dashboard', [RedirectController::class,'dashboard'])->middleware('CheckRol:login');
Route::get('/user_dashboard', [RedirectController::class,'user_dashboard'])->middleware('CheckRol:login');
Route::get('/admin_dashboard', [RedirectController::class,'admin_dashboard'])->middleware('CheckRol:view_users');

Route::get('/edit/{id}',[RedirectController::class, 'user_edit'])->middleware('CheckRol:edit_users');
Route::post('/edit/{id}', [RedirectController::class, 'edit'])->name('edit.store')->middleware('CheckRol:edit_users');

Route::get('/delete/{id}',[RedirectController::class,'user_delete'])->middleware('CheckRol:delete_users');
Route::post('/delete/{id}', [RedirectController::class, 'delete'])->name('delete.store')->middleware('CheckRol:delete_users');

Route::get('/add',[RedirectController::class, 'user_add'])->middleware('CheckRol:add_users');
Route::post('/add',[RedirectController::class,'add'])->name('add')->middleware('CheckRol:add_users');

//rol dashboard
Route::get('/manage', [RedirectController::class,'manage'])->middleware('CheckRol:manage_perms');

Route::get('/editrol/{id}',[RedirectController::class, 'rol_edit'])->middleware('CheckRol:edit_rols');
Route::post('/editrol/{id}', [RedirectController::class, 'editrol'])->name('editrol.store')->middleware('CheckRol:edit_rols');

Route::get('/deleterol/{id}',[RedirectController::class,'rol_delete'])->middleware('CheckRol:delete_rols');
Route::post('/deleterol/{id}', [RedirectController::class, 'deleterol'])->name('deleterol.store')->middleware('CheckRol:delete_rols');

Route::get('/addrol',[RedirectController::class, 'rol_add'])->middleware('CheckRol:add_rols');
Route::post('/addrol',[RedirectController::class,'addrol'])->name('addrol')->middleware('CheckRol:add_rols');

//password reset
Route::get('/passwordforgot',[RedirectController::class,'passwordforgot'])->middleware('CheckLogin');
Route::post('/passwordreset',[RedirectController::class,'passwordreset'])->name('passwordreset')->middleware('CheckLogin');

Route::get('/resetpassword/{token}',[RedirectController::class,'resetpassword'])->name('resetpassword');
Route::post('/reset',[RedirectController::class,'reset'])->name('reset');
