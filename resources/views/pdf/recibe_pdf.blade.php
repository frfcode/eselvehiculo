<html>
<head>
    <title>recibo_{{$factureID}}</title>
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
thead tr th,
.recibe-footer h3 {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
        Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue",
        sans-serif;
}

.text-bold {
    font-weight: bold;
}

.recibe-facture-title {
    font-size: 30px;
    margin-bottom: 10px;
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
        <p class="recibe-facture-title text-bold">Factura N° {{$factureID}}</p>
        <p class="text-bold">ESELVECHICULO C.A, VENEZUELA</p>
        <p class="text-bold">TELFEFONO LOCAL: 0412-265-59-54</p>
        <p class="text-bold">WEBSITE: WWW.ESELVEHICULO.COM</p>
    </div>
    <div class="element-margin-top">
      <p>FECHA: {{explode(" ", $products[0]['created_at'])[0]}} - {{date("g:i a",strtotime($products[0]['created_at']))}} </p>
      <p>VENDIDO POR: <span class="text-bold">{{strtoupper($total[0]->vendor)}}</span></p>
      <p>PARA EL CLIENTE: <span class="text-bold">{{strtoupper($total[0]->client)}}</span></p>
    </div>
  </div>
  <div class="recibe-main">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Codigo</th>
          <th scope="col">Nombre</th>
          <th scope="col">Canitdad</th>
          <th scope="col">Precio</th>
          <th scope="col">Monto</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $key => $product)
        <tr>
          <td>{{$product['code']}}</td>
          <td>{{$product['product']}}</td>
          <td>{{$product['product_cant']}}</td>
          <td>{{$product['price']}}</td>
          <td>{{(int) $product['price'] *  (int) $product['product_cant']}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="recibe-footer">
    <div class="text-right">
        <h3>IVA: {{$total[0]->iva}}</h3>
        <h3>Total: {{$total[0]->total_price}}</h3>
    </div>
  </div>
</body>

</html>
