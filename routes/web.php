<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ComplaintAdminController;
use App\Http\Controllers\Admin\CaseController;
use App\Http\Controllers\Admin\ChildController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Ngo\NgoCaseController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Admin\StoryAdminController;
use App\Http\Controllers\Admin\ImpactController;

// ── PUBLIC ──────────────────────────────────────────────
Route::get('/', fn() => view('welcome'));

Route::get('/complaint',         [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/complaint',        [ComplaintController::class, 'store'])->name('complaint.store');
Route::get('/complaint/success/{trackingId}', [ComplaintController::class, 'success'])->name('complaint.success');
Route::get('/complaint/track',   [ComplaintController::class, 'track'])->name('complaint.track');

// Stories of Hope
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');

// ── AUTH ─────────────────────────────────────────────────
Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

// ── ADMIN ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/',            [DashboardController::class, 'index'])->name('dashboard');

    // Complaints
    Route::get('complaints',                  [ComplaintAdminController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{complaint}',      [ComplaintAdminController::class, 'show'])->name('complaints.show');
    Route::post('complaints/{complaint}/approve', [ComplaintAdminController::class, 'approve'])->name('complaints.approve');
    Route::post('complaints/{complaint}/reject',  [ComplaintAdminController::class, 'reject'])->name('complaints.reject');

    // Cases
    Route::get('cases',                        [CaseController::class, 'index'])->name('cases.index');
    Route::get('cases/{case}',                 [CaseController::class, 'show'])->name('cases.show');
    Route::post('cases/{case}/assign-ngo',     [CaseController::class, 'assignNgo'])->name('cases.assign-ngo');
    Route::post('cases/{case}/update-status',  [CaseController::class, 'updateStatus'])->name('cases.update-status');

    // Children
    Route::get('children',                [ChildController::class, 'index'])->name('children.index');
    Route::get('children/{child}',        [ChildController::class, 'show'])->name('children.show');
    Route::get('cases/{case}/add-child',  [ChildController::class, 'create'])->name('children.create');
    Route::post('cases/{case}/add-child', [ChildController::class, 'store'])->name('children.store');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Impact Dashboard
    Route::get('impact', [ImpactController::class, 'index'])->name('impact');

    // Stories of Hope (Admin)
    Route::get('stories', [StoryAdminController::class, 'index'])->name('stories.index');
    Route::post('stories/{story}/approve', [StoryAdminController::class, 'approve'])->name('stories.approve');
    Route::post('stories/{story}/reject', [StoryAdminController::class, 'reject'])->name('stories.reject');
});

// ── NGO ───────────────────────────────────────────────────
Route::prefix('ngo')->name('ngo.')->middleware(['auth', 'ngo'])->group(function () {
    Route::get('/',                            [NgoCaseController::class, 'dashboard'])->name('dashboard');
    Route::get('cases/{case}',                 [NgoCaseController::class, 'show'])->name('cases.show');
    Route::post('cases/{case}/update',         [NgoCaseController::class, 'updateProgress'])->name('cases.update');
    Route::post('cases/{case}/add-child',      [NgoCaseController::class, 'addChild'])->name('cases.add-child');
    Route::post('cases/{case}/story',          [NgoCaseController::class, 'submitStory'])->name('stories.store');
    Route::get('contributions',                [NgoCaseController::class, 'contributions'])->name('contributions');
});
