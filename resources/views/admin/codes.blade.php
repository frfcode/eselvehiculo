@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1 class="m-0 text-dark">Codigos</h1>
@stop

@section('content')
    <div id="status" class="status-content"></div>
    <div class="row">
        <div class="col-4">
            <button type="click" id="button_code_item" class="btn btn-primary w-100">Agregar nuevo Codigo</button>
        </div>
        <div class="col-4">
            <button type="click" id="button_code_item" class="active btn btn-primary w-100">Lista de Codigos</button>
        </div>
    </div>
    <div class="row mt-4 hidden-content" id="code_content">
        <div class="col-12">
            <form method="post" id="add_code">
                <div class="card p-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Codigo</label>
                        <input type="text" class="form-control" name="code_name" id="code_name" required placeholder="INCA ATF3">
                    </div>
                    <button type="submit" class="btn btn-primary">Cargar</button>
                </div>
            </form>
        </div>
    </div>
    {{-- LISTA DE CATEGORIA --}}
    <div class="row" id="code_content">
        <div class="col-12">
            <div class="card mt-4">
                <table class="table text-center">
                    <thead>
                        @if(Auth::user()->rol == 'GERENCIA')
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                        </tr>
                        @else
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Eliminar</th>
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
    let getButtonList = document.querySelectorAll('#button_code_item')
    let getConent = document.querySelectorAll('#code_content')

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


    let assignStatus = document.getElementById('status')
    let getFormAddCode = document.getElementById('add_code')
    getFormAddCode.addEventListener('submit', async (e)=>{
        e.preventDefault()

        let getCodeName = document.getElementById('code_name')

        let objCategory = {
            code: getCodeName.value.toUpperCase(),
        }

        let options = {
            method: "POST",
            mode: "cors",
            headers: {
                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]')['content'],
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(objCategory)
        }

        let response = await fetch('/admin/add-code', options)
        let data = await response.json()

        if(data.success == true){
            assignStatus.innerHTML = ''
            assignStatus.innerHTML = `<span class="p-2 bg-success" >
                ${data.message}
            </span>`
            showTableContentList()
            timeHoverStatus()

            getCategory.value = ''
        }

        if(data.success == false){
            assignStatus.innerHTML = ''
            assignStatus.innerHTML = `<span class="p-2 bg-danger" >
                ${data.message}
            </span>`
            showTableContentList()
            timeHoverStatus()

            getCategory.value = ''
        }

    })

         //MOSTRAR LISTA
        showTableContentList()

        async function showTableContentList(){
           let addTableContent = document.getElementById('content_table_list')
           let response = await fetch('/admin/get-codes').catch((error)=>{console.log(error)})
           let data = await response.json()
           if(data.success == true){
            addTableContent.innerHTML = ''
            data.codes.forEach((getCode, index) => {
                if(getUserRol == 'GERENCIA'){
                    addTableContent.innerHTML += `
                    <tr>
                        <th scope="row">${(index + 1)}</th>
                        <th>${getCode.code}</th>
                    </tr>
                    `
                }else{
                    addTableContent.innerHTML += `
                    <tr>
                        <th scope="row">${(index + 1)}</th>
                        <th>${getCode.code}</th>
                        <td><button class="btn btn-danger w-20" id="btn_delete_code" value="${getCode.id}">eliminar</button></td>
                    </tr>
                    `
                }
            });
           }

           //ELIMINAR CLIENTE
           let getButtonsDelete = document.querySelectorAll('#btn_delete_code')
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
                    let response = await fetch(`/admin/delete-code/${buttonDelete.value}`, options).catch((error)=>{console.log(error)})
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
