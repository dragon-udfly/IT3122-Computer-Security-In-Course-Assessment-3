<?php

$host = 'localhost';
$dbname = 'security_db';
$username = 'root'; 
$password = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST['username'];
    
    // $sql = "SELECT * FROM users WHERE username = '$user_input'"; 
    // $stmt = $pdo->query($sql); 

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([$user_input]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $message = "Success! User ID: " . $user['id'];
    } else {
        $message = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Check User</title>
        <meta charset="utf-8">
        <style>
            div {
                margin: auto;
                width: 50%;
                border: 3px solid green;
                padding: 10px;
                margin-top: 10%;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>1. SQL Injection Secure Login</h1>
            <form method="POST">
                Username: <input type="text" name="username" required>
                <button type="submit">Check User</button>
            </form>
            <p><b>Result:</b> <?php echo $message; ?></p>
        </div>
    </body>
</html>