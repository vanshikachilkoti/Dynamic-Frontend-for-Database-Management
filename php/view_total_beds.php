<?php
session_start();
require_once 'config.php';

// Example SQL query to calculate total number of beds
$sql = "SELECT SUM(No_of_beds) AS total_beds FROM infrastructure";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBeds = $row['total_beds'];
    echo "Total Number of Beds in the Hostel: " . $totalBeds;
} else {
    echo "No data available.";
}

$conn->close();
?>
