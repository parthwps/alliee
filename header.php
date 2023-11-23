<nav class="navbar bg-body-tertiary">
  <div class="container-fluid mx-3">
    <a class="navbar-brand" href="/">
      <img src="assets/img/logo.png" alt="Bootstrap" class="logo">
    </a>
    Hi, 
<?php
$whereConditions = ["id" => $_SESSION['udetails']];
$userDetails = selectFromTable("user", ["firstname"], $whereConditions);
if ($userDetails) {
  echo $userDetails['firstname'];
} else {
  echo "User";
}
?>
    <span class="mx-2">|</span>
    <a href="profile.php">Profile</a>
  </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Selected Rooms</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="roomsContainer">
      <li class="nav-item"><a class="nav-link" href="foyer.php">Foyer</a></li>
      <li class="nav-item"><a class="nav-link" href="passage.php">Passage</a></li>
      <li class="nav-item"><a class="nav-link" href="living-room.php">Living Room</a></li>
      <li class="nav-item"><a class="nav-link" href="drawing-room.php">Drawing Room</a></li>
      <li class="nav-item"><a class="nav-link" href="dining-room.php">Dining Room</a></li>
      <li class="nav-item"><a class="nav-link" href="kitchen.php">Kitchen</a></li>
      <li class="nav-item"><a class="nav-link" href="bedroom-1.php">Bedroom 1</a></li>
      <li class="nav-item"><a class="nav-link" href="bedroom-2.php">Bedroom 2</a></li>
      <li class="nav-item"><a class="nav-link" href="bedroom-3.php">Bedroom 3</a></li>
      <li class="nav-item"><a class="nav-link" href="bathroom.php">Bathroom</a></li>
      <li class="nav-item"><a class="nav-link" href="garden.php">Garden / Outside Entrance / Balcony</a></li>
    </ul>
  </div>
</div>