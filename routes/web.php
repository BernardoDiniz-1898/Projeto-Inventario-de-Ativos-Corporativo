<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $total = \App\Models\Notebook::count();
        $disponiveis = \App\Models\Notebook::where('status', 'disponivel')->count();
        $emUso = \App\Models\Notebook::where('status', 'em_uso')->count();
        $manutencao = \App\Models\Notebook::where('status', 'manutencao')->count();
        $ociosos = \App\Models\Notebook::where('status', 'ocioso')->count();
        $totalFuncionarios = \App\Models\Employee::count();

        $porMarca = \App\Models\Notebook::select('marca', \DB::raw('count(*) as total'))
            ->groupBy('marca')
            ->orderByDesc('total')
            ->get();

        $porDepartamento = \App\Models\Employee::whereHas('notebooks')
            ->select('departamento', \DB::raw('count(*) as total'))
            ->groupBy('departamento')
            ->orderByDesc('total')
            ->get();

        $recentes = \App\Models\Notebook::with('funcionario')->latest()->take(5)->get();

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
