<?php
require("connect.php");

// Assuming $_POST["data"] is an array containing key-value pairs
$data = $_POST["data"];
echo $data;
// Define a list of keys
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

// Initialize an array to store conditions
$conditions = array();
$conditions1 = array();

//"SELECT * FROM panel_sugg WHERE (switch = :switch OR scenario = :scenario OR plug = :plug) AND (hl_switch = 0 AND fan = 0 AND dimmer = 0 AND tunable = 0 AND curtain = 0)[{"id":"1","name":"1 Switch","module":"2 Module","type":"s","switch":"1","hl_switch":"0","scenario":"0","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"},{"id":"2","name":"4 Switch","module":"2 Module","type":"s","switch":"4","hl_switch":"0","scenario":"0","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"},{"id":"4","name":"4 Scenario","module":"2 Module","type":"ss","switch":"0","hl_switch":"0","scenario":"4","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"},{"id":"5","name":"2 Switch + 2 Scenario","module":"2 Module","type":"ss","switch":"2","hl_switch":"0","scenario":"2","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"},{"id":"6","name":"6 Switch + 2 Scenario","module":"4 Module","type":"ss","switch":"6","hl_switch":"0","scenario":"2","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"},{"id":"7","name":"8 Switch + 2 Scenario","module":"6 & 8 Module","type":"ss","switch":"8","hl_switch":"0","scenario":"2","plug":"0","fan":"0","dimmer":"0","tunable":"0","curtain":"0","time":"2023-12-15 13:51:49"}]"

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
$conditionsString1 = implode(" AND ", $conditions1);
try {
    $stmt = $pdo->prepare("SELECT * FROM panel_sugg WHERE ($conditionsString) AND ($conditionsString1)");
// echo "SELECT * FROM panel_sugg WHERE ($conditionsString) AND ($conditionsString1)";
    // Bind the values to the placeholders
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
