<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_email'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$email = $_SESSION['user_email'];

if (!isset($_POST['product_id']) || !isset($_POST['qty'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$product_id = intval($_POST['product_id']);
$qty = intval($_POST['qty']);

if ($product_id <= 0 || $qty <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid product or quantity"]);
    exit();
}

$user_query = "SELECT id FROM users WHERE email = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit();
}

$user = $user_result->fetch_assoc();
$user_id = $user['id'];

$product_query = "SELECT product_name, category, brand, model, price, image, stock FROM products WHERE id = ?";
$product_stmt = $conn->prepare($product_query);
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

if ($product_result->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "Product not found"]);
    exit();
}

$product = $product_result->fetch_assoc();
$stock = $product['stock'];

if ($qty > $stock) {
    echo json_encode(["status" => "error", "message" => "Not enough stock available"]);
    exit();
}

$cart_check_query = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
$cart_check_stmt = $conn->prepare($cart_check_query);
$cart_check_stmt->bind_param("ii", $user_id, $product_id);
$cart_check_stmt->execute();
$cart_check_result = $cart_check_stmt->get_result();

if ($cart_check_result->num_rows > 0) {
    $cart_item = $cart_check_result->fetch_assoc();
    $new_qty = $cart_item['quantity'] + $qty;

    if ($new_qty > $stock) {
        echo json_encode(["status" => "error", "message" => "Cannot add more than available stock"]);
        exit();
    }

    $update_query = "UPDATE cart SET quantity = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $new_qty, $cart_item['id']);
    $update_stmt->execute();
} else {
    $insert_query = "INSERT INTO cart (user_id, product_id, product_name, category, brand, model, price, image, quantity) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param(
        "iissssdsi",
        $user_id,
        $product_id,
        $product['product_name'],
        $product['category'],
        $product['brand'],
        $product['model'],
        $product['price'],
        $product['image'],
        $qty
    );
    $insert_stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Product added to cart"]);
