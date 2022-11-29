<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;
use Laravel\Jetstream\Http\Controllers\Inertia\OtherBrowserSessionsController;
use Laravel\Jetstream\Http\Controllers\Inertia\ProfilePhotoController;
use Laravel\Jetstream\Jetstream;
use \App\Http\Controllers\MessagesController;
use \App\Http\Controllers\PushController;
use \App\Http\Controllers\ReviewsController;
use \App\Http\Controllers\UserDetailController;
use \App\Http\Controllers\UserProfileController;

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

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/profile-details', [UserDetailController::class, 'index'])->name('profile-details');

    Route::put('/profile-details/update', [UserDetailController::class, 'update'])->name('profile-details.update');

});
Route::get('/', function () {

    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');

Route::group(['middleware' => ['auth:sanctum', 'verified', 'profile_ready']], function () {

    Route::get('/dashboard/{option?}', function ($option = 0) {
        return Inertia::render(
            'Dashboard',
            [
                'userId' => Auth::user()->id,
                'option' => $option,
            ]
        );
    })->name('dashboard');

    Route::get('/reviews', [ReviewsController::class, 'index'])->name('reviews');
    Route::get('/reviews/posted', [ReviewsController::class, 'posted'])->name('reviews.posted');
    Route::get('/reviews/confirmed', [ReviewsController::class, 'confirmed'])->name('reviews.confirmed');
    Route::get('/reviews/waiting', [ReviewsController::class, 'waiting'])->name('reviews.waiting');
    Route::get('/reviews/faulty', [ReviewsController::class, 'faulty'])->name('reviews.faulty');

    Route::get('/messages/{contact?}', [MessagesController::class, 'index'])->name('messages');
    //    Route::get('/messages/inbox', [MessagesController::class, 'inbox'])->name('messages.inbox');
    //    Route::get('/messages/outbox', [MessagesController::class, 'index'])->name('messages.outbox');
    //    Route::get('/messages/trash', [MessagesController::class, 'trash'])->name('messages.trash');

    //store a push subscriber.
    Route::post('/push', [PushController::class, 'store']);
    //delete a push subscriber.
    Route::post('/push/delete', [PushController::class, 'delete']);

});

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/agb', function () {
            return Inertia::render('TermsOfService');
        })->name('terms');
        Route::get('/datenschutz', function () {
            return Inertia::render('PrivacyPolicy');
        })->name('policy');
    }

    Route::group(['middleware' => ['auth', 'verified']], function () {
        // User & Profile...
        Route::get('/user/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');

        Route::delete('/user/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
            ->name('other-browser-sessions.destroy');

        Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])
            ->name('current-user-photo.destroy');

        if (Jetstream::hasAccountDeletionFeatures()) {
            Route::delete('/user', [CurrentUserController::class, 'destroy'])
                ->name('current-user.destroy');
        }

    });
});
