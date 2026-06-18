<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";
$user_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'"))['id'];

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_rating'])){
    $book_id = intval($_POST['book_id']);
    $rating = floatval($_POST['rating']);
    $review = trim($_POST['review']);

    if($rating < 1 || $rating > 5){
        $error = "Rating must be between 1 and 5.";
    } else {
        $stmt = $conn->prepare("INSERT INTO ratings (book_id, user_id, rating, review) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE rating=VALUES(rating), review=VALUES(review)");
        $stmt->bind_param("iids", $book_id, $user_id, $rating, $review);
        if($stmt->execute()){
            $avg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(rating) AS avg FROM ratings WHERE book_id=$book_id"))['avg'];
            mysqli_query($conn, "UPDATE books SET rating=$avg WHERE id=$book_id");
            $message = "Rating submitted!";
        } else {
            $error = "Error submitting rating.";
        }
    }
}

$ratings_result = mysqli_query($conn, "SELECT r.id, b.title AS book_title, u.username, r.rating, r.review, r.created_at FROM ratings r JOIN books b ON r.book_id = b.id JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$books_list = mysqli_query($conn, "SELECT id, title FROM books");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ratings - PageTurn</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0072ff, #00c6ff);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        color: #003366;
        margin: 0;
        padding: 40px;
    }

    .card {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(12px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 800px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-weight: bold;
    }

    select, input, textarea {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        background: rgba(255, 255, 255, 0.4);
        color: #003366;
    }

    textarea {
        resize: vertical;
    }

    button {
        padding: 12px 20px;
        background: #0072ff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        width: 95%;
    }

    button:hover {
        background: #005fcc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: left;
        color: #003366;
    }

    th {
        background: rgba(255, 255, 255, 0.6);
        font-weight: bold;
    }

    tr:nth-child(even) {
        background: rgba(255, 255, 255, 0.2);
    }

    .message {
        color: green;
        font-weight: bold;
        margin: 10px 0;
    }

    .error {
        color: #ff4d4d;
        font-weight: bold;
        margin: 10px 0;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 20px;
        background: #0072ff;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }

    a:hover {
        background: #005fcc;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2>Rate a Book</h2>

        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <select name="book_id" required>
                <option value="">Select a book</option>
                <?php while($b = mysqli_fetch_assoc($books_list)){ ?>
                <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['title']) ?></option>
                <?php } ?>
            </select>
            <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" step="0.1" required>
            <textarea name="review" placeholder="Write a review (optional)" rows="3"></textarea>
            <button type="submit" name="submit_rating">Submit Rating</button>
        </form>

        <h2>All Ratings</h2>
        <table>
            <tr>
                <th>Book</th>
                <th>User</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Date</th>
            </tr>
            <?php if(mysqli_num_rows($ratings_result) > 0){
                while($r = mysqli_fetch_assoc($ratings_result)){ ?>
            <tr>
                <td><?= htmlspecialchars($r['book_title']) ?></td>
                <td><?= htmlspecialchars($r['username']) ?></td>
                <td><?= $r['rating'] ?></td>
                <td><?= htmlspecialchars($r['review'] ?: '-') ?></td>
                <td><?= $r['created_at'] ?></td>
            </tr>
            <?php } } else { ?>
            <tr><td colspan="5">No ratings yet.</td></tr>
            <?php } ?>
        </table>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>
