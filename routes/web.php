<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\NetworkMonitorController;
use App\Http\Controllers\ServerMonitorController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PENTING: Letakkan Route::resource di ATAS route khusus lainnya
    Route::resource('tickets', TicketController::class);
    
    // Route khusus untuk tickets (harus setelah resource)
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/tickets/export/pdf', [TicketController::class, 'exportPdf'])->name('tickets.exportPdf');
    Route::post('/tickets/{ticket}/approve-manager', [TicketController::class, 'approveManager'])->name('tickets.approveManager');
    Route::post('/tickets/{ticket}/approve-it', [TicketController::class, 'approveIt'])->name('tickets.ithead.approve');
    Route::get('/tickets/{ticket}/print', [TicketController::class, 'printTicket'])->name('tickets.printTicket');
    Route::post('tickets/{ticket}/manager/approve', [TicketController::class, 'approveManager'])->name('tickets.manager.approve');
    Route::post('tickets/{ticket}/reject', [TicketController::class, 'rejectTicket'])->name('tickets.reject');

    // Route lainnya...
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/upload-data-assets', [AssetController::class, 'showImportForm'])->name('assets.import.form');
    Route::post('/upload-data-assets', [AssetController::class, 'importProcess'])->name('assets.import.process');
    Route::resource('assets', AssetController::class);

    Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('knowledgebase.index');
   
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export-pdf', [AnalyticsController::class, 'exportPdf'])->name('analytics.export.pdf');
    
    // API routes untuk real-time bandwidth
    Route::get('/api/bandwidth/data', [AnalyticsController::class, 'getBandwidthData'])->name('api.bandwidth.data');
    Route::get('/api/bandwidth/history', [AnalyticsController::class, 'getBandwidthHistory'])->name('api.bandwidth.history');

    Route::get('/network-monitor', [NetworkMonitorController::class, 'index'])->name('monitor.index');
    
    // ServerMonitorController tidak di-import, tambahkan jika diperlukan
    // use App\Http\Controllers\ServerMonitorController;
    
    Route::get('/monitor/servers', [ServerMonitorController::class, 'index'])->name('monitor.servers');
    Route::get('/monitor/api/data', [ServerMonitorController::class, 'getServerData'])->name('monitor.api');
    Route::get('/monitor/api/ping', [ServerMonitorController::class, 'checkStatus']);
});