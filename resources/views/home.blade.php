@extends('layouts.base')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-12 col-xs-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 p-4">
        <h1 class="text-center">BUSCA REPUESTOS PARA LA MARCA DE TU VEHICULO AQUI</h2>
      </div>
    </div>
    <div class="row">
      @if (count($vehicule) > 0 )
        @php
        //CREATE TMPNAMEITEM FOR DELETE DATA REPERAT AND SEARCHBRANDADDITEM FOR COMPLETE NAME OF THE BRANDS
        $tmpNameItem = [];
        $searchBrandsAddFullName = ['CASE', 'ALFA', 'GREAT', 'MERCEDEZ'];

        foreach ($vehicule as $item) {
          $separeItemName = explode(' ', $item->vehicule_brand_model);
          $brand = $separeItemName[0];

          //COMPLETE NAME OF BRAND EXAMPLE ALFA = ALFA ROMEO
          if(in_array($brand, $searchBrandsAddFullName) == true){
            $brand = $separeItemName[0].'_'.$brand = $separeItemName[1];
          }

          //SHOW TARGET WITH NAME OF THE BRAND
          if(count($tmpNameItem) == 0){
            echo '
            <div class="col-12 col-xs-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 pb-2">
            <a href="'.url()->current().'/vehiculo/'.strtolower($brand).'">
              <div class="card shadow" >
                <img src="'.asset('img/brands/'.strtolower($brand).'.png').'" class="card-img-top" alt="'.strtolower($brand).'">
                <div class="card-body">
                  <h5 class="card-title text-dark">'.str_replace('_', ' ' ,$brand).'</h5>
                </div>
              </div>
            </a>
            </div>
            ';
            array_push($tmpNameItem, $brand);
          }

          if(count($tmpNameItem) > 0){
              if(in_array($brand, $tmpNameItem) == false){
                echo '
                <div class="col-12 col-xs-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 pb-2">
                <a href="'.url()->current().'/vehiculo/'.strtolower($brand).'">
                  <div class="card shadow" >
                    <img src="'.asset('img/brands/'.strtolower($brand).'.png').'" class="card-img-top" alt="'.strtolower($brand).'">
                    <div class="card-body">
                      <h5 class="card-title text-dark">'.str_replace('_', ' ' ,$brand).'</h5>
                    </div>
                  </div>
                </a>
                </div>
                ';
                array_push($tmpNameItem, $brand);
              }
          }
      }
      @endphp
      @else
        @php $i = 0; @endphp
        @while ($i < 12)
        <div class="col-12 col-xs-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 pb-2">
          <a href="#">
            <div class="card shadow" >
              <img src="{{ asset('img/default.jpg') }}" class="card-img-top" alt="Default Content">
              <div class="card-body">
                <h5 class="card-title text-dark">No hay Marcas Registradas</h5>
              </div>
            </div>
          </a>
        </div>
        @php $i++; @endphp
        @endwhile
      @endif

    </div>
</div>
@endsection
