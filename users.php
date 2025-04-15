<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Management System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./styles/home.css">
</head>
<body>
  <header>
    <h1>Welcome to the Library Management System</h1>
  </header>

  <nav>
    <div class="nav-user">
      <div class="profile-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
        </svg>
      </div>
      <span class="username"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
    </div>
    <div class="nav-center">
      <a href="./Home.php" style="background-color: #16a085; border-radius: 4px;">Home</a>
      <a href="./faq.php">FAQs</a>
      <a href="./rental.php">Rent a Book</a>
    </div>
    <div class="nav-logout">
      <button class="logout-btn" onclick="window.location.href='./database/logout.php'">Logout</button>
    </div>
  </nav>
  
  <div class="container">
    <h2>Discover. Read. Learn.</h2>
    <p>Manage your library efficiently — search books, track members, and handle issuing and returns with ease.</p>
    <img src="library.jpeg" alt="Library Image" style="max-width: 1000px; width: 100%;">
  </div>

  <footer>
    &copy; 2025 Library Management System. All rights reserved.
  </footer>
</body>
</html>