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
                            <p class="text-xs mx-0 my-1 d-none">Customer ID: <span id="CId"></span> </p>
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
                                <span id="payable">0</span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>
                                <span id="vat">0</span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>
                                <span id="discount">0</span>
                            </p>
                            <span class="text-xxs">Discount(%):</span>
                            <input onkeyup="discount()" value="0" min="0" type="number"
                                class="form-control w-40 " id="discountP" />
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
                        // console.log(response);
                        response.data.forEach(function(item, index) {
                            let row = `<tr>
                                        <td class="col-10">${item['name']}</td>
                                        <td>
                                            <button onClick="pickCustomer(this)"  data-id="${item['id']}" data-name="${item['name']}" data-email="${item['email']}" data-mobile="${item['mobile']}" data-user_id="${item['user_id']}" class="customerPick float-end btn m-0  bg-gradient-primary">Pick</button>
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
                                            <button onClick="addProductModel(this)" data-id="${item['id']}" data-name="${item['name']}" data-price="${item['price']}" 
                                            class="float-end btn m-0  bg-gradient-primary addProduct">Add</button>
                                            
                                            
                                            </td>
                                            </tr>`;
                            // data-bs-toggle="modal" data-bs-target="#create-modal"
                            // <button data-id="${item['id']}" data-name="${item['name']}" data-price="${item['price']}"  class="btn productPick btn-sm bg-gradient-success">Pick</button>

                            productList.append(row)

                        })
                        productTable.DataTable({
                            order: [
                                [0, 'desc']
                            ],
                            lengthMenu: [5, 10, 15, 20, 30]
                        });

                        // $('.addProduct').on('click', function() {



                        // })
                    }
                }

            });

        }

        productList();

        function addProductModel(button) {
            $('#create-modal').modal('show');

            let id = $(button).data('id');
            let name = $(button).data('name');
            let price = $(button).data('price');
            $('#PId').val(id);
            $('#PName').val(name);
            $('#PPrice').val(price);
            $('#PQty').val(1);
        }


        function pickProduct() {
            let id = $('#PId').val();
            let name = $('#PName').val();
            let price = $('#PPrice').val();
            let quantity = $('#PQty').val();
            if (quantity <= 0) {
                errorToast("Quantity Can't be 0")
            } else if (price <= 0) {
                errorToast("Price Can't be 0")
            } else {

                let total = price * quantity;

                let invoiceList = $('#invoiceList');
                let row = `<tr data-id="${id}">
                            <td class="col-1">${name}</td>
                            <td>${quantity}</td>
                            <td>${total}</td>
                            <td class="col-1">
                                <button data-total="${total}" onClick="deleteProduct(this)" class="btn  btn-sm bg-gradient-danger">Remove</button>
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



                    $('#payable').text((payableTotal).toFixed(2));

                    invoiceList.append(row);
                    successToast("Product Added")


                }

            }
            discount()

        }

        function discount() {
            let total = parseFloat($('#total').text());
            let calculateVat = (5 / 100) * total;

            parseFloat($('#vat').text(calculateVat.toFixed(2)));

            let vat = parseFloat($('#vat').text());

            parseFloat($('#payable').text(total + vat));

            let payable = parseFloat($('#payable').text());
            let discount = parseFloat($('#discountP').val());
            if (isNaN(discount)) {
                errorToast("Discount can't be Empty");
                discount = 0;
            }

            let calculateDiscount = (discount / 100) * total
            parseFloat($('#discount').text(calculateDiscount.toFixed(2)));
            let finalAmount = payable - calculateDiscount;
            parseFloat($('#payable').text(finalAmount.toFixed(2)));
            console.log(payable - calculateDiscount)
        }

        function pickCustomer(button) {
            //get data and store
            let id = $(button).data('id');
            let name = $(button).data('name');
            let email = $(button).data('email');
            let mobile = $(button).data('mobile');
            let user_id = $(button).data('user_id');
            // set data 
            let customerName = $('#CName').text(name);
            let customerEmail = $('#CEmail').text(email);
            let customerId = $('#CId').text(id);
            successToast("Customer Added");
        }

        function deleteProduct(button) {
            //subtrac from total
            let total = $(button).data('total');
            let grandTotal = parseFloat($('#total').text());
            grandTotal -= total;
            $('#total').text(grandTotal);

            //calculate all 
            let calculateVAtPercent = (5 / 100) * grandTotal; //5% vat
            $('#vat').text(calculateVAtPercent.toFixed(2));

            let payableTotal = calculateVAtPercent + grandTotal;



            $('#payable').text((payableTotal).toFixed(2));
            discount()

            $(button).closest('tr').remove();
        }

        function createInvoice() {

            let total = $('#total').text();
            console.log(total)
            let discount = $('#discount').text();
            let vat = $('#vat').text();
            let payable = $('#payable').text();
            let customerId = $('#CId').text();
            let products = $('#invoiceList').find('tr').length;

            if (!customerId) {
                errorToast("Customer is Empty");
            } else if (products <= 0) {
                errorToast("Please Add Some Products");
            } else {
                let productList = [];
                $('#invoiceList').find('tr').each(function() {

                    let product_id = $(this).data('id');
                    let qty = $(this).find('td:nth-child(2)').text();
                    let sale_price = $(this).find('td:nth-child(3)').text();

                    productList.push({
                        'product_id': product_id,
                        'qty': qty,
                        'sale_price': sale_price
                    })
                })
                if (!total) {
                    errorToast("Total is Empty");
                } else if (!discount) {
                    errorToast("Discount is Empty");
                } else if (!vat) {
                    errorToast("Vat is Empty");
                } else if (!payable) {
                    errorToast("Payable is Empty");
                } else {

                    showLoader()
                    $.ajax({
                        type: "Post",
                        url: "/invoice-create",
                        data: {
                            total: total,
                            discount: discount,
                            vat: vat,
                            payable: payable,
                            customerId: customerId,
                            products: productList
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.status == '200') {
                                successToast(response.message);
                                hideLoader();
                                window.location.href = '/invoicePage';
                            } else {
                                errorToast(response.message);
                                hideLoader();
                            }
                        }
                    })
                }
            }


        }
    </script>
@endsection
