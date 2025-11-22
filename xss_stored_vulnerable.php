<?php
$host = 'localhost';
$dbname = 'security_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    
    $stmt = $pdo->prepare("INSERT INTO comments (comment_text) VALUES (?)");
    $stmt->execute([$comment]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Stored XSS Demo</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        textarea { width: 98%; height: 80px; margin-bottom: 10px; border: 1px solid #aaa; }
        .comment-display { 
            border: 2px solid green; 
            padding: 15px; 
            margin-top: 20px;
            background: #ffe0e0;
        }
        .comment-item { 
            border-bottom: 1px dashed #ccc; 
            padding: 10px 0; 
            margin-bottom: 5px; 
        }
    </style>
</head>
<body>
    <h1>Stored XSS Vulnerability (Comment Section)</h1>
    
    <form method="POST">
        <h3>Leave a Comment (Vulnerable)</h3>
        <textarea name="comment" placeholder="Your comment here..."></textarea>
        <button type="submit">Post Comment</button>
    </form>

    <div class="comment-display">
        <h3>Existing Comments:</h3>
        <?php
        $stmt = $pdo->query("SELECT comment_text FROM comments ORDER BY id DESC");
        while ($row = $stmt->fetch()) {
            echo "<div class='comment-item'>" . $row['comment_text'] . "</div>";
        }
        ?>
    </div>
</body>
</html>