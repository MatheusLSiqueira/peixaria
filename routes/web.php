<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ─── Públicas ───────────────────────────────────────────────
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

// ─── Carrinho (público, sessão) ──────────────────────────────
Route::prefix('carrinho')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/adicionar/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/atualizar/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remover/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/limpar', [CartController::class, 'clear'])->name('clear');
});

// ─── Pedidos (autenticado) ───────────────────────────────────
Route::prefix('pedidos')->name('orders.')->middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
});

// ─── Admin ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Pedidos admin
    Route::get('/pedidos', [AdminController::class, 'orders'])->name('orders');
    Route::get('/pedidos/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/pedidos/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Clientes
    Route::get('/clientes', [AdminController::class, 'customers'])->name('customers');
    Route::get('/clientes/{user}', [AdminController::class, 'showCustomer'])->name('customers.show');
    Route::get('/clientes/{user}/editar', [AdminController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/clientes/{user}', [AdminController::class, 'updateCustomer'])->name('customers.update');
    Route::delete('/clientes/{user}', [AdminController::class, 'destroyCustomer'])->name('customers.destroy');

    // Produtos admin
    Route::get('/produtos', [ProductController::class, 'adminIndex'])->name('products.index');
    Route::get('/produtos/criar', [ProductController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Relatórios
    Route::get('/relatorios', [AdminController::class, 'reports'])->name('reports');
});

//teste//
Route::get('/login', function () { return 'Página de Login'; })->name('login');
Route::get('/register', function () { return 'Página de Registro'; })->name('register');

// ─── Auth (Breeze/Jetstream gera automaticamente, mas como exemplo:) ─
//require __DIR__ . '/auth.php';//
