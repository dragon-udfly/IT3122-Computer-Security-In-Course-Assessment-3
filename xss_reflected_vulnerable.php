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

$item_name = '';
$results = [];
$message = 'Search for a product (e.g., Apple).';

if (isset($_GET['item'])) {
    $item_name = trim($_GET['item']);
    
    $sql = "SELECT product_id, product_name, price FROM products WHERE product_name LIKE ?";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute(["%$item_name%"]); 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        $message = "Found " . count($results) . " matching product(s).";
    } else {
        $message = "No products found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Vulnerability Demo (Products)</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .result-box {
            border: 2px solid red; 
            padding: 15px; 
            background: #ffe0e0; 
            margin-top: 20px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #f59e9e; }
    </style>
</head>
<body>
    <h1>Reflected XSS Vulnerability</h1>
    
    <form method="GET">
        <label for="item">Search Product Name:</label>
        <input type="text" name="item" id="item" size="40" placeholder="e.g., Apple Watch">
        <button type="submit">Search</button>
    </form>

    <?php
    if (!empty($item_name) || count($results) > 0) {
        echo '<div class="result-box">';
        
        echo "<h2>Search Results for: " . $item_name . "</h2>";
        
        echo "<p>Status: " . $message . "</p>";

        if (count($results) > 0) {
            echo "<table>";
            echo "<thead><tr><th>Product ID</th><th>Product Name</th><th>Price</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
        echo '</div>';
    }
    ?>
</body>
</html>