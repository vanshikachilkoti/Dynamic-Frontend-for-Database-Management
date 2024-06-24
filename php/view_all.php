<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

$sql = "SELECT * FROM girls_info";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All - Girls Hostel Database</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>All Entries</h1>
        <div id="results">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo " - Room_No " . $row["Room_no"]. " - Name: " . $row["Name"]. " - Branch: " . $row["Branch"]. " - Semester: " . $row["Semester"]. " - Contact: " . $row["Contact"]. "<br>";

                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>
</body>
</html>
