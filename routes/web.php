<?php
use App\Http\Controllers\ContactController;

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

Auth::routes();

Route::get('/', [ContactController::class, 'index'])->name('/');
Route::middleware(['auth'])->group(function () {
    Route::get('/create', [ContactController::class, 'createContact']);
    Route::post('/store-contact', [ContactController::class, 'storeContact']);
    Route::get('/edit-contact/{id}', [ContactController::class, 'editContact']);
    Route::post('/update-contact/{id}', [ContactController::class, 'updateContact']);
    Route::delete('/delete-contact/{id}', [ContactController::class, 'destroyContact']);
    Route::get('/search-contacts', [ContactController::class, 'searchContacts'])->name('search.contacts');
});

