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
    <a href="profile.php">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
      </svg>
    </a>
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