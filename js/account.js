document
  .getElementById("change-password-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("changepassword.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        Swal.fire({
          title: data.title,
          text: data.message,
          icon: data.status,
        }).then(() => {
          if (data.redirect) {
            window.location.href = data.redirect;
          }
        });
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });

function changepw() {
  if ($("#register-password").val() == "") {
    alert("Please input Password");
    $("#register-password").focus();
    return false;
  } else if ($("#register-confirmpassword").val() == "") {
    alert("Please input Confirm Password");
    $("#register-confirmpassword").focus();
    return false;
  } else if (
    $("#register-confirmpassword").val() != $("#register-password").val()
  ) {
    alert("Password must be same with confirm password!");
    $("#register-confirmpassword").focus();
    return false;
  }

  $.ajax({
    url: "changepassword.php",
    data: $("#account-form").serialize(),
    type: "POST",
    success: function (msg) {
      alert(msg);
    },
  });
}
