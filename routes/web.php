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
use App\Http\Controllers\RecursosHumanosController;
use App\Http\Controllers\HorasExtrasController;
use App\Http\Controllers\FaltasController;
use App\Http\Controllers\VacacionesController;
use App\Http\Controllers\BonosController;
use App\Http\Controllers\PlanillaSueldosController;
use App\Http\Controllers\QuincenasController;
use App\Http\Controllers\AnticiposController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\CreditosController;
use App\Http\Controllers\BoletasExtrasController;
use App\Http\Controllers\GastosExtrasController;
use App\Http\Controllers\IVAController;
use App\Http\Controllers\FacturasComprasController;
use App\Http\Controllers\LogisticaController;
use App\Http\Controllers\DespachosController;


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

    Route::prefix('rrhh')->group(function () {
        Route::get('/', [RecursosHumanosController::class, 'index'])->name('rrhh.index');
    
    // Trabajadores
        Route::prefix('trabajadores')->group(function () {
            Route::get('/', [TrabajadorController::class, 'index'])->name('rrhh.trabajadores.index');
            Route::get('/create', [TrabajadorController::class, 'create'])->name('rrhh.trabajadores.create');
            Route::post('/store', [TrabajadorController::class, 'store'])->name('rrhh.trabajadores.store');
            Route::get('/{id}/edit', [TrabajadorController::class, 'edit'])->name('rrhh.trabajadores.edit');
            Route::put('/{id}', [TrabajadorController::class, 'update'])->name('rrhh.trabajadores.update');
            Route::delete('/{id}', [TrabajadorController::class, 'destroy'])->name('rrhh.trabajadores.destroy');
        });
    
        // Sueldos
        Route::get('/rrhh/planilla-sueldos', [PlanillaSueldosController::class, 'index'])->name('rrhh.planilla_sueldos.index');
    
        // Horas Extras
        Route::get('/horas-extras', [RecursosHumanosController::class, 'extraHours'])->name('rrhh.horas_extras.index');

        Route::prefix('rrhh/horas-extras')->group(function () {
            // Vista principal de horas extras (lista de todas las horas extras registradas)
            Route::get('/', [HorasExtrasController::class, 'index'])->name('rrhh.horas_extras.index');
        
            // Crear nuevas horas extras
            Route::get('/create', [HorasExtrasController::class, 'create'])->name('rrhh.horas_extras.create');
            Route::post('/store', [HorasExtrasController::class, 'store'])->name('rrhh.horas_extras.store');
        
            // Editar horas extras existentes
            Route::get('/{id}/edit', [HorasExtrasController::class, 'edit'])->name('rrhh.horas_extras.edit');
            Route::put('/{id}', [HorasExtrasController::class, 'update'])->name('rrhh.horas_extras.update');
        
            // Eliminar horas extras existentes
            Route::delete('/{id}', [HorasExtrasController::class, 'destroy'])->name('rrhh.horas_extras.destroy');
        });
    
        // Faltas
        Route::get('/faltas', [RecursosHumanosController::class, 'absences'])->name('rrhh.faltas.index');

        Route::prefix('rrhh/faltas')->group(function () {
            Route::get('/', [FaltasController::class, 'index'])->name('rrhh.faltas.index');
            Route::get('/create-dia', [FaltasController::class, 'createDia'])->name('rrhh.faltas.create_dia');
            Route::get('/create-horas', [FaltasController::class, 'createHoras'])->name('rrhh.faltas.create_horas');
            Route::post('/store', [FaltasController::class, 'store'])->name('rrhh.faltas.store');
        });
    
        // Vacaciones
        Route::get('/vacaciones', [RecursosHumanosController::class, 'vacations'])->name('rrhh.vacaciones.index');

        Route::prefix('rrhh/vacaciones')->group(function () {
            Route::get('/', [VacacionesController::class, 'index'])->name('rrhh.vacaciones.index');
            Route::get('/create', [VacacionesController::class, 'create'])->name('rrhh.vacaciones.create');
            Route::post('/store', [VacacionesController::class, 'store'])->name('rrhh.vacaciones.store');
        });
    
        // Bonos
        Route::get('/bonos', [RecursosHumanosController::class, 'bonuses'])->name('rrhh.bonos.index');

        Route::prefix('rrhh/bonos')->group(function () {
            Route::get('/', [BonosController::class, 'index'])->name('rrhh.bonos.index');
            Route::get('/create', [BonosController::class, 'create'])->name('rrhh.bonos.create');
            Route::post('/store', [BonosController::class, 'store'])->name('rrhh.bonos.store');
        });

        Route::get('/quincenas', [RecursosHumanosController::class, 'quincenass'])->name('rrhh.quincenas.index');

        Route::prefix('rrhh/quincenas')->group(function () {
            Route::get('/', [QuincenasController::class, 'index'])->name('rrhh.quincenas.index');
            Route::get('/create', [QuincenasController::class, 'create'])->name('rrhh.quincenas.create');
            Route::post('/store', [QuincenasController::class, 'store'])->name('rrhh.quincenas.store');
        });

        Route::prefix('rrhh/anticipos')->group(function () {
            Route::get('/', [AnticiposController::class, 'index'])->name('rrhh.anticipos.index');
            Route::get('/create', [AnticiposController::class, 'create'])->name('rrhh.anticipos.create');
            Route::post('/store', [AnticiposController::class, 'store'])->name('rrhh.anticipos.store');
        });

        Route::prefix('rrhh/prestamos')->group(function () {
            Route::get('/', [PrestamosController::class, 'index'])->name('rrhh.prestamos.index');
            Route::get('/create', [PrestamosController::class, 'create'])->name('rrhh.prestamos.create');
            Route::post('/store', [PrestamosController::class, 'store'])->name('rrhh.prestamos.store');
            Route::get('/{id}/edit', [PrestamosController::class, 'edit'])->name('rrhh.prestamos.edit');
            Route::post('/{id}/registrar-pago', [PrestamosController::class, 'registrarPago'])->name('rrhh.prestamos.registrar_pago');
            Route::post('/{id}/aplazar-cuota', [PrestamosController::class, 'aplazarCuota'])->name('rrhh.prestamos.aplazar_cuota');
        });
    });

    Route::prefix('finanzas')->group(function () {
        Route::get('/', [FinanzasController::class, 'index'])->name('finanzas.index');
        Route::get('/creditos', [FinanzasController::class, 'creditos'])->name('finanzas.creditos.index');
        Route::get('/facturas', [FinanzasController::class, 'facturas'])->name('finanzas.facturas.index');
        Route::get('/boletas', [FinanzasController::class, 'boletas'])->name('finanzas.boletas.index');
        Route::get('/gastos', [FinanzasController::class, 'gastos'])->name('finanzas.gastos.index');
        Route::get('/iva', [FinanzasController::class, 'iva'])->name('finanzas.iva.index');
    });

    Route::prefix('finanzas/creditos')->group(function () {
        Route::get('/', [CreditosController::class, 'index'])->name('finanzas.creditos.index');
        Route::get('/create', [CreditosController::class, 'create'])->name('finanzas.creditos.create');
        Route::post('/store', [CreditosController::class, 'store'])->name('finanzas.creditos.store');
        Route::get('/{id}', [CreditosController::class, 'show'])->name('finanzas.creditos.show');
        Route::get('/{id}/edit', [CreditosController::class, 'edit'])->name('finanzas.creditos.edit');
        Route::delete('/{id}', [CreditosController::class, 'destroy'])->name('finanzas.creditos.destroy');
        Route::put('/finanzas/creditos/{id}', [CreditosController::class, 'update'])->name('finanzas.creditos.update');
    });

    Route::prefix('finanzas/boletas')->group(function () {
        Route::get('/create', [BoletasExtrasController::class, 'create'])->name('finanzas.boletas.create');
        Route::post('/store', [BoletasExtrasController::class, 'store'])->name('finanzas.boletas.store');
        Route::get('/', [BoletasExtrasController::class, 'index'])->name('finanzas.boletas.index');
        Route::get('/{id}', [BoletasExtrasController::class, 'show'])->name('finanzas.boletas.show');
        Route::get('/{id}/edit', [BoletasExtrasController::class, 'edit'])->name('finanzas.boletas.edit');
        Route::delete('/{id}', [BoletasExtrasController::class, 'destroy'])->name('finanzas.boletas.destroy');
        Route::put('/finanzas/boletas/{id}', [BoletasExtrasController::class, 'update'])->name('finanzas.boletas.update');
    });

    Route::prefix('finanzas/gastos')->group(function () {
        Route::get('/create', [GastosExtrasController::class, 'create'])->name('finanzas.gastos.create');
        Route::post('/store', [GastosExtrasController::class, 'store'])->name('finanzas.gastos.store');
        Route::get('/', [GastosExtrasController::class, 'index'])->name('finanzas.gastos.index');
        Route::get('/finanzas/gastos/{id}', [GastosExtrasController::class, 'show'])->name('finanzas.gastos.show');
        Route::get('/finanzas/gastos/{id}/edit', [GastosExtrasController::class, 'edit'])->name('finanzas.gastos.edit');
        Route::put('/finanzas/gastos/{id}', [GastosExtrasController::class, 'update'])->name('finanzas.gastos.update');
        Route::delete('/finanzas/gastos/{id}', [GastosExtrasController::class, 'destroy'])->name('finanzas.gastos.destroy');
    });

    Route::prefix('finanzas/iva')->group(function () {
        Route::get('/', [IVAController::class, 'index'])->name('finanzas.iva.index');
        Route::get('/create', [IVAController::class, 'create'])->name('finanzas.iva.create');
        Route::post('/store', [IVAController::class, 'store'])->name('finanzas.iva.store');
        Route::get('/{id}', [IVAController::class, 'show'])->name('finanzas.iva.show');
        Route::get('/{id}/edit', [IVAController::class, 'edit'])->name('finanzas.iva.edit');
        Route::put('/{id}', [IVAController::class, 'update'])->name('finanzas.iva.update');
        Route::delete('/{id}', [IVAController::class, 'destroy'])->name('finanzas.iva.destroy');
    });

    Route::prefix('finanzas/facturas')->group(function () {
        Route::get('/create', [FacturasComprasController::class, 'create'])->name('finanzas.facturas.create');
        Route::post('/store', [FacturasComprasController::class, 'store'])->name('finanzas.facturas.store');
        Route::get('/', [FacturasComprasController::class, 'index'])->name('finanzas.facturas.index');
        Route::get('/{id}', [FacturasComprasController::class, 'show'])->name('finanzas.facturas.show');
        Route::get('/{id}/edit', [FacturasComprasController::class, 'edit'])->name('finanzas.facturas.edit');
        Route::put('/{id}', [FacturasComprasController::class, 'update'])->name('finanzas.facturas.update');
        Route::delete('/{id}', [FacturasComprasController::class, 'destroy'])->name('finanzas.facturas.destroy');
        Route::get('/{id}/pagos', [FacturasComprasController::class, 'pagos'])->name('finanzas.facturas.pagos');
        Route::post('/{id}/pagos', [FacturasComprasController::class, 'registrarPago'])->name('finanzas.facturas.registrarPago');
        Route::get('/pagos/{id}/edit', [FacturasComprasController::class, 'editarPago'])->name('finanzas.facturas.pagos.editar');
        Route::post('/pagos/{id}/update', [FacturasComprasController::class, 'actualizarPago'])->name('finanzas.facturas.pagos.actualizar');
        Route::delete('/pagos/{id}', [FacturasComprasController::class, 'eliminarPago'])->name('finanzas.facturas.pagos.eliminar');
    });

    Route::prefix('logistica')->name('logistica.')->group(function () {
        Route::get('/', [LogisticaController::class, 'index'])->name('index');
    
        // Rutas de devoluciones
        Route::get('/devoluciones', [LogisticaController::class, 'devolucionesIndex'])->name('devoluciones.index');
    
        // Rutas de inventario
        Route::get('/inventario', [LogisticaController::class, 'inventarioIndex'])->name('inventario.index');
    
        // Rutas de despachos
        Route::get('/despachos', [LogisticaController::class, 'despachosIndex'])->name('despachos.index');
    });

    Route::get('/logistica/inventario/analisis', [LogisticaController::class, 'inventarioAnalisis'])->name('logistica.inventario.analisis');
    Route::get('/logistica/inventario/ventas', [LogisticaController::class, 'inventarioVentas'])->name('logistica.inventario.ventas');
    Route::get('/logistica/inventario/dashboard', [LogisticaController::class, 'dashboard'])->name('logistica.inventario.dashboard');
    Route::post('/logistica/devoluciones/{id}/cambiar-estado', [LogisticaController::class, 'cambiarEstadoDevolucion'])->name('logistica.devoluciones.cambiarEstado');
    Route::get('/logistica/devoluciones/todas', [LogisticaController::class, 'devolucionesTodas'])->name('logistica.devoluciones.todas');

    Route::post('/produccion/generate-report', [ProduccionController::class, 'generateReport'])->name('produccion.generateReport');
    

    Route::prefix('logistica/despachos')->name('logistica.despachos.')->group(function () {
        Route::get('/', [DespachosController::class, 'index'])->name('index'); // Lista de despachos
        Route::get('/create', [DespachosController::class, 'create'])->name('create'); // Formulario para crear despacho
        Route::post('/', [DespachosController::class, 'store'])->name('store'); // Guardar despacho
        Route::get('/{id}', [DespachosController::class, 'show'])->name('show'); // Mostrar detalle del despacho
        Route::get('/{id}/edit', [DespachosController::class, 'edit'])->name('edit'); // Formulario para editar despacho
        Route::put('/{id}', [DespachosController::class, 'update'])->name('update'); // Actualizar despacho
        Route::delete('/{id}', [DespachosController::class, 'destroy'])->name('destroy'); // Eliminar despacho
    });
});
