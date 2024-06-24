<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.html");
    exit();
}

require_once 'config.php'; // Include your database connection configuration file here
require_once 'functions.php'; // Include your functions file containing sanitizeInput

$searchTerm = "";
$searchOption = "";
$searchResults = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = sanitizeInput($_POST['searchTerm']);
    $searchOption = $_POST['searchOption'];

    if ($searchOption == 'name') {
        // Example: Search by name in girls_info table
        $sql = "SELECT * FROM girls_info WHERE Name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $searchTerm . "%"; // Add wildcards for partial matching
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $searchResults .= "<h2>Search Results:</h2>";
            while ($row = $result->fetch_assoc()) {
                $searchResults .= "<p>Room_No: " . $row['Room_no'] . " - Name: " . $row['Name'] . " - Branch: " . $row['Branch'] . " - Semester: " . $row['Semester'] . " - Contact: " . $row['Contact'] . "</p>";
            }
        } else {
            $searchResults .= "<p>No results found.</p>";
        }

        $stmt->close();
    } elseif ($searchOption == 'total_beds') {
        // Example: Calculate total number of beds from infrastructure table
        $sql = "SELECT SUM(No_of_beds) AS total_beds FROM infrastructure";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalBeds = $row['total_beds'];
            $searchResults .= "<h2>Total Number of Beds in the Hostel:</h2>";
            $searchResults .= "<p>" . $totalBeds . "</p>";
        } else {
            $searchResults .= "<p>No data available.</p>";
        }
    } elseif ($searchOption == 'total_chairs') {
        // Example: Calculate total number of chairs from infrastructure table
        $sql = "SELECT SUM(No_of_chairs) AS total_chairs FROM infrastructure";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalChairs = $row['total_chairs'];
            $searchResults .= "<h2>Total Number of Chairs in the Hostel:</h2>";
            $searchResults .= "<p>" . $totalChairs . "</p>";
        } else {
            $searchResults .= "<p>No data available.</p>";
        }
    } elseif ($searchOption == 'total_tables') {
        // Example: Calculate total number of tables from infrastructure table
        $sql = "SELECT SUM(No_of_tables) AS total_tables FROM infrastructure";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalTables = $row['total_tables'];
            $searchResults .= "<h2>Total Number of Tables in the Hostel:</h2>";
            $searchResults .= "<p>" . $totalTables . "</p>";
        } else {
            $searchResults .= "<p>No data available.</p>";
        }
    } elseif ($searchOption == 'total_rooms') {
        // Example: Count total number of rooms from your rooms table (adjust the query according to your schema)
        $sql = "SELECT COUNT(*) AS total_rooms FROM girls_info";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalRooms = $row['total_rooms'];
            $searchResults .= "<h2>Total Number of Rooms in the Hostel:</h2>";
            $searchResults .= "<p>" . $totalRooms . "</p>";
        } else {
            $searchResults .= "<p>No data available.</p>";
        }
    } elseif ($searchOption == 'total_students') {
        // Example: Count total number of students from girls_info table
        $sql = "SELECT COUNT(*) AS total_students FROM girls_info";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalStudents = $row['total_students'];
            $searchResults .= "<h2>Total Number of Students in the Hostel:</h2>";
            $searchResults .= "<p>" . $totalStudents . "</p>";
        } else {
            $searchResults .= "<p>No data available.</p>";
        }
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Girls Hostel Database</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="delete.php">Delete Entry</a></li>
                <li><a href="view_all.php">View All Entries</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <div class="dashboard-container">
            <h2>Search Entry</h2>
            <div class="search-section">
                <form action="dashboard.php" method="post">
                    <label for="searchTerm">Search:</label>
                    <input type="text" name="searchTerm" id="searchTerm" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Enter search term">
                    <select name="searchOption" id="searchOption">
                        <option value="name" <?php echo ($searchOption == 'name') ? 'selected' : ''; ?>>Search by Name</option>
                        <option value="total_beds" <?php echo ($searchOption == 'total_beds') ? 'selected' : ''; ?>>Total Number of Beds</option>
                        <option value="total_chairs" <?php echo ($searchOption == 'total_chairs') ? 'selected' : ''; ?>>Total Number of Chairs</option>
                        <option value="total_tables" <?php echo ($searchOption == 'total_tables') ? 'selected' : ''; ?>>Total Number of Tables</option>
                        <option value="total_rooms" <?php echo ($searchOption == 'total_rooms') ? 'selected' : ''; ?>>Total Number of Rooms</option>
                        <option value="total_students" <?php echo ($searchOption == 'total_students') ? 'selected' : ''; ?>>Total Number of Students</option>
                        <!-- Remove students_semester option -->
                    </select>
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="search-results">
                <!-- Display search results here dynamically -->
                <?php echo $searchResults; ?>
            </div>
        </div>
    </div>
    <script src="../js/scripts.js"></script> <!-- Ensure correct path to your JavaScript file -->
</body>
</html>
