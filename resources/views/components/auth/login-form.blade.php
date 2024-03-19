<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br />
                    <input id="email" placeholder="User Email" class="form-control" type="email" value="admin@gmail.com" />
                    <br />
                    <input id="password" placeholder="User Password" class="form-control" type="password" value="123456" />
                    <br />
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr />
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{ url('/userRegistration') }}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{ url('/sendOtp') }}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function SubmitLogin() {
        var email = $('#email').val();
        var password = $('#password').val();
        // alert('ahh, you click me')
        if (email.length == 0) {
            errorToast("Email is required");
        } else if (password.length == 0) {
            errorToast("Password is required");
        } else {
            showLoader();
            $.ajax({
                url: '/user-login',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                success: function(res) {
                    if (res.status == 'success') {
                        successToast(res.message);
                        window.location.href = "/dashboard";
                        console.log(res);
                    } else {
                        errorToast(res.message);
                        hideLoader();
                    }
                }
            });


        }
    }
</script>
