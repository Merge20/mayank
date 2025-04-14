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
  <title>Add New Book</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./styles/addBooks.css">
</head>
<body>
  <header>
    <h1>Library Management System</h1>
  </header>

  <nav>
    <div class="nav-user">
      <div class="profile-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
        </svg>
      </div>
      <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
    </div>
    <div class="nav-center">
      <a href="./home.php">Home</a>
      <a href="./addBooks.php" style="background-color: #16a085; border-radius: 4px;">Add Book</a>
      <a href="./rental.php">Rent a Book</a>
    </div>
    <div class="nav-logout">
      <button class="logout-btn" onclick="window.location.href='./database/logout.php'">Logout</button>
    </div>
  </nav>

  <div class="container">
    <h2 class="form-title">Add a New Book</h2>
    <p class="form-description">Please fill in the details of the book you want to add.</p>

    <div class="form-container">
      <form action="./database/addBook.php" method="POST">
        <div class="form-group">
          <label for="bookTitle">Book Title</label>
          <input type="text" id="bookTitle" name="bookTitle" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="author">Author</label>
          <input type="text" id="author" name="author" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="genre">Genre</label>
          <select id="genre" name="genre" class="form-control" required>
            <option value="">Select a genre</option>
            <option value="fictional">Fictional</option>
            <option value="historic">Historic</option>
            <option value="comic">Comic</option>
            <option value="travel">Travel</option>
          </select>
        </div>
        <div class="form-group">
          <label for="year">Year of Publication</label>
          <input type="number" id="year" name="year" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="description">Book Description</label>
          <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn">Add Book</button>
      </form>
    </div>
    <?php if (isset($_SESSION['success_message'])): ?>
      <div class="alert-box">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
      </div>
    <?php endif; ?>

  </div>

  <footer>
    &copy; 2025 Library Management System. All rights reserved.
  </footer>
</body>
</html>