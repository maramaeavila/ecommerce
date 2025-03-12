<nav class="navbar navbar-expand-lg py-3 fixed-top">
    <div class="container-fluid">
        <img src="imgs/CasetifyLogo.png">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href=""><i class="fa fa-cart-shopping white"></i></a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php"><i class="fa fa-sign-out white"></i> Logout</a>
                <?php else: ?>
                    <a href="login.php"><i class="fa fa-user-circle white"></i> Login</a>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>