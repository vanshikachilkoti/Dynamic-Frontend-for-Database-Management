<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    if ($password === "12345") {
        $sql = "SELECT * FROM personal_info WHERE Roll_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "No user found with this roll number.";
        }
    } else {
        echo "Invalid password.";
    }

    $conn->close();
}
?>
