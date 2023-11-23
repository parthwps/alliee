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
        $stmt = $pdo->prepare("SELECT `id`,`panel` FROM panels");
        $stmt->execute();
        $panels = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "panels" => $panels]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
?>