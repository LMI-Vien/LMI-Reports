<?php
// Optionally, you can set a message based on the migration status.
$serverMigrationMessage = "We are currently migrating data to this server. Please be patient while we complete the process.";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$baseUrl = $protocol . $host . $basePath;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Server Migration in Progress</title>
    
    <!-- Bootstrap CSS -->
    <link href="<?= $baseUrl ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
            padding: 50px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .heading {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
        }

        .message {
            font-size: 18px;
            color: #6c757d;
            margin-top: 20px;
        }

        .btn-link {
            font-size: 18px;
            margin-top: 30px;
        }

        .alert {
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="container">
        <p class="message">
            <?php echo $serverMigrationMessage; ?>
        </p>

        <p class="alert alert-info">
            Migration may take a little time. Thank you for your patience!
        </p>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script type="text/javascript" src="<?= $baseUrl ?>/assets/js/jquery-3.7.1.min.js" ></script>
    <script src="<?= $baseUrl ?>/assets/js/popper.min.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
