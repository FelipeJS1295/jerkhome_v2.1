<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Mostrar el listado de productos.
     */
    public function index()
    {
        $productos = Producto::with('insumos')->get();
        return view('configuracion.productos.index', compact('productos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo producto.
     */
    public function create()
    {
        $insumos = Insumo::all(); // Traer todos los insumos disponibles
        return view('configuracion.productos.create', compact('insumos'));
    }

    /**
     * Almacenar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|string|max:255|unique:productos',
            'nombre' => 'required|string|max:255',
            'esqueleto' => 'required|string|max:255',
            'sku_esqueleto' => 'nullable|string|max:255',
            'sku_hites' => 'nullable|string|max:255',
            'sku_la_polar' => 'nullable|string|max:255',
            'costo_costura' => 'required|numeric|min:0',
            'costo_tapiceria' => 'required|numeric|min:0',
            'costo_esqueleteria' => 'required|numeric|min:0',
            'costo_armado' => 'required|numeric|min:0',
            'costo_corte' => 'required|numeric|min:0',
            'imagen_corte' => 'nullable|image|max:2048',
            'imagen_tapizado' => 'nullable|image|max:2048',
            'imagen_corte_esqueleto' => 'nullable|image|max:2048',
            'imagen_esqueleto' => 'nullable|image|max:2048',
            'insumos' => 'required|array|min:1',
            'insumos.*.id' => 'required|exists:insumos,id',
            'insumos.*.cantidad' => 'required|numeric|min:0.1',
        ], [
            'sku.required' => 'El SKU es obligatorio',
            'sku.unique' => 'Este SKU ya está en uso',
            'nombre.required' => 'El nombre es obligatorio',
            'esqueleto.required' => 'El esqueleto es obligatorio',
            'costo_costura.required' => 'El costo de costura es obligatorio',
            'costo_costura.numeric' => 'El costo de costura debe ser un número',
            'costo_costura.min' => 'El costo de costura no puede ser negativo',
            'insumos.required' => 'Debe agregar al menos un insumo',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        DB::beginTransaction();
    
        try {
            $data = $request->except('insumos', 'imagen_corte', 'imagen_tapizado', 'imagen_corte_esqueleto', 'imagen_esqueleto');
    
            // Procesar imágenes
            $imageFields = [
                'imagen_corte' => 'productos/imagenes_corte',
                'imagen_tapizado' => 'productos/imagenes_tapizado',
                'imagen_corte_esqueleto' => 'productos/imagenes_corte_esqueleto',
                'imagen_esqueleto' => 'productos/imagenes_esqueleto',
            ];
    
            foreach ($imageFields as $field => $path) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store($path, 'public');
                }
            }
    
            $producto = Producto::create($data);
    
            // Validar que todos los insumos sean únicos
            $insumoIds = collect($request->insumos)->pluck('id');
            if ($insumoIds->count() !== $insumoIds->unique()->count()) {
                throw new \Exception('No puede agregar el mismo insumo más de una vez');
            }
    
            foreach ($request->insumos as $insumo) {
                $producto->insumos()->attach($insumo['id'], [
                    'cantidad' => $insumo['cantidad']
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('productos.index')
                ->with('message', 'Producto creado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
    
            // Limpiar imágenes subidas en caso de error
            foreach ($imageFields as $field => $path) {
                if (isset($data[$field])) {
                    Storage::disk('public')->delete($data[$field]);
                }
            }
    
            return back()
                ->withErrors(['error' => 'Error al crear el producto: ' . $e->getMessage()])
                ->withInput();
        }
    }
    

    /**
     * Mostrar los detalles de un producto específico.
     */
    public function show($id)
    {
        $producto = Producto::with('insumos')->findOrFail($id);
        
        $insumosConPromedio = DB::table('producto_insumo as pi')
            ->join('insumos as i', 'pi.insumo_id', '=', 'i.id')
            ->where('pi.producto_id', $id)
            ->select(
                'i.sku_padre',
                DB::raw('MAX(i.nombre) as nombre'), // Tomamos un nombre representativo
                DB::raw('AVG(i.precio_costo) as precio_promedio'),
                'pi.cantidad',
                DB::raw('COUNT(DISTINCT i.id) as total_variantes')
            )
            ->groupBy('i.sku_padre', 'pi.cantidad')
            ->get();
    
        // Opcional: Si quieres ver los datos para debug
        // dd($insumosConPromedio);
    
        return view('configuracion.productos.show', compact('producto', 'insumosConPromedio'));
    }

    /**
     * Mostrar el formulario para editar un producto existente.
     */
    public function edit($id)
    {
        $producto = Producto::with('insumos')->findOrFail($id);
        $insumos = Insumo::all(); // Traer todos los insumos disponibles
        return view('configuracion.productos.edit', compact('producto', 'insumos'));
    }

    /**
     * Actualizar un producto en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sku' => 'required|max:255|unique:productos,sku,' . $id,
            'nombre' => 'required|max:255',
            'esqueleto' => 'nullable|max:255',
            'costo_costura' => 'nullable|numeric',
            'costo_tapiceria' => 'nullable|numeric',
            'costo_esqueleteria' => 'nullable|numeric',
            'costo_armado' => 'nullable|numeric',
            'costo_corte' => 'nullable|numeric',
            'insumos' => 'nullable|array',
            'insumos.*.id' => 'exists:insumos,id',
            'insumos.*.cantidad' => 'numeric|min:1',
        ]);
    
        $producto = Producto::findOrFail($id);
        $producto->update($validatedData);
    
        // Actualizar insumos si existen
        if ($request->has('insumos')) {
            $insumos = [];
            foreach ($request->insumos as $insumo) {
                if (is_array($insumo) && isset($insumo['id']) && isset($insumo['cantidad'])) {
                    $insumos[$insumo['id']] = ['cantidad' => $insumo['cantidad']];
                }
            }
            $producto->insumos()->sync($insumos);
        }
    
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }
    
    

    /**
     * Eliminar un producto de la base de datos.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar la relación con insumos antes de eliminar el producto
        $producto->insumos()->detach();
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function copy($id)
    {
        $producto = Producto::with('insumos')->findOrFail($id); // Obtiene el producto junto con sus insumos
        $insumos = Insumo::all(); // Obtiene todos los insumos disponibles
    
        return view('configuracion.productos.copy', compact('producto', 'insumos'));
    }

    public function storeCopy(Request $request, $id)
    {
        $productoOriginal = Producto::findOrFail($id); // Encuentra el producto original.

        $validatedData = $request->validate([
            'sku' => 'required|unique:productos,sku',
            'nombre' => 'required',
            'esqueleto' => 'required',
            // Validaciones adicionales...
        ]);

        $nuevoProducto = $productoOriginal->replicate(); // Crea una copia de todos los datos del producto original.
        $nuevoProducto->fill($validatedData); // Reemplaza los datos con los nuevos valores.
        $nuevoProducto->save(); // Guarda el nuevo producto.

        return redirect()->route('productos.index')->with('success', 'Producto copiado y creado exitosamente.');
    }


}
