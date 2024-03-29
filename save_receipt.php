<?php



include 'db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $client_name = $_POST['client_name'];
    $payment_method = $_POST['payment_method'];
    $other_method = isset($_POST['other_method']) ? $_POST['other_method'] : '';
    $payment_type = $_POST['payment_type'];
    $amount = $_POST['amount'];
    $amount_words = $_POST['amount_words'];
    $date = $_POST['date'];

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO receipts (client_name, payment_method, other_method, payment_type, amount, amount_words, date) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdss", $client_name, $payment_method, $other_method, $payment_type, $amount, $amount_words, $date);

    // Execute the statement
    if ($stmt->execute()) {
       
       
        echo "<script>alert('Receipt saved successfully'); window.location.href = 'view_receipts.php';</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If the form wasn't submitted via POST method, handle accordingly
    echo "Form submission method not recognized";
}

// Close the database connection
$conn->close();
