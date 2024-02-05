<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobile">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function Save() {
        let name = $('#customerName').val();
        let email = $('#customerEmail').val();
        let mobile = $('#customerMobile').val();
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
                url: "/customer-create",
                data: {
                    name: name,
                    email: email,
                    mobile: mobile
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $("#create-modal").modal('hide');
                        successToast(response.message);
                        $('#save-form')[0].reset();
                        getCustomersData();
                    } else if (response.status == 'error') {
                        errorToast(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    errorToast(textStatus, errorThrown);
                }
            });
            hideLoader();
        }
    }
</script>
