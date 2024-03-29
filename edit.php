<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
include 'db.php';

// Check if ID parameter is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch client details by ID
    $sql = "SELECT * FROM client_details WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        echo "No client found with ID: $id";
        exit;
    }
} else {
    echo "Invalid ID";
    exit;
}

// Update client details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_name = $_POST['recipient_name'];
    $date = $_POST['date'];
    $driving_license_number = $_POST['driving_license_number'];
    $contact_number = $_POST['contact_number'];
    $duration = $_POST['duration'];
    $ghana_card_id = $_POST['ghana_card_id'];
    $destination = $_POST['destination'];
    $car_registration = $_POST['car_registration'];
    $amount = $_POST['amount'];
    $guarantor = $_POST['guarantor'];
    $location_guarantor = $_POST['location_guarantor'];
    $ghana_card_id_guarantor = $_POST['ghana_card_id_guarantor'];
    $contact_guarantor = $_POST['contact_guarantor'];

    $sql = "UPDATE client_details SET 
            recipient_name = '$recipient_name', 
            date = '$date', 
            driving_license_number = '$driving_license_number', 
            contact_number = '$contact_number', 
            duration = '$duration', 
            ghana_card_id = '$ghana_card_id', 
            destination = '$destination', 
            car_registration = '$car_registration', 
            amount = '$amount', 
            guarantor = '$guarantor', 
            location_guarantor = '$location_guarantor', 
            ghana_card_id_guarantor = '$ghana_card_id_guarantor', 
            contact_guarantor = '$contact_guarantor' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New Update successfully'); window.location.href = 'client_details.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client Details</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/client.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="admin_all">
        <h2>Edit Client Details</h2>
        <form method="post">
            <div class="clients_forms">
                <label>Recipient Name:</label>
                <input type="text" class="form-control" name="recipient_name" value="<?php echo $client['recipient_name']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Date:</label>
                <input type="date" class="form-control" name="date" value="<?php echo $client['date']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Driving License Number:</label>
                <input type="text" class="form-control" name="driving_license_number" value="<?php echo $client['driving_license_number']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Contact Number:</label>
                <input type="text" class="form-control" name="contact_number" value="<?php echo $client['contact_number']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Durations (Days):</label>
                <input type="number" class="form-control" name="duration" value="<?php echo $client['duration']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Ghana Card ID:</label>
                <input type="text" class="form-control" name="ghana_card_id" value="<?php echo $client['ghana_card_id']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Destination:</label>
                <input type="text" class="form-control" name="destination" value="<?php echo $client['destination']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Car Registration:</label>
                <input type="text" class="form-control" name="car_registration" value="<?php echo $client['car_registration']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Amount:</label>
                <input type="text" class="form-control" name="amount" value="<?php echo $client['amount']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Guarantor:</label>
                <input type="text" class="form-control" name="guarantor" value="<?php echo $client['guarantor']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Location (Guarantor):</label>
                <input type="text" class="form-control" name="location_guarantor" value="<?php echo $client['location_guarantor']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Ghana Card No (Guarantor):</label>
                <input type="text" class="form-control" name="ghana_card_id_guarantor" value="<?php echo $client['ghana_card_id_guarantor']; ?>" required>
            </div>
            <div class="clients_forms">
                <label>Contact (Guarantor):</label>
                <input type="text" class="form-control" name="contact_guarantor" value="<?php echo $client['contact_guarantor']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>

</html>