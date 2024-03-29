<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
include 'db.php';

// Check if receipt ID is provided in the URL
if (isset($_GET['id'])) {
    $receipt_id = $_GET['id'];

    // Retrieve receipt details for the specified ID
    $sql = "SELECT * FROM receipts WHERE id = $receipt_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Receipt</title>
        </head>

        <body>
            <h2>Edit Receipt</h2>
            <form action="update_receipt.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label>Client Name:</label>
                <input type="text" name="client_name" value="<?php echo $row['client_name']; ?>"><br><br>
                <label>Payment Method:</label>
                <select name="payment_method">
                    <option value="cash" <?php if ($row['payment_method'] == 'cash') echo 'selected'; ?>>Cash</option>
                    <option value="momo" <?php if ($row['payment_method'] == 'momo') echo 'selected'; ?>>Momo</option>
                    <option value="bank_transfer" <?php if ($row['payment_method'] == 'bank_transfer') echo 'selected'; ?>>Bank Transfer</option>
                    <option value="other" <?php if ($row['payment_method'] == 'other') echo 'selected'; ?>>Other</option>
                </select><br><br>
                <label>Full or Partial Payment:</label>
                <select name="payment_type">
                    <option value="full" <?php if ($row['payment_type'] == 'full') echo 'selected'; ?>>Full</option>
                    <option value="partial" <?php if ($row['payment_type'] == 'partial') echo 'selected'; ?>>Partial</option>
                </select><br><br>
                <label>Other Method:</label>
                <input type="text" name="other_method" value="<?php echo $row['other_method']; ?>"><br><br>
                <label>Amount:</label>
                <input type="number" name="amount" value="<?php echo $row['amount']; ?>"><br><br>
                <label>Amount Words:</label>
                <input type="text" name="amount_words" value="<?php echo $row['amount_words']; ?>"><br><br>
                <label>Date:</label>
                <input type="date" name="date" value="<?php echo $row['date']; ?>"><br><br>
                <input type="submit" value="Update Receipt">
            </form>
        </body>

        </html>
<?php
    } else {
        echo "Receipt not found";
    }
} else {
    echo "No receipt ID provided";
}

$conn->close();
?>