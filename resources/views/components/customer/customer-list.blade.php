<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Customer</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
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


<script>
    //showing customer data
    function getCustomersData() {
        var tableData = $('#tableData');
        var tableList = $('#tableList');
        tableData.DataTable().destroy();
        tableList.empty();
        showLoader();
        $.ajax({
            type: "get",
            url: "/customer-list",
            success: function(response) {
                if (response.status == 'success') {
                    hideLoader();
                    // $('#tableList').empty();
                    response.data.forEach(function(item, index) {
                        let row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>${item['name']}</td>
                                        <td>${item['email']}</td>
                                        <td>${item['mobile']}</td>
                                        <td>
                                            <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                                            <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>`
                        $('#tableList').append(row)
                    });

                    //click event of edit and delete customer and set value 
                    $('.editBtn').on('click', function() {
                        let id = $(this).data('id');
                        $('#updateID').val(id);
                        customerEdit(id);
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
    getCustomersData();

    

</script>
