<?php
// connect.php contains your database connection logic
require("connect.php");
if($_GET["wf"] == 1){
    try {
        $stmt = $pdo->prepare("SELECT `id`,`name` FROM rooms");
        $stmt->execute();
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "rooms" => $rooms]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
if($_GET["wf"] == 2){
    try {
        $stmt = $pdo->prepare("SELECT `id`,`panel`,`modules` FROM panels");
        $stmt->execute();
        $panels = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "panels" => $panels]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
if($_GET["wf"] == 3){
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
?>