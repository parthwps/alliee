<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("connect.php");

// Fetching the filter criteria from the user (requestData)
$requestData = json_decode(file_get_contents("php://input"), true);

// If switch value is provided in the request data, use it; otherwise, set it to null
$selectedSwitch = isset($requestData['switch']) ? $requestData['switch'] : null;

// Define the range of switches for each value
$switchRanges = [
    1 => [1, 2, 3, 4],
    2 => [1, 2, 3, 4],
    3 => [2, 3, 4, 5],
    4 => [3, 4, 5, 6],
    5 => [4, 5, 6, 7],
    6 => [5, 6, 7, 8],
    7 => [5, 6, 7, 8],
    8 => [5, 6, 7, 8]
];

// Get the switch range for the selected switch value, or all switches if no value is provided
$switchRange = $selectedSwitch ? ($switchRanges[$selectedSwitch] ?? []) : [];

// Construct the SQL query
$sql = "SELECT * FROM panel_sugg";

// Add switch range condition to the SQL query if a switch value is provided
if (!empty($switchRange)) {
    $sql .= " WHERE switch BETWEEN :minSwitch AND :maxSwitch";
}

try {
    // Prepare and execute the SQL query
    $stmt = $pdo->prepare($sql);
    if (!empty($switchRange)) {
        $stmt->bindValue(":minSwitch", min($switchRange), PDO::PARAM_INT);
        $stmt->bindValue(":maxSwitch", max($switchRange), PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = array_filter($result, function($row) use ($requestData) {
        $fanCondition = 0;
        $curtainCondition = 0;
        $dimmerCondition = 0;
        if (isset($requestData['fan']) && $requestData['fan'] !== 0) {
            $fanCondition = isset($row['fan']) && $row['fan'] == $requestData['fan'];
        }else{
            $fanCondition = isset($row['fan']) && $row['fan'] == 0;
        }
    
        // Check 'curtain' condition - ensure it's not set or not equal to 0
        $curtainCondition = !isset($row['curtain']) || $row['curtain'] !== 0;
        $dimmerCondition = !isset($row['dimmer']) || $row['dimmer'] !== 0;
        // Return true if both conditions are met
        return $fanCondition && $curtainCondition && $dimmerCondition;
    });
    
    // Output the filtered data as JSON
    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    // Handle any errors
    echo "Query failed: " . $e->getMessage();
}
?>
