<?php include("common.php");?>
<style>
#otp-form {
  display: none;
}
.login-form.slide-out {
  animation: slideOut 0.5s forwards;
}
.login-form.slide-in {
  animation: slideIn 0.5s forwards;
}
.otp-form.slide-in {
  animation: slideIn 0.5s forwards;
}
.otp-form.slide-out {
  animation: slideOut 0.5s forwards;
}

@keyframes slideOut {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-120%);
  }
}

@keyframes slideIn {
  from {
    transform: translateX(120%);
  display: block;
  opacity: 0;
  visibility: hidden;
  }
  to {
    transform: translateX(0);
    display: block;
    opacity: 1;
    visibility: visible;
  }
}

  </style>

<div class="container-fluid d-flex flex-column justify-content-between pt-5 px-4 login-page">
  <section>
    <div class="logo mx-auto mb-5">
      <img src="assets/img/logo.png" alt="alliee" class="logo">
    </div>
    <h2 class="my-5 text-center">Smart&nbsp;Touch<br>Panel&nbsp;<span>Selection</span></h2>
   
    <div class="login-wrapper">
    <div class="login-form mb-5 text-center" id="login-form">
      <div class="mb-4">
        <label for="mobile" class="form-label">Login with Mobile Number</label>
        <input type="number" class="form-control mobile-input" id="mobile" maxlength="10" placeholder="Enter your 10 Digit Mobile Number">
      </div>
      <button type="button" class="btn btn-blue" id="get-otp-button">GET OTP</button>
    </div>

    <div class="otp-form text-center" id="otp-form">
      <form >
        <div class="mb-4">
          <label for="mobile" class="form-label">Enter OTP : </label>
          <div class="otp">
            <input type="number" class="form-control mobile-input otpf" id="otp1" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" id="otp2" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" id="otp3" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" id="otp4" maxlength="1">
          </div>
        </div>
        <button type="button" class="btn btn-blue" id="verifyOtp">LOGIN</button>
      </form>
      <p class="mt-2 d-flex justify-content-between"><button type="button" class="btn">RESEND</button><button type="button" class="btn" id="change-number">CHANGE NUMBER</button></p>
    </div>
  </div>

  </section>
  
  <div class="login-image">
  </div>

</div>
<script>

$(document).ajaxStart(function() {
        $("#ajax-progress").show();
    });

    $(document).ajaxStop(function() {
        $("#ajax-progress").hide();
    });

document.addEventListener("DOMContentLoaded", function() {  


document.getElementById("verifyOtp").addEventListener("click", function() {
    // Get the OTP values from the input fields
    var otp1 = document.getElementById("otp1").value;
    var otp2 = document.getElementById("otp2").value;
    var otp3 = document.getElementById("otp3").value;
    var otp4 = document.getElementById("otp4").value;

    // Concatenate the OTP values
    var otp = otp1 + otp2 + otp3 + otp4;
    var mobileNumber = document.querySelector("#mobile").value;

    if(otp.length == 4){
    
    $("#ajax-progress").show();
    $.ajax({
        type: "POST",
        url: "verifyotp.php",
        data: { otp: otp, mobile: mobileNumber },
        success: function(response) {
          if (response.startsWith("1,")) {
            window.location.href = "dashboard.php";
          }else if (response.startsWith("2,")) {
            window.location.href = "profile.php";
          } else {
            alert("Error: " + response);
          }
        },
        error: function(error) {
            console.log("Error:", error);
        },
        complete: function() {
          $("#ajax-progress").hide();
        }
    });
    }else{
      alert("Invalid OTP")
    }
});
  const mobileInputs = document.querySelectorAll(".mobile-input");
  mobileInputs.forEach(function(input) {
    input.addEventListener("input", function() {
      const maxLength = parseInt(this.getAttribute('maxlength'));
      if (this.value.length > maxLength) {
        this.value = this.value.slice(0, maxLength);
      }
    });
  });

  const otpFields = document.querySelectorAll(".otpf");

  otpFields.forEach(function(input, index, otpFields) {
    input.addEventListener("input", function() {
      if (this.value.length === 1 && index < otpFields.length - 1) {
        otpFields[index + 1].focus();
      }
    });

    // Handle backspace to move to the previous field
    input.addEventListener("keydown", function(event) {
      if (event.key === "Backspace") {
        if (index > 0) {
          otpFields[index - 1].focus();
        }
        if(index == 3){
          otpFields[index].value = "";
          otpFields[index - 1].focus();
        }
      }
    });
  });


  const loginForm = document.getElementById("login-form");
  const otpForm = document.getElementById("otp-form");
  const getOtpButton = document.getElementById("get-otp-button");
  const changenumber = document.getElementById("change-number");

  getOtpButton.addEventListener("click", function() {
    var mobileNumber = document.querySelector("#mobile").value;
    // Validate mobile number
    if (mobileNumber.trim() === "") {
      alert("Please enter a mobile number.");
      return;
    }

    // Check if it's a 10-digit Indian mobile number
    if (!isValidIndianMobileNumber(mobileNumber)) {
      alert("Please enter a valid 10-digit Indian mobile number.");
      return;
    }

    $.ajax({
        type: "POST",
        url: "loginrequest.php",
        data: { mobile: mobileNumber },
        success: function(response) {
          if (response.startsWith("0,")) {
            document.querySelector(".otpf").focus();
            otpForm.classList.remove("slide-out");
            loginForm.classList.remove("slide-in");
            loginForm.classList.add("slide-out");
            otpForm.classList.add("slide-in");
            otpForm.style.display = "block";

            var otpValue = response.split(",")[1].trim();
            console.log(otpValue);
            for (var i = 0; i < otpValue.length; i++) {
                var inputField = document.getElementById("otp" + (i + 1));
                if (inputField) {
                    inputField.value = otpValue[i];
                }
            }
            setTimeout(function() {
                document.querySelector(".otpf").focus();
            }, 500);
          }else{
            var errorMessage = response.split(",")[1].trim();
            alert(errorMessage);
          }
        },
        error: function(error) {
            console.log("Error:", error);
        },
        complete: function() {
          $("#ajax-progress").hide();
        }
    });
  });

  changenumber.addEventListener("click", function() {
    loginForm.classList.remove("slide-out");
    otpForm.classList.remove("slide-in");
    otpForm.classList.add("slide-out");
    loginForm.classList.add("slide-in");
    loginForm.style.display = "block";
  });
});
function isValidIndianMobileNumber(mobileNumber) {
    var indianMobileNumberRegex = /^[6789]\d{9}$/;
    return indianMobileNumberRegex.test(mobileNumber);
}
</script>

<?php include("footer.php");?>