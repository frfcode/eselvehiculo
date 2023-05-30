@extends('adminlte::page')

@section('title', 'Historial de Ventas')

@section('content_header')
    <h1 class="m-0 text-dark">Historial de Ventas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-4">
            <button type="click" id="button_history_item" class="active btn btn-primary w-100">Lista de Ventas de hoy</button>
        </div>
        <div class="col-4">
            <button type="click" id="button_history_item" class="btn btn-primary w-100">Lista de Ventas Semanales</button>
        </div>
        <div class="col-4">
            <button type="click" id="button_history_item" class="btn btn-primary w-100">Lista de Ventas Mensaules</button>
        </div>
    </div>
    <div class="row" id="history_content">
        <div class="col-12">
            <div class="card mt-4">
                <div class="col-12">
                    <h3>Ventas De Hoy</h3>
                </div>
                <div class="col-12 mt-2 mb-2">
                    <button type="button" class="btn btn-success">Exprotar Lista</button>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Categorias</th>
                        <th scope="col">Precio de Compra</th>
                        <th scope="col">Precio de Ventas</th>
                        <th scope="col">Cant. Disponible</th>
                        <th scope="col">Ganacias Aproximadas</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="row hidden-content" id="history_content">
        <div class="col-12">
            <div class="card mt-4">
                <div class="col-12">
                    <h3>Ventas Semanales</h3>
                </div>
                <div class="col-12 mt-2 mb-2">
                    <button type="button" class="btn btn-success">Exprotar Lista</button>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Categorias</th>
                        <th scope="col">Precio de Compra</th>
                        <th scope="col">Precio de Ventas</th>
                        <th scope="col">Cant. Disponible</th>
                        <th scope="col">Ganacias Aproximadas</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="row hidden-content" id="history_content">
        <div class="col-12">
            <div class="card mt-4">
                <div class="col-12">
                    <h3>Ventas Mensaules</h3>
                </div>
                <div class="col-12 mt-2 mb-2">
                    <button type="button" class="btn btn-success">Exprotar Lista</button>
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Categorias</th>
                        <th scope="col">Precio de Compra</th>
                        <th scope="col">Precio de Ventas</th>
                        <th scope="col">Cant. Disponible</th>
                        <th scope="col">Ganacias Aproximadas</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td>Mark</td>
                        <td><button class="btn btn-primary w-20">editar</button></td>
                        <td><button class="btn btn-danger w-20">eliminar</button></td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="row hidden-content" id="client_content">
        <div class="col-12">
            <div class="card mt-4">
                <h4>Exportar Lista de Clientes</h4>
            </div>
        </div>
    </div>

    <script>
        let getButtonList = document.querySelectorAll('#button_history_item')
        let getConent = document.querySelectorAll('#history_content')
    
    getButtonList.forEach((buttonItem, index) => {
        buttonItem.addEventListener('click',()=>{
            if(!buttonItem.classList.contains('active')){
                buttonItem.classList.add('active')
            }

            if(getConent[index].classList.contains('hidden-content')){
                getConent[index].classList.remove('hidden-content')
            }
            
            disableOtherButton(getButtonList, index)
        })

         function disableOtherButton(buttonList, buttonIndex){
             buttonList.forEach((element, index) => {
                 if(index != buttonIndex){
                    if(buttonList[index].classList.contains('active')){
                         buttonList[index].classList.remove('active')
                         getConent[index].classList.add('hidden-content')
                    }
                 }
             });
         }
    });
    </script>
@stop