<?php
session_start();
include 'connection.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contactno = trim($_POST['contactno']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($password !== $confirmpassword) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered!";
        } else {
            $stmt->close();

            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "Username is already taken!";
            } else {
                $stmt->close();

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $role = 'user';

                $stmt = $conn->prepare("INSERT INTO users (name, email, contactno, address, city, username, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $name, $email, $contactno, $address, $city, $username, $hashed_password, $role);

                if ($stmt->execute()) {
                    $success = "Registration successful! Redirecting to login...";
                } else {
                    $error = "Error registering. Please try again.";
                }
                $stmt->close();
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Register</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/sweetalert.js"></script>
</head>

<body>

    <?php include "header.php"; ?>

    <section id="register" class="my-5 py-5">
        <div class="container text-center mt-5 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" action="register.php" method="POST">
                <div class="form-group">
                    <label for="register-name">Name</label>
                    <input type="text" class="form-control" name="name" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" class="form-control" name="email" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label for="register-contactno">Contact No.</label>
                    <input type="tel" class="form-control" name="contactno" pattern="[0-9]{11}" required>
                </div>

                <div class="form-group">
                    <label for="register-address">Address</label>
                    <input type="text" class="form-control" name="address" maxlength="150" required>
                </div>

                <div class="form-group">
                    <label for="register-city">City</label>
                    <input type="text" class="form-control" name="city" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label for="register-username">Username</label>
                    <input type="text" class="form-control" name="username" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" class="form-control" name="password" minlength="8" required>
                </div>

                <div class="form-group">
                    <label for="register-confirmpassword">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmpassword" minlength="8" required>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn submitbtn">Signup</button>
                </div>
                <div class="form-group mt-2">
                    <a href="login.php" class="btn btn-link">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        <?php if (!empty($success)): ?>
            showAlert('success', 'Success!', '<?php echo $success; ?>', 'login.php');
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            showAlert('error', 'Oops...', '<?php echo $error; ?>');
        <?php endif; ?>
    </script>

</body>

</html>