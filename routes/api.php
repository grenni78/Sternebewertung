<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Inertia\ApiTokenController;
use Laravel\Jetstream\Jetstream;
use \App\Http\Controllers\MessagesController;
use \App\Http\Controllers\UpdatesController;

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

Route::prefix('v1_1')
    ->middleware('auth')
    ->group(function () {

        Route::get('messages', [MessagesController::class, 'api_get_messages'])->name('messages');
        Route::get('message/{id}', [MessagesController::class, 'api_get_message'])->name('message');
        Route::post('messages', [MessagesController::class, 'api_post_message'])->name('post_message');
        Route::post('messages/mark-read', [MessagesController::class, 'api_mark_read'])->name('mark-read');

        Route::get('user', function (Request $request) {
            return $request->user();
        })->name('userinfo');

        Route::get('updates', [UpdatesController::class, 'api_get_updates'])->name('updates');

        if (Jetstream::hasApiFeatures()) {
            Route::get('user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            Route::post('user/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
            Route::put('user/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
            Route::delete('user/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
        }

    });
