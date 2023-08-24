<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MapController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\ShareSpotController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SpotCategoryController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleLoginController;


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

Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
    ->name('login.google');

Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
    ->name('login.google.callback');

// Route::resource("maps", MapController::class);

// Route::resource("characters", CharacterController::class)
// ->middleware(['auth']);

Route::resource("spots", SpotController::class)
->middleware(['auth', 'check.verified']);

Route::get("/", [ShareSpotController::class, 'index'])
->name('sharespots.index');

Route::get("sharespots/{spot}", [ShareSpotController::class, 'show'])
->name('sharespots.show');

Route::post('/spots/{spot}/like', [LikeController::class, 'store'])
->name('likes.store')
->middleware(['auth', 'check.verified']);

Route::delete('/spots/{spot}/like', [LikeController::class, 'destroy'])
->name('likes.destroy')
->middleware(['auth', 'check.verified']);

Route::post('/spotcategory', [SpotCategoryController::class, 'store'])
->name('spotcategory.store')
->middleware(['auth', 'check.verified']);

Route::delete('/spotcategory', [SpotCategoryController::class, 'destroy'])
->name('spotcategory.destroy')
->middleware(['auth', 'check.verified']);

Route::resource('/categories', CategoryController::class)
->middleware(['auth', 'check.verified']);

Route::resource('/tags', TagController::class)
->middleware(['auth', 'check.verified']);

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'check.verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/send-verification-email', 'VerificationController@sendEmail')->middleware('auth');


require __DIR__.'/auth.php';
