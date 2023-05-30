@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Bienvenido <b>{{ Auth::user()->name }}</b> a eselvehiculo.com, hoy es <b>{{ $date}}</b>, que tengas un Buen Dia</h3>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-12 text-center" id="gif_dashboard"></div>
                   </div>
                   @if(Auth::user()->rol == 'GERENCIA')
                   <div class="row mt-3">
                        <div class="col-6">
                            <div class="bg-primary px-1 py-2 block-dashboard">
                                <h4 class="text-center border-bottom border-white border-2 pb-2">TOTAL DE PRODUCTOS QUE HAZ VENDIDO</h4>
                                <p class="text-center">{{$todaySell}}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-success px-1 py-2 block-dashboard">
                                <h4 class="text-center border-bottom border-white border-2 pb-2">TOTAL DE PRODUCTOS AGREGADOS</h4>
                                <p class="text-center">{{$allProducts}}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mt-3">
                        <div class="col-4">
                            <div class="bg-primary px-1 py-2 block-dashboard">
                                <h4 class="text-center border-bottom border-white border-2 pb-2">TOTAL DE VENTAS DE HOY</h4>
                                <p class="text-center">{{$todaySell}}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-warning px-1 py-2 block-dashboard">
                                <h4 class="text-center border-bottom border-dark border-2 pb-2">GANANCIAS APROXIMADAS</h4>
                                <p class="text-center">{{$sumEarning}}</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-success px-1 py-2 block-dashboard">
                                <h4 class="text-center border-bottom border-white border-2 pb-2">TOTAL DE PRODUCTOS AGREGADOS</h4>
                                <p class="text-center">{{$allProducts}}</p>
                            </div>
                        </div>
                   </div>
                   @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        async function getGifDashboard(){
           let response = await fetch('https://api.giphy.com/v1/gifs/search?api_key=VlKvvZawnlTHUfMONR2MUVtUhXpQJvW2&q=meme&limit=100&offset=0&rating=g&lang=es').catch((error)=>{console.log(error)})
           let data = await response.json()
           return data
        }

        function createCookie(name, value, days) {
          let expires = ''
          let date = ''
          if(days) {
              date = new Date();
              date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
              expires = "; expires=" + date.toGMTString();
          }else {
              expires = ""
          }
          document.cookie = name + "=" + value + expires + "; path=/"
        }

        function readCookie(name) {
            let nameCookie = name + "="
            let cookieValues = document.cookie.split(';')
            for (var i = 0; i < cookieValues.length; i++) {
                let getCookieValue = cookieValues[i]
                while (getCookieValue.charAt(0) == ' ') getCookieValue = getCookieValue.substring(1, getCookieValue.length)
                if (getCookieValue.indexOf(nameCookie) == 0) {
                    return decodeURIComponent(getCookieValue.substring(nameCookie.length, getCookieValue.length))
                }
            }
            return null;
        }

        let assingImageDashboard = document.getElementById('gif_dashboard')
        if(readCookie('GIFdashboard') === null || readCookie('GIFdashboard') === 'null'){
            getGifDashboard().then((images)=>{
                let random =  Math.floor(Math.random() * ((images.data.length - 1) - 0) + 0)
                let gifURL = images.data[random].images.original.url
                let gifSLUG =  images.data[random].title
                assingImageDashboard.innerHTML = ''
                assingImageDashboard.innerHTML = `<img src="${gifURL}" class="gif-dashboard" alt="${gifSLUG}">`
                createCookie('GIFdashboard', JSON.stringify({url: gifURL, slug: gifSLUG}), 1)
            })
        }else{
            let data = JSON.parse(readCookie('GIFdashboard'))
            assingImageDashboard.innerHTML = ''
            assingImageDashboard.innerHTML = `<img src="${data.url}" class="gif-dashboard" alt="${data.slug}">`
        }
    </script>
@stop
