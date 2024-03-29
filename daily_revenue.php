<?php

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Proceed with displaying the page content since the user is logged in

include 'db.php';

// Get start and end dates for the current year
$thisYearStart = date('Y-01-01');
$thisYearEnd = date('Y-12-31');

// Query to get total amount for each day of the current year
$sqlYearly = "SELECT DATE(date) AS date, SUM(amount) AS total_amount FROM receipts WHERE DATE(date) BETWEEN '$thisYearStart' AND '$thisYearEnd' GROUP BY DATE(date)";
$resultYearly = $conn->query($sqlYearly);

// Create an associative array to store total amounts for each date
$yearlyRevenue = [];
while ($row = $resultYearly->fetch_assoc()) {
    $date = $row['date'];
    $total_amount = $row['total_amount'];
    $yearlyRevenue[$date] = $total_amount;
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Revenue</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="revenue_summary_all">
        <h2>Daily Revenue</h2>

        <table>
            <tr>
                <th>Date</th>
                <th>Total Amount</th>
            </tr>
            <?php
            // Loop through each day of the year and display the total amount
            $currentDate = strtotime($thisYearStart);
            $endDate = strtotime($thisYearEnd);
            while ($currentDate <= $endDate) {
                $date = date('Y-m-d', $currentDate);
                $total_amount = isset($yearlyRevenue[$date]) ? $yearlyRevenue[$date] : 0;
            ?>
                <tr>
                    <td><?php echo $date; ?></td>
                    <td><?php echo "GH₵ " . $total_amount; ?></td>
                </tr>
            <?php
                // Move to the next day
                $currentDate = strtotime('+1 day', $currentDate);
            }
            ?>
        </table>
    </div>
</body>

</html>