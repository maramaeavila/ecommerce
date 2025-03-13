<?php
include "connection.php";

if (isset($_POST['prod_id'])) {
    $prod_id = $_POST['prod_id'];

    error_log("Fetching product: " . $prod_id);

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $prod_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Product not found"]);
    }
} else {
    echo json_encode(["error" => "Product ID not provided"]);
}
