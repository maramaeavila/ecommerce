<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renz and Co.</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <link rel="stylesheet" href="./css/style.css">

</head>

<body>

    <!-- navbar -->
    <?php
    include "header.php";
    ?>

    <!-- Home -->
    <section id="home">
        <div class="content">
            <p>Limited Time Only</p>
            <h1>Fashion</h1>
            <h3>Look Your Best On your Best Day</h3>
            <!-- <button id="btn-explore">Explore Now</button> -->
        </div>
    </section>

    <!-- About Us -->
    <section id="aboutus">
        <div class="container mt-5">
            <h2 data-text="About Us...">About Us...</h2>
            <div class="row">
                <!-- <div class="col-sm">
                    <div class="card">
                        <img src="" alt="">
                    </div>
                </div> -->
                <div class="col-sm mt-5">
                    <h3>Our Story</h3>
                    <p style="font-size: 25px;">Welcome to Renz and Co,
                        where shopping meets convenience and reliability! <br>
                        to create clothing that not only looks good but also feels good. <br>
                        Founded in 3 years ago, Renz and Co. was born out of a desire <br>
                        to redefine fashion by blending style, comfort, and sustainability. <br>
                        <br>
                        <br>
                        Our journey began in a small studio, where our founder, Renz and Co., <br>
                        poured their heart and soul into designing pieces that inspire confidence <br>
                        and self-expression. With a focus on quality craftsmanship and attention to detail, <br>
                        We set out to create clothing that stands the test of time. <br>
                    </p>
                    <!-- <button id="btn-aboutus">Learn More.</button> -->
                </div>
            </div>
        </div>
    </section>


    <!-- Categories -->
    <section id="categories" class="w-100">
        <div>
            <h1>Top Categories</h1>
        </div>
        <div class="row p-0 m-0">
            <!-- Men -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/men.png">
                <div class="details">
                    <h2>Men</h2>
                    <a href="product.php" class="btn btn-dark" role="button">Shop Now</a>
                </div>
            </div>
            <!-- Women -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/women.png">
                <div class="details">
                    <h2>Women</h2>
                    <a href="product.php" class="btn btn-dark" role="button">Shop Now</a>
                </div>
            </div>
            <!-- Kid -->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="./imgs/kid.PNG">
                <div class="details">
                    <h2>Kid</h2>
                    <a href="product.php" class="btn btn-dark" role="button">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner -->
    <section id="banner">
        <div class="container">
            <h4 class="text-center">Shop the Latest Trends in Renz and Co!</h4>
            <h1 class="text-center">"Explore our Stylish Collection Today."</h1>
        </div>

    </section>

    <?php
    include "Footercontactus.php";
    ?>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script>
        $('#categories .box-area').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1000,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        $('#prodSlider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        document.getElementById('prevSlide').addEventListener('click', function() {
            $('#prodSlider').slick('slickPrev');
        });

        document.getElementById('nextSlide').addEventListener('click', function() {
            $('#prodSlider').slick('slickNext');
        });

        document.addEventListener('DOMContentLoaded', function() {
            let section = document.querySelectorAll('section');
            let navLinks = document.querySelectorAll('nav a');

            window.onscroll = () => {
                section.forEach(sec => {
                    let top = window.scrollY;
                    let offset = sec.offsetTop;
                    let height = sec.offsetHeight;
                    let id = sec.getAttribute('id');

                    if (top >= offset && top < offset + height) {
                        navLinks.forEach(links => {
                            links.classList.remove('active');
                            document.querySelector('nav a[href*=' + id + ']').classList.add('active');
                        })
                    }
                })
            }
        });
    </script>

</body>

</html>