@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <h3 class="text-center">Bienvenido <b>{{ Auth::user()->name }}</b> a eselvehiculo.com, hoy es
                                <b>{{ $date }}</b>, que tengas un Buen Dia
                            </h3>
                        </div>
                    </div>
                    @if (Auth::user()->rol == 'GERENCIA')
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="bg-primary px-1 py-2 block-dashboard">
                                    <h4 class="text-center border-bottom border-white border-2 pb-2 font-weight-bold">TOTAL
                                        PRODUCTOS
                                        VENDIDOS</h4>
                                    <p class="text-center">{{ $todaySell }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="bg-success px-1 py-2 block-dashboard">
                                    <h4 class="text-center border-bottom border-white border-2 pb-2 font-weight-bold">TOTAL
                                        PRODUCTOS
                                        ACTUALES</h4>
                                    <p class="text-center">{{ $allProducts }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="bg-primary px-1 py-2 block-dashboard">
                                    <h4 class="text-center border-bottom border-white border-2 pb-2 font-weight-bold">TOTAL
                                        VENTAS DE HOY
                                    </h4>
                                    <p class="text-center">{{ $todaySell }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="bg-warning px-1 py-2 block-dashboard">
                                    <h4 class="text-center border-bottom border-dark border-2 pb-2 font-weight-bold">
                                        GANANCIAS APROXIMADAS
                                    </h4>
                                    <p class="text-center">{{ $sumEarning }}</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                <div class="bg-success px-1 py-2 block-dashboard">
                                    <h4 class="text-center border-bottom border-white border-2 pb-2 font-weight-bold">TOTAL
                                        PRODUCTOS
                                        ACTUALES
                                    </h4>
                                    <p class="text-center">{{ $allProducts }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop
