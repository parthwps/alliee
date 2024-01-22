<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("connect.php");

// $data = $_GET["data"];

// $allowedKeys = array(
//     'switch',
//     'hl_switch',
//     'scenario',
//     'plug',
//     'tunable'
// );
// $allowedmin1 = array(
//     'dimmer',
//     'curtain',
//     'fan'
// );
// $conditions = array();
// $conditions2 = array();

// foreach ($allowedKeys as $allowedKey) {
//     if($allowedKey=="switch"){
//         $switchmin1 = $data["switch"]-1;
//         $switchmin = $data["switch"];
//         $switchadd1 = $data["switch"] + 1;
//         $switchadd2 = $data["switch"] + 2;
//         $conditions[] = "($allowedKey = $switchmin1 OR $allowedKey = $switchmin OR $allowedKey = $switchadd1 OR $allowedKey = $switchadd2)";
//     }else{
//         if (isset($data[$allowedKey]) && $data[$allowedKey] >= 0) {
//             $conditions[] = "$allowedKey >= 0";
//         }
//     }
// }

// $conditionsString = implode(" AND ", $conditions);

// foreach ($allowedmin1 as $allowedKey) {
//     $conditions2[] = "$allowedKey = 0";
// }
// $conditionsString2 = implode(" AND ", $conditions2);


try {
    $query = "SELECT * FROM panel_sugg";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $jsonError = json_last_error();
    if ($jsonError !== JSON_ERROR_NONE) {
        throw new Exception("JSON encoding error: " . json_last_error_msg());
    }

    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>
