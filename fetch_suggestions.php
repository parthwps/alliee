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

foreach ($allowedKeys as $allowedKey) {
    if (isset($data[$allowedKey]) && $data[$allowedKey] > 0) {
        $conditions[] = "$allowedKey > 0";
    }
}

$conditionsString = implode(" AND ", $conditions);

try {
    $query = "SELECT * FROM panel_sugg WHERE $conditionsString";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check for JSON encoding errors
    $jsonError = json_last_error();
    if ($jsonError !== JSON_ERROR_NONE) {
        throw new Exception("JSON encoding error: " . json_last_error_msg());
    }
    
    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>
