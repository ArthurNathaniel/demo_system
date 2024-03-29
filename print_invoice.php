<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
// Establish a database connection
include 'db.php';

// Check if invoice ID is provided
if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Fetch invoice data based on the provided ID
    $sql = "SELECT * FROM invoices WHERE id = $invoice_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Invoice not found.";
        exit;
    }
} else {
    echo "Invoice ID not provided.";
    exit;
}

// Fetch invoice details
$sql_details = "SELECT * FROM invoice_services WHERE invoice_id = $invoice_id";
$result_details = $conn->query($sql_details);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/invoice.css">
    <!-- <style>
        /* Add your print styles here */
        @media print {

            /* Define styles for printing */
            /* For example, hide unnecessary elements */
            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style> -->
</head>

<body>
    <div class="navbar_top">
        <div class="nav_logo"></div>
        <div class="nav_title">
            <h1>INVOICE</h1>
        </div>
    </div>
    <div id="print-section">

        <!-- <h2>Invoice Details</h2> -->
        <?php
        $dateToday = date("Y-m-d");
        ?>
        <div class="client_details">
            <p><strong>Invoice ID:</strong> <?php echo $row['id']; ?></p>
            <p><strong>Billed to:</strong> <?php echo $row['billed_to']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $row['contact_number']; ?></p>
            <p><strong>Date:</strong> <?php echo $dateToday; ?></p>
        </div>

        <!-- Invoice details table -->
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Service</th>
                    <th>Day</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_details->num_rows > 0) {
                    $row_number = 1;
                    while ($row_detail = $result_details->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_number++ . "</td>";
                        echo "<td>" . $row_detail["service"] . "</td>";
                        echo "<td>" . $row_detail["day"] . "</td>";
                        echo "<td>" . $row_detail["price"] . "</td>";
                        echo "<td>" . $row_detail["amount"] . "</td>";

                        echo "</tr>";
                    }
                    echo "<tr><td colspan='4' align='right'><strong >Tax:</strong></td><td><p> " . $row["vat_tax"] . "</p></td></tr>";
                    echo "<tr><td colspan='4' align='right'><strong >Subtotal:</strong></td><td><p> " . $row["subtotal"] . "</p></td></tr>";
                    echo "<tr><td colspan='4' align='right'><strong >Total:</strong></td><td><h1> " . 'GH₵ '  . $row["total"] . "</h1></td></tr>";
                } else {
                    echo "<tr><td colspan='5'>No invoice details found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="payment_details">
            <h2>Payment Info:</h2>
            <p><strong>Mobile Money Number: </strong>+233 24 910 3331</p>
            <p><strong>Mobile Money Name: </strong>Ogazy G. Car Rental</p>
        </div>

    </div>
    <div class="navbar_top">
        <div class="nav_logo"></div>
        <div class="nav_title">
            <h1>INVOICE</h1>
        </div>
    </div>

    <div class="terms">
        <div class="terms_title">
            <h1>
                <h1>Ogazy G. Car Rental Terms and Conditions</h1>
            </h1>
        </div>
        <div class="terms_text">
            <p> Welcome to Ogazy G. Car Rentals! Prior to confirming your reservation, please take a moment to familiarize yourself with our terms and conditions outlined below. These guidelines are designed to ensure a seamless and pleasant rental experience for all our valued customers. Should you have any inquiries or require assistance, our dedicated team is readily available to assist you. Thank you for selecting Ogazy G. Car Rentals for your travel needs. </p>
        </div>
        <div class="terms_list">
            <ol>
                <li>Reservations subject to availability, made online or via phone.</li>
                <li>Valid driver's license and payment required at pickup.</li>
                <li>Security deposit may apply.</li>
                <li>Cancellation policy enforced.</li>
                <li>Basic insurance included; additional options available.</li>
                <li>Vehicle return as agreed; late returns may incur fees.</li>
                <li>No smoking or pets allowed.</li>
                <li>Prompt reporting of damages or issues required.</li>
                <li>Ogazy not liable for personal belongings.</li>
                <li>Additional terms may apply.</li>
            </ol>
        </div>
        <br>
        <br>
        <div class="payment_details">
            <h2>Payment Info:</h2>
            <p><strong>Mobile Money Number: </strong>+233 24 910 3331</p>
            <p><strong>Mobile Money Name: </strong>Ogazy G. Car Rental</p>
        </div>


    </div>
    <div class="last_details">
        <div class="nav_logo"></div>
        <div class="location">
            <h2>CONTACT US:</h2>
            <br>
            <p><i class="fa-solid fa-location-dot"></i> Airport Roundabout, Opposite DVLA, Ksi</p>

            <p><i class="fa-solid fa-phone"></i> +233 24 910 3331 / +233 59 636 8628</p>
        </div>
    </div>
    <!-- Button to trigger printing -->
    <button onclick="window.print()">Print Invoice</button>
</body>

</html>