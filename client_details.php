<?php
                session_start();

                // Check if user is logged in
                if (!isset($_SESSION['user_id'])) {
                    // Redirect to login page
                    header("Location: login.php");
                    exit();
                }
include 'db.php';
// Function to fetch all client details
function fetchAllClientDetails($conn)
{
    $sql = "SELECT * FROM client_details";
    $result = $conn->query($sql);
    $clients = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }

    return $clients;
}

// Fetch all client details
$clients = fetchAllClientDetails($conn);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Client Details</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/client.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="admin_all">
        <h2>Client Details</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipient Name</th>
                    <th>Date</th>
                    <th>Driving License Number</th>
                    <th>Contact Number</th>
                    <th>Durations (Days)</th>
                    <th>Ghana Card ID</th>
                    <th>Destination</th>
                    <th>Car Registration</th>
                    <th>Amount</th>
                    <th>Guarantor</th>
                    <th>Location (Guarantor)</th>
                    <th>Ghana Card ID (Guarantor)</th>
                    <th>Contact (Guarantor)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client) { ?>
                    <tr>
                        <td><?php echo $client['id']; ?></td>
                        <td><?php echo $client['recipient_name']; ?></td>
                        <td><?php echo $client['date']; ?></td>
                        <td><?php echo $client['driving_license_number']; ?></td>
                        <td><?php echo $client['contact_number']; ?></td>
                        <td><?php echo $client['duration']; ?></td>
                        <td><?php echo $client['ghana_card_id']; ?></td>
                        <td><?php echo $client['destination']; ?></td>
                        <td><?php echo $client['car_registration']; ?></td>
                        <td><?php echo $client['amount']; ?></td>
                        <td><?php echo $client['guarantor']; ?></td>
                        <td><?php echo $client['location_guarantor']; ?></td>
                        <td><?php echo $client['ghana_card_id_guarantor']; ?></td>
                        <td><?php echo $client['contact_guarantor']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $client['id']; ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $client['id']; ?>" class="ml-2" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            <a href="print_client.php?id=<?php echo $client['id']; ?>" class="ml-2">Print</a> <!-- New line for Print option -->
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</body>

</html>