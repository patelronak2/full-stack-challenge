<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/jobs', function () {
    return Inertia::render('Job/List');
})->name('jobs.index');

Route::get('/jobs/{id}', function (){})
    ->name('jobs.show')->whereUuid('id');

Route::middleware('auth')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index'])
        ->name('companies.index');
    Route::get('/companies/create', [CompanyController::class, 'create'])
        ->name('companies.create');
    Route::post('/companies', [CompanyController::class, 'store'])
        ->name('companies.store');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])
        ->name('companies.show')->whereUuid('company');
    Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])
        ->name('companies.edit')->whereUuid('company');
    Route::patch('/companies/{company}', [CompanyController::class, 'update'])
        ->name('companies.update')->whereUuid('company');
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])
        ->name('companies.destroy')->whereUuid('company');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
