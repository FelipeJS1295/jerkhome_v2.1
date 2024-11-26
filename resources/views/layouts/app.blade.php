<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Jerk Home - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleapp.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleventas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylesidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleheader.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleconfig.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylecreateproduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleproduct.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylefichaventa.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylemaestra.css') }}">
    <link rel="stylesheet" href="{{ asset('css/stylerrhh.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleproduccioncreate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleproduccion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleshowventas.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>
    
    
    
</head>
<body>
    <div class="app-wrapper">
        @include('partials.sidebar')
        
        <div class="main-content">
            @include('partials.header')
            
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@section('styles')
<style>
    @media print {
        body {
            font-family: Arial, sans-serif !important;
            color: black !important;
            background: white !important;
            margin: 0;
            padding: 0;
        }

        .app-wrapper, .main-content, .sidebar, .header {
            display: none; /* Ocultar elementos del layout global */
        }

        .content-area {
            display: block !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button, a, .no-print {
            display: none !important; /* Ocultar botones y enlaces al imprimir */
        }
    }
</style>
@endsection
</body>
</html>
