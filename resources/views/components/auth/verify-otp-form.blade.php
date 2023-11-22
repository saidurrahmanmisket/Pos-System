<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
   async function VerifyOtp() {
        let otp = document.getElementById('otp').value;
        if(otp.length !==4){
           errorToast('Invalid OTP')
        }
        else{
            showLoader();
            let res=await axios.post('/verify-otp', {
                otp: otp,
                email:sessionStorage.getItem('email')
            })
            hideLoader();

            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message'])
                sessionStorage.clear();
                setTimeout(() => {
                    window.location.href='/resetPassword'
                }, 1000);
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }
</script> --}}


<script>
    function VerifyOtp() {
        var otp = $('#otp').val();
        if (otp.length !== 4) {
            errorToast("Need 4 Degit OTP");
        } else {
            showLoader();
            $.ajax({
                url: '/verify-otp',
                type: 'POST',
                data: {
                    email: sessionStorage.getItem('email'),
                    otp: otp
                },
                success: function(res) {
                    if (res.status == 'success') {
                        successToast(res.message);
                        sessionStorage.clear();
                        setTimeout(function(){
                            window.location.href = "/resetPassword";
                        }, 1000)
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