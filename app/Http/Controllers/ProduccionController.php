<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Trabajador;
use App\Models\Producto;
use App\Models\Produccion;
use Exception;

class ProduccionController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('produccion')
            ->join('trabajadores', 'produccion.trabajadores_id', '=', 'trabajadores.id')
            ->join('productos', 'produccion.productos_id', '=', 'productos.id')
            ->join('users', 'trabajadores.user_id', '=', 'users.id')
            ->select(
                'produccion.*',
                'trabajadores.id as trabajador_id',
                'trabajadores.nombres as trabajador_nombre',
                'productos.nombre as producto_nombre',
                'users.rol',
                DB::raw("
                    CASE 
                        WHEN produccion.tipo = 'reparacion' THEN produccion.precio_reparacion
                        WHEN users.rol = 'Tapicería' THEN productos.costo_tapiceria
                        WHEN users.rol = 'Costura' THEN productos.costo_costura
                        WHEN users.rol = 'Esqueletería' THEN productos.costo_esqueleteria
                        ELSE NULL
                    END as costo
                ")
            );
    
        // Filtros (mantener los existentes)
        if ($request->filled('trabajador_id')) {
            $query->where('trabajadores.id', $request->trabajador_id);
        }
    
        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $query->whereBetween('produccion.fecha', [$request->fecha_desde, $request->fecha_hasta]);
        }
    
        if ($request->filled('numero_orden')) {
            $query->where('produccion.numero_orden_trabajo', 'like', '%' . $request->numero_orden . '%');
        }
    
        $produccion = $query->paginate(100);
        $trabajadores = DB::table('trabajadores')->select('id', 'nombres')->get();
    
        return view('produccion.index', compact('produccion', 'trabajadores'));
    }
    

    public function create()
    {
        // Obtener los trabajadores con roles específicos
        $trabajadores = Trabajador::whereHas('user', function ($query) {
            $query->whereIn('rol', ['Tapicería', 'Costura', 'Esqueletería']);
        })->get();
    
        // Obtener los productos disponibles
        $productos = Producto::all();
    
        return view('produccion.create', compact('trabajadores', 'productos'));
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'trabajador_id_report' => 'required',
            'fecha_desde_report' => 'required|date',
            'fecha_hasta_report' => 'required|date',
        ]);
    
        $ordenes = DB::table('produccion')
            ->join('trabajadores', 'produccion.trabajadores_id', '=', 'trabajadores.id')
            ->join('productos', 'produccion.productos_id', '=', 'productos.id')
            ->join('users', 'trabajadores.user_id', '=', 'users.id')
            ->select(
                'produccion.*',
                'trabajadores.nombres as trabajador_nombre',
                'productos.nombre as producto_nombre',
                'users.rol',
                DB::raw("
                    CASE 
                        WHEN produccion.tipo = 'reparacion' THEN produccion.precio_reparacion
                        WHEN users.rol = 'Tapicería' THEN productos.costo_tapiceria
                        WHEN users.rol = 'Costura' THEN productos.costo_costura
                        WHEN users.rol = 'Esqueletería' THEN productos.costo_esqueleteria
                        ELSE NULL
                    END as costo
                ")
            )
            ->where('trabajadores.id', $request->trabajador_id_report)
            ->whereBetween('produccion.fecha', [$request->fecha_desde_report, $request->fecha_hasta_report])
            ->orderBy('produccion.fecha')
            ->get();
    
        $totalUnidades = $ordenes->count();
        $totalCosto = $ordenes->sum('costo');
    
        return view('produccion.report', compact('ordenes', 'totalUnidades', 'totalCosto'));
    }
    


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador_id' => 'required|exists:trabajadores,id',
            'ordenes.*.producto_id' => 'required|exists:productos,id',
            'ordenes.*.fecha' => 'required|date',
            'ordenes.*.numero_orden_trabajo' => 'required|unique:produccion,numero_orden_trabajo',
        ]);
    
        foreach ($validatedData['ordenes'] as $orden) {
            Produccion::create([
                'trabajadores_id' => $request->trabajador_id,
                'productos_id' => $orden['producto_id'],
                'fecha' => $orden['fecha'],
                'numero_orden_trabajo' => $orden['numero_orden_trabajo'],
            ]);
        }
    
        return redirect()->route('produccion.index')->with('success', 'Órdenes de trabajo creadas exitosamente.');
    }

    public function edit($id)
    {
        $produccion = DB::table('produccion')->where('id', $id)->first();
        $trabajadores = DB::table('trabajadores')->get();
        $productos = DB::table('productos')->get();

        return view('produccion.edit', compact('produccion', 'trabajadores', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trabajadores_id' => 'required|exists:trabajadores,id',
            'productos_id' => 'required|exists:productos,id',
            'fecha' => 'required|date',
            'numero_orden_trabajo' => "required|unique:produccion,numero_orden_trabajo,$id",
        ]);

        DB::table('produccion')->where('id', $id)->update([
            'trabajadores_id' => $request->trabajadores_id,
            'productos_id' => $request->productos_id,
            'fecha' => $request->fecha,
            'numero_orden_trabajo' => $request->numero_orden_trabajo,
            'updated_at' => now(),
        ]);

        return redirect()->route('produccion.index')->with('success', 'Orden de trabajo actualizada correctamente.');
    }

    public function destroy($id)
    {
        DB::table('produccion')->where('id', $id)->delete();

        return redirect()->route('produccion.index')->with('success', 'Orden de trabajo eliminada correctamente.');
    }

    public function storeReparacion(Request $request)
    {
        try {
            $data = $request->validate([
                'trabajadores_id' => 'required|exists:trabajadores,id',
                'ordenes.*.producto_id' => 'required|exists:productos,id',
                'ordenes.*.fecha' => 'required|date',
                'ordenes.*.numero_orden_trabajo' => 'required|string',
                'ordenes.*.descripcion' => 'nullable|string',
                'ordenes.*.precio_reparacion' => 'nullable|numeric|min:0',
            ]);

            foreach ($data['ordenes'] as $orden) {
                DB::table('produccion')->insert([
                    'trabajadores_id' => $request->trabajadores_id,
                    'productos_id' => $orden['producto_id'], // Cambiado a `productos_id`
                    'fecha' => $orden['fecha'],
                    'numero_orden_trabajo' => $orden['numero_orden_trabajo'],
                    'descripcion' => $orden['descripcion'] ?? null,
                    'precio_reparacion' => $orden['precio_reparacion'] ?? null,
                    'tipo' => 'reparacion',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('produccion.index')->with('success', 'Reparación registrada exitosamente.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al registrar la reparación: ' . $e->getMessage());
        }
    }

    public function reparaciones()
    {
        $trabajadores = DB::table('trabajadores')->get();
        $productos = DB::table('productos')->get();

        return view('produccion.reparaciones', compact('trabajadores', 'productos'));
    }
}