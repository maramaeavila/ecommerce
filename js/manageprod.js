$(document).ready(function () {
  $("#addModal").on("show.bs.modal", function () {
    console.log("Add Product modal opened.");
  });

  $("form").on("submit", function (e) {
    var isValid = true;

    $(this)
      .find("input[required], textarea[required], select[required]")
      .each(function () {
        if ($(this).val().trim() === "") {
          isValid = false;
          $(this).addClass("is-invalid");
        } else {
          $(this).removeClass("is-invalid");
        }
      });

    if (!isValid) {
      e.preventDefault();
      alert("Please fill in all required fields.");
    }
  });

  $("input, textarea, select").on("input", function () {
    $(this).removeClass("is-invalid");
  });
});

$(document).ready(function () {
  $(document).on("click", ".btn-warning", function () {
    var row = $(this).closest("tr");
    var prod_id = row.find("td:first").text();

    $.ajax({
      url: "fetchproduct.php",
      type: "POST",
      data: { prod_id: prod_id },
      dataType: "json",
      success: function (response) {
        $("#xproductid").val(response.id);
        $("#xproductname").val(response.product_name);
        $("#xcategory").val(response.category);
        $("#xbrand").val(response.brand);
        $("#xmodel").val(response.model);
        $("#xprice").val(response.price);
        $("#xproddescription").val(response.proddescription);

        $("#xproductimage_preview").attr("src", response.image);

        $("#editproduct").modal("show");
      },
    });
  });

  $("#xproductimage").change(function () {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#xproductimage_preview").attr("src", e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
  });

  $("#editProductForm").submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("xproductid", $("#xproductid").val());

    $.ajax({
      url: "updateprod.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Product updated successfully.",
        }).then(() => {
          $("#editproduct").modal("hide");
          location.reload();
        });
      },
      error: function () {
        Swal.fire("Error!", "Failed to update product.", "error");
      },
    });
  });
});

$(".btn-danger").click(function () {
  var row = $(this).closest("tr");
  var prod_id = row.find("td:first").text();
  var prod_name = row.find("td:nth-child(2)").text();

  Swal.fire({
    title: "Are you sure?",
    text: `Delete product: ${prod_name}?`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "deleteproduct.php",
        type: "POST",
        data: { prod_id: prod_id },
        success: function (response) {
          Swal.fire("Deleted!", "Product has been deleted.", "success");
          row.fadeOut(500, function () {
            $(this).remove();
          });
        },
        error: function () {
          Swal.fire("Error!", "Failed to delete product.", "error");
        },
      });
    }
  });
});
