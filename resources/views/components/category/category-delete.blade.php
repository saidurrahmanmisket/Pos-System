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
                    <button onclick="itemDelete(data.item['id'])" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>

     async  function  itemDelete(){
            let id=document.getElementById('deleteID').value;
            document.getElementById('delete-modal-close').click();
            showLoader();
            let res=await axios.post("/delete-category",{id:id})
            hideLoader();
            if(res.data===1){
                successToast("Request completed")
                await getList();
            }
            else{
                errorToast("Request fail!")
            }
     }

</script> --}}

<script>
    function itemDelete(id){
        // $('#deleteID').val() = $(data.id);
        // console.log(id);
        $deleteID = id;
        $.ajax({
            type: "Post",
            url: "/category-delete",
            data: {'category_id': $deleteID},
            success: function (response) {
                if (response.status == 'success') {
                    successToast(response.message);
                    getList();
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
