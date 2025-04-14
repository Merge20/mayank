<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password (plain text comparison - not recommended for production)
        if ($password === $row['password']) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $row['username'];
            echo "success";
            exit;
        }
    }
    
    // If we reach here, credentials were invalid
    echo "Invalid username or password";
    unset($stmt);
    unset($conn);
}
?>