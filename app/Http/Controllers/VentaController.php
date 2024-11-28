<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class VentaController extends Controller
{
    /**
     * Mostrar la lista de ventas.
     */
    public function index(Request $request)
    {
        $query = Venta::query();
    
        // Obtener la fecha actual
        $hoy = now()->format('Y-m-d');
    
        // Aplicar filtros
        if ($request->filled('numero_orden')) {
            $query->where('numero_orden', 'like', '%' . $request->input('numero_orden') . '%');
        }
    
        if ($request->filled('cliente')) {
            $query->where('cliente_final', 'like', '%' . $request->input('cliente') . '%');
        }
    
        if ($request->filled('fecha_entrega_desde') && $request->filled('fecha_entrega_hasta')) {
            $query->whereBetween('fecha_entrega', [
                $request->input('fecha_entrega_desde'),
                $request->input('fecha_entrega_hasta'),
            ]);
        }
    
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }
    
        // Filtrar ventas con estado 'nueva' o 'despachada' pero con fecha de entrega igual al día actual
        $query->where(function ($subQuery) use ($hoy) {
            $subQuery->where('estado', 'nueva')
                     ->orWhere(function ($subSubQuery) use ($hoy) {
                         $subSubQuery->where('estado', 'despachada')
                                     ->where('fecha_entrega', $hoy);
                     });
        });
    
        // Ordenación
        $sortBy = $request->input('sort_by', 'created_at'); // Columna por defecto
        $sortDirection = $request->input('sort_direction', 'desc'); // Dirección por defecto
        $query->orderBy($sortBy, $sortDirection);
    
        // Paginación
        $ventas = $query->paginate(50)->appends($request->all());
    
        return view('ventas.index', compact('ventas'));
    }
    

    public function show($id)
    {
        $venta = Venta::find($id);

        if (!$venta) {
            return redirect()->route('ventas.index')->withErrors(['error' => 'La venta no fue encontrada.']);
        }

        return view('ventas.show', compact('venta'));
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id); // Busca la venta por ID o devuelve un error 404 si no existe
        return view('ventas.edit', compact('venta'));
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'numero_orden' => 'required|string|max:255',
            'cliente_id' => 'nullable|integer',
            'cliente_final' => 'nullable|string|max:255',
            'rut_documento' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:255',
            'fecha_compra' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'producto' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric',
            'precio_cliente' => 'nullable|numeric',
            'costo_despacho' => 'nullable|numeric',
            'estado' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        // Actualizar los datos en la base de datos
        $venta->update($validatedData);

        // Redirigir al listado de ventas con un mensaje de éxito
        return redirect()->route('ventas.index')->with('success', 'Orden de compra actualizada correctamente.');
    }

    public function updateStatusBulk(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:ventas,id',
            'estado' => 'required|string',
        ]);
    
        Venta::whereIn('id', $validated['ids'])->update(['estado' => $validated['estado']]);
    
        return response()->json(['success' => true, 'message' => 'Estados actualizados correctamente.']);
    }

    public function importView()
    {
        return view('ventas.import');
    }

    public function importarCencosud(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel con formato .xlsx, .xls o .csv.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Leer el archivo Excel utilizando PhpSpreadsheet
            $path = $request->file('archivo')->getRealPath();
            $extension = $request->file('archivo')->getClientOriginalExtension();
    
            // Seleccionar el lector adecuado basado en la extensión
            $reader = match ($extension) {
                'xlsx' => new \PhpOffice\PhpSpreadsheet\Reader\Xlsx(),
                'xls' => new \PhpOffice\PhpSpreadsheet\Reader\Xls(),
                'csv' => new \PhpOffice\PhpSpreadsheet\Reader\Csv(),
                default => throw new \Exception('Formato de archivo no soportado.'),
            };
    
            // Cargar los datos del archivo
            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            // Verificar si los datos están vacíos o no tienen filas válidas
            if (empty($data) || count($data) <= 1) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }
    
            $processedData = [];
    
            foreach ($data as $index => $row) {
                // Saltar la fila de encabezados (asumiendo que es la primera fila)
                if ($index === 0) {
                    continue;
                }
    
                $numeroOrden = $row[0] ?? null;
    
                // Verificar si la orden ya existe en la base de datos
                $yaExiste = Venta::where('numero_orden', $numeroOrden)->exists();
    
                // Procesar y mapear los datos del Excel
                $processedData[] = [
                    'numero_orden' => $numeroOrden,
                    'cliente_id' => 2, // Asignar cliente_id como 2
                    'cliente_final' => $row[2] ?? null,
                    'rut_documento' => $row[3] ?? null,
                    'email' => $row[4] ?? null,
                    'telefono' => $row[5] ?? null,
                    'fecha_compra' => isset($row[6]) ? Carbon::parse($row[6])->format('d-m-Y') : null,
                    'fecha_entrega' => isset($row[7]) ? Carbon::parse($row[7])->format('d-m-Y') : null,
                    'fecha_cliente' => isset($row[8]) ? Carbon::parse($row[8])->format('d-m-Y') : null,
                    'producto' => $row[9] ?? null,
                    'precio' => isset($row[10]) ? intval($row[10]) : null,
                    'precio_cliente' => isset($row[11]) ? intval($row[11]) : null,
                    'costo_despacho' => isset($row[12]) ? intval($row[12]) : null,
                    'comuna' => $row[13] ?? null,
                    'direccion' => $row[14] ?? null,
                    'region' => $row[15] ?? null,
                    'sku' => isset($row[17]) ? explode('-', $row[17])[0] : null,
                    'estado' => 'Nueva', // Estado por defecto
                    'documento' => $row[19] ?? null,
                    'razon_social' => $row[20] ?? null,
                    'rut' => $row[21] ?? null,
                    'giro' => $row[22] ?? null,
                    'direccion_factura' => $row[23] ?? null,
                    'currier' => $row[27] ?? null,
                    'ya_existe' => $yaExiste, // Indicar si la orden ya existe
                ];
            }
    
            // Redirigir a la vista preview con los datos procesados
            return view('ventas.preview', ['ventas' => $processedData]);
    
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
    
    

    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel con formato .xlsx, .xls o .csv.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            $path = $request->file('archivo')->getRealPath();
            $data = Excel::toArray([], $path);
    
            if (!isset($data[0]) || count($data[0]) === 0) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene formato válido.']);
            }
    
            $ventasPreview = [];
            foreach ($data[0] as $index => $row) {
                if ($index === 0) continue; // Saltar encabezados
    
                $numeroOrden = $row[0];
                $fechaEntrega = isset($row[7]) ? Carbon::createFromFormat('Y-m-d', $row[7])->format('d-m-Y') : null;
                $sku = isset($row[17]) ? preg_replace('/-\d+$/', '', $row[17]) : null;
                $producto = $row[9] ?? null;
                $precioCliente = isset($row[11]) ? intval($row[11]) : null;
    
                $yaExiste = Venta::where('numero_orden', $numeroOrden)->exists();
    
                $ventasPreview[] = [
                    'numero_orden' => $numeroOrden,
                    'fecha_entrega' => $fechaEntrega,
                    'sku' => $sku,
                    'producto' => $producto,
                    'precio_cliente' => $precioCliente,
                    'ya_existe' => $yaExiste,
                ];
            }
    
            return view('ventas.preview', ['ventas' => $ventasPreview]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
    

    public function storeFromPreview(Request $request)
    {
        $ventasSeleccionadas = json_decode($request->input('ventas'), true);
    
        if (!$ventasSeleccionadas || count($ventasSeleccionadas) === 0) {
            return back()->withErrors(['error' => 'No hay ventas para guardar.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($ventasSeleccionadas as $venta) {
                // Verificar si la orden ya existe para evitar duplicados
                if (Venta::where('numero_orden', $venta['numero_orden'])->exists()) {
                    continue;
                }
    
                // Convertir fechas al formato 'YYYY-MM-DD'
                $fechaCompra = isset($venta['fecha_compra']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_compra'])->format('Y-m-d') : null;
                $fechaEntrega = isset($venta['fecha_entrega']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_entrega'])->format('Y-m-d') : null;
                $fechaCliente = isset($venta['fecha_cliente']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_cliente'])->format('Y-m-d') : null;
    
                // Crear la venta en la base de datos
                Venta::create([
                    'numero_orden' => $venta['numero_orden'],
                    'cliente_id' => 2, // Asignar cliente_id fijo como 2
                    'cliente_final' => $venta['cliente_final'],
                    'rut_documento' => $venta['rut_documento'], // Rut del documento
                    'email' => $venta['email'],
                    'telefono' => $venta['telefono'],
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                    'fecha_cliente' => $fechaCliente,
                    'producto' => $venta['producto'], // Producto
                    'precio' => $venta['precio'],
                    'precio_cliente' => $venta['precio_cliente'],
                    'costo_despacho' => $venta['costo_despacho'],
                    'comuna' => $venta['comuna'],
                    'direccion' => $venta['direccion'],
                    'region' => $venta['region'],
                    'sku' => $venta['sku'],
                    'estado' => $venta['estado'], // Estado
                    'documento' => $venta['documento'],
                    'razon_social' => $venta['razon_social'], // Razón social
                    'rut' => $venta['rut'], // RUT
                    'giro' => $venta['giro'], // Giro
                    'direccion_factura' => $venta['direccion_factura'], // Dirección de factura
                    'currier' => $venta['currier'], // Currier
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Ventas guardadas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las ventas: ' . $e->getMessage()]);
        }
    }    

    public function destroy($id)
    {
        try {
            $venta = Venta::findOrFail($id); // Busca la venta por ID o lanza un error 404 si no existe
            $venta->delete(); // Elimina la venta de la base de datos
    
            // Devuelve una respuesta JSON exitosa
            return response()->json(['success' => true, 'message' => 'Orden de compra eliminada correctamente.']);
        } catch (\Exception $e) {
            // Devuelve una respuesta JSON con el mensaje de error
            return response()->json(['success' => false, 'message' => 'Error al eliminar la orden de compra: ' . $e->getMessage()], 500);
        }
    }


    public function maestra()
    {
        // Obtener todos los clientes con sus ventas en estado "Nueva"
        $clientes = Cliente::whereHas('ventas', function ($query) {
            $query->where('estado', 'Nueva');
        })->with(['ventas' => function ($query) {
            $query->where('estado', 'Nueva');
        }])->get();
    
        // Obtener todas las fechas únicas ordenadas de menor a mayor
        $fechas = Venta::where('estado', 'Nueva')
            ->select('fecha_entrega')
            ->distinct()
            ->orderBy('fecha_entrega', 'asc')
            ->pluck('fecha_entrega');
    
        // Preparar datos para cada cliente
        $clientes = $clientes->map(function ($cliente) use ($fechas) {
            $productos = $cliente->ventas->groupBy('producto')->map(function ($ventasPorProducto) use ($fechas) {
                $sku = $ventasPorProducto->first()->producto;
                
                // Buscar en la tabla productos usando el modelo Producto
                $producto = Producto::where('sku', $sku)
                    ->orWhere('sku_hites', $sku)
                    ->orWhere('sku_la_polar', $sku)
                    ->first();
    
                $productoData = [
                    'producto' => $producto ? $producto->nombre : $ventasPorProducto->first()->producto,
                    'fechas' => $fechas->mapWithKeys(function ($fecha) use ($ventasPorProducto) {
                        return [$fecha => $ventasPorProducto->where('fecha_entrega', $fecha)->count()];
                    }),
                ];
                $productoData['total'] = $productoData['fechas']->sum();
                return $productoData;
            });
            $cliente->productos = $productos;
            return $cliente;
        });
    
        // Calcular totales por producto
        $totalesPorProducto = Venta::where('estado', 'Nueva')
            ->select('producto', DB::raw('count(*) as total'))
            ->groupBy('producto')
            ->pluck('total', 'producto');
    
        // Calcular totales por cliente
        $totalesPorCliente = Venta::where('estado', 'Nueva')
            ->select('cliente_id', DB::raw('count(*) as total'))
            ->groupBy('cliente_id')
            ->pluck('total', 'cliente_id');
        
        // Calcular el total por fecha
        $totalesPorFecha = Venta::where('estado', 'Nueva')
            ->select('fecha_entrega', DB::raw('count(*) as total'))
            ->groupBy('fecha_entrega')
            ->pluck('total', 'fecha_entrega');
    
        // Calcular el gran total
        $granTotal = Venta::where('estado', 'Nueva')->count();
    
        return view('ventas.maestra', compact(
            'clientes', 
            'fechas', 
            'totalesPorProducto', 
            'totalesPorFecha', 
            'totalesPorCliente', 
            'granTotal'
        ));
    }


    public function importarWalmart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel con formato .xlsx, .xls o .csv.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Obtener el archivo y su extensión
            $path = $request->file('archivo')->getRealPath();
            $extension = $request->file('archivo')->getClientOriginalExtension();
    
            // Seleccionar el lector adecuado basado en la extensión
            $reader = match ($extension) {
                'xlsx' => new \PhpOffice\PhpSpreadsheet\Reader\Xlsx(),
                'xls' => new \PhpOffice\PhpSpreadsheet\Reader\Xls(),
                'csv' => new \PhpOffice\PhpSpreadsheet\Reader\Csv(),
                default => throw new \Exception('Formato de archivo no soportado.'),
            };
    
            // Cargar los datos del archivo
            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            // Validar que el archivo no esté vacío
            if (empty($data) || count($data) <= 1) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }
    
            $processedData = [];
    
            foreach ($data as $index => $row) {
                // Saltar la fila de encabezados
                if ($index === 0) {
                    continue;
                }
    
                $numeroOrden = $row[1] ?? null;
                $precio = isset($row[25]) && isset($row[27]) ? intval($row[25]) + intval($row[27]) : null;
    
                // Verificar si la orden ya existe en la base de datos
                $yaExiste = Venta::where('numero_orden', $numeroOrden)->exists();
    
                // Procesar y mapear los datos del Excel
                $processedData[] = [
                    'numero_orden' => $numeroOrden,
                    'cliente_id' => 3, // ID del cliente asociado a Walmart
                    'fecha_compra' => isset($row[2]) ? Carbon::parse($row[2])->format('d-m-Y') : null,
                    'fecha_entrega' => isset($row[3]) ? Carbon::parse($row[3])->format('d-m-Y') : null,
                    'fecha_cliente' => isset($row[4]) ? Carbon::parse($row[4])->format('d-m-Y') : null,
                    'cliente_final' => $row[5] ?? null,
                    'rut_documento' => $row[12] ?? null,
                    'email' => null, // Campo faltante
                    'telefono' => $row[7] ?? null,
                    'direccion' => $row[8] ?? null,
                    'region' => $row[11] ?? null,
                    'comuna' => $row[10] ?? null,
                    'sku' => $row[24] ?? null,
                    'producto' => $row[21] ?? null,
                    'precio' => isset($row[25]) ? intval($row[25]) : null, // Precio base
                    'precio_cliente' => $precio, // Precio + impuesto
                    'costo_despacho' => isset($row[26]) ? intval($row[26]) : null,
                    'estado' => 'Nueva', // Estado por defecto
                    'documento' => null, // Campo faltante
                    'razon_social' => null, // Campo faltante
                    'rut' => null, // Campo faltante
                    'giro' => null, // Campo faltante
                    'direccion_factura' => null, // Campo faltante
                    'currier' => $row[30] ?? null,
                    'created_at' => Carbon::now(), // Fecha actual como predeterminada
                    'updated_at' => Carbon::now(), // Fecha actual como predeterminada
                    'ya_existe' => $yaExiste, // Indicar si ya existe
                ];
            }
    
            // Redirigir a la vista preview con los datos procesados
            return view('ventas.previewwalmart', ['ventas' => $processedData]);
    
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
    

    public function storeFromPreviewwalmart(Request $request)
    {
        $ventasSeleccionadas = json_decode($request->input('ventas'), true);
    
        if (!$ventasSeleccionadas || count($ventasSeleccionadas) === 0) {
            return back()->withErrors(['error' => 'No hay ventas para guardar.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($ventasSeleccionadas as $venta) {
                // Verificar si la orden ya existe para evitar duplicados
                if (Venta::where('numero_orden', $venta['numero_orden'])->exists()) {
                    continue;
                }
    
                // Convertir fechas al formato 'YYYY-MM-DD'
                $fechaCompra = isset($venta['fecha_compra']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_compra'])->format('Y-m-d') : null;
                $fechaEntrega = isset($venta['fecha_entrega']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_entrega'])->format('Y-m-d') : null;
                $fechaCliente = isset($venta['fecha_cliente']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_cliente'])->format('Y-m-d') : null;
    
                // Crear la venta en la base de datos
                Venta::create([
                    'numero_orden' => $venta['numero_orden'],
                    'cliente_id' => 3, // Asignar cliente_id fijo como 2
                    'cliente_final' => $venta['cliente_final'],
                    'rut_documento' => $venta['rut_documento'], // Rut del documento
                    'email' => $venta['email'],
                    'telefono' => $venta['telefono'],
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                    'fecha_cliente' => $fechaCliente,
                    'producto' => $venta['producto'], // Producto
                    'precio' => $venta['precio'],
                    'precio_cliente' => $venta['precio_cliente'],
                    'costo_despacho' => $venta['costo_despacho'],
                    'comuna' => $venta['comuna'],
                    'direccion' => $venta['direccion'],
                    'region' => $venta['region'],
                    'sku' => $venta['sku'],
                    'estado' => $venta['estado'], // Estado
                    'documento' => $venta['documento'],
                    'razon_social' => $venta['razon_social'], // Razón social
                    'rut' => $venta['rut'], // RUT
                    'giro' => $venta['giro'], // Giro
                    'direccion_factura' => $venta['direccion_factura'], // Dirección de factura
                    'currier' => $venta['currier'], // Currier
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Ventas guardadas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las ventas: ' . $e->getMessage()]);
        }
    }




    public function importarFalabella(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel con formato .xlsx, .xls o .csv.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Obtener el archivo y su extensión
            $path = $request->file('archivo')->getRealPath();
            $extension = $request->file('archivo')->getClientOriginalExtension();
    
            // Seleccionar el lector adecuado según la extensión
            $reader = match ($extension) {
                'xlsx' => new \PhpOffice\PhpSpreadsheet\Reader\Xlsx(),
                'xls' => new \PhpOffice\PhpSpreadsheet\Reader\Xls(),
                'csv' => new \PhpOffice\PhpSpreadsheet\Reader\Csv(),
                default => throw new \Exception('Formato de archivo no soportado.'),
            };
    
            // Cargar los datos del archivo
            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            // Validar que el archivo no esté vacío
            if (empty($data) || count($data) <= 1) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }
    
            $processedData = [];
    
            foreach ($data as $index => $row) {
                // Saltar la fila de encabezados
                if ($index === 0) {
                    continue;
                }
    
                $numeroOrden = $row[4] ?? null;
    
                // Verificar si la orden ya existe en la base de datos
                $yaExiste = Venta::where('numero_orden', $numeroOrden)->exists();
    
                // Procesar y mapear los datos del Excel
                $processedData[] = [
                    'numero_orden' => $numeroOrden,
                    'cliente_id' => 4, // ID del cliente asociado a Falabella
                    'fecha_compra' => isset($row[3]) ? Carbon::parse($row[3])->format('d-m-Y') : null,
                    'fecha_entrega' => isset($row[50]) ? Carbon::parse($row[50])->format('d-m-Y') : null,
                    'cliente_final' => $row[9] ?? null,
                    'rut_documento' => $row[11] ?? null,
                    'direccion' => $row[13] ?? null,
                    'comuna' => $row[18] ?? null,
                    'region' => $row[22] ?? null,
                    'sku' => $row[1] ?? null,
                    'producto' => $row[40] ?? null,
                    'precio' => isset($row[35]) ? intval(str_replace(',', '', $row[35])) : null,
                    'precio_cliente' => isset($row[36]) ? intval(str_replace(',', '', $row[36])) : null,
                    'costo_despacho' => isset($row[37]) ? intval(str_replace(',', '', $row[37])) : null,
                    'currier' => $row[42] ?? null,
                    'estado' => 'Nueva', // Estado por defecto
                    'documento' => $row[8] ?? null,
                    'ya_existe' => $yaExiste, // Indicar si ya existe
                ];
            }
    
            // Redirigir a la vista preview con los datos procesados
            return view('ventas.previewfalabella', ['ventas' => $processedData]);
    
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }

    public function storeFromPreviewFalabella(Request $request)
    {
        $ventasSeleccionadas = json_decode($request->input('ventas'), true);
    
        if (!$ventasSeleccionadas || count($ventasSeleccionadas) === 0) {
            return back()->withErrors(['error' => 'No hay ventas para guardar.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($ventasSeleccionadas as $venta) {
                // Verificar si la orden ya existe para evitar duplicados
                if (Venta::where('numero_orden', $venta['numero_orden'])->exists()) {
                    continue;
                }
    
                // Convertir fechas al formato 'YYYY-MM-DD'
                $fechaCompra = isset($venta['fecha_compra']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_compra'])->format('Y-m-d') : null;
                $fechaEntrega = isset($venta['fecha_entrega']) ? Carbon::createFromFormat('d-m-Y', $venta['fecha_entrega'])->format('Y-m-d') : null;
    
                // Crear la venta en la base de datos
                Venta::create([
                    'numero_orden' => $venta['numero_orden'],
                    'cliente_id' => 4, // Asignar cliente_id fijo como 4 (Falabella)
                    'cliente_final' => $venta['cliente_final'],
                    'rut_documento' => $venta['rut_documento'], // Rut del documento
                    'direccion' => $venta['direccion'],
                    'comuna' => $venta['comuna'],
                    'region' => $venta['region'],
                    'sku' => $venta['sku'],
                    'producto' => $venta['producto'],
                    'precio' => $venta['precio'],
                    'precio_cliente' => $venta['precio_cliente'],
                    'costo_despacho' => $venta['costo_despacho'],
                    'currier' => $venta['currier'],
                    'estado' => $venta['estado'], // Estado
                    'documento' => $venta['documento'],
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Ventas de Falabella guardadas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las ventas: ' . $e->getMessage()]);
        }
    }
    
    





    public function importarLapolar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xls,xlsx|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel en formato .xls o .xlsx.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            $path = $request->file('archivo')->getRealPath();
    
            // Verificar el formato del archivo
            $reader = $request->file('archivo')->getClientOriginalExtension() === 'xls'
                ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
                : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    
            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            if (empty($data) || count($data[0]) === 0) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }
    
            $processedData = [];
            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Saltar encabezados
    
                $numeroOrden = $row[0] ?? null;
                $documento = $row[1] ?? null;
                $fechaCompra = isset($row[4]) && !empty($row[4]) ? Carbon::parse($row[4])->format('d-m-Y') : null;
                $fechaEntrega = isset($row[9]) && !empty($row[9]) ? Carbon::parse($row[9])->format('d-m-Y') : null;
                $sku = $row[12] ?? null;
                $producto = $row[14] ?? null;
    
                // Convertir precios a enteros
                $precio = isset($row[15]) ? intval(preg_replace('/[^\d]/', '', $row[15])) : null;
                $precioCliente = isset($row[16]) ? intval(preg_replace('/[^\d]/', '', $row[16])) : null;
    
                $clienteFinal = $row[23] ?? null;
                $direccion = $row[24] ?? null;
                $comuna = $row[25] ?? null;
                $region = $row[26] ?? null;
                $telefono = $row[28] ?? null;
                $fechaCliente = isset($row[32]) && !empty($row[32]) ? Carbon::parse($row[32])->format('d-m-Y') : null;
    
                $yaExiste = Venta::where('numero_orden', $numeroOrden)->exists();
    
                $processedData[] = [
                    'numero_orden' => $numeroOrden,
                    'documento' => $documento,
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                    'sku' => $sku,
                    'producto' => $producto,
                    'precio' => $precio,
                    'precio_cliente' => $precioCliente,
                    'cliente_final' => $clienteFinal,
                    'direccion' => $direccion,
                    'comuna' => $comuna,
                    'region' => $region,
                    'telefono' => $telefono,
                    'fecha_cliente' => $fechaCliente,
                    'ya_existe' => $yaExiste,
                ];
            }
    
            return view('ventas.previewlapolar', ['ventas' => $processedData]);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
    
    
    

    public function storeFromPreviewLapolar(Request $request)
    {
        $ventasSeleccionadas = json_decode($request->input('ventas'), true);
    
        if (!$ventasSeleccionadas || count($ventasSeleccionadas) === 0) {
            return back()->withErrors(['error' => 'No hay ventas para guardar.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($ventasSeleccionadas as $venta) {
                if (Venta::where('numero_orden', $venta['numero_orden'])->exists()) {
                    continue;
                }
    
                $fechaCompra = isset($venta['fecha_compra']) && !empty($venta['fecha_compra'])
                    ? Carbon::createFromFormat('d-m-Y', $venta['fecha_compra'])->format('Y-m-d') : null;
    
                $fechaEntrega = isset($venta['fecha_entrega']) && !empty($venta['fecha_entrega'])
                    ? Carbon::createFromFormat('d-m-Y', $venta['fecha_entrega'])->format('Y-m-d') : null;
    
                $fechaCliente = isset($venta['fecha_cliente']) && !empty($venta['fecha_cliente'])
                    ? Carbon::createFromFormat('d-m-Y', $venta['fecha_cliente'])->format('Y-m-d') : null;
    
                $precio = isset($venta['precio']) ? intval(preg_replace('/[^\d]/', '', $venta['precio'])) : null;
                $precioCliente = isset($venta['precio_cliente']) ? intval(preg_replace('/[^\d]/', '', $venta['precio_cliente'])) : null;
    
                Venta::create([
                    'numero_orden' => $venta['numero_orden'],
                    'cliente_id' => 5, // ID del cliente asociado a La Polar
                    'documento' => $venta['documento'],
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                    'sku' => $venta['sku'],
                    'producto' => $venta['producto'],
                    'precio' => $precio,
                    'precio_cliente' => $precioCliente,
                    'cliente_final' => $venta['cliente_final'],
                    'direccion' => $venta['direccion'],
                    'comuna' => $venta['comuna'],
                    'region' => $venta['region'],
                    'telefono' => $venta['telefono'],
                    'fecha_cliente' => $fechaCliente,
                    'estado' => 'Nueva',
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Ventas de La Polar guardadas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las ventas: ' . $e->getMessage()]);
        }
    }




    public function importarHites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xls,xlsx|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel en formato .xls o .xlsx.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $path = $request->file('archivo')->getRealPath();

            // Verificar el formato del archivo
            $reader = $request->file('archivo')->getClientOriginalExtension() === 'xls'
                ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
                : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();

            if (empty($data) || count($data[0]) === 0) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }

            $processedData = [];
            foreach ($data as $index => $row) {
                if ($index === 0) continue; // Saltar encabezados

                $processedData[] = [
                    'numero_orden' => $row[1] ?? null,
                    'fecha_compra' => isset($row[5]) ? Carbon::parse($row[5])->format('d-m-Y') : null,
                    'fecha_entrega' => isset($row[5]) ? Carbon::parse($row[5])->format('d-m-Y') : null,
                    'precio' => isset($row[11]) ? intval($row[11]) : null,
                    'precio_cliente' => isset($row[12]) ? intval($row[12]) : null,
                    'costo_despacho' => isset($row[13]) ? intval($row[13]) : null,
                    'cliente_final' => $row[35] ?? null,
                    'telefono' => $row[36] ?? null,
                    'email' => $row[37] ?? null,
                    'ya_existe' => Venta::where('numero_orden', $row[1] ?? '')->exists(),
                ];
            }

            return view('ventas.previewhites', ['ventas' => $processedData]);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }

    public function storeFromPreviewHites(Request $request)
    {
        $ventasSeleccionadas = json_decode($request->input('ventas'), true);

        if (!$ventasSeleccionadas || count($ventasSeleccionadas) === 0) {
            return back()->withErrors(['error' => 'No hay ventas para guardar.']);
        }

        DB::beginTransaction();

        try {
            foreach ($ventasSeleccionadas as $venta) {
                // Verificar si la orden ya existe para evitar duplicados
                if (Venta::where('numero_orden', $venta['numero_orden'])->exists()) {
                    continue;
                }

                // Convertir fechas al formato 'YYYY-MM-DD'
                $fechaCompra = isset($venta['fecha_compra']) && !empty($venta['fecha_compra'])
                    ? Carbon::createFromFormat('d-m-Y', $venta['fecha_compra'])->format('Y-m-d') : null;
                $fechaEntrega = isset($venta['fecha_entrega']) && !empty($venta['fecha_entrega'])
                ? Carbon::createFromFormat('d-m-Y', $venta['fecha_entrega'])->format('Y-m-d') : null;        

                // Crear la venta en la base de datos
                Venta::create([
                    'numero_orden' => $venta['numero_orden'],
                    'cliente_id' => 6, // ID del cliente asociado a Hites
                    'fecha_compra' => $fechaCompra,
                    'fecha_entrega' => $fechaEntrega,
                    'precio' => $venta['precio'],
                    'precio_cliente' => $venta['precio_cliente'],
                    'costo_despacho' => $venta['costo_despacho'],
                    'cliente_final' => $venta['cliente_final'],
                    'telefono' => $venta['telefono'],
                    'email' => $venta['email'],
                    'estado' => 'Nueva', // Estado por defecto
                ]);
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Ventas de Hites guardadas exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar las ventas: ' . $e->getMessage()]);
        }
    }




    public function previewActualizarOrdenesHites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'archivo' => 'required|mimes:xls,xlsx|max:2048',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.mimes' => 'El archivo debe ser un Excel en formato .xls o .xlsx.',
            'archivo.max' => 'El archivo no puede superar los 2MB.',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            $path = $request->file('archivo')->getRealPath();
    
            // Leer el archivo Excel
            $reader = $request->file('archivo')->getClientOriginalExtension() === 'xls'
                ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
                : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    
            $spreadsheet = $reader->load($path);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            if (empty($data) || count($data[0]) === 0) {
                return back()->withErrors(['error' => 'El archivo está vacío o no tiene un formato válido.']);
            }
    
            $orders = [];
            // Saltar fila de encabezados (índice 0)
            for ($i = 1; $i < count($data); $i++) {
                $row = $data[$i];
                $numeroOrden = $row[0] ?? null;
    
                if ($numeroOrden) {
                    // Inicializar el arreglo para la orden si no existe
                    if (!isset($orders[$numeroOrden])) {
                        $orders[$numeroOrden] = [];
                    }
                    // Agregar la fila al arreglo de la orden correspondiente
                    $orders[$numeroOrden][] = $row;
                }
            }
    
            $previewData = [];
    
            foreach ($orders as $numeroOrden => $rows) {
                // Obtener los datos necesarios de la primera fila de cada orden
                $fila1 = $rows[0];
                $fila2 = isset($rows[1]) ? $rows[1] : null;
    
                $sku = $fila1[1] ?? null;
                $producto = $fila1[3] ?? null;
                $rut_documento = $fila1[11] ?? null;
    
                // `precio_cliente` y `costo_despacho`
                $precio_cliente = isset($fila1[8]) ? intval($fila1[8]) : 0;
                $costo_despacho = isset($fila2[8]) ? intval($fila2[8]) : 0;
    
                $previewData[] = [
                    'numero_orden' => $numeroOrden,
                    'sku' => $sku,
                    'producto' => $producto,
                    'precio_cliente' => $precio_cliente,
                    'costo_despacho' => $costo_despacho,
                    'rut_documento' => $rut_documento,
                ];
            }
    
            return view('ventas.previewactualizarhites', ['ordenes' => $previewData]);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return back()->withErrors(['error' => 'Error al leer el archivo: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar el archivo: ' . $e->getMessage()]);
        }
    }
    


    public function guardarActualizarOrdenesHites(Request $request)
    {
        $ordenesActualizadas = json_decode($request->input('ordenes'), true);
    
        if (!$ordenesActualizadas || count($ordenesActualizadas) === 0) {
            return back()->withErrors(['error' => 'No hay órdenes para actualizar.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($ordenesActualizadas as $orden) {
                // Buscar la orden en la base de datos
                $venta = Venta::where('numero_orden', $orden['numero_orden'])->first();
    
                if ($venta) {
                    // Actualizar datos
                    $venta->sku = $orden['sku'] ?? $venta->sku;
                    $venta->producto = $orden['producto'] ?? $venta->producto;
                    $venta->precio_cliente = $orden['precio_cliente'] ?? $venta->precio_cliente;
                    $venta->costo_despacho = $orden['costo_despacho'] ?? $venta->costo_despacho;
                    $venta->rut_documento = $orden['rut_documento'] ?? $venta->rut_documento;
    
                    $venta->save();
                }
            }
    
            DB::commit();
    
            return redirect()->route('ventas.index')->with('success', 'Órdenes actualizadas correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar las órdenes: ' . $e->getMessage()]);
        }
    }
    


}