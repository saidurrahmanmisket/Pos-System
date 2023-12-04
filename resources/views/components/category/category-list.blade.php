<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Category</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Category</th>
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
</div>


<script>
    var tableData = $('#tableData');
    var tableList = $('#tableList');
    getTableData()

    function getTableData() {
        tableData.DataTable().destroy();
        tableList.empty();
        showLoader();
        $.ajax({
            type: "get",
            url: "/category-list",
            success: function(response) {
                if (response.status == 'success') {

                    hideLoader();
                    response.data.forEach(function(item, index) {
                        let row = `<tr>
                                        <td>${index+1}</td>
                                        <td>${item['name']}</td>
                                        <td>
                                            <button data-id="${item['id']}" edit onclick="UpdateForm(${item['id']})" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                                            <button data-id="${item['id']}"  delete  data-bs-toggle="modal" data-bs-target="#delete-modal"  class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>`;
                        tableList.append(row)
                    })

                    //set delete button id
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
                } else if (response.status == 'error') {
                    errorToast(response.message);
                    hideLoader();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorToast(textStatus, errorThrown);
            }

        });

    }
</script>
