<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">

                                <input type="text" class="d-none" id="updateID">
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
    //edit customer 

    function customerEdit(id) {
        showLoader();
        $.ajax({
            type: "Get",
            url: "/customer-by-id",
            data: {
                customer_id: id
            },
            success: function(response) {
                if (response.status == 'success') {
                    hideLoader();
                    $("#update-modal").modal('show');
                    $('#customerNameUpdate').val(response.data['name']);
                    $('#customerEmailUpdate').val(response.data['email']);
                    $('#customerMobileUpdate').val(response.data['mobile']);
                    $('#updateID').val(response.data['id']);
                } else {
                    errorToast(response.message);
                    hideLoader();
                }
            },
            error: function(error) {
                errorToast(error.responseJSON.message);
            }
        })
        hideLoader();
    }
    
//update customer
    function Update() {
        let name = $('#customerNameUpdate').val();
        let email = $('#customerEmailUpdate').val();
        let mobile = $('#customerMobileUpdate').val();
        let id = $('#updateID').val();
        if (name.length === 0) {
            errorToast("Customer Name Required!")
        } else if (email.length === 0) {
            errorToast("Customer Email Required!")
        } else if (mobile.length === 0) {
            errorToast("Customer Mobile Required!")
        } else {
            showLoader();
            $.ajax({
                type: "Post",
                url: "/customer-update",
                data: {
                    name: name,
                    email: email,
                    mobile: mobile,
                    customer_id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#update-modal').modal('hide');
                        hideLoader();
                        successToast(response.message);
                        $('#update-form')[0].reset();
                        getCustomersData();
                    } else {
                        errorToast(response.message);
                        hideLoader();
                    }
                },
                error: function(error) {
                    errorToast(error.responseJSON.message);
                }
            })
            hideLoader();
        }
    }
</script>
