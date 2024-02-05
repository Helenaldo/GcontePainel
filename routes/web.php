<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ContatosController;
use App\Http\Controllers\Admin\ProcessoController;
use App\Http\Controllers\admin\ProcessomovController;
use App\Http\Controllers\Admin\ResponsabilidadesController;
use App\Http\Controllers\Admin\TributacaoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('site');

Route::prefix('painel')->group(function() {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin');

    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::resource('clientes', ClienteController::class);
    Route::post('clientes/filtrar', [ClienteController::class, 'clientesFiltrar'])->name('clientesFiltrar');

    Route::resource('contatos', ContatosController::class);
    Route::resource('tributacao', TributacaoController::class);

    Route::resource('processo', ProcessoController::class);
    Route::post('processo/filtrar', [ProcessoController::class, 'processosFiltrar'])->name('processosFiltrar');
    Route::resource('processoMov', ProcessomovController::class);

    Route::resource('usuarios', UserController::class);
    Route::resource('responsabilidades', ResponsabilidadesController::class);

    Route::put('processoFim/{id}', [ProcessoController::class, 'processoFim'])->name('processoFim');

    Route::get('alterarSenha/{id}', [UserController::class, 'alterarSenha'])->name('alterarSenha');
    Route::put('alterarSenhaAction', [UserController::class, 'alterarSenhaAction'])->name('alterarSenhaAction');

});



Route::get('clientes/buscar-cidade', [ClienteController::class, 'buscarCidade'])->name('buscarCidade');
// Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');





