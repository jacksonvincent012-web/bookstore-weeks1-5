<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$userId = null;
$userResult = mysqli_query($conn, "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'");
if($userRow = $userResult->fetch_assoc()){
    $userId = $userRow['id'];
}

// Submit rating
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'], $_POST['rating'])){
    $bookId = intval($_POST['book_id']);
    $rating = floatval($_POST['rating']);
    $review = trim($_POST['review'] ?? "");

    if($rating < 0.5 || $rating > 5.0){
        $error = "Rating must be between 0.5 and 5.0.";
    } else {
        $stmt = $conn->prepare("INSERT INTO ratings (book_id, user_id, rating, review) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE rating = VALUES(rating), review = VALUES(review)");
        $stmt->bind_param("iids", $bookId, $userId, $rating, $review);
        if($stmt->execute()){
            // Update the average rating in books table
            $avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg FROM ratings WHERE book_id = $bookId"))['avg'];
            $updateAvg = $conn->prepare("UPDATE books SET rating = ? WHERE id = ?");
            $updateAvg->bind_param("di", $avg, $bookId);
            $updateAvg->execute();

            $success = "Rating submitted!";
        } else {
            $error = "Error submitting rating: " . $conn->error;
        }
    }
}

$books = mysqli_query($conn, "SELECT id, title, author FROM books ORDER BY title");
$ratings = mysqli_query($conn, "SELECT r.rating, r.review, r.created_at, b.title AS book_title, u.username FROM ratings r JOIN books b ON r.book_id = b.id JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ratings - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        margin: 0; padding: 0; color: #003366; display: flex;
    }
    .main { flex: 1; padding: 40px; margin-left: 260px; }
    h1 { text-align: center; margin-bottom: 30px; }
    .card {
        background: rgba(255,255,255,0.25); backdrop-filter: blur(12px);
        padding: 20px; border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2); margin-bottom: 20px;
    }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.3); }
    th { background: rgba(255,255,255,0.3); }
    select, input, textarea, button {
        padding: 10px; margin: 5px 0; border: none; border-radius: 6px; width: 100%; box-sizing: border-box;
    }
    button { background: #0072ff; color: #fff; font-weight: bold; cursor: pointer; width: auto; }
    button:hover { background: #005fcc; }
    .success { color: #28a745; font-weight: bold; }
    .error { color: #ff4d4d; font-weight: bold; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Book Ratings & Reviews</h1>

        <div class="card">
            <h3>Submit a Rating</h3>
            <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <select name="book_id" required>
                    <option value="">Select a book</option>
                    <?php while($b = $books->fetch_assoc()){ ?>
                    <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['title']) ?> by <?= htmlspecialchars($b['author']) ?></option>
                    <?php } ?>
                </select>
                <label>Rating (0.5 - 5.0)</label>
                <input type="number" step="0.5" min="0.5" max="5.0" name="rating" required>
                <label>Review (optional)</label>
                <textarea name="review" rows="3" placeholder="Write your review..."></textarea>
                <button type="submit">Submit Rating</button>
            </form>
        </div>

        <div class="card">
            <h3>All Ratings & Reviews</h3>
            <?php if($ratings->num_rows > 0){ ?>
            <table>
                <tr><th>Book</th><th>User</th><th>Rating</th><th>Review</th><th>Date</th></tr>
                <?php while($r = $ratings->fetch_assoc()){ ?>
                <tr>
                    <td><?= htmlspecialchars($r['book_title']) ?></td>
                    <td><?= htmlspecialchars($r['username']) ?></td>
                    <td><?= $r['rating'] ?> / 5</td>
                    <td><?= $r['review'] ? htmlspecialchars($r['review']) : '-' ?></td>
                    <td><?= date("M d, Y", strtotime($r['created_at'])) ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <p>No ratings yet. Be the first!</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
