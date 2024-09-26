<?php
// Database connection
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);
    
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                echo "Registration successful!";
                header("Location: login.php");
                exit();
            } else {
                echo "Registration failed. Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neon Registration Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Orbitron', sans-serif;
            background: #0f0f0f;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .register-container {
            background: rgba(15, 15, 15, 0.9);
            padding: 50px;
            border-radius: 15px;
            text-align: center;
            width: 400px;
            position: relative;
            box-shadow: 0 0 20px rgba(255, 0, 255, 0.7);
            border: 1px solid rgba(255, 0, 255, 0.5);
        }
        .register-container::before {
            content: '';
            position: absolute;
            top: -5px;
            bottom: -5px;
            left: -5px;
            right: -5px;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 0, 255, 0.7), 0 0 60px rgba(255, 0, 255, 0.5);
            z-index: -1;
        }
        h2 {
            color: #ff00ff;
            font-size: 30px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: none;
            background: transparent;
            border-bottom: 2px solid #ff00ff;
            color: #fff;
            font-size: 16px;
            outline: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-register {
            width: 100%;
            padding: 15px;
            background: #ff00ff;
            color: #000;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
            transition: 0.3s ease;
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.5);
        }
        .btn-register:hover {
            background: #ff66ff;
            box-shadow: 0 0 20px rgba(255, 102, 255, 0.8);
        }
        .neon-effect {
            text-shadow: 0 0 10px #ff00ff, 0 0 20px #ff00ff, 0 0 30px #ff00ff;
        }
        .terms {
            margin-top: 15px;
            font-size: 12px;
        }
        .terms input {
            margin-right: 10px;
        }
        .back-to-login {
            margin-top: 20px;
            font-size: 14px;
        }
        .back-to-login a {
            color: #ff00ff;
            text-decoration: none;
        }
        .back-to-login a:hover {
            text-shadow: 0 0 5px #ff00ff;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="neon-effect">Register</h2>
        <form action="" method="POST">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <input type="password" class="form-control" name="confirm-password" placeholder="Confirm Password" required>
            <div class="terms">
                <input type="checkbox" name="terms" required> I agree to the Terms & Conditions
            </div>
            <button type="submit" class="btn-register">Register</button>
        </form>
        <div class="back-to-login">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
