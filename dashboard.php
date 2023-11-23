<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex justify-content-between mt-3">
    <h2>Select Room</h2>
    <div class="navbar">
    <!-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB1klEQVR4nO3YP6jNYRzH8dcVRZGk7qIsFBIGGRSJYpXIxIDFZqCsMimLLBKDDFKEgfEqUqQYLCY3FkUp5eJyuY9+9Qyn0zmnc87vOefn9+t512f9Ps/793v+k8lkMplMJpPBY7zCmrp/jRDzBXs1QCTgD85qgEiIuYUlGiBS5DVWa4BIkc/YpQEiAbM4oQEiIeYqFlXd2WXYh/O4jSd4i68DiARMYeW4O78Cp/AScwN2uFemsWkcAmtxAz8Sdj605RsOjkqgWPfP4ecIBUJL5nEBC1JKbMa7MQmEttyPc7A0hzBTkUSIeVFW4lj8xaHOIvsTr0bD5hGWDyuxZYyTOnTJfNyXhp7si/GmYomZODdLcaliiem4SpZiHX5XKPEUkxLwYMCGf+E5ruAMDmBbvJ9Pxk2031qXsTCFxMY+l9r3uIidfd7y+jnGH5eQ6z0aKwQfYjcmBqzbS+IjtqeUWIrvXRorhs7WErW7SRSn5lUSc6RDQ3Nx3Jc9tHWSuBmX+eTc6XCM3pOodvtz0GkjYgKfWhordvQdCeuP7YFuQ9tXO5q4/lR8Mi0uZCPlZIvEXTXmWpT4i/Vq/loecE/N+RBFDqs5s1EkyWGtSp7FW1gmk8n47/gHPrwN5aSVwGoAAAAASUVORK5CYII="> -->
        <button class="navbar-toggler" type="button" data-toggle="tooltip" data-placement="left" title="Selected Rooms" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
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
            echo '<div class="col-lg-3 col-md-4 col-6 form-check"><input class="form-check-input" type="checkbox" id="'.$panel['id'].'" data-panel-id="'.$panel['id'].'" data-room-id="'.$room['id'].'">
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
$('.form-check-input').on('change', function() {
    var checkedItems = [];
    var rooms = [];

    $('.form-check-input:checked').each(function() {
        var roomId = $(this).data('room-id');
        var panelId = $(this).data('panel-id');
        checkedItems.push({ r: roomId, p: panelId });
        if (rooms.indexOf(roomId) === -1) {
            rooms.push(roomId);
        }
    });

    localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
    var checkedItems = localStorage.getItem('checkedItems');

    localStorage.setItem('rooms', JSON.stringify(rooms));
    var rooms = localStorage.getItem('rooms');
    updaterooms();
    
});

$(document).ready(function() {
    var storedRooms = localStorage.getItem('allRooms');
    $.ajax({
        type: "GET",
        url: "ajaxfunctions.php",
        dataType: "json",
        success: function(response) {
            if (response.success) {
                if (storedRooms === null) {
                    localStorage.setItem('allRooms', JSON.stringify(response.rooms));
                }
                updaterooms();
            } else {
                console.error("Error fetching rooms: " + response.message);
            }
        },
        error: function(error) {
            console.error("AJAX Error:", error);
        }
    });
    
    var storedItems = localStorage.getItem('checkedItems');
    if (storedItems) {
        storedItems = JSON.parse(storedItems);

        storedItems.forEach(function(item) {
            $('#' + item.p).prop('checked', true);
        });
    }
});
function updaterooms(){
        var rooms = JSON.parse(localStorage.getItem('rooms'));
        var allRooms = JSON.parse(localStorage.getItem('allRooms'));
        var roomsContainer = $('#roomsContainer');
        roomsContainer.empty(); 
        rooms.forEach(function(roomId) {
            allRooms.forEach(function(room) {
                if(room.id == roomId){
                    var roomHtml = '<li class="nav-item"><a class="nav-link" href="foyer.php">' + room.name + '</a></li>';
                    roomsContainer.append(roomHtml);
                }
            });
        });
    }
</script>
<?php include("footer.php");?>