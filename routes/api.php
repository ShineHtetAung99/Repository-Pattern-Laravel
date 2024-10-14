<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Api\OperationController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('store_customer',[OperationController::class,'storeCustomerData'])->name('store_customer');
Route::get('get_customer',[OperationController::class,'allCustomerData'])->name('get_customer');
Route::post('update_customer',[OperationController::class,'updateCustomerData'])->name('update_customer');
Route::post('delete_customer',[OperationController::class,'deleteCustomerData'])->name('delete_customer');

Route::post('customer_upload',[OperationController::class,'customerUploadData'])->name('customer_upload');



Route::get('show-file/{fileId}',[FileController::class,'showFile'])->name('file_show');
Route::get('download/{fileId}',[FileController::class,'downFile'])->name('file_down');
Route::delete('delete/{fileId}',[FileController::class,'deleteFile'])->name('file_delete');
