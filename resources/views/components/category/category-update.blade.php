<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function UpdateForm(id) {

        $('#update-modal').modal('show');
        showLoader();
        $.ajax({
            type: "get",
            url: "/category-by-id",
            data: {
                'category_id': id
            },
            success: function(response) {
                if (response.status == 'success') {
                    hideLoader();
                    $('#categoryNameUpdate').val(response.data.name);
                    $('#updateID').val(response.data.id);
                } else {
                    errorToast(response.message);
                    hideLoader();

                }
            }
        });

    }

    function Update() {
        $id = $('#updateID').val();
        $name = $('#categoryNameUpdate').val();
        if ($name.length == 0) {
            errorToast("Category name required");
        } else {
            $('#update-modal-close').click();
            showLoader();
            $.ajax({
                type: "post",
                url: "/category-update",
                data: {
                    'category_id': $id,
                    'name': $name
                },
                success: function(response) {
                    if (response.status == 'success') {
                        hideLoader();
                        successToast(response.message);
                        getTableData();
                    } else {
                        errorToast(response.message);
                        hideLoader();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorToast(textStatus, errorThrown);
                }
            });
        }
    }
</script>
