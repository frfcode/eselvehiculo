@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1 class="m-0 text-dark">Categorias</h1>
@stop

@section('content')
    <div id="status" class="status-content"></div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 my-2">
            <button type="click" id="button_category_item" class="btn btn-primary w-100">Agregar nueva categoria</button>
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 my-2">
            <button type="click" id="button_category_item" class="active btn btn-primary w-100">Lista de
                Categorias</button>
        </div>
    </div>
    <div class="row mt-4 hidden-content" id="category_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form method="post" id="add_categories">
                <div class="card p-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de Categoria</label>
                        <input type="text" class="form-control" name="category_name" id="category_name" required
                            placeholder="Filtro de Aceite">
                    </div>
                    <button type="submit" class="btn btn-primary">Cargar</button>
                </div>
            </form>
        </div>
    </div>
    {{-- LISTA DE CATEGORIA --}}
    <div class="row" id="category_content">
        @if (Auth::user()->rol != 'GERENCIA')
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-3 my-2">
                <button type="button" class="btn btn-primary btn-block" id="btn_config_save_menu">Guardar configuracion de
                    menu</button>
            </div>
        @endif
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="mt-2">
                <div class="container-fluid table-responsive">
                    <table class="table table-striped text-center" id="table_category_list">
                        <thead>
                            @if (Auth::user()->rol == 'GERENCIA')
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Categori</th>
                                    <th scope="col">Slug</th>
                                </tr>
                            @else
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Categori</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Eliminar</th>
                                    <th scope="col">Habilitar en Menu</th>
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
        let getUserRol = "{{ Auth::user()->rol }}";

        let getButtonList = document.querySelectorAll('#button_category_item')
        let getConent = document.querySelectorAll('#category_content')

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

        //SAVE CHANGES OF CATEGORY
        let assignStatus = document.getElementById('status')
        let getFormAddCode = document.getElementById('add_categories')
        getFormAddCode.addEventListener('submit', async (e) => {
            e.preventDefault()

            let getCategory = document.getElementById('category_name')

            let objCategory = {
                category_name: getCategory.value.toLowerCase(),
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

            let response = await fetch('/admin/add-category', options)
            let data = await response.json()

            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )
                showTableContentList()


                getCategory.value = ''
            }

        })

        //SHOW CATEGORY LIST
        showTableContentList()

        async function showTableContentList() {

            if ($.fn.DataTable.isDataTable('#table_products_list')) {
                $('#table_products_list').DataTable().destroy();
            }

            let addTableContent = document.getElementById('content_table_list')
            let response = await fetch('/admin/get-categories').catch((error) => {
                console.log(error)
            })
            let data = await response.json()
            if (data.success == true) {
                addTableContent.innerHTML = ''
                data.categories.forEach((category, index) => {
                    if (getUserRol == 'GERENCIA') {
                        if (category.check == false) {
                            addTableContent.innerHTML += `
                        <tr>
                            <th scope="row">${(index + 1)}</th>
                            <th>${category.name}</th>
                            <td>${category.name.replaceAll(' ', '-')}</td>
                        </tr>
                        `
                        } else {
                            addTableContent.innerHTML += `
                        <tr>
                            <th scope="row">${(index + 1)}</th>
                            <th>${category.name}</th>
                            <td>${category.name.replaceAll(' ', '-')}</td>
                        </tr>
                        `
                        }
                    } else {
                        if (category.check == false) {
                            addTableContent.innerHTML += `
                        <tr>
                            <th scope="row">${(index + 1)}</th>
                            <th>${category.name}</th>
                            <td>${category.name.replaceAll(' ', '-')}</td>
                            <td><button class="btn btn-danger w-20" id="btn_delete_category" value="${category.id}">eliminar</button></td>
                            <td><input type="checkbox"  name="" id="enable_category_menu" value="${category.name}"></td>
                        </tr>
                        `
                        } else {
                            addTableContent.innerHTML += `
                        <tr>
                            <th scope="row">${(index + 1)}</th>
                            <th>${category.name}</th>
                            <td>${category.name.replaceAll(' ', '-')}</td>
                            <td><button class="btn btn-danger w-20" id="btn_delete_category" value="${category.id}">eliminar</button></td>
                            <td><input type="checkbox" checked  name="" id="enable_category_menu" value="${category.name}"></td>
                        </tr>
                        `
                        }
                    }
                });

                $("#table_category_list").DataTable({
                    drawCallback: function(settings) {
                        deleteCategory()
                    },
                });
            }

            //DELETE CATEGORY
            function deleteCategory() {
                let getButtonsDelete = document.querySelectorAll('#btn_delete_category')
                getButtonsDelete.forEach(buttonDelete => {
                    buttonDelete.addEventListener('click', async () => {
                        let options = {
                            method: "DELETE",
                            mode: "cors",
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')[
                                    'content'],
                                'Content-Type': 'application/json'
                            },
                        }
                        let response = await fetch(`/admin/delete-category/${buttonDelete.value}`,
                            options).catch((error) => {
                            console.log(error)
                        })
                        let data = await response.json()
                        if (data.success == true) {
                            Swal.fire(
                                `${data.message}`,
                                ``,
                                'success'
                            )
                            showTableContentList()
                        }
                    })
                });
            }
        }

        // SAVE CONFIG OF THE CATEGORYS
        let getButtonMenuSave = document.getElementById('btn_config_save_menu')
        getButtonMenuSave.addEventListener('click', async () => {
            let getCategoryInputs = document.querySelectorAll('#enable_category_menu')
            let menuItemsEnable = []
            for (const [index, category] of getCategoryInputs.entries()) {
                if (category.checked == true) {
                    menuItemsEnable.push({
                        name: category.value
                    })
                }
            }
            console.log(JSON.stringify({
                menu_items: menuItemsEnable
            }))
            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    menu_items: menuItemsEnable
                })
            }

            let response = await fetch('/admin/save-config-menu', options)
            let data = await response.json()
            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )

            }
        })
    </script>
@stop
