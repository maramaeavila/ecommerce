<?php
include "connection.php";

if (isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];

    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
