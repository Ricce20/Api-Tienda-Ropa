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
    //employees register
    Route::post('/employee-register',[UserRegisterController::class,'RegisterEmployee'])->name('register-employee');
    Route::post('/user-employee-register',[UserRegisterController::class, 'UserEndEmployeeRegister'])->name('register-user-employee');
    Route::put('/employee-edit/{id}',[UserRegisterController::class, 'editEmpleyee'])->name('edit-employee');
    Route::delete('/employee-delete/{id}',[UserRegisterController::class, 'deleteEmployee'])->name('delete-employee');
    Route::delete('/user-delete/{id}',[UserRegisterController::class, 'enableUser'])->name('enableUser');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    //gestion products
    Route::apiResource('/categories', CategoryController::class);//
    Route::apiResource('/suppliers', SupplierController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/entries',ProductEntryController::class);
});


//customers
Route::group(['middleware' => ['auth:sanctum', 'check_user_type:2']], function () {

});