<?php

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
// echo "good";

$conditions = array();
$conditions1 = array();

foreach ($allowedKeys as $allowedKey) {
    if (array_key_exists($allowedKey, $data)) {
        $conditions[] = "$allowedKey = :$allowedKey";
    }
}
$conditionsString = implode(" OR ", $conditions);
foreach ($allowedKeys as $allowedKey) {
    if (array_key_exists($allowedKey, $data)) {
    }else{
        $conditions1[] = "$allowedKey = 0";
    }
}
// print_r($conditions);
$conditionsString1 = implode(" AND ", $conditions1);
try {
    $query = "SELECT * FROM panel_sugg";
    $stmt = $pdo->prepare($query);
    foreach ($allowedKeys as $allowedKey) {
        if (array_key_exists($allowedKey, $data)) {
            $stmt->bindValue(":$allowedKey", $data[$allowedKey]);
        }
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>
