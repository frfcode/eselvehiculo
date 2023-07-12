<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $title }}</title>
    <link rel="shortcut icon" href="{{url('/favicon.ico')}}" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="routerName" content="{{ Route::currentRouteName() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.time()) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/popper.min.js?v='.time()) }}"></script>
    <script src="{{ asset('js/app.js?v='.time()) }}"></script>
    <script src="{{ asset('js/global.js?v='.time()) }}"></script>

    <!-- SEO TAGS-->
    <meta name="description" content="{{$description}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:locale" content="es_VE">
    <meta property="og:image" content="{{ asset('img/logo.png') }}">
    <meta name="author" content="eselvehiculo">
    <meta name="robots" content="index">
    <meta name="copyright" content="eselvehiculo">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{$description}}">
    <meta name="keywords" content="filtros venezuela, bujias venezuela, carros repuestos, eselvehiculo, eselvehiculo venezuela, eselvehiculo filtros, eselveiculo bujias, eselvehiculo repuestos, eselvehiculo correas">


    <!--PWA FILE AND META TAGS-->
    <meta name="theme-color" content="#105b89"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" type="image/png" href="{{ asset('pwa/icon-512x512.png') }} ">
    <link rel="apple-touch-icon" href="{{ asset('pwa/icons/icon-512x512.png') }} " />
    <link rel="apple-touch-startup-image" href="{{ asset('pwa/icon-512x512.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-72x72.png') }}"  />
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-96x96.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-128x128.png') }} " />
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-144x144.png') }} "/>
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-152x152.png') }} "/>
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-192x192.png') }} "/>
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-384x384.png') }} "/>
    <link rel="apple-touch-icon" href="{{ asset('pwa/icon-512x512.png') }} "/>
    <meta name="apple-mobile-web-app-status-bar" content="#105b89" />
    <link rel="manifest" href="{{ url('/manifest.json') }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-42XLSS2BHR"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-42XLSS2BHR');
    </script>

</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg eselvehiculo-background_1">
        <div class="container-fluid">
          <a class="navbar-brand" href="/"><img src="{{ asset('img/logo.png') }}" alt="eselvehiculo"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link fw-bold" href="/">HOME</a>
              </li>
              @foreach ( $menu as $item )
                <li class="nav-item">
                  <a class="nav-link fw-bold" href="/lista/{{$item['name']}}">{{strtoupper($item['name'])}}</a>
                </li>
              @endforeach

              {{-- @if (Route::has('login'))
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              @endif --}}
            </ul>
          </div>
          <div>
          </div>
        </div>
      </nav>
    </header>
      <main>
        {{-- LOADING --}}
        <div class="loading" id="eselvehiculo_loading">
          <img src="{{ asset('img/loading.png') }}" width="200" alt="eselvehiculo"/>
        </div>



        {{-- WHATS APP --}}
        <div>
          <div class="eselvehiculo-contact shadow">
            <a href="https://wa.me/+584241606670" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            <span class="eselvehiculo-placheholder">Contactanos</span>
          </div>
        </div>

        {{-- LIST CATALOGO --}}
        <div>
          <div class="eselvehiculo-catalogue shadow">
            <a href="/catalog-exports" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
            <span class="eselvehiculo-placheholder">Catalogo Digital</span>
          </div>
        </div>

        {{-- GOOGLE MAPS UBICATION --}}
        <div>
          <div class="eselvehiculo-ubication shadow">
            <a href="https://goo.gl/maps/WNzHgLqtoZSbD5cJ6" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
            <span class="eselvehiculo-placheholder">Ubicacion</span>
          </div>
        </div>

        {{-- HOME.BLADE CONTENT --}}
        @yield('content')
      </main>
</body>
</html>
