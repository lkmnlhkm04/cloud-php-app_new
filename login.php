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
        $error = "Username atau Password Anda Salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;

            /* Gradient Background */
            background: linear-gradient(120deg, #74ebd5, #ACB6E5);
            font-family: Arial, sans-serif;
        }

        .login-box {
            width: 360px;
            padding: 30px;

            /* GLASSMORPHISM */
            background: rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            /* Animation */
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.7s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* icon toggle password */
        .toggle-pass {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="login-box text-center">

    <h3 class="mb-4 fw-bold">Login Admin</h3>

    <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="POST">

        <!-- Floating Label Username -->
        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
            <label for="username">Username</label>
        </div>

        <!-- Floating Label Password + Show/Hide -->
        <div class="form-floating mb-3 position-relative">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            <label for="password">Password</label>

            <span class="toggle-pass" onclick="togglePassword()">👁️</span>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="text-center mt-3" style="font-size: 13px; color: #222; font-style: italic;">
            Created by <strong>Lukmanul Hakim</strong>
        </p>
    </form>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
