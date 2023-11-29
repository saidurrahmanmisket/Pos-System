<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control"
                                    type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control"
                                    type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();

    function getProfile() {
        showLoader();
        $.ajax({
            type: "GET",
            url: "/user-profile",
            contentType: "application/json",
            dataType: "json",
            success: function(data) {
                hideLoader();
                $("#email").val(data.user.email);
                $("#firstName").val(data.user.firstName);
                $("#lastName").val(data.user.lastName);
                $("#mobile").val(data.user.mobile);
                $("#password").val(data.user.password);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        })
    }

    function onUpdate() {
        var email = $("#email").val();
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();
        var mobile = $("#mobile").val();
        var password = $("#password").val();

        if(firstName.length===0){
            alert("Please enter first name");
            return false;
        }
        if(lastName.length===0){
            alert("Please enter last name");
            return false;
        }
        if(mobile.length===0){
            alert("Please enter mobile number");
            return false;
        }
        if(password.length===0){
            alert("Please enter password");
            return false;
        }
       
        showLoader();
        $.ajax({
            type: "Post",
            url: "/user-update",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                email: email,
                firstName: firstName,
                lastName: lastName,
                mobile: mobile,
                password: password
            }),
            success: function(data) {
                if(data.status==="success"){
                    successToast(data.message);
                }
                hideLoader();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }

        })
    }
</script>
