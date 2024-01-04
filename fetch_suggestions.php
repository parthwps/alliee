<body style="background:red;">
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
// echo "good";

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
// print_r($conditions);
$conditionsString1 = implode(" AND ", $conditions1);
try {
    //  WHERE ($conditionsString) AND ($conditionsString1)
    $query = "SELECT * FROM panel_sugg";
    echo $query;

    $stmt = $pdo->prepare($query);
    var_dump($stmt);
    // foreach ($allowedKeys as $allowedKey) {
    //     if (isset($data[$allowedKey])) {
    //         $stmt->bindValue(":$allowedKey", $data[$allowedKey]);
    //     }
    // }

    if($stmt->execute()){
        echo "good";
    }else{
        echo "not good";
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);
    echo json_encode($result);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    echo "test";
}
?>
</body>