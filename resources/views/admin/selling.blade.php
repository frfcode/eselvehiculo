@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1 class="m-0 text-dark">Ventas</h1>
@stop

@section('content')
<div id="status" class="status-content"></div>
<div class="row">
    <div class="col-3">
        <button type="click" id="button_selling_item" class="btn btn-primary w-100">Registrar nueva venta</button>
    </div>

    <div class="col-3">
      <button type="click" id="button_selling_item" class="active btn btn-primary w-100">Lista de Ventas de hoy</button>
    </div>
    @if(Auth::user()->rol != 'GERENCIA')
    <div class="col-3">
        <button type="click" id="button_selling_item" class="btn btn-primary w-100">Lista de Ventas Semanales</button>
    </div>
    <div class="col-3">
        <button type="click" id="button_selling_item" class="btn btn-primary w-100">Lista de Ventas Mensaules</button>
    </div>
    @endif
</div>
{{-- SELLING BY PRODUCT --}}
<div class="row hidden-content" id="selling_content">
    <div class="col-12">
        <div class="card mt-4">
            <form method="post" id="add_selling">
              <input type="text" hidden value="{{ Auth::user()->name }}" id="vendor_name">
                <div class="card p-4">
                  <div class="form-group">
                    <div class="form-group">
                      <div class="row border-bottom border-dark border-4">
                        <div class="col-2">
                            <p class="title-facture text-center">Factura N°</p>
                        </div>
                        <div class="col-2">
                          <input type="number" readonly name="facture_number" id="facture_number" class="form-control text-center w-20" value="{{ ($factureID + 1)}}">
                        </div>
                      </div>
                    </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="exampleInputEmail1">Cliente</label>
                                <select name="client_name" id="client_name" class="form-control">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                            <div class="col-2 mt-auto">
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal_add_client">Agregar nuevo cliente</button>
                            </div>
                            <div class="col-3 mt-auto">
                                <label for="exampleInputEmail1">Facturar sin IVA</label>
                                <input type="checkbox" class="ml-2" id="check_iva_product">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <div class="row">
                            <div class="col-4 position-relative">
                                <label for="exampleInputEmail1">Agregar de Producto</label>
                                <input type="text" class="form-control" id="search_product" name="search_product" placeholder="Filtro para motor">
                                <div id="results" class="results-box"></div>
                            </div>
                            <div class="col-4">
                                <label for="exampleInputEmail1">Cant. de Venta</label>
                                <input type="number" class="form-control" id="product_quantity" name="product_quantity" placeholder="20">
                            </div>
                            <div class="col-4 mt-auto">
                                <button type="button" class="btn btn-primary w-20" id="add_item_product">Agregar</button>
                            </div>
                       </div>
                    </div>
                    <div class="row" id="selling_product_list">
                        <div class="col-12">
                        <table class="table">
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
                    <div class="row">
                        <div class="col-12 border-top border-dark border-4">
                            <h3 class="text-right" id="iva_product_cost">IVA: 0</h3>
                        </div>
                        <div class="col-12  border-bottom border-dark border-4">
                            <h3 class="text-right" id="total_product_cost">Total: 0</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 mt-4">
                            <button type="submit" class="btn btn-primary w-100">Facturar</button>
                        </div>
                        <div class="col-3 mt-4">
                          <a href="#" class="btn btn-primary w-100" id="btn_generate_Facture">Generar Factura</a>
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
        <div class="card mt-4">
            <div class="col-12 mt-3">
                <h3>Ventas De Hoy</h3>
            </div>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">N° Factura</th>
                    <th scope="col">Precio Total</th>
                    <th scope="col">Fecha Factura</th>
                    <th scope="col">Revisar</th>
                  </tr>
                </thead>
                <tbody id="sales_today"></tbody>
              </table>
        </div>
    </div>
</div>
@if(Auth::user()->rol != 'GERENCIA')
<div class="row hidden-content" id="selling_content">
    <div class="col-12">
        <div class="card mt-4">
            <div class="col-12 mt-3">
                <h3>Ventas Semanales</h3>
            </div>
            <table class="table">
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
{{-- SELLING LIST BY MONTH--}}
<div class="row hidden-content" id="selling_content">
    <div class="col-12">
        <div class="card mt-4">
            <div class="col-12 mt-3">
                <h3>Ventas Mensaules</h3>
            </div>
            <table class="table">
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
@endif
{{-- ADD NEW CLIENT --}}
   {{-- MODAL --}}
   <div class="modal fade" id="modal_add_client" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title fs-5" id="exampleModalLabel">Agregar Nuevo Cliente</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="post" id="add_client">
                <div class="card p-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de client</label>
                        <input type="text" class="form-control" id="client_modal_name" name="client_modal_name" placeholder="Juan Pablo Duarte">
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
                        <label for="exampleInputEmail1">Cedula o DNI</label>
                        <input type="text" class="form-control" id="client_modal_dni" name="client_modal_dni" placeholder="V-24436494">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Telefono</label>
                        <input type="number" class="form-control" id="client_modal_phone" name="client_modal_phone" placeholder="+584125487861">
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
<script>
    let getButtonList = document.querySelectorAll('#button_selling_item')
    let getConent = document.querySelectorAll('#selling_content')

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



  let getInputSearchProduct = document.getElementById('search_product')
  let resultsSearch = document.getElementById("results");


  //ADD PRODUCT TO TABLE
  let getTableSelling = document.getElementById('prodcut_seeling_list')
  let buttonAddProductItem = document.getElementById('add_item_product')
  let products = []
  let getTotalPrice = document.getElementById('total_product_cost')
  let checkEnableIVA = document.getElementById('check_iva_product')
  let getIVA = document.getElementById('iva_product_cost')

  buttonAddProductItem.addEventListener('click', (e)=>{
    e.preventDefault();
    let getProductQuantity = document.getElementById('product_quantity')

    if(getProductQuantity.value == null || getProductQuantity.value == ''){
        assignStatus.innerHTML = ''
        assignStatus.innerHTML = `<span class="p-2 bg-danger">Agrege precio al producto, por favor</span>`
        timeHoverStatus()
        return
    }

    if(getInputSearchProduct.value == ''){
        assignStatus.innerHTML = ''
        assignStatus.innerHTML = `<span class="p-2 bg-danger">Agrege un producto, por favor</span>`
        timeHoverStatus()
        return
    }

    let getQuantityProduct = getInputSearchProduct.value.split('|')[1].split(':')[1].replace(' unidades', '')
    let getCode = getInputSearchProduct.value.split('|')[0].split('-')[1]
    let getProductName = getInputSearchProduct.value.split('|')[0].split('-')[0]
    let getPrice = getInputSearchProduct.value.split('|')[2].split(':')[1].trim()

    if(getProductQuantity.value > parseInt(getQuantityProduct.trim())){
      assignStatus.innerHTML = ''
      assignStatus.innerHTML = `<span class="p-2 bg-danger">Product excede la cantidad disponible</span>`
      timeHoverStatus()
      return
    }


    products.push({
      code: getCode,
      product: getProductName,
      quantity: getProductQuantity.value,
      price: getPrice,
      maxQuantity: getQuantityProduct
    })

    showProductSellingList(JSON.stringify(products))

    getInputSearchProduct.value = ''
    getProductQuantity.value = ''

  })


  function showProductSellingList(items){
    let itemsList = JSON.parse(items)
      getTableSelling.innerHTML = ''
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

    if(checkEnableIVA.checked == true){
        getIVA.innerHTML = `IVA: `
        getTotalPrice.innerHTML = `Total: ${formatNumbers(Number(sumTotal))}`
    }else{
        getIVA.innerHTML = `IVA: ${formatNumbers(calculeIVA)}`
        getTotalPrice.innerHTML = `Total: ${formatNumbers(Number(calculeIVA) + Number(sumTotal))}`
    }

    let getAllButtonDelete = document.querySelectorAll('#product_item_delete')
      getAllButtonDelete.forEach((buttonDelete, index) => {
        buttonDelete.addEventListener('click',()=>{
          itemsList.splice(index, 1)
          products = itemsList
          showProductSellingList(JSON.stringify(products))
      })
    });



    function formatNumbers(number) {
        let haveDecimals = number % 1 !== 0
        if(haveDecimals){
            return Number(number).toFixed(2)
        }
        return Number(number)
    }
  }

  let getFormClient = document.querySelector('#add_client')
  let assignStatus = document.getElementById('status')
  getFormClient.addEventListener('submit', async (e)=>{
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

    if(data.success == true){
        assignStatus.innerHTML = ''
        assignStatus.innerHTML = `<span class="p-2 bg-success">
            ${data.message}
        </span>`
        timeHoverStatus()
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
    let response = await fetch('/admin/get-clients').catch((error)=>{console.log(error)})
    let getInputClients = document.getElementById('client_name')
    let data = await response.json()
    if(data.success == true){
      getInputClients.innerHTML = ''
      data.clients.forEach((client, index) => {
        getInputClients.innerHTML += `
         <option value="${client.id}">${client.name} - ${client.dni}</option>
         `
     });
    }
  }

  initWordsProductSearch()

  function initWordsProductSearch(){
    getProducsWords().then((data)=> {
    const words = data
    getInputSearchProduct.addEventListener('input', async (e) =>{
    if(e.target.value != null && e.target.value.split('').length >= 2){
      let searchValue = e.target.value.toLowerCase()
      resultsSearch.innerHTML = ''

      const filteredWords = words.filter(word => word.startsWith(searchValue))
      if(filteredWords == ''){
        const div = document.createElement("div");
        div.classList.add(['form-control'],['text-white'],['bg-dark'])
        div.textContent = 'PRODUCTO NO EXISTE';
        resultsSearch.appendChild(div);
        return
      }

      resultsSearch.innerHTML = "";
      filteredWords.forEach(word => {
          const div = document.createElement("div");
          div.classList.add(['border-bottom'],['border-white'], ['p-2'], ['pb-2'],['element-cursor-pointer'],['text-white'], ['bg-dark'])
          div.textContent = word;
          div.addEventListener("click", function() {
            getInputSearchProduct.value = word;
            resultsSearch.innerHTML = "";
          });
        resultsSearch.appendChild(div);
      })
      return
    }
    resultsSearch.innerHTML = "";
  });
  })
  }
  //OBTAIN ALL PRODUCTS
  async function getProducsWords() {
    let response = await fetch('/admin/get-products-distict').catch((error)=>{console.log(error)})
    let data = await response.json()
    let wordsProducts = []
    if(data.success == true){
      for (const [index, product] of data.products.entries()) {
        wordsProducts.push(`${product.product_name.toLowerCase()} - ${product.code.toLowerCase()} | Disponible: ${product.product_quantity} unidades | Precio: ${product.product_selling}`)
      }
    }
    return wordsProducts
  }

  //SUBMIT FACTURE
  let getFormSelling = document.getElementById('add_selling')
  getFormSelling.addEventListener('submit', async (e)=>{
    e.preventDefault()
    let getClientName = document.getElementById('client_name')
    let getAllProductsTable = document.querySelectorAll('#prodcut_seeling_list tr')
    let objProductList = []
    let getMaxQuantity = 0
    for (const [index, product] of getAllProductsTable.entries()) {
        let getItems = product.querySelectorAll('td')
        let getCode = getItems[0].innerText
        getMaxQuantity = getItems[6].querySelector('input').value
        let getProductName = getItems[1].innerText

        if(validateQuantityProducts(getCode, getProductName, getAllProductsTable, getMaxQuantity) == false){
          assignStatus.innerHTML = ''
          assignStatus.innerHTML = `<span class="p-2 bg-danger">El producto ${getProductName} excede la cantidad disponible</span>`
          timeHoverStatus()
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

    let getTotalPrice = document.getElementById('total_product_cost').textContent.replace(/Total|:| /g,'')
    let getIvaTotal = document.getElementById('iva_product_cost').textContent.replace(/IVA|:| /g,'')
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

    let response = await fetch('/admin/generate-selling', options).catch((error)=>{console.log(error)})
    let data = await response.json()

    if(data.success == true){
      assignStatus.innerHTML = ''
      assignStatus.innerHTML = `<span class="p-2 bg-success" role="alert"> ${data.message} </span>`
      timeHoverStatus()
      initWordsProductSearch()
      salesFactureTable()
      document.getElementById('btn_generate_Facture').href =`/admin/facture/${getFacture.value}`;
      getFacture.value = parseInt(getFacture.value) + 1
      document.getElementById('prodcut_seeling_list').innerHTML = ''
      document.getElementById('total_product_cost').innerHTML = 'Total: 0'
      document.getElementById('iva_product_cost').innerHTML = 'IVA: 0'
      products = []
    }else{
        assignStatus.innerHTML = ''
        assignStatus.innerHTML = `<span class="p-2 bg-danger" role="alert"> ${data.message} </span>`
        timeHoverStatus()
    }


    //VALIDATE CODES AND NAME PRODCUT FOR QUANTITY
    function validateQuantityProducts(code, productName, tableList, maxQuantityByProduct){
      let verifyQuantity = 0
      for (const [index, product] of tableList.entries()) {
        let getItems = product.querySelectorAll('td')
        let verifiyCode = getItems[0].innerText
        let verifyProduct = getItems[1].innerText

        if(code == verifiyCode && productName == verifyProduct){
          verifyQuantity = parseInt(getItems[3].innerText) + verifyQuantity
        }
      }
      if(verifyQuantity <= parseInt(maxQuantityByProduct)){
        return true
      }else{
        return false
      }
    }
  })

  //GENERATE FACTURE

  let getButtonFacture = document.getElementById('btn_generate_Facture')
  getButtonFacture.addEventListener('click',()=>{
    if(getButtonFacture.href.indexOf('#') != -1){
      assignStatus.innerHTML = ''
      assignStatus.innerHTML = `<span class="p-2 bg-danger">Debe Generar la Factura Primero</span>`
      timeHoverStatus()
    }
  })


  //ASSIG SELLING TABLES
  salesFactureTable()


  async function salesFactureTable(){
    let tableFactureToday = document.getElementById('sales_today')
    let getUserRol = "@php echo Auth::user()->rol @endphp";
    let tableFactureMonth = ''
    let tableFactureWeek = ''
    if(getUserRol != 'GERENCIA'){
      tableFactureMonth = document.getElementById('sales_monthly')
      tableFactureWeek = document.getElementById('sales_weekly')
    }

    let response = await fetch('/admin/sales-history').catch((error)=>{console.log(error)})
    let data = await response.json()
    if(data.success == true){
      tableFactureToday.innerHTML = ''
        if(getUserRol != 'GERENCIA'){
          data.history[0].forEach((facture, index) => {
          tableFactureToday.innerHTML += `
               <tr>
                  <th scope="row">${(index + 1)}</th>
                   <td>${facture.id}</td>
                   <td>${facture.total_price}</td>
                   <td>${facture.created_at.split(' ')[0]} | ${facture.created_at.split(' ')[1].split('.')[0]}</td>
                   <td><a href="/admin/facture/${facture.id}" class="btn btn-danger w-100" id="btn_generate_Facture">Descargar</a></td>
                   <td><button class="btn btn-danger w-20" id="btn_delete_facture" value="${facture.id}">eliminar</button></td>
                </tr>
               `
        });

        data.history[1].forEach((facture, index) => {
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

        deleteFactureToday()
      }else{
        data.history[0].forEach((facture, index) => {
          tableFactureToday.innerHTML += `
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

  }


  function deleteFactureToday(){
    let getAllBtnDeleteFacture = document.querySelectorAll('#btn_delete_facture')
    getAllBtnDeleteFacture.forEach(btnDeleteFacture => {
      btnDeleteFacture.addEventListener('click', async ()=>{
        let options = {
          method: "DELETE",
          mode: "cors",
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')['content'],
              'Content-Type': 'application/json'
          },
        }
        let response = await fetch(`/admin/delete-selling/${btnDeleteFacture.value}`, options).catch((error)=>{console.log(error)})
        let data = await response.json()
        if(data.success == true){

            await salesFactureTable()

            assignStatus.innerHTML = ''
            assignStatus.innerHTML = `<span class="p-2 bg-success">
                ${data.message}
            </span>`

            timeHoverStatus()

            document.getElementById('facture_number').value = data.factureID + 1
        }
      })
    })
  }
  function timeHoverStatus(){
      setTimeout(() => {
          assignStatus.innerHTML = ''
      }, 7000);
  }
</script>
@stop
