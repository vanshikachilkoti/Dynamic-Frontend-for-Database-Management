<?php
require_once 'config.php';

function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, $data));
}
?>
