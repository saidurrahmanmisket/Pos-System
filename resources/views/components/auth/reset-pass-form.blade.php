<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br />
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password" />
                    <br />
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password" />
                    <br />
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script>
  async function ResetPass() {
        let password = document.getElementById('password').value;
        let cpassword = document.getElementById('cpassword').value;

        if(password.length===0){
            errorToast('Password is required')
        }
        else if(cpassword.length===0){
            errorToast('Confirm Password is required')
        }
        else if(password!==cpassword){
            errorToast('Password and Confirm Password must be same')
        }
        else{
          showLoader()
          let res=await axios.post("/reset-password",{password:password});
          hideLoader();
          if(res.status===200 && res.data['status']==='success'){
              successToast(res.data['message']);
              setTimeout(function () {
                  window.location.href="/userLogin";
              },1000);
          }
          else{
            errorToast(res.data['message'])
          }
        }

    }
</script> --}}

<script>
    function ResetPass() {
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();
        if (password.length == 0) {
            errorToast("Password Requird");
        } else if (cpassword.length == 0) {
            errorToast("Confirm password Requird");
        } else if (password !== cpassword) {
            errorToast("Password not match");
        } else {
            showLoader();
            $.ajax({
                url: '/rest-password',
                type: 'POST',
                data: {
                    password:password
                },
                success: function(res) {
                    if (res.status == 'success') {
                        successToast(res.message);
                        setTimeout(function() {
                            window.location.href = "/userLogin";
                        }, 1000)
                    }else if(res.status == 'expired'){
                        errorToast(res.message);
                        setTimeout(function() {
                            window.location.href = "/sendOtp";
                        }, 1000)
                    } else {
                        errorToast(res.message);
                        console.log(res);
                        hideLoader();
                    }
                }
            });


        }
    }
</script>
