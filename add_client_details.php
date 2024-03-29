<?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page
        header("Location: login.php");
        exit();
    }
include 'db.php';

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $recipient_name = $conn->real_escape_string($_POST['recipient_name']);
    $date = $conn->real_escape_string($_POST['date']);
    $driving_license_number = $conn->real_escape_string($_POST['driving_license_number']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $duration = $conn->real_escape_string($_POST['duration']);
    $ghana_card_id = $conn->real_escape_string($_POST['ghana_card_id']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $car_registration = $conn->real_escape_string($_POST['car_registration']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $guarantor = $conn->real_escape_string($_POST['guarantor']);
    $location_guarantor = $conn->real_escape_string($_POST['location_guarantor']);
    $ghana_card_id_guarantor = $conn->real_escape_string($_POST['ghana_card_id_guarantor']);
    $contact_guarantor = $conn->real_escape_string($_POST['contact_guarantor']);

    // Attempt insert query execution
    $sql = "INSERT INTO client_details (recipient_name, date, driving_license_number, contact_number, duration, ghana_card_id, destination, car_registration, amount, guarantor, location_guarantor, ghana_card_id_guarantor, contact_guarantor)
    VALUES ('$recipient_name', '$date', '$driving_license_number', '$contact_number', '$duration', '$ghana_card_id', '$destination', '$car_registration', '$amount', '$guarantor', '$location_guarantor', '$ghana_card_id_guarantor', '$contact_guarantor')";

    if ($conn->query($sql) === TRUE) {
       
        echo "<script>alert('New record created successfully'); window.location.href = 'add_client_details.php';</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/client.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="admin_all">
        <div class="clients_all_title">
            <h1>Client Details</h1>
        </div>
        <form action="" method="post" enctype="">


            <div class="clients_grid">
                <div class="clients_forms">
                    <label>Recipient Name:</label>
                    <input type="text" placeholder="Enter your recipient name" name="recipient_name" required>
                </div>

                <div class="clients_forms">
                    <label>Date:</label>
                    <input type="date" placeholder="Enter the date" name="date" required>
                </div>

                <div class="clients_forms">
                    <label>Driving License Number:</label>
                    <input type="text" placeholder="Enter your driving license number" name="driving_license_number" required>
                </div>

                <div class="clients_forms">
                    <label>Contact Number:</label>
                    <input type="number" placeholder="Enter your contact number" name="contact_number" required>
                </div>

                <div class="clients_forms">
                    <label>Durations (Days):</label>
                    <input type="number" placeholder="Enter your duration" name="duration" required>
                </div>

                <div class="clients_forms">
                    <label>Ghana Card ID:</label>
                    <input type="text" placeholder="Enter your Ghana card ID" name="ghana_card_id" required>
                </div>

                <div class="clients_forms">
                    <label>Destination:</label>
                    <input type="text" placeholder="Enter your destination" name="destination" required>
                </div>

                <div class="clients_forms">
                    <label>Car Registration:</label>
                    <input type="text" placeholder="Enter your car registration" name="car_registration" required>
                </div>

                <div class="clients_forms">
                    <label>Amount:</label>
                    <input type="text" placeholder="Enter the amount" name="amount" required>
                </div>
            </div>

            <div class="clients_grid">
                <div class="clients_forms">
                    <h1>Guarantor Details</h1>
                </div>
            </div>
            <div class="clients_grid">

                <div class="clients_forms">
                    <label>Guarantor:</label>
                    <input type="text" placeholder="Enter the guarantor" name="guarantor" required>
                </div>

                <div class="clients_forms">
                    <label>Location (Guarantor):</label>
                    <input type="text" placeholder="Enter the location" name="location_guarantor" required>
                </div>

                <div class="clients_forms">
                    <label>Ghana Card No(Guarantor):</label>
                    <input type="text" placeholder="Enter the location" name="ghana_card_id_guarantor" required>
                </div>
                <div class="clients_forms">
                    <label>Contact(Guarantor):</label>
                    <input type="text" placeholder="Enter the location" name="contact_guarantor" required>
                </div>
            </div>

            <div class="clients_grid">
                <div class="clients_forms">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script src="../js/sidebar.js"></script>
</body>

</html>