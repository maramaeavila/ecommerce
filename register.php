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
                <div class="form-group row">
                    <label for="register-name" class="col-sm-4 col-form-label left">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-email" class="col-sm-4 col-form-label left">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="email" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-contactno" class="col-sm-4 col-form-label left">Contact No.</label>
                    <div class="col-sm-8">
                        <input type="tel" class="form-control" name="contactno" pattern="[0-9]{11}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-address" class="col-sm-4 col-form-label left">Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="address" maxlength="150" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-city" class="col-sm-4 col-form-label left">City</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="city" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-username" class="col-sm-4 col-form-label left">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" maxlength="50" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-password" class="col-sm-4 col-form-label left">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" minlength="8" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="register-confirmpassword" class="col-sm-4 col-form-label left">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="confirmpassword" minlength="8" required>
                    </div>
                </div>

                <div class="form-group row mt-3">
                    <div class="col-sm-8 offset-sm-4">
                        <button type="submit" class="btn submitbtn">Signup</button>
                    </div>
                </div>

                <div class="form-group row mt-2">
                    <div class="col-sm-8 offset-sm-4">
                        <a href="login.php" class="btn btn-link">Already have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section id="banner">
        <div>
            <!-- <h2>Get 10% Off Your First Order</h2>
            <p>Our latest Phone cases offer the perfect blend of style, durability, and protection.</p> -->
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