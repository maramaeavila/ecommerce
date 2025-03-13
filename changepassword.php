<?php
include "connection.php";
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Something went wrong", "title" => "Error!"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['password']) && !empty($_POST['email'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_email_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $hashed_password, $email);

            if ($stmt->execute()) {
                $response = [
                    "status" => "success",
                    "title" => "Success!",
                    "message" => "Password was successfully changed.",
                    "redirect" => "login.php"
                ];
            } else {
                $response["message"] = "Unable to change password.";
            }
            $stmt->close();
        }
    } else {
        $response["message"] = "Email not found in records.";
    }
    $check_stmt->close();
} else {
    $response["message"] = "Email or Password not provided.";
}

$conn->close();
echo json_encode($response);
