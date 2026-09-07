<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirección inteligente del Dashboard según el rol del usuario
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        
        if ($role === 'cocina') {
            return redirect()->route('cocina.index');
        }
        
        return app(OrderController::class)->index();
    })->name('dashboard');

    // Rutas para Cocina y Admin
    Route::middleware('role:cocina,admin')->group(function () {
        Route::get('/cocina', [CocinaController::class, 'index'])->name('cocina.index');
        Route::post('/cocina/{id}/listo', [CocinaController::class, 'marcarListo'])->name('cocina.listo');
    });

    // Rutas para Mozo y Admin
    Route::middleware('role:mozo,admin')->group(function () {
        Route::get('/mesa/{table}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::put('/orders/{id}/cobrar', [OrderController::class, 'cobrarOrden'])->name('orders.cobrar');

        Route::get('/mesa/{table}/pagar', [PagoController::class, 'show'])->name('pagos.show');
        Route::post('/pagar', [PagoController::class, 'store'])->name('pagos.store');
        Route::get('/pago-exitoso/{id}', [PagoController::class, 'exito'])->name('pagos.exito');
        Route::get('/voucher/{id}', [PagoController::class, 'voucher'])->name('pagos.voucher');

        Route::get('/delivery', [OrderController::class, 'createDelivery'])->name('orders.delivery');
        Route::get('/delivery/despacho', [OrderController::class, 'dispatch'])->name('orders.dispatch');
        Route::put('/orders/{id}/assign', [OrderController::class, 'assignDriver'])->name('orders.assign');

        Route::resource('reservations', ReservaController::class);
        Route::put('/reservations/{id}/cancel', [ReservaController::class, 'cancel'])->name('reservations.cancel');
        Route::post('/reservations/{id}/confirm', [ReservaController::class, 'confirm'])->name('reservations.confirm');
    });

    // Rutas de Administración
    Route::middleware('role:admin')->group(function () {
        Route::resource('admin/products', AdminProductController::class)->names('admin.products');
        Route::put('/admin/productos/{id}/toggle', [AdminProductController::class, 'toggleDisponibilidad'])->name('admin.productos.toggle');
        Route::resource('admin/categorias', CategoriaController::class)->names('admin.categorias');

        Route::resource('admin/mesas', MesaController::class)->names('admin.mesas');
        Route::resource('admin/repartidores', RepartidorController::class)->names('admin.repartidores');

        Route::get('/admin/reportes', [ReporteController::class, 'index'])->name('admin.reports.index');

        Route::resource('admin/users', UserController::class)
             ->names('admin.users')
             ->except(['show', 'destroy']);

        Route::put('/admin/users/{id}/toggle', [UserController::class, 'toggleAccess'])
             ->name('admin.users.toggle');

        Route::get('/buttons/text', function () { return view('buttons-showcase.text'); })->name('buttons.text');
        Route::get('/buttons/icon', function () { return view('buttons-showcase.icon'); })->name('buttons.icon');
        Route::get('/buttons/text-icon', function () { return view('buttons-showcase.text-icon'); })->name('buttons.text-icon');
    });

});