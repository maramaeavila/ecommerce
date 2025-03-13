<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["xproductid"];
    $product_name = $_POST["xproductname"];
    $category = $_POST["xcategory"];
    $brand = $_POST["xbrand"];
    $model = $_POST["xmodel"];
    $price = $_POST["xprice"];
    $proddescription = $_POST["xproddescription"];

    $uploadDir = "uploads/";
    $imagePath = "";

    if (!empty($_FILES["xproductimage"]["name"])) {
        $imageName = basename($_FILES["xproductimage"]["name"]);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES["xproductimage"]["tmp_name"], $imagePath)) {
            $query = "UPDATE products SET 
                      product_name = ?, category = ?, brand = ?, model = ?, price = ?, proddescription = ?, image = ? 
                      WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssdsi", $product_name, $category, $brand, $model, $price, $proddescription, $imagePath, $id);
        } else {
            echo json_encode(["error" => "Failed to upload image"]);
            exit;
        }
    } else {
        $query = "UPDATE products SET 
                  product_name = ?, category = ?, brand = ?, model = ?, price = ?, proddescription = ? 
                  WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $product_name, $category, $brand, $model, $price, $proddescription, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => "Product updated successfully"]);
    } else {
        echo json_encode(["error" => "Update failed"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
