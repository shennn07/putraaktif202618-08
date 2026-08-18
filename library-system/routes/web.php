<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowController as AdminBorrowController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReturnController as AdminReturnController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\User\BorrowController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes — bisa diakses tanpa login
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Student Routes — wajib login sebagai siswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::post('/borrow/{book}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::post('/borrow/{borrowing}/cancel', [BorrowController::class, 'cancel'])->name('borrow.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Routes — wajib login sebagai admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/books', [AdminBookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [AdminBookController::class, 'create'])->name('books.create');
    Route::post('/books', [AdminBookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [AdminBookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [AdminBookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])->name('books.destroy');

    Route::get('/borrowings', [AdminBorrowController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{borrowing}/accept', [AdminBorrowController::class, 'accept'])->name('borrowings.accept');
    Route::post('/borrowings/{borrowing}/reject', [AdminBorrowController::class, 'reject'])->name('borrowings.reject');

    Route::post('/returns/{borrowing}', [AdminReturnController::class, 'update'])->name('returns.update');
});
