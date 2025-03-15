<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casetify</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <?php
    include "header.php";
    ?>

    <header>
        <h1>CASETIFY COLLECTION</h1>
        <p>Your Style, Your Case.</p>
    </header>
    <section id="banner">
        <div>
            <!-- <h2>Get 10% Off Your First Order</h2>
            <p>Our latest Phone cases offer the perfect blend of style, durability, and protection.</p> -->
        </div>
    </section>

    <section id="categories" class="w-100">
        <div>
            <h1>Top Categories</h1>
        </div>
        <div class="row p-0 m-0">
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/cases.jpg">
                <div class="details">
                    <h2>Cases</h2>
                    <a href="" class="btn" role="button">Shop Now</a>
                </div>
            </div>
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/airpods.jpg">
                <div class="details">
                    <h2>Airpods</h2>
                    <a href="" class="btn" role="button">Shop Now</a>
                </div>
            </div>
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/accessories.jpg">
                <div class="details">
                    <h2>Accessories</h2>
                    <a href="" class="btn" role="button">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <?php
    include "contactus.php";
    ?>

</body>

</html>