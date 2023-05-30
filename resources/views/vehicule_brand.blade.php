@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 p-4">
        <h1 class="text-center">SELECCIONA EL MODELO {{ strtoupper($search) }} AQUI</h1>
      </div>
    </div>
    <div class="row">
      @php
      //CREATE TMPNAMEITEM FOR DELETE DATA REPERAT AND SEARCHBRANDADDITEM FOR COMPLETE NAME OF THE BRANDS
      $tmpNameItem = [];
      $searchBrandsAddFullName = ['CASE', 'ALFA', 'GREAT', 'MERCEDEZ'];

      foreach ($vehicule as $item) {
        $separeItemName = explode(' ', $item->vehicule_brand_model);
        $brand = $separeItemName[0];
        $details = $item->vehicule_brand_model.' '.$item->id;

        if(in_array($brand, $searchBrandsAddFullName) == true){
          $brand = $separeItemName[0].'_'.$brand = $separeItemName[1];
        }

          echo '
          <div class="col-12 col-xs-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 pb-2">
          <a href="'.url('/').'/vehiculo/details/'.strtolower(str_replace(' ','_', $details)).'">
            <div class="card shadow" >
              <img src="'.asset('img/brands/'.strtolower($brand).'.png').'" class="card-img-top" alt="'.strtolower($brand).'">
              <div class="card-body">
                <h5 class="card-title text-dark">'.$item->vehicule_brand_model.'</h5>
                <div class="row">
                    <div class="col-6">
                        <p class="text-dark"><span class="fw-bold">Año:</span> '.$item->vehicule_date.'</p>
                    </div>
                    <div class="col-6">
                        <p class="text-dark"><span class="fw-bold">Tipo Motor:</span> '.$item->vehicule_motor_type  .'</p>
                    </div>
                    <div class="col-6">
                        <p class="text-dark"><span class="fw-bold">Motor Litros:</span> '.$item->vehicule_motor_lits.'</p>
                    </div>
                    <div class="col-6">
                        <p class="text-dark"><span class="fw-bold">Sistema:</span> '.$item->vehicule_motor_system.'</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn fw-bold btn-primary w-100 d-flex justify-content-center">Obtener respuestos compatibles</p>
                    </div>
                </div>
              </div>
            </div>
          </a>
          </div>
          ';
      }
      @endphp
    </div>
</div>
@endsection
