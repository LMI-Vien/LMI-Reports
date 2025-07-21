<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | 404</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .error-container {
            text-align: center;
            margin-top: 100px;
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #dc3545;
        }
        .error-message {
            font-size: 24px;
            color: #6c757d;
        }
        .btn-home {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <div class="error-message">Oops! The page you're looking for cannot be found.</div>
            <p class="mt-4">
                <a href="/" class="btn btn-primary btn-home">Go to Home Page</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper (for Bootstrap components like modals or dropdowns) -->
    <script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.7.1.min.js" ></script>
    <script src="<?= base_url();?>assets/js/popper.min.js" ></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
