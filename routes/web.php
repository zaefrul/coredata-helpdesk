<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\IncidentController as CustomerIncidentController;
use App\Http\Controllers\Customer\ContractController as CustomerContractController;
use App\Http\Controllers\Customer\AssetController as CustomerAssetController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\EnsureRoleIsAgentOrAdmin;
use App\Http\Middleware\EnsureRoleIsUser;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::check()) {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::fallback(function () {
    return view('errors.404');
});

Route::middleware(['auth'])->group(function () {

    Route::group(['middleware' => EnsureRoleIsAgentOrAdmin::class], function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/show', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        // department json
        Route::get('/customers/{customer_id}/departments', [DepartmentController::class, 'customerDepartments'])->name('departments.customer');

        // Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        // Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        // Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        // Route::get('/projects/{id}/show', [ProjectController::class, 'show'])->name('projects.show');
        // Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        // Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
        // Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{id}/show', [ContractController::class, 'show'])->name('contracts.show');
        Route::get('/contracts/{id}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
        Route::put('/contracts/{id}', [ContractController::class, 'update'])->name('contracts.update');
        Route::delete('/contracts/{id}', [ContractController::class, 'destroy'])->name('contracts.destroy');

        Route::get('/resources', [AssetController::class, 'index'])->name('assets.index');
        Route::get('/resources/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('/resources', [AssetController::class, 'store'])->name('assets.store');
        Route::get('/resources/{id}/show', [AssetController::class, 'show'])->name('assets.show');
        Route::get('/resources/{id}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('/resources/{id}', [AssetController::class, 'update'])->name('assets.update');
        Route::delete('/resources/{id}', [AssetController::class, 'destroy'])->name('assets.destroy');
        Route::get('/resources/{contract_id}', [AssetController::class, 'getAssetByContractorId'])->name('assets.getbycontract');

        Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
        Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
        Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
        Route::get('/incidents/{id}/show', [IncidentController::class, 'show'])->name('incidents.show');
        Route::get('/incidents/{id}/edit', [IncidentController::class, 'edit'])->name('incidents.edit');
        Route::put('/incidents/{id}', [IncidentController::class, 'update'])->name('incidents.update');
        Route::delete('/incidents/{id}', [IncidentController::class, 'destroy'])->name('incidents.destroy');
        Route::put('/incident/{incident}/assign', [IncidentController::class, 'assign'])->name('incident.assign');
        Route::put('/incident/{incident}/status', [IncidentController::class, 'status'])->name('incident.status');
        Route::put('/incident/{incident}/priority', [IncidentController::class, 'priority'])->name('incident.priority');
        Route::put('/incident/{incident}/comment', [IncidentController::class, 'comment'])->name('incident.comment');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/show', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard2', function () { return view('dashboard'); })->name('dashboard2');

        Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
        Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
        Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
        Route::get('/inventories/{id}/show', [InventoryController::class, 'show'])->name('inventories.show');
        Route::get('/inventories/{id}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
        Route::put('/inventories/{id}', [InventoryController::class, 'update'])->name('inventories.update');
        Route::delete('/inventories/{id}', [InventoryController::class, 'destroy'])->name('inventories.destroy');
        Route::post('/inventories/search', [InventoryController::class, 'search'])->name('inventories.search');

        Route::post('/incident/{id}/replace/part', [IncidentController::class, 'replacePart'])->name('incident.replace.part');

        Route::group(['middleware' => EnsureUserIsAdmin::class], function () {
            Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
            Route::get('/admin/components', [AdminController::class, 'components'])->name('admin.components');
            Route::get('/admin/migration', [AdminController::class, 'runMigration'])->name('admin.migration');
            Route::get('/admin/seeder', [AdminController::class, 'runSeeder'])->name('admin.seeder');

            Route::post('admin/components', [SettingController::class, 'store_component_type'])->name('components.store');
            Route::delete('admin/components/{id}', [SettingController::class, 'destroy_component_type'])->name('components.destroy');
            Route::put('admin/components/{id}', [SettingController::class, 'update_component_type'])->name('components.update');

            Route::get('/admin/emails/on', [SettingController::class, 'turnEmailOn'])->name('settings.email.on');
            Route::get('/admin/emails/off', [SettingController::class, 'turnEmailOff'])->name('settings.email.off');
        });
    });

    Route::group(['middleware' => EnsureRoleIsUser::class, 'prefix' => 'user'], function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/accounts/{id}/show', [UserController::class, 'show'])->name('user.accounts.show');

        Route::get('/incidents', [CustomerIncidentController::class, 'index'])->name('user.incidents.index');
        Route::get('/incidents/create', [CustomerIncidentController::class, 'create'])->name('user.incidents.create');
        Route::post('/incidents', [CustomerIncidentController::class, 'store'])->name('user.incidents.store');
        Route::get('/incidents/{id}/show', [CustomerIncidentController::class, 'show'])->name('user.incidents.show');
        Route::put('/incident/{incident}/comment', [IncidentController::class, 'comment'])->name('user.incident.comment');
        Route::get('/incident/resources/{contract_id}', [AssetController::class, 'getAssetByContractorId'])->name('user.assets.getbycontract');

        Route::get('/contracts', [CustomerContractController::class, 'index'])->name('user.contracts.index');
        Route::get('/contracts/{id}/show', [CustomerContractController::class, 'show'])->name('user.contracts.show');

        Route::get('resources', [CustomerAssetController::class, 'index'])->name('user.assets.index');
        Route::get('resources/{id}/show', [CustomerAssetController::class, 'show'])->name('user.assets.show');
    });

    Route::post('/incidentπ/attachment', [IncidentController::class, 'uploadAttachment'])->name('incident.attachment');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
