<?php
// Include database connection
include 'db.php';

// Define variables for error messages
$username_error = $password_error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $username_error = "Username already exists!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL insert statement
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="forms_page">
        <div class="forms_swiper">
            <div class="logo"></div>
        </div>
        <div class="forms_details">

            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="forms">
                    <h2>Sign Up</h2>
                </div>
                <div class="error_message">
                    <span style="color: red;"><?php echo $username_error; ?></span>
                </div>
                <div class="forms">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="forms">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                </div>
                <div class="forms">
                    <button type="submit">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>