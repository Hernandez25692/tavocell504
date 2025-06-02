<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    VentaController,
    CierreDiarioController,
    ReparacionController,
    SeguimientoReparacionController,
    ConsultaReparacionController,
    ProductoController,
    InventarioController,
    ClienteController,
    FacturaController,
    FacturaProductoController,
    FacturaReparacionController,
    DevolucionController,
    SuscripcionNetflixController,
    SalidaCajaController,
    UsuarioController,
    AjusteInventarioController,
    UtilidadController
};

// Redirección inicial
Route::get('/', fn() => redirect()->route('login'));

// Dashboard protegido por autenticación
Route::get('/dashboard', [DashboardController::class, 'mostrar'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================
    // ADMIN — Acceso Total
    // ============================
    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('productos', ProductoController::class);

        Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
        Route::post('/inventario', [InventarioController::class, 'store'])->name('inventario.store');

        Route::get('cierres', [CierreDiarioController::class, 'index'])->name('cierres.index');
        Route::post('cierres', [CierreDiarioController::class, 'store'])->name('cierres.store');
        Route::post('/cierres/{id}/descargar', [CierreDiarioController::class, 'descargar'])->name('cierres.descargar');
        Route::post('/cierres/{id}/actualizar-efectivo', [CierreDiarioController::class, 'actualizarEfectivo'])->name('cierres.actualizarEfectivo');

        Route::resource('suscripciones-netflix', SuscripcionNetflixController::class);
        Route::get('/utilidades', [UtilidadController::class, 'index'])->name('utilidades.index');
        Route::resource('salidas-caja', SalidaCajaController::class);

        // Ajustes de inventario
        Route::get('ajustes-inventario', [AjusteInventarioController::class, 'index'])->name('ajustes-inventario.index');
        Route::get('ajustes-inventario/create', [AjusteInventarioController::class, 'create'])->name('ajustes-inventario.create');
        Route::post('ajustes-inventario', [AjusteInventarioController::class, 'store'])->name('ajustes-inventario.store');
        Route::get('ajustes-inventario/{id}', [AjusteInventarioController::class, 'show'])->name('ajustes-inventario.show');

        // Búsqueda de productos por código
        Route::get('/producto/por-codigo/{codigo}', [ProductoController::class, 'buscarPorCodigo'])->name('productos.buscar-por-codigo');
    });

    // ============================
    // ADMIN y CAJERO — Facturas, Clientes, Reparaciones
    // ============================
    Route::middleware([CheckRole::class . ':admin|cajero'])->group(function () {
        Route::resource('clientes', ClienteController::class);
        Route::resource('facturas', FacturaController::class);
        Route::get('/facturas/{factura}/pdf', [FacturaController::class, 'descargarPDF'])->name('facturas.pdf');

        // Facturas de Productos
        Route::prefix('facturas-productos')->name('facturas_productos.')->group(function () {
            Route::get('/', [FacturaProductoController::class, 'index'])->name('index');
            Route::get('/create', [FacturaProductoController::class, 'create'])->name('create');
            Route::post('/', [FacturaProductoController::class, 'store'])->name('store');
            Route::get('/{factura}', [FacturaProductoController::class, 'show'])->name('show');
            Route::get('/{factura}/pdf', [FacturaProductoController::class, 'descargarPDF'])->name('pdf');
        });

        // Facturas de Reparaciones
        Route::prefix('facturas-reparaciones')->name('facturas_reparaciones.')->group(function () {
            Route::get('/', [FacturaReparacionController::class, 'index'])->name('index');
            Route::get('/{factura}', [FacturaReparacionController::class, 'show'])->name('show');
            Route::get('/{factura}/pdf', [FacturaReparacionController::class, 'pdf'])->name('pdf');
            Route::delete('/{factura}', [FacturaReparacionController::class, 'destroy'])->name('destroy');
        });

        Route::resource('salidas-caja', SalidaCajaController::class);
    });

    // ============================
    // ADMIN, CAJERO y TÉCNICO — Reparaciones
    // ============================
    Route::middleware([CheckRole::class . ':admin|cajero|tecnico'])->group(function () {
        Route::resource('reparaciones', ReparacionController::class);
        Route::post('/reparaciones/{reparacion}/facturar', [ReparacionController::class, 'facturar'])->name('facturar.reparacion');
        Route::post('/reparaciones/{reparacion}/abonar', [ReparacionController::class, 'abonar'])->name('reparaciones.abonar');
        Route::get('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'index'])->name('seguimientos.index');
        Route::post('reparaciones/{reparacion}/seguimientos', [SeguimientoReparacionController::class, 'store'])->name('seguimientos.store');
        Route::get('/reparaciones/{reparacion}/comprobante', [ReparacionController::class, 'comprobante'])->name('reparaciones.comprobante');
    });
});

// ============================
// Devoluciones de Productos
// ============================
Route::prefix('devoluciones')->name('devoluciones.')->group(function () {
    Route::get('/', [DevolucionController::class, 'index'])->name('index'); // Historial
    Route::get('/buscar', [DevolucionController::class, 'buscarFactura'])->name('buscar'); // Buscar factura
    Route::post('/mostrar', [DevolucionController::class, 'mostrarFactura'])->name('mostrar'); // Mostrar detalles
    Route::post('/procesar', [DevolucionController::class, 'procesar'])->name('procesar'); // Procesar devolución
    Route::get('/{devolucion}', [DevolucionController::class, 'show'])->name('show'); // Ver detalle devolución
});

// ============================
// Consulta Pública — Reparaciones
// ============================
Route::get('/estado-reparacion', [ConsultaReparacionController::class, 'index'])->name('consulta.reparacion');
Route::post('/estado-reparacion', [ConsultaReparacionController::class, 'buscar'])->name('consulta.buscar');
Route::get('/reparacion/{id}/seguimiento', [ConsultaReparacionController::class, 'publica'])->name('consulta.reparacion.publica');

// ============================
// Rutas de autenticación (Laravel Breeze o Jetstream)
// ============================
require __DIR__ . '/auth.php';
