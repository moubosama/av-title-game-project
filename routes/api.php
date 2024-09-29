<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('customers/{customer_id}', [ApiController::class, 'getCustomer']);
Route::put('customers/{customer_id}', [ApiController::class, 'putCustomer']);
Route::delete('customers/{customer_id}', [ApiController::class, 'deleteCustomer']);

Route::get('reports', [ApiController::class, 'getReports']);
Route::post('reports', [ApiController::class, 'postReport']);
Route::get('reports/{report_id}', [ApiController::class, 'getReport']);
Route::put('reports/{report_id}', [ApiController::class, 'putReport']);
Route::delete('reports/{report_id}', [ApiController::class, 'deleteReport']);

Route::get('customers', function() {
    return response()->json();
});

Route::get('customers', function () {
    return response()->json(\App\Models\Customer::query()->select(['id', 'name'])->get());
});


Route::post('customers', function (\Illuminate\Http\Request $request) {
    $customer = new \App\Models\Customer();
    $customer->name = $request->json('name');
    $customer->save();
});


Route::post('customers', function (\Illuminate\Http\Request $request) {
    // 検証
    if (!$request->json('name')) {
        return response()
            ->make('', \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $customer = new \App\Models\Customer();
    $customer->name = $request->json('name');
    $customer->save();
});



