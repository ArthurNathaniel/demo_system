<?php
session_start();

// Include database connection
include 'db.php';

// Define variable for error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL select statement
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($user_id, $hashed_password);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store user id in session variable
            $_SESSION['user_id'] = $user_id;

            // Redirect to index.php
            header("Location: revenue_summary.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "Invalid username or password";
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
    <title>Login</title>
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
                    <h2>Ogazy G. Car Rentals - Login</h2>
                </div>
                <div class="error_message">
                    <p>
                        <span style="color: red;"><?php echo $error_message; ?></span>
                    </p>
                </div>
                <div class="forms">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="forms">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                </div>
                <div class="forms">
                    <button type="submit">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>