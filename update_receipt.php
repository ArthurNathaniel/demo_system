<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}


include 'db.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['id'];
    $client_name = $_POST['client_name'];
    $payment_method = $_POST['payment_method'];
    $other_method = isset($_POST['other_method']) ? $_POST['other_method'] : '';
    $payment_type = $_POST['payment_type'];
    $amount = $_POST['amount'];
    $amount_words = $_POST['amount_words'];
    $date = $_POST['date'];

    // Update receipt record in the database
    $sql = "UPDATE receipts SET client_name='$client_name', payment_method='$payment_method', other_method='$other_method', payment_type='$payment_type', amount='$amount', amount_words='$amount_words', date='$date' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the list of receipts
        header("Location: view_receipts.php");
        exit();
    } else {
        echo "Error updating receipt: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
