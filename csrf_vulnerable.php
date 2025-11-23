<?php

session_start();

$host = 'localhost';
$dbname = 'security_db'; 
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $message = "Database Connection failed: " . $e->getMessage();
}

$message = "Please enter your new password.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'] ?? '';
    
    if (!empty($new_password)) {
        
        if (isset($pdo)) {
            $user_id_to_update = 1; 

            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            
            try {
                $stmt->execute([$new_password, $user_id_to_update]);
                
                $message = "<span style='color:red; font-weight:bold;'>VULNERABILITY SUCCESS:</span> Password changed successfully to: " . htmlspecialchars($new_password) . ". User ID: {$user_id_to_update} updated in DB. This action was executed by an attacker via CSRF!";
            
            } catch (PDOException $e) {
                $message = "Database Error (Check your 'users' table and 'password' column): " . $e->getMessage();
            }
        } else {
             $message = "Database is unavailable. Cannot perform update.";
        }

    } else {
        $message = "Error: Password cannot be empty.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Change Password Form</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { 
            border: 2px solid red; 
            padding: 20px; 
            background: #ffe0e0; 
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <h1>Trusted Site: Vulnerable Change Password (Database Target)</h1>
    
    <div class="box">
        <form method="POST" action="csrf_vulnerable.php">
            <label for="new_password">New Password:</label>
            <input type="text" name="new_password" id="new_password" required>
            <button type="submit">Change Password</button>
        </form>
        <p><b>Status:</b> <?php echo $message; ?></p>
    </div>
    
    <h3>Demonstration:</h3>
    <p>Run <code>attacker_site.html</code> in a separate tab to trigger this vulnerability.</p>
</body>
</html>