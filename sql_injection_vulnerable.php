<?php
$host = 'localhost';
$dbname = 'security_db';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_input = $_POST['username'];

    $sql = "SELECT * FROM users WHERE username = '$username_input'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $message = "<span style='color:red; font-weight:bold;'>SUCCESS! <br> Logged in as: " . $user['username'] . "</span>";
    } else {
        $message = "Login failed.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Check User (MySQLi)</title>
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
            <h1>1. SQL Injection Risky Login</h1>
            <form method="POST">
                Username: <input type="text" name="username" required>
                <button type="submit">Check User</button>
            </form>
            <p><b>Result:</b> <?php echo $message; ?></p>
        </div>
    </body>
</html>
