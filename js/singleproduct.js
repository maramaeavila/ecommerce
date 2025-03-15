function changeQty(value) {
  let qtyInput = document.getElementById("qty");
  let currentQty = parseInt(qtyInput.value);
  let maxQty = parseInt(qtyInput.max);

  if (!isNaN(currentQty)) {
    let newQty = currentQty + value;
    if (newQty >= 1 && newQty <= maxQty) {
      qtyInput.value = newQty;
    }
  }
}

function addToCart(productId) {
  let qty = parseInt(document.getElementById("qty").value);

  $.ajax({
    url: "addtocart.php",
    type: "POST",
    data: { product_id: productId, qty: qty },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Added to Cart!",
          text: "Product successfully added to your cart.",
          confirmButtonText: "Go to Cart",
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "cart.php";
          }
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.message,
          confirmButtonText: "OK",
        });
      }
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "An error occurred while adding to cart.",
        confirmButtonText: "OK",
      });
    },
  });
}
