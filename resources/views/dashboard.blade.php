@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50/50">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Panel de Control</h1>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Última actualización: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <select class="bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Este Mes</option>
                    <option>Último Mes</option>
                    <option>Este Año</option>
                </select>
                <button class="bg-blue-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-blue-700 transition-colors duration-150">
                    Exportar Datos
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Ventas Totales -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-chart-line text-xl text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Ventas Totales</h3>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($ventasMesActual->total, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center mt-4 text-sm">
                            <span class="text-green-600 flex items-center mr-2">
                                <i class="fas fa-arrow-up mr-1"></i> 12.5%
                            </span>
                            <span class="text-gray-500">vs mes anterior</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unidades Vendidas -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-box text-xl text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Unidades Vendidas</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($ventasMesActual->unidades) }}</p>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500">
                            Total acumulado: {{ number_format($ventasTotales->unidades) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sueldos -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-wallet text-xl text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Total Sueldos</h3>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($totalSueldos, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-500">
                            Actualizado mensualmente
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Ventas Mensuales -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Ventas Mensuales</h3>
                    <div class="flex items-center space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                    </div>
                </div>
                <div class="h-[400px]"> <!-- Contenedor con altura fija -->
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>

            <!-- Proyección -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Proyección de Ventas</h3>
                    <div class="flex items-center space-x-2">
                        <select class="text-sm border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Próximos 6 meses</option>
                            <option>Próximo año</option>
                        </select>
                    </div>
                </div>
                <div class="h-[400px]"> <!-- Contenedor con altura fija -->
                    <canvas id="proyeccionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Ventas por Región -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribución por Región</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-700">Ver Detalles</button>
                </div>
                <div class="h-[400px]"> <!-- Contenedor con altura fija -->
                    <canvas id="regionesChart"></canvas>
                </div>
            </div>

            <!-- Productos Más Vendidos -->
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Productos Más Vendidos</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-700">Ver Todos</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unidades (Mes)</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($topProductos as $producto)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $producto->producto }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ number_format($producto->unidades_mes) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ number_format($producto->unidades_totales) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 text-right">${{ number_format($producto->precio_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<script>
// Configuración común para los charts
Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
Chart.defaults.color = '#6B7280';
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(17, 24, 39, 0.95)';
Chart.defaults.plugins.tooltip.padding = 12;
Chart.defaults.plugins.tooltip.cornerRadius = 8;
Chart.defaults.plugins.tooltip.titleFont.size = 14;
Chart.defaults.plugins.tooltip.titleFont.weight = '600';
Chart.defaults.plugins.tooltip.bodyFont.size = 13;

// Ventas Mensuales Chart
new Chart(document.getElementById('ventasChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventasMensuales->pluck('mes')->map(fn($mes) => \Carbon\Carbon::create()->month($mes)->format('M'))) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventasMensuales->pluck('total')) !!},
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderColor: 'rgba(37, 99, 235, 0.8)',
            borderWidth: 2,
            borderRadius: 6,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(107, 114, 128, 0.1)'
                },
                ticks: {
                    callback: value => `$${new Intl.NumberFormat().format(value)}`
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Proyección Chart
new Chart(document.getElementById('proyeccionChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($proyeccion->pluck('mes')) !!},
        datasets: [{
            label: 'Proyección',
            data: {!! json_encode($proyeccion->pluck('proyeccion')) !!},
            borderColor: 'rgba(16, 185, 129, 0.8)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(107, 114, 128, 0.1)'
                },
                ticks: {
                    callback: value => `$${new Intl.NumberFormat().format(value)}`
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Ventas por Región Chart
new Chart(document.getElementById('regionesChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ventasRegion->pluck('region')) !!},
        datasets: [{
            data: {!! json_encode($ventasRegion->pluck('monto')) !!},
            backgroundColor: [
                'rgba(37, 99, 235, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(236, 72, 153, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            }
        }
    }
});
</script>
@endsection