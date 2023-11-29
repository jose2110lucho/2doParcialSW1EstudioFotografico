<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPhotographerController;
use App\Http\Controllers\SelectRolController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ListGuests;
use App\Livewire\ListPhotographers;
use App\Http\Controllers\PictureController;
use App\Models\Picture;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    });
    Route::get('/select-rol', [SelectRolController::class, 'index']);
    Route::get('/select-rol/{rol}', [SelectRolController::class, 'updateRol']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('event', EventController::class);
    Route::get('event/{event}/guests', ListGuests::class)->name('events.guests');
    Route::get('event/{event}/photographers', ListPhotographers::class)->name('events.photographers');
    Route::get('event/listEvents/photographer', [EventPhotographerController::class, 'index'])->name('events.listEvents.photographer');
    Route::get('event/listEvents/photographer/show/{event}', [EventPhotographerController::class, 'show'])->name('events.listEvents.photographer.show');
    Route::get('event/{event}/gallery', [PictureController::class, 'index'])->name('event.gallery.index');
    Route::get('event/{event}/verify', [EventPhotographerController::class, 'verifyToken'])->name('verify.token');
    Route::post('event/{event}/confirm/{user}', [EventPhotographerController::class, 'eventConfirm'])->name('event.confirm');
    Route::get('event/{event}/gallery/create', [PictureController::class, 'create'])->name('event.gallery.create');
    Route::post('event/{event}/gallery/store', [PictureController::class, 'store'])->name('event.gallery.store');
    Route::post('event/{event}/gallery/delete/{picture}', [PictureController::class, 'destroy'])->name('event.gallery.destroy');

    Route::get('guest_invitations/{invitation}', [InvitationController::class, 'showGuestInvitation'])->name('guests.invitations.show');
    Route::get('guest_invitations/{invitation}/reject', [InvitationController::class, 'rejectGuestInvitation'])->name('guests.invitations.reject');
    Route::get('guest_invitations/{invitation}/accept', [InvitationController::class, 'acceptGuestInvitation'])->name('guests.invitations.accept');
});
