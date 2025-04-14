<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./login.html");
    exit();
}

require_once './database/config.php';

// Fetch books from database
$stmt = $conn->query("SELECT title, author, genre FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$thankYouMessage = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookTitle = $_POST['bookTitle'];
    $author = $_POST['author'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $duration = $_POST['duration'];

    $stmt = $conn->prepare("INSERT INTO rentals (bookTitle, author, name, email, phone, duration) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$bookTitle, $author, $name, $email, $phone, $duration]);

    $thankYouMessage = "Thank you for renting '$bookTitle' from our website! We've sent the details to $email.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rent a Book</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./styles/rental.css">
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
      <a href="./addBooks.php">Add Book</a>
      <a href="./rental.php" style="background-color: #16a085; border-radius: 4px;">Rent a Book</a>
    </div>
    <div class="nav-logout">
      <button class="logout-btn" onclick="window.location.href='./database/logout.php'">Logout</button>
    </div>
  </nav>

  <div class="container">
    <h2 class="page-title">Rent a Book</h2>
    <p class="page-subtitle">Select a book and fill in your details to complete the rental</p>
    
    <div class="rental-container">
      <div class="available-books">
        <h3>Available Books</h3>
        <div class="genre-filter">
          <button class="genre-btn active" onclick="filterByGenre('all')">All</button>
          <button class="genre-btn" onclick="filterByGenre('Fictional')">Fictional</button>
          <button class="genre-btn" onclick="filterByGenre('Historic')">Historic</button>
          <button class="genre-btn" onclick="filterByGenre('Comic')">Comic</button>
          <button class="genre-btn" onclick="filterByGenre('Travel')">Travel</button>
        </div>
        <div class="book-list" id="bookList">
          <?php foreach ($books as $book): ?>
            <div class="book-item" 
                 data-title="<?= htmlspecialchars($book['title']) ?>" 
                 data-author="<?= htmlspecialchars($book['author']) ?>" 
                 data-genre="<?= htmlspecialchars($book['genre']) ?>">
              <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
              <div class="book-author"><?= htmlspecialchars($book['author']) ?></div>
              <div class="book-genre"><?= htmlspecialchars($book['genre']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      
      <div class="rental-form">
        <h3>Rental Information</h3>
        <form id="rentalForm" method="POST">
          <div class="form-group">
            <label for="selectedBook">Selected Book</label>
            <input type="text" id="selectedBook" name="bookTitle" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="name">Your Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="duration">Rental Duration (days)</label>
            <select id="duration" name="duration" class="form-control" required>
              <option value="">Select duration</option>
              <option value="7">7 days</option>
              <option value="14">14 days</option>
              <option value="21">21 days</option>
            </select>
          </div>
          <button type="submit" class="btn">Complete Rental</button>
        </form>
      </div>
    </div>

    <?php if (!empty($thankYouMessage)): ?>
      <div class="thank-you-message">
        <div class="message-box">
          <h3>Thank You!</h3>
          <p><?php echo htmlspecialchars($thankYouMessage); ?></p>
          <button onclick="document.querySelector('.thank-you-message').style.display='none'">OK</button>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <footer>
    &copy; 2025 Library Management System. All rights reserved.
  </footer>

  <script>
    function filterByGenre(genre) {
      const allBooks = document.querySelectorAll('.book-item');
      allBooks.forEach(book => {
        const bookGenre = book.getAttribute('data-genre').toLowerCase();
        if (genre.toLowerCase() === 'all' || bookGenre === genre.toLowerCase()) {
          book.style.display = 'block';
        } else {
          book.style.display = 'none';
        }
      });

      document.querySelectorAll('.genre-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.textContent.toLowerCase() === genre.toLowerCase() || (genre.toLowerCase() === 'all' && btn.textContent.toLowerCase() === 'all')) {
          btn.classList.add('active');
        }
      });
    }

    function selectBook(element, title, author) {
      document.querySelectorAll('.book-item').forEach(book => {
        book.classList.remove('selected');
      });
      element.classList.add('selected');
      document.getElementById('selectedBook').value = title;
      document.getElementById('author').value = author;
    }

    document.querySelectorAll('.book-item').forEach(item => {
      item.addEventListener('click', () => {
        const title = item.getAttribute('data-title');
        const author = item.getAttribute('data-author');
        selectBook(item, title, author);
      });
    });

    document.getElementById('rentalForm').addEventListener('submit', function(e) {
      const selectedBook = document.getElementById('selectedBook').value;
      if (!selectedBook) {
        e.preventDefault();
        alert('Please select a book first');
        return;
      }
    });

    filterByGenre('all');
  </script>
</body>
</html>