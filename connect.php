<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $host = 'localhost';
    $dbname = 'alliee';
    $username = 'root';
    $password = '';
} else {
    $host = 'localhost';
    $dbname = 'technocr_alliee';
    $username = 'technocr_alliee';
    $password = '9H*f?lXv;5vJ';
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
