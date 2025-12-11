<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClaimCenterController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AnalyticsController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Models\User;
use App\Models\Project;

Route::get('/', function () {
    $total_claims = Project::count();
    $active_users = User::count();
    $total_payouts = Project::sum('nett_budget');
    $latest_members = User::latest()->take(5)->get();
    
    // Cool Real Data: Hall of Fame & Activity
    $top_contributors = User::withCount('projects')->orderByDesc('projects_count')->take(3)->get();
    $completed_projects = Project::where('status', 'completed')->with('assignees')->latest()->take(8)->get();
    
    // Testimonials (Real Users, Fake Quotes)
    $testimonial_users = User::whereNotNull('profile_photo')->inRandomOrder()->take(3)->get();
    if ($testimonial_users->count() < 3) {
        $testimonial_users = User::inRandomOrder()->take(3)->get();
    }
    
    // Avg Payout for Stats
    $avg_payout = Project::where('status', 'completed')->avg('nett_budget') ?? 0;

    return view('welcome', compact('total_claims', 'active_users', 'total_payouts', 'latest_members', 'top_contributors', 'completed_projects', 'testimonial_users', 'avg_payout'));
})->name('home');

Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/support', 'pages.support')->name('support');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Claim Center (Staff & Admin) - MUST BE BEFORE projects resource route
    Route::get('/projects/claim-center', [ClaimCenterController::class, 'index'])->name('claim-center.index');
    Route::get('/projects/claim-center/{project}', [ClaimCenterController::class, 'show'])->name('claim-center.show');
    Route::post('/projects/{project}/claim', [ClaimCenterController::class, 'claim'])->name('claim-center.claim');
    
    // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/export/excel', [ProjectController::class, 'export'])->name('projects.export');
    Route::get('/projects/{project}/invoice', [ProjectController::class, 'generateInvoice'])->name('projects.invoice');
    Route::get('/projects/{project}/bast', [ProjectController::class, 'generateBast'])->name('projects.bast');
    Route::get('/projects/{project}/poc', [ProjectController::class, 'generatePoc'])->name('projects.poc');
    Route::post('/projects/{project}/complete', [ProjectController::class, 'complete'])->name('projects.complete');
    Route::post('/projects/{project}/approve-bid', [ProjectController::class, 'approveBid'])->name('projects.approve-bid');
    Route::post('/projects/{project}/cancel', [ProjectController::class, 'cancel'])->name('projects.cancel');
    
    // Project Deliverables
    Route::post('/projects/{project}/deliverables', [ProjectController::class, 'storeDeliverable'])->name('projects.deliverables.store');
    Route::put('/projects/{project}/deliverables/{deliverable}', [ProjectController::class, 'updateDeliverable'])->name('projects.deliverables.update');
    Route::post('/projects/{project}/deliverables/{deliverable}/toggle', [ProjectController::class, 'toggleDeliverable'])->name('projects.deliverables.toggle');
    Route::delete('/projects/{project}/deliverables/{deliverable}', [ProjectController::class, 'deleteDeliverable'])->name('projects.deliverables.delete');
    
    // Staff Management (Admin only) - MUST BE BEFORE public staff resource
    Route::middleware(['admin'])->group(function () {
        Route::resource('staff', StaffController::class)->except(['index', 'show']);
        Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/activity-logs/{activityLog}', [\App\Http\Controllers\ActivityLogController::class, 'show'])->name('activity-logs.show');
    });

    // Staff Management (Read Access for All Auth Users)
    Route::resource('staff', StaffController::class)->only(['index', 'show']);
    
    // Wiki Management (Admin only) - MUST BE BEFORE {wiki} WILDCARD
    Route::middleware(['admin'])->group(function () {
        Route::get('/wiki/create', [\App\Http\Controllers\WikiController::class, 'create'])->name('wiki.create');
        Route::post('/wiki', [\App\Http\Controllers\WikiController::class, 'store'])->name('wiki.store');
        Route::get('/wiki/{wiki}/edit', [\App\Http\Controllers\WikiController::class, 'edit'])->name('wiki.edit');
        Route::put('/wiki/{wiki}', [\App\Http\Controllers\WikiController::class, 'update'])->name('wiki.update');
        Route::delete('/wiki/{wiki}', [\App\Http\Controllers\WikiController::class, 'destroy'])->name('wiki.destroy');
    });

    // Wiki/Knowledge Base
    Route::get('/wiki', [\App\Http\Controllers\WikiController::class, 'index'])->name('wiki.index');
    Route::get('/wiki/{wiki}', [\App\Http\Controllers\WikiController::class, 'show'])->name('wiki.show');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('analytics.export');
    
    // Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Hidden Asset Management Page (Admin only, no menu link)
    Route::middleware(['admin'])->prefix('admin/assets')->name('admin.assets.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LogoUploadController::class, 'index'])->name('index');
        Route::post('/university', [\App\Http\Controllers\Admin\LogoUploadController::class, 'storeUniversity'])->name('university.store');
        Route::post('/bank', [\App\Http\Controllers\Admin\LogoUploadController::class, 'storeBank'])->name('bank.store');
        Route::post('/university/{university}/logo', [\App\Http\Controllers\Admin\LogoUploadController::class, 'uploadUniversity'])->name('university.upload');
        Route::post('/bank/{bank}/logo', [\App\Http\Controllers\Admin\LogoUploadController::class, 'uploadBank'])->name('bank.upload');
        Route::delete('/university/{university}/logo', [\App\Http\Controllers\Admin\LogoUploadController::class, 'deleteUniversity'])->name('university.delete');
        Route::delete('/bank/{bank}/logo', [\App\Http\Controllers\Admin\LogoUploadController::class, 'deleteBank'])->name('bank.delete');
    });
    
});


