<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Visitantes e Clientes)
|--------------------------------------------------------------------------
*/

// Home e Listagem de Produtos
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

// Carrinho de Compras (Acessível sem login)
Route::prefix('carrinho')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/adicionar/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/atualizar/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remover/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/limpar', [CartController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Apenas Usuários Logados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard padrão do usuário
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil do Usuário (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pedidos do Cliente
    Route::prefix('pedidos')->name('orders.')->group(function () {
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas Administrativas (Apenas para Admins)
|--------------------------------------------------------------------------
*/
// Certifique-se de que o middleware 'admin' está registrado em app/Http/Kernel.php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestão de Pedidos (Admin)
    Route::get('/pedidos', [AdminController::class, 'orders'])->name('orders');
    Route::get('/pedidos/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/pedidos/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Gestão de Clientes (Manter Cliente)
    Route::get('/clientes', [AdminController::class, 'customers'])->name('customers');
    Route::get('/clientes/{user}', [AdminController::class, 'showCustomer'])->name('customers.show');
    Route::get('/clientes/{user}/editar', [AdminController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/clientes/{user}', [AdminController::class, 'updateCustomer'])->name('customers.update');
    Route::delete('/clientes/{user}', [AdminController::class, 'destroyCustomer'])->name('customers.destroy');

    // Gestão de Produtos (Manter Produtos)
    Route::get('/produtos', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Relatórios
    Route::get('/relatorios', [AdminController::class, 'reports'])->name('reports');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação (Breeze/Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';