<?php
include("db_connect.php");
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$message = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])){
    $book_id = intval($_POST['book_id']);
    $quantity = intval($_POST['quantity']);
    $user_id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM users WHERE username='" . $_SESSION['user'] . "'"))['id'];

    if($quantity < 1){
        $error = "Quantity must be at least 1.";
    } else {
        $book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$book_id"));

        if(!$book){
            $error = "Book not found.";
        } elseif($book['stock'] < $quantity){
            $error = "Insufficient stock. Available: " . $book['stock'];
        } else {
            mysqli_begin_transaction($conn);
            try {
                $total = $book['price'] * $quantity;
                mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, status) VALUES ($user_id, $total, 'pending')");
                $order_id = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES ($order_id, $book_id, $quantity, {$book['price']})");
                mysqli_query($conn, "UPDATE books SET stock = stock - $quantity WHERE id = $book_id");
                mysqli_commit($conn);
                $message = "Order placed successfully! Order #$order_id";
            } catch(Exception $e){
                mysqli_rollback($conn);
                $error = "Order failed: " . $e->getMessage();
            }
        }
    }
}

$orders_result = mysqli_query($conn, "SELECT o.id, u.username, o.total_amount, o.status, o.created_at FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
$books_list = mysqli_query($conn, "SELECT id, title, price, stock FROM books WHERE stock > 0");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Orders - PageTurn</title>
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

    select, input {
        padding: 12px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        background: rgba(255, 255, 255, 0.4);
        color: #003366;
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
        <h2>Place Order</h2>

        <?php if($message) echo "<p class='message'>$message</p>"; ?>
        <?php if($error) echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="">
            <select name="book_id" required>
                <option value="">Select a book</option>
                <?php while($b = mysqli_fetch_assoc($books_list)){ ?>
                <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['title']) ?> - $<?= $b['price'] ?> (Stock: <?= $b['stock'] ?>)</option>
                <?php } ?>
            </select>
            <input type="number" name="quantity" placeholder="Quantity" min="1" required>
            <button type="submit" name="place_order">Place Order</button>
        </form>

        <h2>Order History</h2>
        <table>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php if(mysqli_num_rows($orders_result) > 0){
                while($o = mysqli_fetch_assoc($orders_result)){ ?>
            <tr>
                <td>#<?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['username']) ?></td>
                <td>$<?= number_format($o['total_amount'], 2) ?></td>
                <td><?= $o['status'] ?></td>
                <td><?= $o['created_at'] ?></td>
            </tr>
            <?php } } else { ?>
            <tr><td colspan="5">No orders yet.</td></tr>
            <?php } ?>
        </table>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>
