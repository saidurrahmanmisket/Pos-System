<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form" enctype="multipart/form-data">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Price<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Unit<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="productUnit">

                                <br />
                                <img class="w-15" id="newImg" src="{{ asset('images/default.jpg') }}" />
                                <br />

                                <label class="form-label">Image<span class="text-danger">*</span></label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control" id="productImg">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>


{{-- <script>



    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })
    }


    async function Save() {

        let productCategory=document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productImg = document.getElementById('productImg').files[0];

        if (productCategory.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productName.length===0){
            errorToast("Product Name Required !")
        }
        else if(productPrice.length===0){
            errorToast("Product Price Required !")
        }
        else if(productUnit.length===0){
            errorToast("Product Unit Required !")
        }
        else if(!productImg){
            errorToast("Product Image Required !")
        }

        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',productImg)
            formData.append('name',productName)
            formData.append('price',productPrice)
            formData.append('unit',productUnit)
            formData.append('category_id',productCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/create-product",formData,config)
            hideLoader();

            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script> --}}

<script>
    // category dropdown
    function categoryDropdown() {
        showLoader();
        $.ajax({
            type: "get",
            url: "/category-list",
            success: function(response) {
                if (response.status == 'success') {
                    hideLoader();
                    response.data.forEach(function(item, i) {
                        let option = `<option value="${item['id']}">${item['name']}</option>`;
                        $('#productCategory').append(option);
                    });
                } else {
                    hideLoader();
                    errorToast(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                errorToast(textStatus, errorThrown);
            }
        });
    }

    // save
    function Save() {
        let productCategory = $('#productCategory').val();
        let productName = $('#productName').val();
        let productPrice = $('#productPrice').val();
        let productUnit = $('#productUnit').val();
        let productImg = $('#productImg').prop('files')[0];

        if (productCategory.length === 0) {
            errorToast("Product Category Required!")
        }
        else if (productName.length === 0) {
            errorToast("Product Name Required!")
        } else if (productPrice.length === 0) {
            errorToast("Product Price Required!")
        } else if (productUnit.length === 0) {
            errorToast("Product Unit Required!")
        } else if (!productImg) {
            errorToast("Product Image Required!")
        }
        else {
            let formData = new FormData();
            formData.append('category_id', productCategory);
            formData.append('name', productName);
            formData.append('price', productPrice);
            formData.append('unit', productUnit);
            formData.append('image', productImg);
            showLoader();
            $.ajax({
                type: "post",
                url: "/product-create",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,

                data: formData,
                success: function(response) {
                    hideLoader();
                    if (response.status === 200) {
                        $('#create-modal').modal('hide');
                        $('#save-form')[0].reset();
                        $('#newImg').attr('src', '{{ asset('images/default.jpg') }}');
                        successToast(response.message);
                        productList();
                    } else {
                        hideLoader();
                        if (response.status === 422 && response.message) {
                            console.log(response.message);
                            Object.values(response.message).forEach(error => {
                                errorToast(error[0]);
                            });
                        } else {
                            errorToast(response.errors);
                        }
                    }
                }
            });
            hideLoader();
        }

    }
</script>
