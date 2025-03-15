<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "header.php"; ?>

    <section id="cart">
        <div class="container mt-5">
            <h1>My Shopping Cart</h1>
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody id="cart-table">
                    <!-- Cart items will be loaded here -->
                </tbody>
            </table>

            <h4 class="mt-5">Total: ₱ <span id="total-amount">0.00</span></h4>

            <button id="add-selected">Add Selected to Order</button>
        </div>
    </section>

    <section id="banner">
        <div>
            <!--  -->
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadCart() {
                $.ajax({
                    url: "fetchcart.php",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            let cartHTML = "";
                            response.cart.forEach(item => {
                                cartHTML += `
                            <tr>
                                <td><input type="checkbox" class="cart-checkbox" data-price="${item.price * item.quantity}" value="${item.id}"></td>
                                <td>${item.product_name}</td>
                                <td>${item.quantity}</td>
                                <td>₱ ${parseFloat(item.price).toFixed(2)}</td>
                            </tr>
                        `;
                            });
                            $("#cart-table").html(cartHTML);
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "Failed to load cart", "error");
                    }
                });
            }

            loadCart();

            function updateTotal() {
                let total = 0;
                $(".cart-checkbox:checked").each(function() {
                    total += parseFloat($(this).data("price"));
                });
                $("#total-amount").text(total.toFixed(2));
            }

            $(document).on("change", ".cart-checkbox", updateTotal);

            $("#select-all").click(function() {
                $(".cart-checkbox").prop("checked", $(this).prop("checked"));
                updateTotal();
            });

            $("#add-selected").click(function() {
                let selectedItems = [];
                $(".cart-checkbox:checked").each(function() {
                    selectedItems.push($(this).val());
                });

                if (selectedItems.length === 0) {
                    Swal.fire("No Selection", "Please select at least one item.", "warning");
                    return;
                }

                $.ajax({
                    url: "addselectcart.php",
                    type: "POST",
                    data: {
                        cart_ids: selectedItems
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire("Success", response.message, "success");
                            loadCart();
                            $("#total-amount").text("0.00");
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "Failed to add items", "error");
                    }
                });
            });
        });
    </script>

</body>

</html>