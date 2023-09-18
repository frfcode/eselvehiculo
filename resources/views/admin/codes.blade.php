@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1 class="m-0 text-dark">Codigos</h1>
@stop

@section('content')
    <div id="status" class="status-content"></div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 my-2">
            <button type="click" id="button_code_item" class="btn btn-primary w-100">Agregar nuevo Codigo</button>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 my-2">
            <button type="click" id="button_code_item" class="active btn btn-primary w-100">Lista de Codigos</button>
        </div>
    </div>
    <div class="row mt-4 hidden-content" id="code_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form method="post" id="add_code">
                <div class="card p-4">
                    <div class="form-group">
                        <label>Codigo</label>
                        <input type="text" class="form-control" name="code_name" id="code_name" required
                            placeholder="INCA ATF3">
                    </div>
                    <button type="submit" class="btn btn-primary">Cargar</button>
                </div>
            </form>
        </div>
    </div>
    {{-- LISTA DE CATEGORIA --}}
    <div class="row" id="code_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="mt-4">
                <div class="container-fluid table-responsive">
                    <table class="table text-center table-striped " id="table_codes_list">
                        <thead>
                            @if (Auth::user()->rol == 'GERENCIA')
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
    </div>
@stop

@section('js')
    <script>
        let getUserRol = "@php echo Auth::user()->rol @endphp";
        let getButtonList = document.querySelectorAll('#button_code_item')
        let getConent = document.querySelectorAll('#code_content')

        getButtonList.forEach((buttonItem, index) => {
            buttonItem.addEventListener('click', () => {
                if (!buttonItem.classList.contains('active')) {
                    buttonItem.classList.add('active')
                }

                if (getConent[index].classList.contains('hidden-content')) {
                    getConent[index].classList.remove('hidden-content')
                }

                disableOtherButton(getButtonList, index)
            })

            function disableOtherButton(buttonList, buttonIndex) {
                buttonList.forEach((element, index) => {
                    if (index != buttonIndex) {
                        if (buttonList[index].classList.contains('active')) {
                            buttonList[index].classList.remove('active')
                            getConent[index].classList.add('hidden-content')
                        }
                    }
                });
            }
        });


        let assignStatus = document.getElementById('status')
        let getFormAddCode = document.getElementById('add_code')
        getFormAddCode.addEventListener('submit', async (e) => {
            e.preventDefault()

            let getCodeName = document.getElementById('code_name')

            let objCategory = {
                code: getCodeName.value.toUpperCase(),
            }

            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(objCategory)
            }

            let response = await fetch('/admin/add-code', options)
            let data = await response.json()

            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )

                showTableContentList()

                getCodeName.value = ''
            } else {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'error'
                )
            }

        })

        //MOSTRAR LISTA
        showTableContentList()

        async function showTableContentList() {


            if ($.fn.DataTable.isDataTable('#table_codes_list')) {
                $('#table_codes_list').DataTable().destroy();
            }
            let addTableContent = document.getElementById('content_table_list')
            let response = await fetch('/admin/get-codes').catch((error) => {
                console.log(error)
            })
            let data = await response.json()
            if (data.success == true) {
                addTableContent.innerHTML = ''
                data.codes.forEach((getCode, index) => {
                    if (getUserRol == 'GERENCIA') {
                        addTableContent.innerHTML += `
                    <tr>
                        <th scope="row">${(index + 1)}</th>
                        <th>${getCode.code}</th>
                    </tr>
                    `
                    } else {
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

            $("#table_codes_list").DataTable({
                drawCallback: function(settings) {
                    deleteCode()
                },
            });

            //ELIMINAR CLIENTE
        }


        function deleteCode() {
            let getButtonsDelete = document.querySelectorAll('#btn_delete_code')
            getButtonsDelete.forEach(buttonDelete => {
                buttonDelete.addEventListener('click', async () => {
                    let options = {
                        method: "DELETE",
                        mode: "cors",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')[
                                'content'],
                            'Content-Type': 'application/json'
                        },
                    }
                    let response = await fetch(`/admin/delete-code/${buttonDelete.value}`, options)
                        .catch((error) => {
                            console.log(error)
                        })
                    let data = await response.json()
                    if (data.success == true) {
                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'success'
                        )

                        await showTableContentList()
                    } else {
                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'error'
                        )
                    }
                })
            });
        }
    </script>
@stop
