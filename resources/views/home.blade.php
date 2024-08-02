@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .bg {
            background-color: #F6F6F6;
        }

        .card-custom {
            padding: 1rem;
            margin: 0.5rem;
            width: calc(100% - 1rem);
            cursor: pointer;
            /* border: 1px solid rgba(0, 0, 0, 0.1); //kalo pake inih ada garisan */
            border: none; 
            box-shadow: 0 0 5px rgba(90, 90, 90, 0.1); tambah ini
        }
    </style>
</head>
<body class="bg-light-blue">
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <h2 class="card-title text-primary">{{ $salesToday }}</h2>
                        <p class="card-text">Penjualan Hari Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <h2 class="card-title text-primary">{{ $usersToday }}</h2>
                        <p class="card-text">User Daftar Hari Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <h2 class="card-title text-primary">{{ $salesThisMonth }}</h2>
                        <p class="card-text">Penjualan Bulan Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <h2 class="card-title text-primary">{{ $usersThisMonth }}</h2>
                        <p class="card-text">User Daftar Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <p class="card-text">Total Pendapatan Hari Ini</p>
                        <h2 class="card-title text-primary">Rp{{ number_format($totalRevenueToday, 2, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center card-custom">
                    <div class="card-body">
                        <p class="card-text">Total Pendapatan Bulan Ini</p>
                        <h2 class="card-title text-primary">Rp{{ number_format($totalRevenueThisMonth, 2, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@endsection

