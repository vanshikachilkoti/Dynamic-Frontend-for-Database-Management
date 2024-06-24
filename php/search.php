<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = sanitizeInput($_POST['searchTerm']);
    $sql = "SELECT * FROM girls_info WHERE name LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Girls Hostel Database</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Search Entries</h1>
        <form method="post" action="">
            <input type="text" name="searchTerm" placeholder="Search term">
            <button type="submit">Search</button>
        </form>
        <div id="results">
            <?php
            if (isset($result) && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "Name: " . $row["name"]. " - Age: " . $row["age"]. " - Room: " . $row["room"]. "<br>";
                }
            } else if (isset($result)) {
                echo "0 results";
            }
            ?>
        </div>
    </div>
</body>
</html>
