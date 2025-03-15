<?php
include "connection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_email'])) {
    die("Error: Session email is missing. Please log in again.");
}

$email = $_SESSION['user_email'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Error: No account found with this email.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "header.php"; ?>

    <!-- Account Section -->
    <section id="account" class="my-5 py-5">
        <div class="container text-center mt-5 pt-5">
            <h2 class="font-weight-bold">My Account</h2>
            <hr class="mx-auto">
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 text-center">
                    <h3 class="font-weight-bold">Account Info</h3>
                    <hr class="mx-auto">
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                    <p><strong>Contact No.:</strong> <?= htmlspecialchars($row['contactno']) ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($row['address']) ?></p>
                    <p><strong>City:</strong> <?= htmlspecialchars($row['city']) ?></p>
                </div>

                <div class="col-lg-6 col-md-12">
                    <form id="change-password-form">
                        <h3>Change Password</h3>
                        <hr class="mx-auto">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword" required>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn submitbtn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Orders Section -->
    <section id="orders" class="container my-5 py-5">
        <div class="container mt-2">
            <h2 class="font-weight-bold">My Orders</h2>
            <hr>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Order data displayed here -->
            </tbody>
        </table>
    </section>

    <section id="banner">
        <div>
            <!--  -->
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/account.js"></script>

</body>

</html>