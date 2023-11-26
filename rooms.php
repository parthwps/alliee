<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex align-items-center justify-content-between mt-3">
    <div class="room-arrows">
        <a href="javascript:void(0)" onclick="prevroom()" class="room-arrow room-arrow-left"><span><</span> Prev Room</a>
    </div>
    <div class="room-titles">
        <div><h2 class="room-h2 justify-content-center">Room</h2>
        <h5 class="panel-h5">Panel</h5></div>
    </div>
    <div class="room-arrows">
        <a href="javascript:void(0)" onclick="nextroom()" class="room-arrow room-arrow-right">Next Room <span>></span></a>
    </div>
</div>
<div class="container">
    <div class="row g-3 room_modules">

    </div>
</div>
<script>
    $(document).ready(function() {
        roomsphp();
    });
</script>
<?php include("footer.php");?>