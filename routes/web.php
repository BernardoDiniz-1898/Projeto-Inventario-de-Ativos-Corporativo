<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\SettingsController;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $dashboard = app(DashboardService::class);

        $total = $dashboard->getStats()['total'];
        $disponiveis = $dashboard->getStats()['disponiveis'];
        $emUso = $dashboard->getStats()['emUso'];
        $manutencao = $dashboard->getStats()['manutencao'];
        $ociosos = $dashboard->getStats()['ociosos'];
        $totalFuncionarios = $dashboard->getStats()['totalFuncionarios'];

        $porMarca = $dashboard->getNotebooksByBrand();
        $porDepartamento = $dashboard->getEmployeesByDepartment();
        $recentes = $dashboard->getRecentNotebooks();

        return view('dashboard', compact('total', 'disponiveis', 'emUso', 'manutencao', 'ociosos', 'totalFuncionarios', 'porMarca', 'porDepartamento', 'recentes'));
    })->name('dashboard');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::middleware(['role:admin,editor'])->group(function () {
        Route::resource('notebooks', NotebookController::class);
        Route::get('notebooks/export/xlsx', [NotebookController::class, 'export'])->name('notebooks.export');
        Route::resource('employees', EmployeeController::class);
        Route::get('employees/export/xlsx', [EmployeeController::class, 'export'])->name('employees.export');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except('show');
            Route::put('users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.role');
        });
    });
});
