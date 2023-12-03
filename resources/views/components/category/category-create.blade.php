<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryName">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary " data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    // on click 
    function Save() {
        var saveButton = $('#save-btn');
        var categoryName = $('#categoryName').val();
        if (categoryName.length == 0) {
            errorToast("Category Required !")
        } 
        else {
            $('#modal-close').click();
            $.ajax({
                type: "post",
                url: "/category-create",
                data: {
                    "name": categoryName
                },
                success: function(response) {
                    if (response.status === "success") {
                        successToast('Request completed');
                        $('#save-form')[0].reset();
                        getTableData();
                    } else {
                        errorToast("Request fail !");
                    }
                }
            });

        }
    }
    //on submit call save function
    $('#save-form').submit(function (e) { 
        e.preventDefault();
        Save();
        
    });
</script>
