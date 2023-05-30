<html>
<head>
    <title>lista_productos</title>
    <style>
        * {
        margin: 0;
        padding: 0;
    }
    body {
        margin: 10px;
    }
    .recibe-header {
        display: flex;
        justify-content: space-between;
    }

    .recibe-header p,
    tbody tr td,
    thead tr th {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
            sans-serif;
    }

    .text-bold {
        font-weight: bold;
    }

    .recibe-facture-title {
        font-size: 30px;
        margin-top: 5px;
        margin-bottom: 5px;
    }
    table {
        width: 100%;
        text-align: center;
    }
    thead tr th {
        border-top: 4px solid #000;
        border-bottom: 4px solid #000;
        padding: 8px 0;
    }

    tbody tr td {
        border-bottom: 1px solid #000;
        padding: 7px 0;
        border-right: 1px solid #000;
    }

    .recibe-main {
        margin-top: 20px;
    }

    .element-margin-top{
        margin-top: 10px;
    }

    .recibe-footer {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .text-right {
        text-align: right;
    }

    </style>
</head>

<body>
    <div class="recibe-header">
      <div>
          <p class="recibe-facture-title text-bold">Lista de Productos</p>
      </div>
    </div>
    <div class="recibe-main">
        <table class="table">
            <thead>
              @if(Auth::user()->rol != 'GERENCIA')
              <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio de Compra</th>
                <th scope="col">Precio de Venta</th>
                <th scope="col">Canitdad Disponible</th>
                <th scope="col">Ganancias estimadas</th>
                <th scope="col">Vehiculo Compatible</th>
              </tr>
              @else
              <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Canitdad Disponible</th>
                <th scope="col">Vehiculo Compatible</th>
              </tr>
              @endif
            </thead>
            <tbody>
              @foreach($products as $key => $product)
              @if(Auth::user()->rol != 'GERENCIA')
              <tr>
                <td>{{getCode($product['code'])}}</td>
                <td>{{$product['product_name']}}</td>
                <td>{{$product['product_buying']}}</td>
                <td>{{$product['product_selling']}}</td>
                <td>{{$product['product_quantity']}}</td>
                <td>{{$product['product_earnings']}}</td>
                <td>{{getVehiculeCompability($product['product_vehicule_compatibility'])}}</td>
              </tr>
              @else
              <tr>
                <td>{{getCode($product['code'])}}</td>
                <td>{{$product['product_name']}}</td>
                <td>{{$product['product_buying']}}</td>
                <td>{{$product['product_quantity']}}</td>
                <td>{{getVehiculeCompability($product['product_vehicule_compatibility'])}}</td>
              </tr>
              @endif
              @endforeach
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
            </tbody>
        </table>
     </div>
  </body>
</html>
