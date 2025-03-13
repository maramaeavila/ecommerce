<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    include "header.php";
    ?>

    <section id="contactus">
        <h1>Contact Us</h1>
        <div class="contact-content">
            <div class="contact-info">
                <div><i class="fa-solid fa-location-dot"></i> Quezon City, Philippines</div>
                <div><i class="fa-solid fa-envelope"></i>casetify@gmail.com</div>
                <div><i class="fa-solid fa-mobile"></i>0948-544-7581</div>
            </div>
            <div class="contact-form">
                <h2>Contact Us</h2>
                <form class="contact" action="smtpScript.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="name" class="text-box" placeholder="Your Name" required>
                    <input type="email" name="email" class="text-box" placeholder="Your Email" required>
                    <textarea name="message" rows="5" placeholder=""></textarea>
                    <button class="btn submitbtn" type="submit" name="send">SEND</button>

                </form>
            </div>
        </div>
    </section>

</body>

</html>