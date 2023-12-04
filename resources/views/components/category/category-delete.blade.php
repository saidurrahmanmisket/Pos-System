<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()"  type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // delete operation
    function itemDelete(){
        //get deleteID value which is set from category-list
        $deleteID = $('#deleteID').val();
        $.ajax({
            type: "Post",
            url: "/category-delete",
            data: {'category_id': $deleteID},
            success: function (response) {
                if (response.status == 'success') {
                    successToast(response.message);
                    getTableData();
                    $("#delete-modal").modal('hide');
                } else if (response.status == 'error') {
                    errorToast(response.message);
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                errorToast(textStatus, errorThrown);
            }
        });
    }
</script>
