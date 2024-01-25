@extends('layout.sidenav-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <div class="row">
                        <div class="col-8">
                            <span class="text-bold text-dark">BILLED TO </span>
                            <p class="text-xs mx-0 my-1">Name: <span id="CName"></span> </p>
                            <p class="text-xs mx-0 my-1">Email: <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1">User ID: <span id="CId"></span> </p>
                        </div>
                        <div class="col-4">
                            <img class="w-50" src="{{ 'images/logo.png' }}">
                            <p class="text-bold mx-0 my-1 text-dark">Invoice </p>
                            <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary" />
                    <div class="row">
                        <div class="col-12">
                            <table class="table w-100" id="invoiceTable">
                                <thead class="w-100">
                                    <tr class="text-xs">
                                        <td>Name</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                        <td>Remove</td>
                                    </tr>
                                </thead>
                                <tbody class="w-100" id="invoiceList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary" />
                    <div class="row">
                        <div class="col-12">
                            <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i> <span
                                    id="total">0</span></p>
                            <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>
                                <span id="payable"></span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>
                                <span id="vat"></span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>
                                <span id="discount"></span>
                            </p>
                            <span class="text-xxs">Discount(%):</span>
                            <input value="0" class="form-control w-40 " id="discountP" />
                            <p>
                                <button onclick="createInvoice()"
                                    class="btn  my-3 bg-gradient-primary w-40">Confirm</button>
                            </p>
                        </div>
                        <div class="col-12 p-2">

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table  w-100" id="productTable">
                        <thead class="w-100">
                            <tr class="text-xs text-bold">
                                <td>Product</td>
                                <td>Pick</td>
                            </tr>
                        </thead>
                        <tbody class="w-100" id="productList">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4 col-lg-4 p-2">
                <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                    <table class="table table-sm w-100" id="customerTable">
                        <thead class="w-100">
                            <tr class="text-xs text-bold">
                                <td>Customer</td>
                                <td>Pick</td>
                            </tr>
                        </thead>
                        <tbody class="w-100" id="customerList">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>




    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Add Product</h6>
                </div>
                <div class="modal-body">
                    <form id="add-form">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 p-1">
                                    <div class="d-none">
                                        <label class="form-label">Product ID *</label>
                                        <input type="text" class="form-control" id="PId">
                                    </div>
                                    <label class="form-label mt-2">Product Name *</label>
                                    <input type="text" class="form-control" id="PName" readonly>
                                    <label class="form-label mt-2">Product Price *</label>
                                    <input type="text" class="form-control" id="PPrice">

                                    <label class="form-label mt-2">Product Qty *</label>
                                    <input type="text" class="form-control" id="PQty">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button onclick="pickProduct()" id="save-btn" class="btn bg-gradient-success">Pick</button>
                </div>
            </div>
        </div>
    </div>


    {{-- <script>


        (async ()=>{
          showLoader();
          await  CustomerList();
          await ProductList();
          hideLoader();
        })()


        let InvoiceItemList=[];


        function ShowInvoiceItem() {

            let invoiceList=$('#invoiceList');

            invoiceList.empty();

            InvoiceItemList.forEach(function (item,index) {
                let row=`<tr class="text-xs">
                        <td>${item['product_name']}</td>
                        <td>${item['qty']}</td>
                        <td>${item['sale_price']}</td>
                        <td><a data-index="${index}" class="btn remove text-xxs px-2 py-1  btn-sm m-0">Remove</a></td>
                     </tr>`
                invoiceList.append(row)
            })

            CalculateGrandTotal();

            $('.remove').on('click', async function () {
                let index= $(this).data('index');
                removeItem(index);
            })

        }


        function removeItem(index) {
            InvoiceItemList.splice(index,1);
            ShowInvoiceItem()
        }

        function DiscountChange() {
            CalculateGrandTotal();
        }

        function CalculateGrandTotal(){
            let Total=0;
            let Vat=0;
            let Payable=0;
            let Discount=0;
            let discountPercentage=(parseFloat(document.getElementById('discountP').value));

            InvoiceItemList.forEach((item,index)=>{
                Total=Total+parseFloat(item['sale_price'])
            })

             if(discountPercentage===0){
                 Vat= ((Total*5)/100).toFixed(2);
             }
             else {
                 Discount=((Total*discountPercentage)/100).toFixed(2);
                 Total=(Total-((Total*discountPercentage)/100)).toFixed(2);
                 Vat= ((Total*5)/100).toFixed(2);
             }

             Payable=(parseFloat(Total)+parseFloat(Vat)).toFixed(2);


            document.getElementById('total').innerText=Total;
            document.getElementById('payable').innerText=Payable;
            document.getElementById('vat').innerText=Vat;
            document.getElementById('discount').innerText=Discount;
        }


        function add() {
           let PId= document.getElementById('PId').value;
           let PName= document.getElementById('PName').value;
           let PPrice=document.getElementById('PPrice').value;
           let PQty= document.getElementById('PQty').value;
           let PTotalPrice=(parseFloat(PPrice)*parseFloat(PQty)).toFixed(2);
           if(PId.length===0){
               errorToast("Product ID Required");
           }
           else if(PName.length===0){
               errorToast("Product Name Required");
           }
           else if(PPrice.length===0){
               errorToast("Product Price Required");
           }
           else if(PQty.length===0){
               errorToast("Product Quantity Required");
           }
           else{
               let item={product_name:PName,product_id:PId,qty:PQty,sale_price:PTotalPrice};
               InvoiceItemList.push(item);
               console.log(InvoiceItemList);
               $('#create-modal').modal('hide')
               ShowInvoiceItem();
           }
        }




        function addModal(id,name,price) {
            document.getElementById('PId').value=id
            document.getElementById('PName').value=name
            document.getElementById('PPrice').value=price
            $('#create-modal').modal('show')
        }


        async function CustomerList(){
            let res=await axios.get("/list-customer");
            let customerList=$("#customerList");
            let customerTable=$("#customerTable");
            customerTable.DataTable().destroy();
            customerList.empty();

            res.data.forEach(function (item,index) {
                let row=`<tr class="text-xs">
                        <td><i class="bi bi-person"></i> ${item['name']}</td>
                        <td><a data-name="${item['name']}" data-email="${item['email']}" data-id="${item['id']}" class="btn btn-outline-dark addCustomer  text-xxs px-2 py-1  btn-sm m-0">Add</a></td>
                     </tr>`
                customerList.append(row)
            })


            $('.addCustomer').on('click', async function () {

                let CName= $(this).data('name');
                let CEmail= $(this).data('email');
                let CId= $(this).data('id');

                $("#CName").text(CName)
                $("#CEmail").text(CEmail)
                $("#CId").text(CId)

            })

            new DataTable('#customerTable',{
                order:[[0,'desc']],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
        }


        async function ProductList(){
            let res=await axios.get("/list-product");
            let productList=$("#productList");
            let productTable=$("#productTable");
            productTable.DataTable().destroy();
            productList.empty();

            res.data.forEach(function (item,index) {
                let row=`<tr class="text-xs">
                        <td> <img class="w-10" src="${item['img_url']}"/> ${item['name']} ($ ${item['price']})</td>
                        <td><a data-name="${item['name']}" data-price="${item['price']}" data-id="${item['id']}" class="btn btn-outline-dark text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
                     </tr>`
                productList.append(row)
            })


            $('.addProduct').on('click', async function () {
                let PName= $(this).data('name');
                let PPrice= $(this).data('price');
                let PId= $(this).data('id');
                addModal(PId,PName,PPrice)
            })


            new DataTable('#productTable',{
                order:[[0,'desc']],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
        }



      async  function createInvoice() {
            let total=document.getElementById('total').innerText;
            let discount=document.getElementById('discount').innerText
            let vat=document.getElementById('vat').innerText
            let payable=document.getElementById('payable').innerText
            let CId=document.getElementById('CId').innerText;


            let Data={
                "total":total,
                "discount":discount,
                "vat":vat,
                "payable":payable,
                "customer_id":CId,
                "products":InvoiceItemList
            }


            if(CId.length===0){
                errorToast("Customer Required !")
            }
            else if(InvoiceItemList.length===0){
                errorToast("Product Required !")
            }
            else{

                showLoader();
                let res=await axios.post("/invoice-create",Data)
                hideLoader();
                if(res.data===1){
                    window.location.href='/invoicePage'
                    successToast("Invoice Created");
                }
                else{
                    errorToast("Something Went Wrong")
                }
            }

        }

    </script> --}}

    <script>
        function getCustomersData() {
            var customerTable = $('#customerTable');
            var customerList = $('#customerList');
            customerTable.DataTable().destroy();
            customerList.empty();
            showLoader();
            $.ajax({
                type: "get",
                url: "/customer-list",
                success: function(response) {
                    if (response.status == 'success') {
                        hideLoader();
                        // $('#customerList').empty();
                        console.log(response);
                        response.data.forEach(function(item, index) {
                            let row = `<tr>
                                        <td class="col-10">${item['name']}</td>
                                        <td>
                                            <button data-id="${item['id']}" class="customerPick float-end btn m-0  bg-gradient-primary">Pick</button>
                                        </td>
                                    </tr>`
                            $('#customerList').append(row)
                        });

                        customerTable.DataTable({
                            order: [
                                [0, 'desc']
                            ],
                            lengthMenu: [5, 10, 15, 20, 30]
                        });
                    };
                }
            })
        }
        getCustomersData();

        function productList() {
            var productTable = $('#productTable');
            var productList = $('#productList');
            productTable.DataTable().destroy();
            productList.empty();

            showLoader();
            $.ajax({
                type: "get",
                url: "/product-list",
                success: function(response) {
                    if (response.status === 200) {
                        hideLoader();
                        response.product.forEach(function(item, index) {
                            let row = `<tr>
                                        <td class="col-10">${item['name']}</td>

                                        <td>
                                            <button data-id="${item['id']}" data-name="${item['name']}" data-price="${item['price']}" 
                                            class="float-end btn m-0  bg-gradient-primary addProduct">Add</button>
                                            
                                            
                                            </td>
                                            </tr>`;
                            // data-bs-toggle="modal" data-bs-target="#create-modal"
                            // <button data-id="${item['id']}" data-name="${item['name']}" data-price="${item['price']}"  class="btn productPick btn-sm btn-outline-success">Pick</button>

                            productList.append(row)

                        })
                        productTable.DataTable({
                            order: [
                                [0, 'desc']
                            ],
                            lengthMenu: [5, 10, 15, 20, 30]
                        });

                        $('.addProduct').on('click', function() {


                            $('#create-modal').modal('show');

                            let id = $(this).data('id');
                            let name = $(this).data('name');
                            let price = $(this).data('price');
                            $('#PId').val(id);
                            $('#PName').val(name);
                            $('#PPrice').val(price);
                            $('#PQty').val(1);
                        })
                    }
                }

            });

        }

        productList();

        function pickProduct() {
            let id = $('#PId').val();
            let name = $('#PName').val();
            let price = $('#PPrice').val();
            let quantity = $('#PQty').val();
            if (quantity <= 0) {
                errorToast("Quantity Can't be 0")
            } else {

                let total = price * quantity;

                let invoiceList = $('#invoiceList');
                let row = `<tr data-id="${id}">
                            <td class="col-1">${name}</td>
                            <td>${quantity}</td>
                            <td>${total}</td>
                            <td class="col-1">
                                <button data-total="${total}" onClick="deleteProduct(this)" class="btn  btn-sm btn-outline-danger">Remove</button>
                            </td>
                        </tr>`;

                //check duplicate
                let exists = $('#invoiceList').find('tr[data-id="' + id + '"]').length > 0;
                if (exists) {
                    errorToast('This product Already Exists');
                } else {
                    $('#create-modal').modal('hide');
                    let grandTotal = parseFloat($('#total').text());
                    let vat = parseFloat($('#vat').text());
                    let discount = parseFloat($('#discount').text());
                    let discountPercent = parseFloat($('#discountP').val());

                    /*
                         fristly calculate the total price of all products
                         then calculate vat 
                         then discount the percentage
                    */
                    grandTotal += total;
                    $('#total').text(grandTotal);

                    let calculateVAtPercent = (5 / 100) * grandTotal; //5% vat
                    $('#vat').text(calculateVAtPercent.toFixed(2));

                    let payableTotal = calculateVAtPercent + grandTotal;

                    let calculateDiscountPercent = (discountPercent / 100) * payableTotal;

                    $('#payable').text((payableTotal - calculateDiscountPercent).toFixed(2));

                    invoiceList.append(row)

                }

            }

        }

        function deleteProduct(button) {
            $(button).closest('tr').remove();
            console.log("reomove");
            let total = $(button).data('total');
            let grandTotal = parseFloat($('#total').text());
            grandTotal -= total;
            $('#total').text(grandTotal);

            let calculateVAtPercent = (5 / 100) * grandTotal; //5% vat
            $('#vat').text(calculateVAtPercent.toFixed(2));

            let payableTotal = calculateVAtPercent + grandTotal;

            let calculateDiscountPercent = (discountPercent / 100) * payableTotal;
            
            $('#payable').text((payableTotal - calculateDiscountPercent).toFixed(2));

        }
    </script>
@endsection
