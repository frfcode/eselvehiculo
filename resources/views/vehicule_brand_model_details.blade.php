@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 p-4">
        <h1 class="text-center">REPUESTOS COMPATIBLES PARA {{ strtoupper($vehicule[0]->vehicule_brand_model) }} </h1>
      </div>
    </div>
    <div class="row">
        @if (count($products) == 0)
        <div class="col-12 mt-4">
            <p>NO HAY PRODUCTOS DISPONIBLES.</p>
            <p>PUEDE COMUNICARSE CON NOSOTROS MEDIANTE <span class="fw-bold">WHATSAPP</span> EN CASO DE NECESITAR MAS INFORMACION</p>
        </div>
        @else
        @foreach ($products as $product)
        <div class="col-12 col-xs-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 pb-2">
            <a href="#">
              <div class="card shadow" >
                {{-- <img src="'.asset('img/brands/'.strtolower($brand).'.png').'" class="card-img-top" alt="'.strtolower($brand).'"> --}}
                <div class="card-body">
                  <h5 class="card-title text-dark pb-2 border-bottom border-4 border-dark"> {{  strtoupper(getCode($product['code'])) }} - {{ strtoupper($product['product_name']) }} </h5>
                  <div class="row">
                      <div class="col-6">
                          <p class="text-dark"><span class="fw-bold">Precio:</span> {{ $product['product_selling']}}$ </p>
                      </div>
                      <div class="col-6">
                          <p class="text-dark"><span class="fw-bold">Disponible:</span> {{ $product['product_quantity'] }} </p>
                      </div>
                  </div>
                </div>
              </div>
            </a>
        </div>
        @endforeach
        @endif

        @php

        function getCode($codeID){
          $code = App\Models\Codes::where('id', $codeID)->get();
          return $code[0]['code'];
        }

        function getVehiculeCompability($vehiculeID){
            if($vehiculeID == ''){
                echo 'NO';
            }else{
                $vehicules = App\Models\Vehicules::where('id', $vehiculeID)->get();
                $vehiculeOutput = $vehicules[0]['vehicule_brand_model'].$vehicules[0]['vehicule_date'].$vehicules[0]['vehicule_motor_lits'].$vehicules[0]['vehicule_motor_type'].$vehicules[0]['vehicule_motor_system'];
                echo $vehiculeOutput;
            }
        }
    @endphp
    </div>

</div>
@endsection
