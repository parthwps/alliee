<?php
require("connect.php");

function selectFromTable($tableName, $columns, $whereConditions) {
    global $pdo;
    try {
        $sql = "SELECT " . implode(', ', $columns) . " FROM $tableName";
        if (!empty($whereConditions)) {
            $sql .= " WHERE " . implode(' AND ', array_map(function ($col) {
                return "$col = :$col";
            }, array_keys($whereConditions)));
        }
        $stmt = $pdo->prepare($sql);
        foreach ($whereConditions as $col => $value) {
            $stmt->bindValue(":$col", $value);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        return false;
    }
}
// Example usage:
// $tableName = "user";
// $columns = ["id", "firstname", "lastname"];
// $whereConditions = ["id" => 1];
// $userDetails = selectFromTable($tableName, $columns, $whereConditions);
// if ($userDetails) {
//     echo "User ID: {$userDetails['id']}<br>";
//     echo "First Name: {$userDetails['firstname']}<br>";
//     echo "Last Name: {$userDetails['lastname']}<br>";
// } else {
//     echo "Error fetching user details.";
// }
?>
