<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <link rel="icon" href="<?= base_url('assets/img/lmi_logo.ico') ?>" type="image/x-icon">
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.bundle.min.js" ></script>
    <style>
        body {
            background: #67665a;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        /* Fade + Slide animation */
        .fade-slide {
            animation: fadeSlide 1.5s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeSlide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hammer {
            transform-origin: top right;
            animation: hammerMove 1s infinite ease-in-out;
        }

        @keyframes hammerMove {
            0% { transform: rotate(0deg); }
            50% { transform: rotate(-25deg); }
            100% { transform: rotate(0deg); }
        }

        .worker-container {
            width: 200px;
            margin: 0 auto 20px auto;
        }
    </style>
</head>

<body>
    <div class="text-center fade-slide">
        <div class="worker-container">
        <script src="<?= base_url();?>assets/js/dotlottie-wc.js" type="module"></script>

        <dotlottie-wc 
            src="<?= base_url();?>assets/lottie/maintenance.lottie"
            style="width: 300px; height: 300px"
            autoplay
            loop>
        </dotlottie-wc>
        </div>

        <h1 class="fw-bold">We’re Fixing Things Up!</h1>
        <p class="mt-3 lead">Our website is undergoing scheduled maintenance.</p>
        <p class="small">Hang tight while our team works on improvements.</p>

        <div class="spinner-border text-light mt-3" role="status"></div>
    </div>

</body>

</html>
