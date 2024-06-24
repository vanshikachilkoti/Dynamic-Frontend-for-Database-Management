<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deleteTerm = sanitizeInput($_POST['deleteTerm']);
    $sql = "DELETE FROM girls_info WHERE name = '$deleteTerm'";
    if ($conn->query($sql) === TRUE) {
        $message = "Record deleted successfully";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete - Girls Hostel Database</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete Entry</h1>
        <form method="post" action="">
            <input type="text" name="deleteTerm" placeholder="Entry to delete">
            <button type="submit">Delete</button>
        </form>
        <div id="results">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
        </div>
    </div>
</body>
</html>
