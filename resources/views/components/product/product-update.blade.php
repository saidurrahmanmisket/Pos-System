<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                                <br />
                                <img class="w-15" id="oldImg" src="{{ asset('images/default.jpg') }}" />
                                <br />
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control"  id="productImgUpdate">

                                <input type="text" class="" id="updateID">
                                <input type="text" class="" id="filePath">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>

        </div>
    </div>
</div>


{{-- <script>



    async function UpdateFillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }


    async function FillUpUpdateForm(id,filePath){

        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;


        showLoader();
        await UpdateFillCategoryDropDown();

        let res=await axios.post("/product-by-id",{id:id})
        hideLoader();

        document.getElementById('productNameUpdate').value=res.data['name'];
        document.getElementById('productPriceUpdate').value=res.data['price'];
        document.getElementById('productUnitUpdate').value=res.data['unit'];
        document.getElementById('productCategoryUpdate').value=res.data['category_id'];

    }



    async function update() {

        let productCategoryUpdate=document.getElementById('productCategoryUpdate').value;
        let productNameUpdate = document.getElementById('productNameUpdate').value;
        let productPriceUpdate = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let updateID=document.getElementById('updateID').value;
        let filePath=document.getElementById('filePath').value;
        let productImgUpdate = document.getElementById('productImgUpdate').files[0];


        if (productCategoryUpdate.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productNameUpdate.length===0){
            errorToast("Product Name Required !")
        }
        else if(productPriceUpdate.length===0){
            errorToast("Product Price Required !")
        }
        else if(productUnitUpdate.length===0){
            errorToast("Product Unit Required !")
        }

        else {

            document.getElementById('update-modal-close').click();

            let formData=new FormData();
            formData.append('img',productImgUpdate)
            formData.append('id',updateID)
            formData.append('name',productNameUpdate)
            formData.append('price',productPriceUpdate)
            formData.append('unit',productNameUpdate)
            formData.append('category_id',productCategoryUpdate)
            formData.append('file_path',filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/update-product",formData,config)
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Request completed');
                document.getElementById("update-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script> --}}

<script>
    function setCategory(id) {
        showLoader();
        $('#productCategoryUpdate').empty();
        $.ajax({
            type: "get",
            url: "/category-list",
            success: function(response) {
                if (response.status == 'success') {
                    hideLoader();
                    response.data.forEach(function(item, i) {
                        let option = `<option value="${item['id']}">${item['name']}</option>`;
                        $('#productCategoryUpdate').append(option);
                        if (item['id'] == id) {
                            $('#productCategoryUpdate').val(item['id']);
                        }
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
    } //this function is called from setFromValue function

    function setFromValue(id) {
        $("#update-modal").modal('show');

        showLoader();
        $.ajax({
            type: "get",
            url: "/product-by-id",
            data: {
                product_id: id
            },
            success: function(response) {
                if (response.status === 200) {
                    console.log(response);
                    setCategory(response.product.category_id);//get category option data
                    let imgPath = 'images/product/' + response.product.img_url;
                    $('#oldImg').attr('src', imgPath);
                    // console.log(response.product.img_url);
                    // $('#productImgUpdate').val(response.product.img_url);
                    $('#productNameUpdate').val(response.product.name);
                    $('#productPriceUpdate').val(response.product.price);
                    $('#productUnitUpdate').val(response.product.unit);
                    $('#updateID').val(response.product.id);
                    $('#filePath').val(response.product.img_url);
                } else {
                    hideLoader();
                    errorToast(response.message);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                hideLoader();
                errorToast(textStatus, errorThrown);
            }
        });
        hideLoader();

    }

    function update() {
        let productCategoryUpdate = $('#productCategoryUpdate').val();
        let productNameUpdate = $('#productNameUpdate').val();
        let productPriceUpdate = $('#productPriceUpdate').val();
        let productUnitUpdate = $('#productUnitUpdate').val();
        let productImgUpdate = $('#productImgUpdate').prop('files')[0];
        if (productImgUpdate === undefined) {
            productImgUpdate = $('#oldImg').prop('src');	
        }
        let updateID = $('#updateID').val();
        let filePath = $('#filePath').val();


        if (productCategoryUpdate.length === 0) {
            errorToast("Product Category Required!")
        } else if (productNameUpdate.length === 0) {
            errorToast("Product Name Required!")
        } else if (productPriceUpdate.length === 0) {
            errorToast("Product Price Required!")
        } else if (productUnitUpdate.length === 0) {
            errorToast("Product Unit Required!")
        }
        else {
            let formData = new FormData();
            formData.append('category_id', productCategoryUpdate);
            formData.append('name', productNameUpdate);
            formData.append('price', productPriceUpdate);
            formData.append('unit', productUnitUpdate);
            formData.append('image', productImgUpdate);
            formData.append('product_id', updateID);
            formData.append('file_path', filePath);
            showLoader();
            $.ajax({
                type: "post",
                url: "/product-update",
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
                            errorToast(response.message);
                        }
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    hideLoader();
                    errorToast(textStatus, errorThrown);
                }
            });
            hideLoader();
        }
    }
</script>
