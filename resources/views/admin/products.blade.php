@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1 class="m-0 text-dark">Productos</h1>
@stop

@section('content')
    <div id="status" class="status-content"></div>
    <div class="row">
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 my-2">
            <button type="click" id="button_product_item" class="btn btn-primary w-100">Agregar nuevo producto</button>
        </div>
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 my-2">
            <button type="click" id="button_product_item"class="active btn btn-primary w-100">Mostras Lista de
                productos</button>
        </div>
        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 my-2">
            <a href="/admin/exports/products" class="btn btn-primary w-100">Exportar Lista de productos</a>
        </div>
    </div>
    <div class="row hidden-content" id="product_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form method="post" id="add_product" enctype="multipart/form-data">
                <div class="card p-4 mt-4">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                <label>Codigo Producto</label>
                                <select name="" class="js-states form-control product-code-list" id="product_code"
                                    required></select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 mt-auto my-2">
                                <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal"
                                    data-bs-target="#modal_add_code">Agregar nuevo codigo</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 my-2">
                                <label>Nombre de Producto</label>
                                <input type="text" required class="form-control" id="product_name" required
                                    placeholder="Filtro para motor">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 mt-auto my-2">
                                <label>Es compatible con algun vehiculo</label>
                                <input type="checkbox" id="is_vehicule" name="is_vehicule" class="ml-2">
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 mt-auto hidden-content"
                                id="vehicule_input">
                                <label>Vehiculo Marca - Modelo</label>
                                <select name="" id="product_compatible_vehicule"
                                    class="form-control product-compatible-vehicule-list">
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->rol == 'GERENCIA')
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Cant. Disponible</label>
                                    <input type="number" required class="form-control" required id="product_quantity"
                                        name="product_quantity" placeholder="20">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Precio de Compra</label>
                                    <input type="number" class="form-control" step="0.001" required id="price_buying"
                                        name="price_buying" placeholder="30">
                                </div>
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Precio de Venta</label>
                                    <input type="number" class="form-control" step="0.001" required id="price_selling"
                                        name="price_selling" placeholder="10">
                                </div>
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Cant. Disponible</label>
                                    <input type="number" required class="form-control" required id="product_quantity"
                                        name="product_quantity" placeholder="20">
                                </div>
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Ganancia Aproximada</label>
                                    <input type="number" disabled class="form-control" required id="approximate_earnings"
                                        placeholder="20">
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Categoria</label>
                        <div class="category-checkbox-list">
                            <div class="row" id="category_checbox">

                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label>Imagen</label>
                        <input type="file" class="form-control" name="product_image" id="product_image">
                    </div> --}}
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea class="form-control" rows="3" id="product_description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cargar Producto</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row" id="product_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="mt-4">
                <div class="container-fluid table-responsive">
                    <table class="table table-striped table-responsive  " id="table_products_list">
                        <thead>
                            @if (Auth::user()->rol == 'GERENCIA')
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cant. Disponible</th>
                                    <th scope="col">Vehiculo Compatible</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Estatus</th>
                                </tr>
                            @else
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Precio de Compra</th>
                                    <th scope="col">Precio de Ventas</th>
                                    <th scope="col">Cant. Disponible</th>
                                    <th scope="col">Ganacias Aproximadas</th>
                                    <th scope="col">Vehiculo Compatible</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Editar</th>
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
    <div class="row hidden-content" id="product_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mt-4">
                <h4>Exportar Lista de Productos</h4>
            </div>
        </div>
    </div>
    <div class="row hidden-content" id="product_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mt-4">
                <h4>Importar Lista de Productos</h4>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="modal_add_code" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Agregar Nuevo Codigo</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" id="add_code">
                                <div class="form-group">
                                    <label>Escribe el Codigo</label>
                                    <input type="text" class="form-control" id="product_code_add"
                                        name="product_code_add" required placeholder="CD584AE2">
                                </div>
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                <button type="submit" class="btn btn-primary">Cargar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL EDIT PRODUCT --}}
    <div class="modal fade" id="modal_edit_product" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5">Editar Producto</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" id="edit_product">
                                <div class="form-group">
                                    <label>Nombre de producto</label>
                                    <input type="text" class="form-control" id="product_edit_name"
                                        name="product_edit_name" placeholder="CD584AE2">
                                </div>
                                <div class="form-group">
                                    <label>Precio de compra</label>
                                    <input type="number" step="0.001" class="form-control" id="product_edit_buying"
                                        name="product_edit_buying" placeholder="CD584AE2">
                                </div>
                                <div class="form-group">
                                    <label>Precio de venta</label>
                                    <input type="number" step="0.001" class="form-control" id="product_edit_selling"
                                        name="product_edit_selling" placeholder="CD584AE2">
                                </div>
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="number" class="form-control" id="product_edit_quantity"
                                        name="product_edit_quantity" placeholder="CD584AE2">
                                </div>
                                <div class="form-group">
                                    <label>Ganancias aproximadas</label>
                                    <input type="number" disabled class="form-control" id="product_edit_earnings"
                                        name="product_edit_earnings" placeholder="CD584AE2">
                                </div>
                                <input type="hidden" id="product_edit_id" value="">
                                <button type="submit" class="btn btn-primary" id="btn_edit_product_edit">Editar
                                    Producto</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{--
    <button type="button" class="btn btn-primary" >Agregar nuevo codigo</button>
    --}}

@stop

@section('js')
    <script>
        let getUserRol = "@php echo Auth::user()->rol @endphp";
        //GLOBAL VARIABLE
        let assignStatus = document.getElementById('status')

        /* ENABLE AND SECTIONS MENU */
        let getButtonList = document.querySelectorAll('#button_product_item')
        let getConent = document.querySelectorAll('#product_content')

        getButtonList.forEach((buttonItem, index) => {
            buttonItem.addEventListener('click', () => {
                if (!buttonItem.classList.contains('active')) {
                    buttonItem.classList.add('active')
                }

                if (getConent[index].classList.contains('hidden-content')) {
                    getConent[index].classList.remove('hidden-content')
                }

                if (index == 0) {
                    let checkIsVehiculeProduct = document.getElementById('is_vehicule')
                    let enableVehiculeInputs = document.querySelectorAll('#vehicule_input')
                    checkIsVehiculeProduct.addEventListener('change', (e) => {
                        if (e.target.checked == true) {
                            for (const [index, inputVehicule] of enableVehiculeInputs.entries()) {
                                if (inputVehicule.classList.contains('hidden-content')) {
                                    inputVehicule.classList.remove('hidden-content')
                                }
                            }
                            return
                        }

                        for (const [index, inputVehicule] of enableVehiculeInputs.entries()) {
                            if (!inputVehicule.classList.contains('hidden-content')) {
                                inputVehicule.classList.add('hidden-content')
                            }
                        }
                    })
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
        if (getUserRol != 'GERENCIA') {

            // ADD PRODUCT
            let getInputPriceSelling = document.getElementById('price_selling')
            let getInputPriceQuantity = document.getElementById('product_quantity')
            let getInputPriceBuying = document.getElementById('price_buying')

            getInputPriceSelling.addEventListener('input', () => {
                calculateApproximateEarnings(getInputPriceSelling, getInputPriceQuantity, getInputPriceBuying,
                    false)
            })

            getInputPriceQuantity.addEventListener('input', () => {
                calculateApproximateEarnings(getInputPriceSelling, getInputPriceQuantity, getInputPriceBuying,
                    false)
            })

            getInputPriceBuying.addEventListener('input', () => {
                calculateApproximateEarnings(getInputPriceSelling, getInputPriceQuantity, getInputPriceBuying,
                    false)
            })

        }

        //ADD CODE - IN MODAL
        let getFormAddCode = document.getElementById('add_code')
        getFormAddCode.addEventListener('submit', async (e) => {
            e.preventDefault()

            let getCode = document.getElementById('product_code_add')
            let getToken = document.getElementById('_token')

            let objCode = {
                code: getCode.value,
            }

            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(objCode)
            }

            let response = await fetch('/admin/add-code', options)
            let data = await response.json()

            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )

                $('.product-code-list').select2('destroy');

                getCodes()
                getCode.value = ''

                const getModalCode = document.querySelector('#modal_add_code')
                const modal = bootstrap.Modal.getInstance(getModalCode);
                modal.hide();

            }

            if (data.success == false) {

                Swal.fire(
                    `${data.message}`,
                    ``,
                    'error'
                )

                getCodes()
                getCode.value = ''

                const getModalCode = document.querySelector('#modal_add_code')
                const modal = bootstrap.Modal.getInstance(getModalCode);
                modal.hide();
            }

        })

        //GET CODE
        getCodes()
        async function getCodes() {
            let response = await fetch('/admin/get-codes')
            let data = await response.json()
            if (data.success == true) {
                let getInputCode = document.getElementById('product_code')
                getInputCode.innerHTML = ''
                data.codes.forEach(item => {
                    getInputCode.innerHTML += `<option value="${item.id}">${item.code}</option>`
                });
            }

            $(".product-code-list").select2({
                width: '100%'
            });
        }

        //LISTA DE VEHICULOS
        enableListVehicules()
        async function enableListVehicules() {

            if ($('.product-compatible-vehicule-list').hasClass("select2-hidden-accessible")) {
                $('.product-compatible-vehicule-list').select2('destroy')
            }

            let getInputVehicule = document.querySelector('#product_compatible_vehicule')
            Swal.fire({
                title: "Cargando Modulos..!",
                text: "",
                type: "info",
                showCancelButton: false,
                showConfirmButton: false,
            });

            let response = await fetch('/admin/get-vehicules')
            let data = await response.json()
            if (data.success == true) {
                Swal.fire(
                    'Carga Finalizada',
                    ``,
                    'success'
                )

                getInputVehicule.innerHTML = ''
                data.vehicules.forEach(vehicule => {
                    getInputVehicule.innerHTML +=
                        `<option value="${vehicule.id}">${vehicule.vehicule_brand_model} - ${vehicule.vehicule_date} - ${vehicule.vehicule_motor_lits} - ${vehicule.vehicule_motor_system} </option>`
                });

                $('.product-compatible-vehicule-list').select2({
                    width: '100%'
                });
            }
        }

        //OBTENER LISTA DE CATEGORIAS
        assignListCategoryChecbox()
        async function assignListCategoryChecbox() {
            let categoryCheckboxContent = document.getElementById('category_checbox')
            let response = await fetch('/admin/get-categories').catch((error) => {
                console.log(error)
            })
            let data = await response.json()
            if (data.success == true) {
                categoryCheckboxContent.innerHTML = ''
                data.categories.forEach((category, index) => {
                    categoryCheckboxContent.innerHTML +=
                        `<div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 my-2"><span>${category.name}</span><input type="checkbox" value="${category.id}" id="product_relation_check"></div>`
                })
            }
        }

        //ADD NEW PRODUCT
        let getFormNewProduct = document.getElementById('add_product')
        getFormNewProduct.addEventListener('submit', async (e) => {
            e.preventDefault()
            let getProductCode = document.getElementById('product_code')
            let getProductName = document.getElementById('product_name')
            let checkIsVehicule = document.getElementById('is_vehicule').checked
            let getCompatibleVehicule = ''
            let getProductPriceBuy = ''
            let getProductPriceSell = ''
            let getProductEarning = ''

            if (checkIsVehicule) {
                getCompatibleVehicule = document.getElementById('product_compatible_vehicule')
            }
            if (getUserRol != 'GERENCIA') {
                getProductPriceBuy = document.getElementById('price_buying')
                getProductPriceSell = document.getElementById('price_selling')
                getProductEarning = document.getElementById('approximate_earnings')

                if (getProductPriceBuy.value == 0 || getProductPriceSell.value == 0) {
                    Swal.fire(
                        'El producto debe tener un precio mayor a 0',
                        ``,
                        'error'
                    )
                    return
                }
            }

            let getProductQuantity = document.getElementById('product_quantity')
            let categoryByProductSelected = [];
            let getCategoriesProduct = document.querySelectorAll(
                '#category_checbox input[type="checkbox"]:checked')
            categoryByProductSelected = Array.from(getCategoriesProduct).map(category => category.value)

            if (categoryByProductSelected == '') {
                Swal.fire(
                    'El producto debe pertenecer a alguna categoria',
                    ``,
                    'error'
                )
                return
            }



            let getProductDescription = document.getElementById('product_description')

            //console.log(getProductCode.value)
            //console.log(getProductName.value)
            //console.log(getCompatibleVehicule.value)
            //console.log(getProductPriceBuy.value)
            //console.log(getProductPriceSell.value)
            //console.log(getProductQuantity.value)
            //console.log(getProductEarning.value)
            //console.log(categoryByProductSelected)
            //console.log( await convertirABase64(getFormNewProduct.product_image.files[0]))
            //console.log(getProductDescription.value)

            function convertirABase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                });
            }

            //getFormNewProduct.product_image.files[0]

            let productObj = ''
            if (getUserRol != 'GERENCIA') {
                productObj = {
                    product_code: getProductCode.value,
                    product_name: getProductName.value,
                    product_vehicule_compatible: getCompatibleVehicule.value,
                    product_price_buy: getProductPriceBuy.value,
                    product_price_sell: getProductPriceSell.value,
                    product_quantity: getProductQuantity.value,
                    product_earning: getProductEarning.value,
                    product_categories: categoryByProductSelected,
                    product_image: '',
                    product_description: getProductDescription.value
                }
            } else {
                productObj = {
                    product_code: getProductCode.value,
                    product_name: getProductName.value,
                    product_vehicule_compatible: getCompatibleVehicule.value,
                    product_price_buy: 0,
                    product_price_sell: 0,
                    product_quantity: getProductQuantity.value,
                    product_earning: 0,
                    product_categories: categoryByProductSelected,
                    product_image: '',
                    product_description: getProductDescription.value
                }
            }

            Swal.fire({
                title: "Agrego nuevo producto ..!",
                text: "",
                type: "info",
                showCancelButton: false,
                showConfirmButton: false,
            });

            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(productObj)
            }

            let response = await fetch('/admin/add-product', options)
            let data = await response.json()
            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )

                await showTableContentList()

                if (getUserRol != 'GERENCIA') {
                    getProductCode.value = ''
                    getProductName.value = ''
                    getCompatibleVehicule.value = ''
                    getProductPriceBuy.value = ''
                    getProductPriceSell.value = ''
                    getProductQuantity.value = ''
                    getProductEarning.value = '0'
                    getProductDescription.value = ''
                } else {
                    getProductCode.value = ''
                    getProductName.value = ''
                    getCompatibleVehicule.value = ''
                    getProductQuantity.value = ''
                    getProductDescription.value = ''
                }
            }


        })


        //TABLE LIST
        showTableContentList()
        async function showTableContentList() {
            if ($.fn.DataTable.isDataTable('#table_products_list')) {
                $('#table_products_list').DataTable().destroy();
            }

            let addTableContent = document.getElementById('content_table_list')
            let response = await fetch('/admin/get-products').catch((error) => {
                console.log(error)
            })
            let data = await response.json()
            console.log(data)
            if (data.success == true) {
                addTableContent.innerHTML = ''
                data.products.forEach((product, index) => {
                    if (getUserRol != 'GERENCIA') {
                        addTableContent.innerHTML += `
                <tr>
                    <th scope="row">${(index + 1)}</th>
                    <th>${product.code}</th>
                    <td>${product.name}</td>
                    <td>${product.product_category_compatibility}</td>
                    <td>${product.product_buying}</td>
                    <td>${product.product_selling}</td>
                    <td>${product.product_quantity}</td>
                    <td>${product.product_earnings}</td>
                    <td>${product.product_vehicule_compability}</td>
                    <td>--</td>
                    <td>${product.status}</td>
                    <td><button class="btn btn-primary w-20" value="${product.id}" id="btn_edit_product"  data-bs-toggle="modal" data-bs-target="#modal_edit_product">editar</button></td>
                    <td><button class="btn btn-danger w-20" id="btn_delete_product" value="${product.id}">eliminar</button></td>
                </tr>`


                    } else {
                        addTableContent.innerHTML += `
                <tr>
                    <th scope="row">${(index + 1)}</th>
                    <th>${product.code}</th>
                    <td>${product.name}</td>
                    <td>${product.product_category_compatibility}</td>
                    <td>${product.product_selling}</td>
                    <td>${product.product_quantity}</td>
                    <td>${product.product_vehicule_compability}</td>
                    <td>--</td>
                    <td>${product.status}</td>
                </tr>`
                    }
                });

                $("#table_products_list").DataTable({
                    drawCallback: function(settings) {
                        searchAllBtnEditProduct()
                        searchAllBtnDeleteProduct()
                    },
                });

            }
        }

        //ASIGNAR TODOS LOS BOTONES PARA ELIMINAR PRODUCTOS
        function searchAllBtnDeleteProduct() {
            let getButtonsDelete = document.querySelectorAll('#btn_delete_product')
            getButtonsDelete.forEach(buttonDelete => {
                buttonDelete.addEventListener('click', async () => {
                    Swal.fire({
                        title: "Eliminando producto..!",
                        text: "",
                        type: "info",
                        showCancelButton: false,
                        showConfirmButton: false,
                    });

                    let options = {
                        method: "DELETE",
                        mode: "cors",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')[
                                'content'],
                            'Content-Type': 'application/json'
                        },
                    }
                    let response = await fetch(`/admin/delete-product/${buttonDelete.value}`, options)
                        .catch((error) => {
                            console.log(error)
                        })
                    let data = await response.json()
                    if (data.success == true) {
                        await showTableContentList()

                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'success'
                        )


                    }
                })
            });
        }
        //ASIGNAR TODOS LOS BOTONES PARA EDITAR PRODUCTOS
        function searchAllBtnEditProduct() {
            let getButtons = document.querySelectorAll('#btn_edit_product')
            getButtons.forEach(buttonEdit => {
                buttonEdit.addEventListener('click', async () => {
                    let getProductID = buttonEdit.value
                    let setEditName = document.getElementById('product_edit_name')
                    let setEditProductBuy = document.getElementById('product_edit_buying')
                    let setEditProductSell = document.getElementById('product_edit_selling')
                    let setEditProductQuantity = document.getElementById('product_edit_quantity')
                    let setEditProductEarning = document.getElementById('product_edit_earnings')
                    let setEditProductID = document.getElementById('product_edit_id')

                    await editProductTemplate(getProductID, setEditName, setEditProductBuy,
                        setEditProductSell, setEditProductQuantity, setEditProductEarning,
                        setEditProductID).then(() => {

                        setEditProductSell.addEventListener('input', () => {
                            calculateApproximateEarnings(setEditProductSell,
                                setEditProductQuantity, setEditProductBuy, true)
                        })

                        setEditProductQuantity.addEventListener('input', () => {
                            calculateApproximateEarnings(setEditProductSell,
                                setEditProductQuantity, setEditProductBuy, true)
                        })

                        setEditProductBuy.addEventListener('input', () => {
                            calculateApproximateEarnings(setEditProductSell,
                                setEditProductQuantity, setEditProductBuy, true)
                        })
                    })
                })
            });
        }
        //AGREGAR VALORES A MODAL PARA EDITAR VALOR
        async function editProductTemplate(productID, editName, editProductBuy, editProductSell, editProductQuantity,
            editProductEarning, editProductID) {
            let response = await fetch(`/admin/find-product/${productID}`)
            let data = await response.json()
            if (data.success == true) {
                editName.value = data.products[0].product_name
                editProductBuy.value = data.products[0].product_buying
                editProductSell.value = data.products[0].product_selling
                editProductQuantity.value = data.products[0].product_quantity
                editProductEarning.value = data.products[0].product_earnings
                editProductID.value = data.products[0].id
            }
        }


        //SUBMIT EDITAR PRODUCTO
        let getBtnProductEdit = document.getElementById('btn_edit_product_edit')
        let productObj = ''
        getBtnProductEdit.addEventListener('click', async (e) => {
            e.preventDefault()

            let getFormProductEdit = document.forms.namedItem('edit_product')

            productObj = {
                product_code: getFormProductEdit.elements.namedItem('product_edit_id').value,
                product_edit_name: getFormProductEdit.elements.namedItem('product_edit_name').value,
                product_edit_price_buy: getFormProductEdit.elements.namedItem('product_edit_buying').value,
                product_edit_price_sell: getFormProductEdit.elements.namedItem('product_edit_selling')
                    .value,
                product_edit_quantity: getFormProductEdit.elements.namedItem('product_edit_quantity').value,
                product_edit_earnings: getFormProductEdit.elements.namedItem('product_edit_earnings').value,
            }

            await editProductSubmit(productObj).then(async (data) => {
                if (data.success == true) {

                    await showTableContentList()

                    setTimeout(() => {
                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'success'
                        )
                        const getModalEditProduct = document.querySelector(
                            '#modal_edit_product')
                        const modalEditProduct = bootstrap.Modal.getInstance(
                            getModalEditProduct);
                        modalEditProduct.hide();

                    }, 2000);
                }
            })
        })


        async function editProductSubmit(obj) {
            Swal.fire({
                title: "Editando producto..!",
                text: "",
                type: "info",
                showCancelButton: false,
                showConfirmButton: false,
            });
            let options = {
                method: "PUT",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            }
            let response = await fetch(`/admin/edit-product/`, options).catch((error) => {
                console.log(error)
            })
            let data = await response.json()
            return data
        }

        function calculateApproximateEarnings(sellPrice, quantity, buyPrice, edit) {
            let sellProductTotal = sellPrice.value * quantity.value
            let buyingProductTotal = buyPrice.value * quantity.value
            if (edit == false) {
                let setPriceApproximate = document.getElementById('approximate_earnings')
                setPriceApproximate.value = sellProductTotal - buyingProductTotal
            } else {
                let setEditProductEarning = document.getElementById('product_edit_earnings')
                setEditProductEarning.value = sellProductTotal - buyingProductTotal
            }
        }
    </script>
@stop
