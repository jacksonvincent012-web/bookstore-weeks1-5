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

// Handle new order
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])){
    $bookId = intval($_POST['book_id']);
    $quantity = intval($_POST['quantity']);
    if($quantity < 1) $quantity = 1;

    $bookStmt = $conn->prepare("SELECT price, stock FROM books WHERE id = ?");
    $bookStmt->bind_param("i", $bookId);
    $bookStmt->execute();
    $book = $bookStmt->get_result()->fetch_assoc();

    if($book && $book['stock'] >= $quantity){
        $total = $book['price'] * $quantity;

        $conn->begin_transaction();
        try {
            $orderStmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
            $orderStmt->bind_param("id", $userId, $total);
            $orderStmt->execute();
            $orderId = $conn->insert_id;

            $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
            $itemStmt->bind_param("iiid", $orderId, $bookId, $quantity, $book['price']);
            $itemStmt->execute();

            $updateStmt = $conn->prepare("UPDATE books SET stock = stock - ? WHERE id = ?");
            $updateStmt->bind_param("ii", $quantity, $bookId);
            $updateStmt->execute();

            $conn->commit();
            $success = "Order placed successfully!";
        } catch(Exception $e){
            $conn->rollback();
            $error = "Order failed: " . $e->getMessage();
        }
    } else {
        $error = "Insufficient stock.";
    }
}

// Fetch orders
$orders = $conn->prepare("SELECT o.id, o.order_date, o.total_amount, o.status, u.username FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");
$orders->execute();
$ordersResult = $orders->get_result();

// Fetch books for order form
$books = mysqli_query($conn, "SELECT id, title, price, stock FROM books WHERE stock > 0");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orders - PageTurn</title>
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
    select, input, button {
        padding: 10px; margin: 5px; border: none; border-radius: 6px;
    }
    button { background: #0072ff; color: #fff; font-weight: bold; cursor: pointer; }
    button:hover { background: #005fcc; }
    .success { color: #28a745; font-weight: bold; }
    .error { color: #ff4d4d; font-weight: bold; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main">
        <h1>Orders</h1>

        <div class="card">
            <h3>Place New Order</h3>
            <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <select name="book_id" required>
                    <option value="">Select a book</option>
                    <?php while($b = $books->fetch_assoc()){ ?>
                    <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['title']) ?> - $<?= $b['price'] ?> (Stock: <?= $b['stock'] ?>)</option>
                    <?php } ?>
                </select>
                <input type="number" name="quantity" value="1" min="1" style="width:80px;" required>
                <button type="submit">Place Order</button>
            </form>
        </div>

        <div class="card">
            <h3>Order History</h3>
            <?php if($ordersResult->num_rows > 0){ ?>
            <table>
                <tr><th>Order #</th><th>Customer</th><th>Date</th><th>Amount</th><th>Status</th></tr>
                <?php while($o = $ordersResult->fetch_assoc()){ ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['username']) ?></td>
                    <td><?= date("M d, Y H:i", strtotime($o['order_date'])) ?></td>
                    <td>$<?= number_format($o['total_amount'], 2) ?></td>
                    <td><?= ucfirst($o['status']) ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <p>No orders placed yet.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
