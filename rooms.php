<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex justify-content-between mt-3">
    <div><h2 class="room-h2">Room</h2>
    <h5 class="panel-h5">Panel</h5></div>
    <div class="navbar">
        <a href="javascript:void(0)" onclick="prevroom()" style="font-size:1.25rem;margin-left:1rem;">< Prev</a>
        
        <a href="javascript:void(0)" onclick="nextroom()" style="font-size:1.25rem;margin-left:1rem;">Next ></a>
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