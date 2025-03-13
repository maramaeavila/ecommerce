<?php
include "connection.php";

if (isset($_POST['addProduct'])) {
    $product_name = $_POST['productname'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['productprice'];
    $proddescription = $_POST['proddescription'];

    $image_name = $_FILES['productimage']['name'];
    $image_tmp = $_FILES['productimage']['tmp_name'];
    $image_path = "uploads/" . $image_name;

    move_uploaded_file($image_tmp, $image_path);

    $query = "INSERT INTO products (product_name, category, brand, model, price, proddescription, image) 
              VALUES ('$product_name', '$category', '$brand', '$model', '$price', '$proddescription', '$image_path')";

    if ($conn->query($query) === TRUE) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'Product added successfully!',
                icon: 'success'
            }).then(function() {
                window.location.href = 'admin.php';
            });
        });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to add product. Try again!',
                icon: 'error'
            });
        });
        </script>";
    }
}
