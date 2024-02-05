<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//controllers
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductEntryController;
use App\Http\Controllers\DetailOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//public

Route::post('/register-cliente',[UserRegisterController::class,'UserEndCustomerRegister'])->name('register-customer');
Route::post('/login',[AuthController::class,'login'])->name('login');


//employees
Route::group(['middleware' => ['auth:sanctum', 'check_user_type:1']], function () {
    //employees
    Route::get('/employees',[UserRegisterController::class,'getEmployees'])->name('employees-get');
    Route::get('/employees/{id}',[UserRegisterController::class,'idEmployee'])->name('employees-id');
    Route::post('/user-employee-register',[UserRegisterController::class, 'UserEndEmployeeRegister'])->name('register-user-employee');
    Route::put('/employee-edit/{id}',[UserRegisterController::class, 'editEmpleyee'])->name('edit-employee');
    Route::delete('/employee-delete/{id}',[UserRegisterController::class, 'deleteEmployee'])->name('delete-employee');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    //gestion products
    Route::apiResource('/categories', CategoryController::class);//
    Route::apiResource('/suppliers', SupplierController::class);
    Route::apiResource('/products', ProductController::class);
    Route::get('/orders',[OrderController::class,'getOrders'])->name('get_orders');
    Route::get('/detalles/{id}',[DetailOrderController::class,'getDetails'])->name('get_details');
    Route::apiResource('/entries',ProductEntryController::class);
    Route::post('/detalles/increment/{id}',[DetailOrderController::class,'incrementQuantity'])->name('increment_Quantity');

    //customers
    Route::get('/getCustomers',[CustomerController::class,'getCustomers'])->name('getCustomers');
});



//customers
Route::group(['middleware' => ['auth:sanctum', 'check_user_type:2']], function () {

});