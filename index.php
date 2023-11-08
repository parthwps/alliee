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
      <form action="dashboard.php" method="post">
        <div class="mb-4">
          <label for="mobile" class="form-label">Enter OTP : </label>
          <div class="otp">
            <input type="number" class="form-control mobile-input otpf" id="otpf" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" maxlength="1">
            <input type="number" class="form-control mobile-input otpf" maxlength="1">
          </div>
        </div>
        <button type="submit" class="btn btn-blue">LOGIN</button>
      </form>
      <p class="mt-2 d-flex justify-content-between"><button type="button" class="btn">RESEND</button><button type="button" class="btn" id="change-number">CHANGE NUMBER</button></p>
    </div>
  </div>

  </section>
  
  <div class="login-image">
  </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    
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
    document.querySelector(".otpf").focus();
    otpForm.classList.remove("slide-out");
    loginForm.classList.remove("slide-in");
    loginForm.classList.add("slide-out");
    otpForm.classList.add("slide-in");
    otpForm.style.display = "block";
    setTimeout(function() {
      document.querySelector(".otpf").focus();
    }, 500);
  });

  changenumber.addEventListener("click", function() {
    loginForm.classList.remove("slide-out");
    otpForm.classList.remove("slide-in");
    otpForm.classList.add("slide-out");
    loginForm.classList.add("slide-in");
    loginForm.style.display = "block";
  });
});
</script>

<?php include("footer.php");?>