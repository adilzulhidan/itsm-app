<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;



Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/tickets/export/pdf', [TicketController::class, 'exportPdf'])->name('tickets.exportPdf');
    Route::post('/tickets/{ticket}/approve-manager', [TicketController::class, 'approveManager'])->name('tickets.approveManager');
    Route::post('/tickets/{ticket}/approve-it', [TicketController::class, 'approveIt'])->name('tickets.approveIt');
    Route::get('/tickets/{ticket}/print', [TicketController::class, 'printTicket'])->name('tickets.printTicket');
    
    
    Route::resource('tickets', TicketController::class);
    
    
    Route::resource('users', UserController::class);

    Route::post('tickets/{ticket}/manager/approve', [TicketController::class, 'approveManager'])
    ->name('tickets.manager.approve')
    ->middleware('can:approve-manager');
    Route::post('tickets/{ticket}/reject', [TicketController::class, 'rejectTicket'])
    ->name('tickets.reject')
    ->middleware('can:reject-ticket');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

   

});