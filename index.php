<?php
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="home">
        <div class="logo"></div>
        <h1>Welcome to Ogazy G. Car Rental</h1>
        <div class="powered">
            <p>This system is Powered by <a href="https://wa.link/uhvnz5" target="_blank">Nathstack Tech</a></p>
        </div>
    </div>
</body>

</html>
\ 