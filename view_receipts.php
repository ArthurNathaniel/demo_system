<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Proceed with displaying the page content since the user is logged in
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Management</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action-links a {
            margin-right: 5px;
        }

        .action-links a:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php' ?>
    <?php
    include 'db.php';

    // Check if a receipt ID is provided for deletion
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Perform deletion query
        $sql_delete = "DELETE FROM receipts WHERE id = $delete_id";
        if ($conn->query($sql_delete) === TRUE) {
            // echo "Receipt with ID $delete_id has been deleted successfully.";
            echo "<script>alert('Receipt with ID $delete_id has been deleted successfully.');</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    // Query to retrieve all receipts
    $sql = "SELECT * FROM receipts";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='manage_all'>";
        echo "<h2>All Receipts</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Client Name</th><th>Payment Method</th><th>Other Method</th><th>Payment Type</th><th>Amount</th><th>Amount Words</th><th>Date</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["client_name"] . "</td>";
            echo "<td>" . $row["payment_method"] . "</td>";
            echo "<td>" . $row["other_method"] . "</td>";
            echo "<td>" . $row["payment_type"] . "</td>";
            echo "<td>" . $row["amount"] . "</td>";
            echo "<td>" . $row["amount_words"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td class='action-links'><a href='edit_receipt.php?id=" . $row["id"] . "'>Edit</a> | <a href='print_selected_receipt.php?id=" . $row["id"] . "' target='_blank'>Print</a> | <a href='?delete_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this receipt?\")'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    echo "</div>";
    $conn->close();
    ?>
</body>

</html>