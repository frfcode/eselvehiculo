{{-- show error using sidebar layout if looged in AND on an admin page; otherwise use a blank page --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>eselvehiculo - {{  $title = 'Error '.$error_number }}</title>
  <style>
    *{
      margin: 0;
      padding: 0;
    }
  body {
    background: #face17;
    font-family: monospace;
  }
  main{
    display: flex;
    width: 100%;
    height: 100vh;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  main h3{
    font-size: 40px;
    margin-bottom: 10px;
  }
  main p{
    font-size: 20px;
  }
  body::-webkit-scrollbar {
    width: 5px;
    background: #fff;
    height: 5px;
  }

  body::-webkit-scrollbar-thumb {
    background: #face17;
    border-radius: 5px;
  }

  body.app {
    background: #face17;
  }
  .error_number {
    font-size: 156px;
    font-weight: 600;
    line-height: 100px;
    color: #000;
  }
  .error_number small {
    font-size: 56px;
    font-weight: 700;
  }

  .error_number hr {
    margin-top: 60px;
    margin-bottom: 0;
    width: 50px;
  }

  .error_title {
    font-size: 36px;
    font-weight: 400;
    color: #000;
  }

  .error_description {
    font-size: 24px;
    font-weight: 400;
    color: #000;
  }
  .error_description a{
     color: #EE4444;
     font-weight: bold;
     text-decoration: none;
  }
  </style>
  </head>
<body>
  <main>
    <h3>Error {{ $error_number}}</h3>
    <p>Regresar a <a href='javascript:history.back()'> pagina anterior </a> o volver a <a href="{{ url('/') }}"> pagina de inicio</a>.</p>
  </main>
</body>
</html>