<?php

use App\Http\Controllers\Api\Core\AuthController;
use App\Http\Controllers\Api\Core\CategoriesController;
use App\Http\Controllers\Api\Core\NewsController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1/web')->middleware(['api'])->group(function() {

    Route::prefix('auth')->group(function(){
        Route::post('/register', [AuthController::class, 'postRegister']);
        Route::post('/login', [AuthController::class, 'postLogin']);
        Route::post('/logout', [AuthController::class, 'postLogout'])->middleware(['jwt.verify']);
    });
    
    Route::group(['middleware' => ['jwt.verify']], function() {

        Route::get('/all/users', [AuthController::class, 'getAllUser']);

        Route::prefix('catagory')->group(function(){
            Route::get('/', [CategoriesController::class, 'getsCategory']);
            Route::get('/{id}', [CategoriesController::class, 'getCategory']);
            Route::post('/', [CategoriesController::class, 'postCategory']);
            Route::put('/update/{id}', [CategoriesController::class, 'updateCategory']);
            Route::delete('/delete/{id}', [CategoriesController::class, 'deleteCategory']);

        });

        Route::prefix('news')->group(function(){
            Route::get('/', [NewsController::class, 'getsNews']);
            Route::get('/{id}', [NewsController::class, 'getNews']);
            Route::post('/', [NewsController::class, 'postNews']);
            Route::put('/update/{id}', [NewsController::class, 'updateNews']);
            Route::delete('/delete/{id}', [NewsController::class, 'deleteNews']);

        });
    });

});