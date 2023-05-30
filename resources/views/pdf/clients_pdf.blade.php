<html>
<head>
    <title>lista_clientes</title>
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
            <p class="recibe-facture-title text-bold">Lista de Clientes</p>
        </div>
    </div>
  <div class="recibe-main">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID Cliente</th>
          <th scope="col">Nombre</th>
          <th scope="col">Tipo de persona</th>
          <th scope="col">Cedula</th>
          <th scope="col">Telefono</th>
        </tr>
      </thead>
      <tbody>
        @foreach($clients as $key => $client)
        <tr>
          <td>{{$client['id']}}</td>
          <td>{{$client['name']}}</td>
          <td>{{$client['person_type']}}</td>
          <td>{{$client['dni']}}</td>
          <td>{{$client['phone_number']}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>
