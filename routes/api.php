<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:user-api'] ], function () {
    Route::get('/profile', function(Request $request) {
        return Auth::user();
    });
        Route::get('dashboard/getData',[DashboardController::class, 'getData']);



        Route::get('admin/index',[UserController::class, 'index']);
        Route::post('admin/create',[UserController::class, 'store']);
        Route::get('admin/show/{id}',[UserController::class, 'show']);
        Route::post('admin/update/{id}',[UserController::class, 'update']);
        Route::delete('admin/delete/{admin}',[UserController::class, 'destroy']);
        
        Route::get('employee/index',[EmployeeController::class, 'index']);
        Route::post('employee/create',[EmployeeController::class, 'store']);
        Route::get('employee/show/{id}',[EmployeeController::class, 'show']);
        Route::post('employee/update/{id}',[EmployeeController::class, 'update']);
        Route::delete('employee/delete/{employee}',[EmployeeController::class, 'destroy']);
        
        Route::get('customer/index',[CustomerController::class, 'index']);
        Route::post('customer/create',[CustomerController::class, 'store']);
        Route::get('customer/show/{id}',[CustomerController::class, 'show']);
        Route::post('customer/update/{id}',[CustomerController::class, 'update']);
        Route::delete('customer/delete/{customer}',[CustomerController::class, 'destroy']);    

        Route::get('equipment/index',[EquipmentController::class, 'index']);
        Route::get('equipment/checking',[EquipmentController::class, 'checking']);
        Route::post('equipment/create',[EquipmentController::class, 'store']);
        Route::get('equipment/show/{id}',[EquipmentController::class, 'show']);
        Route::post('equipment/update/{id}',[EquipmentController::class, 'update']);
        Route::get('equipment/generate/{id}',[EquipmentController::class, 'generate']);
        Route::delete('equipment/delete/{equipment}',[EquipmentController::class, 'destroy']);    

        Route::get('subscription/index',[SubscriptionController::class, 'index']);
        Route::post('subscription/create',[SubscriptionController::class, 'store']);
        Route::get('subscription/show/{id}',[SubscriptionController::class, 'show']);
        Route::post('subscription/update/{id}',[SubscriptionController::class, 'update']);
        Route::delete('subscription/delete/{subscription}',[SubscriptionController::class, 'destroy']);

        Route::get('membership/index',[MembershipController::class, 'index']);
        Route::post('membership/create',[MembershipController::class, 'store']);
        Route::get('membership/show/{id}',[MembershipController::class, 'show']);
        Route::post('membership/update/{id}',[MembershipController::class, 'update']);
        Route::delete('membership/delete/{membership}',[MembershipController::class, 'destroy']);     
        
        Route::get('payment/index',[PaymentController::class, 'index']);
        Route::post('payment/create',[PaymentController::class, 'store']);
        Route::get('payment/show/{id}',[PaymentController::class, 'show']);
        Route::post('payment/update/{id}',[PaymentController::class, 'update']);
        Route::post('payment/subscription_payment',[PaymentController::class, 'payment']);
        Route::delete('payment/delete/{payment}',[PaymentController::class, 'destroy']);       


    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});
