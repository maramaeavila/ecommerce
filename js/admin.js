document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll("main.content section");
  const links = document.querySelectorAll(".sidebar ul li a");

  function showSection(sectionId) {
    sections.forEach((section) => (section.style.display = "none"));

    const activeSection = document.getElementById(sectionId);

    if (activeSection) {
      activeSection.style.display = "block";
    } else {
      console.warn(
        `Section with ID "${sectionId}" not found! Defaulting to "products".`
      );
      localStorage.setItem("activeSection", "products");
      document.getElementById("products").style.display = "block";
    }

    links.forEach((link) => link.classList.remove("active"));

    const activeLink = document.querySelector(
      `.sidebar ul li a[href="#${sectionId}"]`
    );
    if (activeLink) {
      activeLink.classList.add("active");
    }

    localStorage.setItem("activeSection", sectionId);
  }

  const savedSection = localStorage.getItem("activeSection") || "products";
  showSection(savedSection);

  links.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const targetId = this.getAttribute("href").substring(1);
      showSection(targetId);
    });
  });
});

$(document).ready(function () {
  $(".add-stock-form").submit(function (event) {
    event.preventDefault();

    let form = $(this);
    let formData = form.serialize();

    $.ajax({
      url: "updatestock.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            title: "Success!",
            text: response.message,
            icon: "success",
            confirmButtonText: "OK",
          });

          let stockCell = form.closest("tr").find(".stock-value");
          let currentStock = parseInt(stockCell.text());
          let addedStock = parseInt(form.find("input[name='new_stock']").val());
          stockCell.text(currentStock + addedStock);

          form.find("input[name='new_stock']").val("");
        } else {
          Swal.fire({
            title: "Error!",
            text: response.message,
            icon: "error",
            confirmButtonText: "OK",
          });
        }
      },
    });
  });
});

function confirmAdminUpgrade(event, userName, userId) {
  event.preventDefault();

  Swal.fire({
    title: "Are you sure?",
    text: "You are promoting " + userName + " to admin!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, make admin!",
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById("makeAdminForm-" + userId).submit();
    }
  });
}
