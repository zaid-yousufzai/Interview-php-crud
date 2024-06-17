<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password =?');
    $stmt->bind_param('ss', $username,$password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $user,$pass);
    $stmt->fetch();
// echo $stmt->num_rows();

// exit;
    if ($stmt->num_rows > 0) {
        $_SESSION['user_id'] = $id;
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p><?= $error ?></p>
    <?php endif; ?>
    <form method="post">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
