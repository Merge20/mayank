<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.html");
    exit();
}

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['bookTitle'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year = $_POST['year'];
    $description = $_POST['description'];

    try {
        $sql = "INSERT INTO books (title, author, genre, year, description) 
                VALUES (:title, :author, :genre, :year, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':year' => $year,
            ':description' => $description
        ]);

        $_SESSION['success_message'] = "Book added successfully!";
        header("Location: ../addBooks.php");
        exit();
    } catch (PDOException $e) {
        echo "Error adding book: " . $e->getMessage();
    }
}
?>
