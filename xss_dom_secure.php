<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Secure DOM-Based XSS Solution</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .info-box {
            border: 2px solid green; 
            padding: 15px; 
            background: #e0ffe0; 
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>DOM-Based XSS Secure Solution</h1>
    <p>This page safely reads data from the URL fragment (the part after the #) and displays it below.</p>

    <div class="info-box">
        <h2>Custom Message (Secure):</h2>
        <p id="display">Awaiting input from URL hash...</p>
    </div>

    <script>
        const hash = window.location.hash.substring(1); 

        if (hash.length > 0) {
            document.getElementById('display').textContent = "You customized the message: " + hash;
        }
    </script>
</body>
</html>