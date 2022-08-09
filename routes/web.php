<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/notes', [NotesController::class, 'index'])->name('notes.index');
// Route::get('/notes/{note}/store', [NotesController::class, 'store'])->name('notes.store');
// Route::get('/notes/{note}/delete', [NotesController::class, 'destroy'])->name('notes.destroy');
Route::resource('notes', NotesController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
