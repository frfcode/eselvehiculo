@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1 class="m-0 text-dark">Clientes</h1>
@stop

@section('content')
    {{--  MOSTRAT STATUS --}}
    <div id="status" class="status-content"></div>

    {{-- BOTONES --}}
    <div class="row">
        <div class="col-4">
            <button type="click" id="button_client_item" class="btn btn-primary w-100">Agregar nuevo cliente</button>
        </div>
        <div class="col-4">
            <button type="click" id="button_client_item" class="active btn btn-primary w-100">Lista de Clientes</button>
        </div>
        @if(Auth::user()->rol != 'GERENCIA')
        <div class="col-4">
            <a href="/admin/exports/clients" class="btn btn-primary w-100">Exportar Lista de Clientes</a>
        </div>
        @endif
    </div>

    {{-- FORMULARIO DE REGISTRO --}}
    <div class="row hidden-content" id="client_content">
        <div class="col-12">
            <form method="POST" id="add_client">
                <div class="card p-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de client</label>
                        <input type="text" class="form-control" id="client_name" required name="client_name" placeholder="Juan Pablo Duarte">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Tipo de Persona</label>
                        <select name="type_client" id="type_client" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="NATURAL">Natural</option>
                            <option value="JURIDICA">Juridica</option>
                            <option value="GUBERNAMENTAL">Gubernamental</option>
                            <option value="EXTRAJERO">Extranjero / Extranjera</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Cedula o DNI</label>
                        <input type="number" class="form-control" id="client_dni" required name="client_dni" placeholder="24436494">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input type="number" class="form-control" id="client_phone" name="client_phone" placeholder="+584125487861">
                    </div>
                    {{-- <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" /> --}}
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- LISTA DE CLIENTES --}}
    <div class="row" id="client_content">
        <div class="col-12">
            <div class="card mt-4">
                <table class="table text-center">
                    <thead>
                        @if(Auth::user()->rol != 'GERENCIA')
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cedula</th>
                        <th scope="col">Tipo de Persona</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Editar</th>
                        <th scope="col">Eliminar</th>
                      </tr>
                      @else
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cliente ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cedula</th>
                        <th scope="col">Tipo de Persona</th>
                        <th scope="col">Telefono</th>
                      </tr>
                      @endif
                    </thead>
                    <tbody id="content_table_list">
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    <script>
         let getUserRol = "@php echo Auth::user()->rol @endphp";
        let getButtonList = document.querySelectorAll('#button_client_item')
        let getConent = document.querySelectorAll('#client_content')

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
        })
        //ADD CLIENT
        let getFormClient = document.querySelector('#add_client')
         let assignStatus = document.getElementById('status')
         getFormClient.addEventListener('submit', async (e)=>{
            e.preventDefault();

            let getClientName = document.getElementById('client_name')
            let getClientType = document.getElementById('type_client')
            let getClientDNI = document.getElementById('client_dni')
            let getClientPhone = document.getElementById('client_phone')


            let objClient = {
                client_name: getClientName.value,
                type_client: getClientType.value,
                client_dni: getClientDNI.value,
                client_phone: getClientPhone.value
            }

            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(objClient)
            }

            let response = await fetch('/admin/add-client', options).catch((error)=>{console.log(error)})
            let data = await response.json()

            if(data.success == true){
                assignStatus.innerHTML = ''
                assignStatus.innerHTML = `<span class="p-2 bg-success" >
                    ${data.message}
                </span>`
                timeHoverStatus()
                showTableContentList()

                getClientName.value = ''
                getClientType.value = ''
                getClientDNI.value = ''
                getClientPhone.value = ''
            }
        })

         //MOSTRAR LISTA
        showTableContentList()

        async function showTableContentList(){
           let addTableContent = document.getElementById('content_table_list')
           let response = await fetch('/admin/get-clients').catch((error)=>{console.log(error)})
           let data = await response.json()
           if(data.success == true){
            addTableContent.innerHTML = ''
            data.clients.forEach((client, index) => {
                if(getUserRol != 'GERENCIA'){
                    addTableContent.innerHTML += `
                <tr>
                    <th scope="row">${(index + 1)}</th>
                    <th>${client.id}</th>
                    <td>${client.name}</td>
                    <td>${client.dni}</td>
                    <td>${client.person_type}</td>
                    <td>${client.phone_number}</td>
                    <td><button class="btn btn-primary w-20" value="${client.id}">editar</button></td>
                    <td><button class="btn btn-danger w-20" id="btn_delete_client" value="${client.id}">eliminar</button></td>
                </tr>
                `
                }else{
                    addTableContent.innerHTML += `
                    <tr>
                        <th scope="row">${(index + 1)}</th>
                        <th>${client.id}</th>
                        <td>${client.name}</td>
                        <td>${client.dni}</td>
                        <td>${client.person_type}</td>
                        <td>${client.phone_number}</td>
                    </tr>
                    `
                }

            });
           }

           //ELIMINAR CLIENTE
           let getButtonsDelete = document.querySelectorAll('#btn_delete_client')
           getButtonsDelete.forEach(buttonDelete => {
                buttonDelete.addEventListener('click', async ()=>{
                    let options = {
                        method: "DELETE",
                        mode: "cors",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                            'Content-Type': 'application/json'
                        },
                    }
                    let response = await fetch(`/admin/delete-client/${buttonDelete.value}`, options).catch((error)=>{console.log(error)})
                    let data = await response.json()
                    if(data.success == true){
                        assignStatus.innerHTML = ''
                        assignStatus.innerHTML = `<span class="p-2 bg-success" >
                            ${data.message}
                        </span>`

                        timeHoverStatus()

                        showTableContentList()
                    }
                })
           });
        }

        function timeHoverStatus(){
            setTimeout(() => {
                assignStatus.innerHTML = ''
            }, 7000);
         }
    </script>
@stop
