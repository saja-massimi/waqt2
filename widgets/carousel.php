<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Carousel Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.theme.default.min.css">
    <style>
        .carousel-wrap {
            margin: 90px auto;
            padding: 0 5%;
            width: 80%;
            position: relative;
        }

        .owl-carousel .item {
            position: relative;
            z-index: 100;
            -webkit-backface-visibility: hidden;
        }

        .owl-carousel .item img {
            width: 100%;
            /* Make images fit the carousel item */
            height: auto;
            display: block;
        }

        /* Navigation arrow styling */
        .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            z-index: 200;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .owl-nav>div {
            color: #333;
            cursor: pointer;
            /* Background for better contrast */
            padding: 10px;
            border-radius: 50%;
        }

        .owl-nav i {
            font-size: 32px;
            /* Adjust font size */
        }

        .owl-prev {
            left: -20px;
            /* Adjusted for better placement */
        }

        .owl-next {
            right: -20px;
        }
    </style>
</head>

<body>
    <div class="carousel-wrap">
        <div class="owl-carousel">

            <?php if (count($brands) == 0): ?>
                <p class="text-center w-100">No featured products available.</p>
            <?php else: ?>
                <?php foreach ($brands as $brand): ?>

                    <div class="item">

                        <img style="object-fit:contain;height:100px;" src="../../Project/dashboards/assets/products_img/<?= htmlspecialchars($brand['brand_image']) ?>" alt="<?php echo htmlspecialchars($brand['brand_image']); ?>" />
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>



        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js"></script>
    <script src="https://use.fontawesome.com/826a7e3dce.js"></script>

    <script>
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            navText: [
                "<i class='fa fa-caret-left'></i>",
                "<i class='fa fa-caret-right'></i>",
            ],
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                },
            },
        });
    </script>
</body>

</html>