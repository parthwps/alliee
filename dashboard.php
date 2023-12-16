<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex justify-content-between mt-3">
    <h2>Select Room</h2>
    <div class="navbar navbar-dnav">
        <button class="navbar-toggler" type="button" data-toggle="tooltip" data-placement="left" title="Selected Rooms" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="rooms.php" style="font-size:2rem">></a>
    </div>
</div>
<div class="container main room" style="background-color:#f2f2f2;">
    <div class="row room-select">
<?php
require("connect.php");

try {
    $roomsQuery = $pdo->query("SELECT `id`, `name`, `time` FROM `rooms`");

    while ($room = $roomsQuery->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='row room-select'><h3>".$room['name']."</h3>";

        $panelsQuery = $pdo->prepare("SELECT `id`, `panel`, `room_id`, `time` FROM `panels` WHERE `room_id` = :roomId");
        $panelsQuery->bindParam(':roomId', $room['id'], PDO::PARAM_INT);
        $panelsQuery->execute();
        while ($panel = $panelsQuery->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-lg-3 col-md-4 col-6 form-check"><input class="form-check-input room-check-box" type="checkbox" id="'.$panel['id'].'" data-panel-id="'.$panel['id'].'" data-room-id="'.$room['id'].'">
            <label class="form-check-label" for="'.$panel['id'].'">'.$panel['panel'].'</label></div>';
        }
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>  
</div>
<script>
$(document).ready(function() {
    var checkedItems2 = JSON.parse(sessionStorage.getItem('checkedItems'));
    console.log(checkedItems2);
    if(checkedItems2 == null || checkedItems2 == 0){
        $('.navbar-dnav').css("display","none");
    }
    sessionStorage.setItem('currentroom',0);
    $('.room-check-box').on('change', function() {
    var checkedItems = [];
    var rooms = [];

    $('.room-check-box:checked').each(function() {
        var roomId = $(this).data('room-id');
        var panelId = $(this).data('panel-id');
        checkedItems.push({ r: roomId, p: panelId });
        if (rooms.indexOf(roomId) === -1) {
            rooms.push(roomId);
        }
    });
    if(checkedItems == null || checkedItems == 0){
        $('.navbar-dnav').css("display","none");
    }else{
        $('.navbar-dnav').css("display","flex");
    }
    sessionStorage.setItem('checkedItems', JSON.stringify(checkedItems));
    var checkedItems = sessionStorage.getItem('checkedItems');

    sessionStorage.setItem('rooms', JSON.stringify(rooms));
    var rooms = sessionStorage.getItem('rooms');
    updaterooms();
});
});
</script>
<?php include("footer.php");?>