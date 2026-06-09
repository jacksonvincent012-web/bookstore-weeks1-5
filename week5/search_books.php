                <?php
include("db_connect.php");
session_start();

// Block access if not logged in
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST['search']);
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
        $like = "%$search%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $results = $stmt->get_result();
    }
}
?>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Search Books - PageTurn</title>
                    <style>
                    body {
                        font-family: 'Segoe UI', sans-serif;
                        background: linear-gradient(135deg, #0072ff, #00c6ff);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        color: #003366;
                    }

                    .card {
                        background: rgba(255, 255, 255, 0.25);
                        backdrop-filter: blur(12px);
                        padding: 40px;
                        border-radius: 16px;
                        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
                        width: 600px;
                        text-align: center;
                    }

                    h2 {
                        margin-bottom: 20px;
                        font-weight: bold;
                    }

                    input {
                        padding: 12px;
                        margin: 10px 0;
                        border: none;
                        border-radius: 8px;
                        width: 80%;
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

                    th,
                    td {
                        padding: 12px;
                        text-align: left;
                        color: #003366;
                    }

                    th {
                        background: rgba(255, 255, 255, 0.6);
                        font-weight: bold;
                    }

                    tr:nth-child(even) {
                        background: rgba(255, 255, 255, 0.3);
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
                        <h2>🔍 Search Books</h2>
                        <form method="POST" action="">
                            <input type="text" name="search" placeholder="Enter title or author">
                            <button type="submit">Search</button>
                        </form>

                        <?php if(!empty($results) && $results->num_rows > 0){ ?>
                        <table>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                            </tr>
                            <?php while($row = $results->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                        <?php } elseif($_SERVER["REQUEST_METHOD"] == "POST") { ?>
                        <p>⚠️ No books found matching your search.</p>
                        <?php } ?>

                        <a href="dashboard.php">⬅ Back to Dashboard</a>
                    </div>
                </body>

                </html>