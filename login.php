<?php
include "connection.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $email;
            $_SESSION['role'] = $row['role'];

            if ($row['role'] === 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_email'] = $email;

                echo "<script>
                    localStorage.setItem('role', 'admin');
                    window.location.href = 'admin.php';
                </script>";
                exit();
            } else {
                echo "<script>
                    localStorage.setItem('role', 'user');
                    window.location.href = 'account.php';
                </script>";
                exit();
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "No account found with this email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include "header.php"; ?>

    <script>
        <?php if (!empty($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '<?php echo $error; ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    </script>

    <section id="login" class="my-5 py-5">
        <div class="container text-center mt-5 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" action="login.php" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn submitbtn">Login</button>
                </div>
                <div class="form-group mt-2">
                    <a href="register.php" class="btn btn-link">Don't have an account? Signup</a>
                </div>
            </form>
        </div>
    </section>

    <section id="banner">
        <div>
            <h2>Get 10% Off Your First Order</h2>
            <p>Our latest Phone cases offer the perfect blend of style, durability, and protection.</p>
        </div>
    </section>
</body>

</html>