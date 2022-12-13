<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ChamberMaidRoomController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ObservationController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('userProfile', [AuthController::class, 'userProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('showInformation/{id}', [RoomController::class, 'showInformation']);
    Route::put('changePassword', [AuthController::class, 'changePassword']);
});

Route::prefix('building')->group(function(){
    Route::get('index', [BuildingController::class, 'index']);
    Route::post('store', [BuildingController::class, 'store']);
    Route::put('update/{id}', [BuildingController::class, 'update']);
    Route::get('show/{id}', [BuildingController::class, 'show']);
    Route::delete('delete/{id}', [BuildingController::class, 'destroy']);
});

Route::prefix('logs')->group(function(){
    Route::get('index', [LogController::class, 'index']);
});

Route::prefix('rooms')->group( function(){
    Route::get('index', [RoomController::class, 'index']);
    Route::post('store', [RoomController::class, 'store']);
    Route::put('update/{id}', [RoomController::class, 'update']);
    Route::get('show/{id}', [RoomController::class, 'show']);
    Route::delete('delete/{id}', [RoomController::class, 'destroy']);
});

Route::prefix('observations')->group( function(){
    Route::post('store', [ObservationController::class, 'store']);
    Route::get('show/{id}', [ObservationController::class, 'show']);
});

Route::prefix('chamberMaidRooms')->group(function(){
    Route::get('show/{id}', [ChamberMaidRoomController::class, 'show']);
});

Route::resource('users', UserController::class);
