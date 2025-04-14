<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username exists
    $checkUser = $conn->prepare("SELECT username FROM users WHERE username = :username");
    $checkUser->bindParam(':username', $username);
    $checkUser->execute();
    
    if ($checkUser->rowCount() > 0) {
        die("Username already exists");
    }

    // Check if email exists
    $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $checkEmail->bindParam(':email', $email);
    $checkEmail->execute();
    
    if ($checkEmail->rowCount() > 0) {
        die("Email already registered");
    }

    // Insert new user
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Registration failed. Please try again.";
    }
    
    unset($stmt);
    unset($conn);
}
?>