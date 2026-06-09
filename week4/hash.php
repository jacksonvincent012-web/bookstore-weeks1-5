<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $plain = $_POST['plain'];
    echo "<p>Generated Hash:</p>";
    echo "<pre>" . password_hash($plain, PASSWORD_DEFAULT) . "</pre>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Hash Generator</title>
</head>

<body>
    <form method="POST">
        <input type="text" name="plain" placeholder="Enter password" required>
        <button type="submit">Generate Hash</button>
    </form>
</body>

</html>