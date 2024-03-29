<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Product</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" onclick="categoryDropdown()" data-bs-target="#create-modal"
                            class="float-end btn m-0  bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">
                        {{-- <tr>
                            <td>${index+1}</td>
                            <td>
                                <img  class="w-15 h-auto" src="{{asset('images/product/1701771414.png')}}" alt="">
                            </td>
                            <td>${item['name']}</td>
                            <td>${item['price']}</td>
                            <td>${item['unit']}</td>
                            <td>
                                <button data-id="${item['id']}" edit onclick="UpdateForm(${item['id']})" class="btn editBtn btn-sm bg-gradient-success">Edit</button>
                                <button data-id="${item['id']}"  delete  data-bs-toggle="modal" data-bs-target="#delete-modal"  class="btn deleteBtn btn-sm bg-gradient-danger">Delete</button>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    function productList() {
        var tableData = $('#tableData');
        var tableList = $('#tableList');
        tableData.DataTable().destroy();
        tableList.empty();

        showLoader();
        $.ajax({
            type: "get",
            url: "/product-list",
            success: function(response) {
                if (response.status === 200) {
                    hideLoader();
                    response.product.forEach(function(item, index) {
                        let row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>
                                            <img class="w-15 h-auto" src="${item['img_url'] ? 'images/product/' + item['img_url'] : 'images/default.jpg'}" alt="">
                                        </td>
                                        <td>${item['name']}</td>
                                        <td>${item['price']}</td>
                                        <td>${item['unit']}</td>
                                        <td>
                                            <button data-id="${item['id']}"  onclick="setFromValue(${item['id']})" class="btn editBtn btn-sm bg-gradient-success">Edit</button>
                                            <button data-id="${item['id']}" data-img_url="${item['img_url']}" class="btn deleteBtn btn-sm bg-gradient-danger">Delete</button>
                                        </td>
                                    </tr>`;

                        tableList.append(row)

                    })
                    tableData.DataTable({
                        order: [
                            [0, 'desc']
                        ],
                        lengthMenu: [10, 20, 50, 100, 500, 1000]
                    });
                    //set delete button id
                    // $('.editBtn').on('click', function() {
                    //     let id = $(this).data('id');
                    //     $("#update-modal").modal('show');
                    //     $("#deleteID").val(id);
                    //     $("#deleteFilePath").val(item['img_url'])


                    // })
                    $('.deleteBtn').on('click', function() {
                        let id = $(this).data('id');
                        let img_url = $(this).data('img_url');
                        $("#delete-modal").modal('show');
                        $("#deleteID").val(id);
                        $("#deleteFilePath").val(img_url)

                    })
                }
            }
        });
    }



    productList()
</script>
