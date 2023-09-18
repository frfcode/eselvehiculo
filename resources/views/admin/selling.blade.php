@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1 class="m-0 text-dark">Ventas</h1>
@stop

@section('content')
    <div id="status" class="status-content"></div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 my-2">
            <button type="click" id="button_selling_item" class="btn btn-primary w-100">Registrar nueva venta</button>
        </div>

        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 my-2">
            <button type="click" id="button_selling_item" class="active btn btn-primary w-100">Lista de Ventas de
                hoy</button>
        </div>
        @if (Auth::user()->rol != 'GERENCIA')
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 my-2">
                <button type="click" id="button_selling_item" class="btn btn-primary w-100">Lista de Todas las Ventas
                </button>
            </div>
            {{-- <div class="col-3">
        <button type="click" id="button_selling_item" class="btn btn-primary w-100">Lista de Ventas Mensaules</button>
    </div> --}}
        @endif
    </div>
    {{-- SELLING BY PRODUCT --}}
    <div class="row hidden-content" id="selling_content">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mt-4">
                <form method="post" id="add_selling">
                    <input type="text" hidden value="{{ Auth::user()->name }}" id="vendor_name">
                    <div class="card p-4">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row border-bottom border-dark border-4">
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-2">
                                        <p class="title-facture text-center">Factura N°</p>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-2">
                                        <input type="number" readonly name="facture_number" id="facture_number"
                                            class="form-control text-center w-20" value="{{ $factureID + 1 }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                    <label>Cliente</label>
                                    <select name="client_name" id="client_name" class="form-control client-list">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-2 mt-auto my-2">
                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#modal_add_client">Agregar nuevo cliente</button>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 mt-auto my-2">
                                    <label>Facturar sin IVA</label>
                                    <input type="checkbox" class="ml-2" id="check_iva_product">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 position-relative my-2">
                                    <label class="d-block">Agregar Producto</label>
                                    {{--  <input type="text" class="form-control" id="search_product" name="search_product"
                                        placeholder="Filtro para motor"> --}}
                                    {{-- <div id="results" class="results-box"></div> --}}
                                    <select name="" class="form-control product-list-items"
                                        id="product_get_list"></select>
                                    {{--  <span class="text-bold text-danger mt-1">Nota: los productos deben ser buscarlo solo por
                                        el nombre</span> --}}
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 my-2">
                                    <label>Cant. de Venta</label>
                                    <input type="number" class="form-control" id="product_quantity" name="product_quantity"
                                        placeholder="20">
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 mt-auto my-2">
                                    <button type="button" class="btn btn-primary btn-block"
                                        id="add_item_product">Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="selling_product_list">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="container-fluid table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Codigo</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Cant.</th>
                                                <th scope="col">Monto</th>
                                                <th scope="col">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="prodcut_seeling_list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border-top border-dark border-4">
                                <h3 class="text-right" id="iva_product_cost">IVA: 0</h3>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  border-bottom border-dark border-4">
                                <h3 class="text-right" id="total_product_cost">Total: 0</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 mt-4">
                                <button type="submit" class="btn btn-primary w-100">Generar Factura</button>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 mt-4">
                                <a href="#" class="btn btn-primary w-100" id="btn_generate_Facture">Mostar
                                    Recibo</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- SELLING LIST BY DAY --}}
    <div class="row" id="selling_content">
        <div class="col-12">
            <div class="mt-4">
                <div class="container-fluid table-responsive">
                    <table class="table table-striped" id="table_sales_today">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">N° Factura</th>
                                <th scope="col">Precio Total</th>
                                <th scope="col">Fecha Factura</th>
                                <th scope="col">Revisar</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="sales_today"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->rol != 'GERENCIA')
        <div class="row hidden-content" id="selling_content">
            <div class="col-12">
                <div class="mt-4">
                    <div class="container-fluid table-responsive">
                        <table class="table table-striped" id="table_sales_month">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">N° Factura</th>
                                    <th scope="col">Precio Total</th>
                                    <th scope="col">Fecha Factura</th>
                                    <th scope="col">Revisar</th>
                                </tr>
                            </thead>
                            <tbody id="sales_weekly">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- SELLING LIST BY MONTH --}}
        <div class="row hidden-content" id="selling_content">
            <div class="col-12">
                <div class="mt-4">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                        <h3>Ventas Mensaules</h3>
                    </div>
                    <div class="container-fluid table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">N° Factura</th>
                                    <th scope="col">Precio Total</th>
                                    <th scope="col">Fecha Factura</th>
                                    <th scope="col">Revisar</th>
                                </tr>
                            </thead>
                            <tbody id="sales_monthly">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- ADD NEW CLIENT --}}
    {{-- MODAL --}}
    <div class="modal fade" id="modal_add_client" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Agregar Nuevo Cliente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_client">
                        <div class="">
                            <div class="form-group">
                                <label>Nombre de client</label>
                                <input type="text" class="form-control" id="client_modal_name"
                                    name="client_modal_name" placeholder="Juan Pablo Duarte">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tipo de Persona</label>
                                <select name="type_modal_client" id="type_modal_client" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="NATURAL">Natural</option>
                                    <option value="JURIDICA">Juridica</option>
                                    <option value="GUBERNAMENTAL">Gubernamental</option>
                                    <option value="EXTRAJERO">Extranjero / Extranjera</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cedula o DNI</label>
                                <input type="text" class="form-control" id="client_modal_dni" name="client_modal_dni"
                                    placeholder="V-24436494">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Telefono</label>
                                <input type="number" class="form-control" id="client_modal_phone"
                                    name="client_modal_phone" placeholder="+584125487861">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        let getButtonList = document.querySelectorAll('#button_selling_item')
        let getConent = document.querySelectorAll('#selling_content')

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



        let getInputSearchProduct = document.getElementById('product_get_list')
        let resultsSearch = document.getElementById("results");


        //ADD PRODUCT TO TABLE
        let getTableSelling = document.getElementById('prodcut_seeling_list')
        let buttonAddProductItem = document.getElementById('add_item_product')
        let products = []
        let getTotalPrice = document.getElementById('total_product_cost')
        let checkEnableIVA = document.getElementById('check_iva_product')
        let getIVA = document.getElementById('iva_product_cost')

        buttonAddProductItem.addEventListener('click', (e) => {
            e.preventDefault();
            let getProductQuantity = document.getElementById('product_quantity')

            if (getProductQuantity.value == null || getProductQuantity.value == '') {
                Swal.fire(
                    'Agrege precio al producto, por favor',
                    ``,
                    'error'
                )
                return
            }

            if (getInputSearchProduct.value == '') {
                Swal.fire(
                    'Agrege un producto, por favor',
                    ``,
                    'error'
                )

                return
            }

            let getQuantityProduct = getInputSearchProduct.value.split('|')[1].split(':')[1].replace(' unidades',
                '')
            let getCode = getInputSearchProduct.value.split('|')[0].split('-')[1]
            let getProductName = getInputSearchProduct.value.split('|')[0].split('-')[0]
            let getPrice = getInputSearchProduct.value.split('|')[2].split(':')[1].trim()

            if (getProductQuantity.value > parseInt(getQuantityProduct.trim())) {
                Swal.fire(
                    'Producto excede la cantidad disponible',
                    ``,
                    'error'
                )

                return
            }


            products.push({
                code: getCode,
                product: getProductName,
                quantity: getProductQuantity.value,
                price: getPrice,
                maxQuantity: getQuantityProduct
            })

            if (sessionStorage.getItem("products") != null) {
                let getOldProducts = JSON.parse(sessionStorage.getItem("products"))
                console.log(getOldProducts)
                getOldProducts.push({
                    code: getCode,
                    product: getProductName,
                    quantity: getProductQuantity.value,
                    price: getPrice,
                    maxQuantity: getQuantityProduct
                })
                sessionStorage.setItem("products", JSON.stringify(getOldProducts));
            } else {
                sessionStorage.setItem("products", JSON.stringify(products));
            }


            showProductSellingList(JSON.stringify(products))

            getProductQuantity.value = ''

        })

        //GET LIST OF PRODUCTS IN TABLE OF SELLING

        getProductsByTableSelling()

        function getProductsByTableSelling() {
            if (sessionStorage.getItem("products") != null) {
                showProductSellingList(sessionStorage.getItem("products"))
            }
        }


        function showProductSellingList(items) {

            getTableSelling.innerHTML = ''

            let itemsList = JSON.parse(sessionStorage.getItem("products"))
            let sumTotal = 0
            for (const [index, item] of itemsList.entries()) {
                getTableSelling.innerHTML += `
         <tr>
           <th scope="row">${(index + 1)}</th>
           <td>${item.code}</td>
           <td>${item.product}</td>
           <td>${item.price}</td>
           <td>${item.quantity}</td>
           <td>${parseInt(item.price) * parseInt(item.quantity)}</td>
           <td><button type="button" class="btn btn-danger w-20" value="${index}" id="product_item_delete">Eliminar producto</button></td>
           <td><input hidden value="${parseInt(item.maxQuantity)}"></td>
          </tr>
         `
                sumTotal = (parseInt(item.price) * parseInt(item.quantity)) + sumTotal
            }
            let calculeIVA = (parseInt(sumTotal) * 0.16)

            if (checkEnableIVA.checked == true) {
                getIVA.innerHTML = `IVA: 0`
                getTotalPrice.innerHTML = `Total: ${formatNumbers(Number(sumTotal))}`
            } else {
                getIVA.innerHTML = `IVA: ${formatNumbers(calculeIVA)}`
                getTotalPrice.innerHTML = `Total: ${formatNumbers(Number(calculeIVA) + Number(sumTotal))}`
            }

            let getAllButtonDelete = document.querySelectorAll('#product_item_delete')
            getAllButtonDelete.forEach((buttonDelete, index) => {
                buttonDelete.addEventListener('click', () => {
                    itemsList.splice(index, 1)
                    products = itemsList
                    showProductSellingList(sessionStorage.setItem('products', JSON.stringify(products)))
                })
            });



            function formatNumbers(number) {
                let haveDecimals = number % 1 !== 0
                if (haveDecimals) {
                    return Number(number).toFixed(2)
                }
                return Number(number)
            }
        }

        let getFormClient = document.querySelector('#add_client')
        let assignStatus = document.getElementById('status')
        getFormClient.addEventListener('submit', async (e) => {
            e.preventDefault();

            let getClientName = document.getElementById('client_modal_name')
            let getClientType = document.getElementById('type_modal_client')
            let getClientDNI = document.getElementById('client_modal_dni')
            let getClientPhone = document.getElementById('client_modal_phone')

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

            let response = await fetch('/admin/add-client', options)
            let data = await response.json()

            if (data.success == true) {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )

                $(".client-list").select2('destroy');
                getClients()

                getClientName.value = ''
                getClientType.value = ''
                getClientDNI.value = ''
                getClientPhone.value = ''

                const getModalClient = document.querySelector('#modal_add_client')
                const modal = bootstrap.Modal.getInstance(getModalClient);
                modal.hide();
            }
        })
        //OBTAIN LIST OF CLIENTS
        getClients()
        async function getClients() {
            let response = await fetch('/admin/get-clients').catch((error) => {
                console.log(error)
            })
            let getInputClients = document.getElementById('client_name')
            let data = await response.json()
            if (data.success == true) {
                getInputClients.innerHTML = ''
                data.clients.forEach((client, index) => {
                    getInputClients.innerHTML += `
         <option value="${client.id}">${client.name} - ${client.dni}</option>
         `
                });
            }

            $(".client-list").select2({
                width: '100%'
            });
        }

        getProducsWords()

        //OBTAIN ALL PRODUCTS
        async function getProducsWords() {

            if ($('.product-list-items').hasClass("select2-hidden-accessible")) {
                $('.product-list-items').select2('destroy')
            }

            let response = await fetch('/admin/get-products-distict').catch((error) => {
                console.log(error)
            })
            let getProductsBox = document.getElementById('product_get_list')
            let data = await response.json()
            if (data.success == true) {
                getProductsBox.innerHTML = ''
                for (const [index, product] of data.products.entries()) {
                    getProductsBox.innerHTML +=
                        ` <option value="${product.product_name.toLowerCase()} - ${product.code.toLowerCase()} | Disponible: ${product.product_quantity} unidades | Precio: ${product.product_selling}">${product.product_name.toLowerCase()} - ${product.code.toLowerCase()} | Disponible: ${product.product_quantity} unidades | Precio: ${product.product_selling}</option> `
                }
            }
            $('.product-list-items').select2({
                width: '100%'
            })
        }

        //SUBMIT FACTURE
        let getFormSelling = document.getElementById('add_selling')
        getFormSelling.addEventListener('submit', async (e) => {
            e.preventDefault()
            getFormSelling.disabled = true
            let getClientName = document.getElementById('client_name')
            let getAllProductsTable = document.querySelectorAll('#prodcut_seeling_list tr')
            let objProductList = []
            let getMaxQuantity = 0
            console.log(getAllProductsTable.length)
            if (getAllProductsTable.length == 0) {
                Swal.fire(
                    `Debe agregar productos para facturar`,
                    ``,
                    'error'
                )
                return
            }
            for (const [index, product] of getAllProductsTable.entries()) {
                let getItems = product.querySelectorAll('td')
                let getCode = getItems[0].innerText
                getMaxQuantity = getItems[6].querySelector('input').value
                let getProductName = getItems[1].innerText

                if (validateQuantityProducts(getCode, getProductName, getAllProductsTable, getMaxQuantity) ==
                    false) {
                    Swal.fire(
                        `El producto ${getProductName} excede la cantidad disponible`,
                        ``,
                        'error'
                    )
                    return
                }

                let getPrice = getItems[2].innerText
                let getQuantity = getItems[3].innerText
                let getProductPrice = getItems[4].innerText

                objProductList.push({
                    code: getCode.toUpperCase(),
                    name: getProductName,
                    price: parseInt(getPrice),
                    product_cant: parseInt(getQuantity)
                })
            }

            let getTotalPrice = document.getElementById('total_product_cost').textContent.replace(/Total|:| /g,
                '')
            let getIvaTotal = document.getElementById('iva_product_cost').textContent.replace(/IVA|:| /g, '')
            let getVendorName = document.getElementById('vendor_name')
            let getFacture = document.getElementById('facture_number')

            let factureObj = {
                products: objProductList,
                vendor: getVendorName.value,
                iva: getIvaTotal,
                client: getClientName.value,
                total_price: getTotalPrice,
                facture: getFacture.value
            }

            //SEND DATA TO FACTURE
            let options = {
                method: "POST",
                mode: "cors",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(factureObj)
            }

            Swal.fire({
                title: "Generando Factura.!",
                text: "",
                type: "info",
                showCancelButton: false,
                showConfirmButton: false,
            });

            let response = await fetch('/admin/generate-selling', options).catch((error) => {
                console.log(error)
            })
            let data = await response.json()

            if (data.success == true) {
                getFormSelling.disabled = false
                sessionStorage.clear()
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'success'
                )
                getProducsWords()
                salesFactureTable()
                document.getElementById('btn_generate_Facture').href = `/admin/facture/${getFacture.value}`;
                getFacture.value = parseInt(getFacture.value) + 1
                document.getElementById('prodcut_seeling_list').innerHTML = ''
                document.getElementById('total_product_cost').innerHTML = 'Total: 0'
                document.getElementById('iva_product_cost').innerHTML = 'IVA: 0'
                products = []
            } else {
                Swal.fire(
                    `${data.message}`,
                    ``,
                    'error'
                )

            }


            //VALIDATE CODES AND NAME PRODCUT FOR QUANTITY
            function validateQuantityProducts(code, productName, tableList, maxQuantityByProduct) {
                let verifyQuantity = 0
                for (const [index, product] of tableList.entries()) {
                    let getItems = product.querySelectorAll('td')
                    let verifiyCode = getItems[0].innerText
                    let verifyProduct = getItems[1].innerText

                    if (code == verifiyCode && productName == verifyProduct) {
                        verifyQuantity = parseInt(getItems[3].innerText) + verifyQuantity
                    }
                }
                if (verifyQuantity <= parseInt(maxQuantityByProduct)) {
                    return true
                } else {
                    return false
                }
            }
        })

        //GENERATE FACTURE

        let getButtonFacture = document.getElementById('btn_generate_Facture')
        getButtonFacture.addEventListener('click', () => {
            if (getButtonFacture.href.indexOf('#') != -1) {
                assignStatus.innerHTML = ''
                assignStatus.innerHTML = `<span class="p-2 bg-danger">Debe Generar la Factura Primero</span>`
                timeHoverStatus()
            }
        })


        //ASSIG SELLING TABLES
        salesFactureTable()


        async function salesFactureTable() {
            if ($.fn.DataTable.isDataTable('#table_sales_month')) {
                $('#table_sales_month').DataTable().destroy();
            }

            if ($.fn.DataTable.isDataTable('#table_sales_today')) {
                $('#table_sales_today').DataTable().destroy();
            }

            let tableFactureToday = document.getElementById('sales_today')
            let getUserRol = "@php echo Auth::user()->rol @endphp";
            let tableFactureMonth = ''
            let tableFactureWeek = ''
            if (getUserRol != 'GERENCIA') {
                tableFactureMonth = document.getElementById('sales_monthly')
                tableFactureWeek = document.getElementById('sales_weekly')
            }

            let response = await fetch('/admin/sales-history').catch((error) => {
                console.log(error)
            })
            let data = await response.json()

            if (data.success == true) {
                tableFactureToday.innerHTML = ''
                tableFactureWeek.innerHTML = ''
                tableFactureMonth.innerHTML = ''
                if (getUserRol != 'GERENCIA') {
                    data.history[0].forEach((facture, index) => {
                        tableFactureToday.innerHTML += `
               <tr>
                  <th scope="row">${(index + 1)}</th>
                   <td>${facture.id}</td>
                   <td>${facture.total_price}</td>
                   <td>${facture.created_at.split(' ')[0]} | ${facture.created_at.split(' ')[1].split('.')[0]}</td>
                   <td><a href="/admin/facture/${facture.id}" class="btn btn-danger w-100" id="btn_generate_Facture">Descargar</a></td>
                   <td><button class="btn btn-danger btn-block" id="btn_delete_facture" value="${facture.id}">eliminar</button></td>
                </tr>
               `
                    });

                    /* data.history[1].forEach((facture, index) => {
                                                                                                                                                                                                                                                                                                                                                        tableFactureWeek.innerHTML += `
                <tr>
                  <th scope="row">${(index + 1)}</th>
                   <td>${facture.id}</td>
                   <td>${facture.total_price}</td>
                   <td>${facture.created_at.split(' ')[0]} | ${facture.created_at.split(' ')[1].split('.')[0]}</td>
                   <td><a href="/admin/facture/${facture.id}" class="btn btn-danger w-100" id="btn_generate_Facture">Descargar</a></td>
                </tr>
            `
                                                                                                                                                                                                                                                                                                                                                    }) */

                    data.history[2].forEach((facture, index) => {
                        tableFactureWeek.innerHTML += `
                <tr>
                  <th scope="row">${(index + 1)}</th>
                   <td>${facture.id}</td>
                   <td>${facture.total_price}</td>
                   <td>${facture.created_at.split(' ')[0]} | ${facture.created_at.split(' ')[1].split('.')[0]}</td>
                   <td><a href="/admin/facture/${facture.id}" class="btn btn-danger w-100" id="btn_generate_Facture">Descargar</a></td>
                </tr>
            `
                    })

                } else {
                    data.history[0].forEach((facture, index) => {
                        tableFactureWeek.innerHTML += `
               <tr>
                  <th scope="row">${(index + 1)}</th>
                   <td>${facture.id}</td>
                   <td>${facture.total_price}</td>
                   <td>${facture.created_at.split(' ')[0]} | ${facture.created_at.split(' ')[1].split('.')[0]}</td>
                   <td><a href="/admin/facture/${facture.id}" class="btn btn-danger w-100" id="btn_generate_Facture">Descargar</a></td>
                </tr>
               `
                    });
                }

            }
            $('#table_sales_month').DataTable()
            $('#table_sales_today').DataTable({
                drawCallback: function(settings) {
                    deleteFactureToday()
                }
            })
        }


        function deleteFactureToday() {
            let getAllBtnDeleteFacture = document.querySelectorAll('#btn_delete_facture')
            getAllBtnDeleteFacture.forEach(btnDeleteFacture => {
                btnDeleteFacture.addEventListener('click', async () => {
                    Swal.fire({
                        title: "Eliminado factura..!",
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
                    let response = await fetch(`/admin/delete-selling/${btnDeleteFacture.value}`,
                        options).catch((error) => {
                        console.log(error)
                    })
                    let data = await response.json()

                    if (data.success == true) {
                        await salesFactureTable()
                        await getProducsWords()
                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'success'
                        )

                        document.getElementById('facture_number').value = data.factureID + 1
                    } else {
                        Swal.fire(
                            `${data.message}`,
                            ``,
                            'error'
                        )

                        await salesFactureTable()

                    }
                })
            })
        }
    </script>
@stop
