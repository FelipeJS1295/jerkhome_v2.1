<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Inertia\Inertia;
use Carbon\Carbon;

class CencosudController extends Controller
{
    /**
     * Mostrar la página de importación para Cencosud.
     */
    public function import()
    {
        return view('ventas.cencosud.import');
    }

    /**
     * Procesar la importación del archivo Excel.
     */
    public function importData(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        // Subir y procesar el archivo
        $file = $request->file('archivo_excel');
        $filePath = $file->store('imports');
        $ordenes = $this->processCencosudExcel(storage_path("app/{$filePath}"));

        if (empty($ordenes)) {
            return redirect()->route('cencosud.import')->with('error', 'No se encontraron órdenes en el archivo.');
        }

        // Guardar las órdenes en la sesión para previsualización
        Session::put('ordenes_previsualizadas', $ordenes);

        // Redirigir a la página de previsualización
        return redirect()->route('cencosud.preview');
    }

    /**
     * Mostrar la página de previsualización de órdenes.
     */
    public function preview()
    {
        $ordenes = Session::get('ordenes_previsualizadas', []);
        return view('ventas.cencosud.preview', ['ordenes' => $ordenes]);
    }

    /**
     * Guardar las órdenes en la base de datos.
     */
    public function save()
    {
        $ordenes = Session::get('ordenes_previsualizadas', []);
        $ordenesGuardadas = 0;

        foreach ($ordenes as $orden) {
            Venta::updateOrCreate(
                ['numero_orden' => $orden['numero_orden'], 'sku' => $orden['sku']],
                $orden
            );
            $ordenesGuardadas++;
        }

        // Limpiar las órdenes de la sesión
        Session::forget('ordenes_previsualizadas');

        return redirect()->route('ventas.index')->with('success', "$ordenesGuardadas órdenes guardadas correctamente.");
    }

    /**
     * Procesar el archivo Excel y extraer las órdenes.
     */
    private function processCencosudExcel($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $ordenes = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Saltar encabezado

            $orden = [
                'numero_orden' => $row[0],
                'cliente_final' => $row[1],
                'email' => $row[2],
                'fecha_compra' => Carbon::parse($row[3])->format('Y-m-d'),
                'producto' => $row[4],
                'precio_cliente' => floatval($row[5]),
                'estado' => $row[6],
                'sku' => $row[7]
            ];

            $ordenes[] = $orden;
        }

        return $ordenes;
    }
}
