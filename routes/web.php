<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShorturlController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'RoleBasedRedirect', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('shorturls', ShorturlController::class);
});
Route::middleware(['auth', 'role:SuperAdmin'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::resource('companies', CompanyController::class);
});
Route::middleware(['auth', 'role:SuperAdmin|Admin'])->group(function () {
    Route::get('company/{company}/invite', [InvitationController::class, 'invite'])->name('company.invite');
    Route::post('company/{company}/send-invitation', [InvitationController::class, 'sendInvitation'])->name('company.send-invitation');
    Route::get('company/{company}/members', MembersController::class)->name('company.members.index');
});


require __DIR__ . '/auth.php';

//short url routes
Route::get('/{short_url}', function ($short_url) {
    $shorturl = App\Models\Shorturl::where('short_url', $short_url)->firstOrFail();
    $shorturl->increment('hits');
    return redirect()->away($shorturl->original_url);
})->name('shorturl.redirect');
