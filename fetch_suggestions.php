<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("connect.php");
$data = $_GET["data"];
$allowedKeys = array(
    'switch',
    'hl_switch',
    'scenario',
    'plug',
    'fan',
    'dimmer',
    'tunable',
    'curtain'
);
$conditions = array();
$conditions1 = array();

foreach ($allowedKeys as $allowedKey) {
    if (isset($data[$allowedKey])) {
        $conditions[] = "$allowedKey = :$allowedKey";
    }
}
$conditionsString = implode(" OR ", $conditions);
foreach ($allowedKeys as $allowedKey) {
    if (!isset($data[$allowedKey])) {
        $conditions1[] = "$allowedKey = 0";
    }
}
$conditionsString1 = implode(" AND ", $conditions1);
try {
    $query = "SELECT * FROM panel_sugg WHERE ($conditionsString) AND ($conditionsString1)";
    $stmt = $pdo->prepare($query);
    foreach ($allowedKeys as $allowedKey) {
        if (isset($data[$allowedKey])) {
            $stmt->bindValue(":$allowedKey", $data[$allowedKey]);
        }
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check for JSON encoding errors
    $jsonError = json_last_error();
    if ($jsonError !== JSON_ERROR_NONE) {
        throw new Exception("JSON encoding error: " . json_last_error_msg());
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>