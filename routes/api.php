<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware'=>['api',/*'pass1'*/'lang1']],function () {
    Route::post('get-main-categories',[CategoryController::class,'index']);
    Route::post('get-category-byId', [CategoryController::class,'getCategoryById']);
    Route::post('change-category-status', [CategoryController::class,'changeStatus']);

    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        Route::post('login', [App\Http\Controllers\Api\Admin\AuthController::class,'login']);

        Route::post('logout',[App\Http\Controllers\Api\Admin\AuthController::class,'logout']) -> middleware(['auth.guard:admin-api']);
        //invalidate token security side

        //broken access controller user enumeration
    });

    Route::group(['prefix' => 'user','namespace'=>'User'],function (){
        Route::post('login',[App\Http\Controllers\Api\User\AuthController::class, 'Login']) ;
    });


    Route::group(['prefix' => 'user' ,'middleware' => 'auth.guard:user-api'],function (){
        Route::post('profile',function(){
            return  Auth::user(); // return authenticated user data
        }) ;


    });

});

Route::group(['middleware'=>['api','pass1','lang1','auth.guard:admin-api']],function () {
    Route::get('offers', [CategoryController::class, 'index']);
});

