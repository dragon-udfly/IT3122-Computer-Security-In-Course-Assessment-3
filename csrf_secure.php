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

if (empty($_COOKIE['csrf_cookie'])) {
    $cookie_token = bin2hex(random_bytes(32)); 
    setcookie('csrf_cookie', $cookie_token, time() + 3600, '/', '', false, false);
} else {
    $cookie_token = $_COOKIE['csrf_cookie'];
}

$message = "Please enter your new password.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'] ?? '';
    $form_token = $_POST['csrf_token'] ?? '';
    
    if (!hash_equals($cookie_token, $form_token)) {
        $message = "<span style='color:green; font-weight:bold;'>SECURITY SUCCESS:</span> CSRF (Double-Submit) token validation failed. Action blocked!";
        goto end_of_post; 
    }
    
    if (!empty($new_password)) {
        
        if (isset($pdo)) {
            $user_id_to_update = 1; 
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            
            try {
                $stmt->execute([$new_password, $user_id_to_update]);
                
                $message = "<span style='color:green; font-weight:bold;'>SECURITY SUCCESS:</span> Password changed successfully. Request validated by Double-Submit Cookie.";
            
            } catch (PDOException $e) {
                $message = "Database Error: " . $e->getMessage();
            }
        } else {
             $message = "Database is unavailable. Cannot perform update.";
        }

    } else {
        $message = "Error: Password cannot be empty.";
    }
}
end_of_post:
?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure Change Password Form (Double-Submit Cookie Fixed)</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .box { 
            border: 2px solid green; 
            padding: 20px; 
            background: #e0ffe0; 
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <h1>Trusted Site: Secure Change Password (Double-Submit Cookie Fixed)</h1>
    
    <div class="box">
        <form method="POST" action="csrf_double_submit.php">
            <label for="new_password">New Password:</label>
            <input type="text" name="new_password" id="new_password" required>
            
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($cookie_token); ?>">
            
            <button type="submit">Change Password</button>
        </form>
        <p><b>Status:</b> <?php echo $message; ?></p>
    </div>
    
    <h3>Demonstration:</h3>
    <p>Run the <code>attacker_site1.html</code> file against this URL. The attack will be successfully blocked because the attacker's site cannot access the cookie value to submit it in the hidden form field.</p>
</body>
</html>