<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\DashboardController;



// Página de inicio
Route::get('/', function () {
    return redirect('/login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (solo accesibles para usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/trabajadores', function () {
        return view('trabajadores.dashboard');
    });

    Route::get('/trabajadores/produccion', function () {
        return view('trabajadores.produccion');
    });

    Route::get('/trabajadores/rrhh', function () {
        return view('trabajadores.rrhh');
    });

    Route::get('/trabajadores/tickets', function () {
        return view('trabajadores.tickets');
    });

    // Rutas para la gestión de ventas
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');


    // Rutas para la sección de Configuración
    Route::prefix('configuracion')->group(function () {
        Route::get('/', function () {
            return view('configuracion.index');
        })->name('configuracion.index');

        // Rutas para Clientes
        Route::prefix('configuracion/clientes')->group(function () {
            Route::get('/', [ClienteController::class, 'index'])->name('configuracion.clientes.index');
            Route::get('/create', [ClienteController::class, 'create'])->name('configuracion.clientes.create');
            Route::post('/store', [ClienteController::class, 'store'])->name('configuracion.clientes.store');
            Route::get('/{cliente}/edit', [ClienteController::class, 'edit'])->name('configuracion.clientes.edit');
            Route::put('/{cliente}', [ClienteController::class, 'update'])->name('configuracion.clientes.update');
            Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('configuracion.clientes.destroy');
        });

        Route::prefix('configuracion/proveedores')->group(function () {
            Route::get('/', [ProveedorController::class, 'index'])->name('configuracion.proveedores.index');
            Route::get('/create', [ProveedorController::class, 'create'])->name('configuracion.proveedores.create');
            Route::post('/store', [ProveedorController::class, 'store'])->name('configuracion.proveedores.store');
            Route::get('/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('configuracion.proveedores.edit');
            Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('configuracion.proveedores.update');
            Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('configuracion.proveedores.destroy');
        });

        // Rutas para Insumos
        Route::prefix('configuracion/insumos')->name('insumos.')->group(function () {
            Route::get('/', [InsumoController::class, 'index'])->name('index');
            Route::get('/create', [InsumoController::class, 'create'])->name('create');
            Route::post('/store', [InsumoController::class, 'store'])->name('store');
            Route::get('/{insumo}/edit', [InsumoController::class, 'edit'])->name('edit');
            Route::put('/{insumo}', [InsumoController::class, 'update'])->name('update');
            Route::delete('/{insumo}', [InsumoController::class, 'destroy'])->name('destroy');
        });

        // Rutas de productos
        Route::prefix('productos')->name('productos.')->group(function () {
            Route::get('/', [ProductoController::class, 'index'])->name('index');
            Route::get('/create', [ProductoController::class, 'create'])->name('create');
            Route::post('/', [ProductoController::class, 'store'])->name('store');
            Route::get('/{id}', [ProductoController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ProductoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductoController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('destroy');
            Route::get('/productos/{id}/copy', [ProductoController::class, 'copy'])->name('copy');
Route::post('/productos/{id}/copy', [ProductoController::class, 'storeCopy'])->name('storeCopy');
        });

        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    Route::prefix('ventas')->group(function () {
        // Listado de ventas
        Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
    
        // Creación de ventas
        Route::get('/create', [VentaController::class, 'create'])->name('ventas.create');
        Route::post('/store', [VentaController::class, 'store'])->name('ventas.store');
    
        // Detalles de una venta
        Route::get('/ventas/{id}/show', [VentaController::class, 'show'])->name('ventas.show');
    
        // Edición de una venta
        Route::get('/{id}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
        Route::put('/{id}', [VentaController::class, 'update'])->name('ventas.update');
    
        // Eliminación de una venta
        Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('ventas.destroy');
    
        // Importación de archivos
        Route::get('/import', [VentaController::class, 'importView'])->name('ventas.import.view');
        Route::post('/import/cencosud', [VentaController::class, 'importarCencosud'])->name('ventas.import.cencosud');
        Route::post('/import/walmart', [VentaController::class, 'importarWalmart'])->name('ventas.import.walmart');
        Route::post('/import/falabella', [VentaController::class, 'importarFalabella'])->name('ventas.import.falabella');
        Route::post('/import/lapolar', [VentaController::class, 'importarLapolar'])->name('ventas.import.lapolar');
        Route::post('/import/hites', [VentaController::class, 'importarHites'])->name('ventas.import.hites');
    
        // Vista previa de datos cargados
        Route::post('/preview/cencosud', [VentaController::class, 'previewCencosud'])->name('ventas.previewCencosud');
        Route::post('/preview/walmart', [VentaController::class, 'previewWalmart'])->name('ventas.previewWalmart');
        Route::post('/preview/falabella', [VentaController::class, 'previewFalabella'])->name('ventas.previewFalabella');
        Route::post('/preview/lapolar', [VentaController::class, 'previewLapolar'])->name('ventas.previewLapolar');
        Route::post('/preview/hites', [VentaController::class, 'previewHites'])->name('ventas.previewHites');
    
        // Guardado desde vista previa
        Route::post('/guardar-preview/cencosud', [VentaController::class, 'storeFromPreview'])->name('ventas.guardarPreview');
        Route::post('/guardar-preview/walmart', [VentaController::class, 'storeFromPreviewWalmart'])->name('ventas.guardarPreviewWalmart');
        Route::post('/guardar-preview/falabella', [VentaController::class, 'storeFromPreviewFalabella'])->name('ventas.guardarPreviewFalabella');
        Route::post('/guardar-preview/lapolar', [VentaController::class, 'storeFromPreviewLapolar'])->name('ventas.guardarPreviewLapolar');
        Route::post('/guardar-preview/hites', [VentaController::class, 'storeFromPreviewHites'])->name('ventas.guardarPreviewHites');


        Route::post('/ventas/update-status-bulk', [VentaController::class, 'updateStatusBulk'])->name('ventas.updateStatusBulk');



        Route::post('/import/preview/hites', [VentaController::class, 'previewActualizarOrdenesHites'])->name('ventas.previewActualizarHites');
        Route::post('/import/save/hites', [VentaController::class, 'guardarActualizarOrdenesHites'])->name('ventas.guardarActualizarHites');
    
        // Ruta para la maestra
        Route::get('/ventas/maestra', [VentaController::class, 'maestra'])->name('ventas.maestra');
    });



    Route::prefix('rrhh')->group(function () {
        Route::get('/', [TrabajadorController::class, 'index'])->name('rrhh.index');
        Route::get('/create', [TrabajadorController::class, 'create'])->name('rrhh.create');
        Route::post('/store', [TrabajadorController::class, 'store'])->name('rrhh.store');
        Route::get('/{id}/edit', [TrabajadorController::class, 'edit'])->name('rrhh.edit');
        Route::put('/{id}', [TrabajadorController::class, 'update'])->name('rrhh.update');
        Route::delete('/{id}', [TrabajadorController::class, 'destroy'])->name('rrhh.destroy');
    });
    
    Route::prefix('produccion')->group(function () {
        Route::get('/', [ProduccionController::class, 'index'])->name('produccion.index');
        Route::get('/create', [ProduccionController::class, 'create'])->name('produccion.create');
        Route::post('/', [ProduccionController::class, 'store'])->name('produccion.store');
        Route::get('/{id}/edit', [ProduccionController::class, 'edit'])->name('produccion.edit');
        Route::put('/{id}', [ProduccionController::class, 'update'])->name('produccion.update');
        Route::delete('/{id}', [ProduccionController::class, 'destroy'])->name('produccion.destroy');
        Route::get('/produccion/reparaciones', [ProduccionController::class, 'reparaciones'])->name('produccion.reparaciones');
        Route::post('/produccion/reparaciones/store', [ProduccionController::class, 'storeReparacion'])->name('produccion.storeReparacion');

    });

    Route::post('/produccion/generate-report', [ProduccionController::class, 'generateReport'])->name('produccion.generateReport');
});
