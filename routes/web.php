<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Students;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\MemberProjectsController;
use App\Http\Controllers\SharedContactController;
use App\Http\Livewire\Contacts;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('students', Students::class)->name('students');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('profile', Profile::class)->name('profile');
    Route::resource('contact', ContactController::class);
    Route::get('contacts', Contacts::class)->name('contacts');
    Route::post('contactImport', [ContactController::class, 'import'])->name('contact.import');
    Route::get('vcf/{id}', [ContactController::class, 'vcf'])->name('vcf');
    Route::post('shareContact', [SharedContactController::class, 'share'])->name('share.contact');
    Route::get('shared/{id}', [SharedContactController::class, 'show'])->name('shared.show');
    Route::post('acceptContact/{id}', [SharedContactController::class, 'accept'])->name('acceptContact');
    Route::post('rejectContact/{id}', [SharedContactController::class, 'reject'])->name('rejectContact');
    Route::get('download', [SharedContactController::class, 'download'])->name('download');
    Route::post('/profile/update_password', [ProfileController::class, 'passwordUpdate'])->name('password.update');
});
