
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--=============== basic  ===============-->
        
     
        <!--=============== css  ===============-->
        <link type="text/css" rel="stylesheet" href="{{url('public/css/invoice.css')}}">
        <!--=============== favicons ===============-->
        <link rel="shortcut icon" href="{{url('public/images/favicon.ico')}}">

        

        <script src="{{url('public/js/jquery.min.js')}}"></script>
        <style>
            .lds-dual-ring {
  /* display: inline-block; */

}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 16px;
  height: 16px;
  margin: 8px;
  border-radius: 50%;
  border: 3px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.form-control{
    display: block;
    width: 100%;
    padding: 0.469rem 0.735rem
rem
;
    font-size: 0.9375rem;
    font-weight: 400;
    line-height: 1.4;
    color: #677788;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #d4d8dd;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    
}

        </style>
    </head>
    <body>
        <div class="invoice-box">
            <div id="sendotp">
            <p>Send an OTP to the Registered Email</p>
            <div class="text-center">
                <div style="display: none" id="error"></div>
            </div>
            <a onclick="SendOTP()" id="submitbtn" class="print-button">
                <div class="lds-dual-ring" style="display: none"></div>
               <span id="btntext">Send OTP</span></a> 
            </div>
            <div id="verifyotp" style="display: none">
                <p>Enter OTP</p>
                <div class="text-center">
                    <div style="display: none" id="error2"></div>
                </div>
                <input class="form-control" id="otp" type="number">
                <a onclick="VerifyOTP()" id="submitbtn2" class="print-button">
                    <div class="lds-dual-ring2" style="display: none"></div>
                   <span id="btntext2">Verify OTP</span></a> 
            </div>
            </div>
       <script>

        function SendOTP(){
  $.ajax({
            type: "GET",
            url: "{{route('SendOTP')}}",
            data: { email: "{{$data[0]->school_email}}" } ,
            beforeSend: function() {
                $("#submitbtn").prop('disabled', true)
                $("#btntext").hide();
                $(".lds-dual-ring").show();
            },
            success: function(data) {
                $("#submitbtn").prop('disabled', false)
                $("#btntext").show();
                $(".lds-dual-ring").hide();
                if (data['success'] == true) {
                    $("#error").show().addClass('alert alert-success').html(data['message']);
                    $('#sendotp').hide();
                    $('#verifyotp').show();
                } else {
                    $("#error").show().addClass('alert alert-danger').html(data['message']);
                }
            }

        })
}

function VerifyOTP(){
    if($('#otp').val() == null || $('#otp').val() == ""){
        $("#error").show().addClass('alert alert-danger').html("Please Fill In the OTP");
    }
    $.ajax({
            type: "GET",
            url: "{{route('VerifyOTP')}}",
            data: { email: "{{$data[0]->school_email}}" , otp: $('#otp').val()} ,
            beforeSend: function() {
                $("#submitbtn2").prop('disabled', true)
                $("#btntext2").hide();
                $(".lds-dual-ring2").show();
            },
            success: function(data) {
                $("#submitbtn2").prop('disabled', false)
                $("#btntext2").show();
                $(".lds-dual-ring2").hide();
                if (data['success'] == true) {
                    $("#error2").show().addClass('alert alert-success').html(data['message']);
                } else {
                    $("#error2").show().addClass('alert alert-danger').html(data['message']);
                }
            }

        })
}
       </script>
    
</body></html>