<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $host = 'localhost';
    $dbname = 'alliee';
    $username = 'root';
    $password = '';
} else {
    $host = 'charmiel_alliee';
    $dbname = 'charmiel_alliee';
    $username = 'root';
    $password = 'Balaji@1234';
}



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
