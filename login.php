<?php
$host = 'localhost';
$db = 'olx_db'; // Replace with your actual database name
$user = 'root'; // Replace with your MySQL username
$pass = 'Kenc1k06'; // Replace with your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                echo "Login successful! Welcome, " . $_SESSION['user_name'];
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that email.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neon Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Orbitron', sans-serif;
            background: #000;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
            border: 1px solid rgba(0, 255, 255, 0.4);
        }
        .login-container h2 {
            color: #00ffff;
            text-transform: uppercase;
            font-size: 24px;
            margin-bottom: 30px;
        }
        .form-control {
            width: 100%;
            padding: 15px;
            border: none;
            background: transparent;
            border-bottom: 2px solid #00ffff;
            margin-bottom: 20px;
            font-size: 16px;
            color: #fff;
            outline: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-login {
            width: 100%;
            padding: 15px;
            background: #00ffff;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
        }
        .btn-login:hover {
            background: #00a3a3;
        }
        .neon-effect {
            text-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff, 0 0 30px #00ffff, 0 0 40px #00ffff;
        }
        .forgot-password {
            margin-top: 20px;
            font-size: 12px;
        }
        .forgot-password a {
            color: #00ffff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-shadow: 0 0 5px #00ffff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="neon-effect">Login</h2>
        <form action="" method="POST">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <input type="submit" name="ok" value="Login" class="btn-login">
        </form>
        <div class="forgot-password">
            <a href="register.php">Not account yet?</a>
        </div>
    </div>
</body>
</html>
