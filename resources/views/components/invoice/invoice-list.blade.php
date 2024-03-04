<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h5>Invoices</h5>
                    </div>
                    <div class="align-items-center col">
                        <a href="{{ url('/salePage') }}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Vat</th>
                            <th>Discount</th>
                            <th>Payable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- 
<script>
    getList();


    async function getList() {


        showLoader();
        let res = await axios.get("/invoice-select");
        hideLoader();

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(item, index) {
            let row = `<tr>
                    <td>${index+1}</td>
                    <td>${item['customer']['name']}</td>
                    <td>${item['customer']['mobile']}</td>
                    <td>${item['total']}</td>
                    <td>${item['vat']}</td>
                    <td>${item['discount']}</td>
                    <td>${item['payable']}</td>
                    <td>
                        <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm fa-eye"></i></button>
                        <button data-id="${item['id']}" data-cus="${item['customer']['id']}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-trash-alt"></i></button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.viewBtn').on('click', async function() {
            let id = $(this).data('id');
            let cus = $(this).data('cus');
            await InvoiceDetails(cus, id)
        })

        $('.deleteBtn').on('click', function() {
            let id = $(this).data('id');
            document.getElementById('deleteID').value = id;
            $("#delete-modal").modal('show');
        })

        new DataTable('#tableData', {
            order: [
                [0, 'desc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script> --}}
 
<script>
    //showing customer data
    function invoiceList() {
        var tableData = $('#tableData');
        var tableList = $('#tableList');
        tableData.DataTable().destroy();
        tableList.empty();
        showLoader();
        $.ajax({
            type: "get",
            url: "/invoice-select",
            success: function(response) {
                if (response.status == '200') {
                    hideLoader();
                    console.log(response.data)
                    response.data.forEach(function(item, index) {
                        let row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>${item.customer['name']}</td>
                                        <td>${item.customer['mobile']}</td>
                                        <td>${item['total']}</td>
                                        <td>${item['vat']}</td>
                                        <td>${item['discount']}</td>
                                        <td>${item['payable']}</td>
                                        <td>
                                            <button data-id="${item['id']}" data-customer_id="${item.customer['id']}" class="btn viewBtn btn-sm btn-outline-success">view</button>
                                            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>`
                        $('#tableList').append(row)
                    });

                    //click event of edit and delete customer and set value 
                    $('.viewBtn').on('click', function() {
                        let invoice_id = $(this).data('id');
                        let customer_id = $(this).data('customer_id');
                        console.log(invoice_id, customer_id)
                        // $("#details-modal").modal('show');
                        InvoiceDetails(customer_id, invoice_id)
                        
                    })

                    $('.deleteBtn').on('click', function() {
                        let id = $(this).data('id');
                        $("#delete-modal").modal('show');
                        $("#deleteID").val(id);
                    })
                    
                    tableData.DataTable({
                        order: [
                            [0, 'desc']
                        ],
                        lengthMenu: [5, 10, 15, 20, 30]
                    });
                };
            }
        })
    }
    invoiceList();

    

</script>