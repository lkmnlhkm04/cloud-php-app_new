<?php
session_start();
require 'vendor/autoload.php';
use MongoDB\Client;

$uri = 'mongodb+srv://ccuser:CcPass123@clustercloud.oblomos.mongodb.net/?appName=clustercloud';
$client = new Client($uri);
$collection = $client->cloud_app->users;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $collection->findOne(['username' => $username]);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = "Username atau Password Anda salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Login Admin</h2>
    <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    
    <form method="POST" class="mt-3">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button type="submit" class="btn btn-primary">Login</button>

        <!-- Caption Tambahan -->
        <p class="text-center mt-3" style="font-size: 13px; color: #777; font-style: italic;">
            Created by <strong>Lukmanul Hakim</strong>
        </p>

    </form>
</div>
</body>
</html>
