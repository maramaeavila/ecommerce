<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_email'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

if (!isset($_POST['cart_ids']) || !is_array($_POST['cart_ids'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit();
}

$email = $_SESSION['user_email'];

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

$order_query = "INSERT INTO orders (user_id, product_name, quantity, price) 
                SELECT user_id, product_name, quantity, price FROM cart WHERE user_id = ? AND id = ?";
$order_stmt = $conn->prepare($order_query);

$delete_query = "DELETE FROM cart WHERE user_id = ? AND id = ?";
$delete_stmt = $conn->prepare($delete_query);

foreach ($_POST['cart_ids'] as $cart_id) {
    $cart_id = intval($cart_id);

    $order_stmt->bind_param("ii", $user_id, $cart_id);
    $order_stmt->execute();

    $delete_stmt->bind_param("ii", $user_id, $cart_id);
    $delete_stmt->execute();
}

echo json_encode(["status" => "success", "message" => "Selected items added to orders"]);
