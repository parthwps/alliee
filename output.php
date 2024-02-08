<?php
session_start();
require("connect.php");
if (isset($_POST['checkedItems'])) {
    // Retrieve the checked items from the AJAX request and decode the JSON string
    $checkedItems = $_POST['checkedItems'];

    // Check if decoding was successful
    if ($checkedItems !== null) {
    $temp = 0;
        foreach ($checkedItems as $item) {
                try {
                    $stmt = $pdo->prepare("SELECT `id`,`name` FROM rooms WHERE `id`=".$item['r']);
                    $stmt->execute();
                    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    try {
                        echo "<div class='table-div'>";
                        $stmt2 = $pdo->prepare("SELECT `id`,`panel` FROM panels WHERE `id`=".$item['p']);
                        $stmt2->execute();
                        $panels = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        echo "<h4 class='o_room_h4'>Rooms: ".$rooms[0]["name"]."<span class='o_room_panel'>(".$panels[0]["panel"].")</span></h4>";

                        if(isset($_POST['panelselected'][$temp])){
                            echo "<p class='o_room_sugg_title'>Selected Panels from suggestions</p>";
                            echo "<table class='table table-striped'>";
                            echo "<tr><th>Panel</td><td>Module</td></tr>";
                            foreach ($_POST['panelselected'][$temp] as $key => $value) {
                                try {
                                    $stmt2 = $pdo->prepare("SELECT * FROM panel_sugg WHERE `id`=".$value);
                                    $stmt2->execute();
                                    $panels = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                                    echo "<tr><td>".$panels[0]["name"]."</td><td>".$panels[0]["module"]."</td></tr>";
                                } catch (PDOException $e) {
                                    echo "Error: No Panels Found Selected";
                                }
                            }
                            echo "</table>";
                        }else{
                            echo "<p class='p-3'>No Panels Selected From Suggested Panels.</p>";
                        }
                        $temp++;
                        echo "</div>";
                    } catch (PDOException $e) {
                        echo "Error: No Panels Selected";
                    }
                } catch (PDOException $e) {
                    echo "Error: No Rooms Selected";
                }
        }
    } else {
        echo "Error: Invalid JSON data";
    }
} else {
    echo "Error: Data not received";
}
?>
