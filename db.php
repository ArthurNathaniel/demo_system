<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo_system";

// $servername = "longwellconnect.com";
// $username = "u500921674_officenath";
// $password = "OnGod@123";
// $dbname = "u500921674_officenath";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
