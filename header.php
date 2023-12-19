<nav class="navbar bg-body-tertiary">
  <div class="container-fluid mx-3">
    <a class="navbar-brand" href="./">
      <img src="assets/img/logo.svg" alt="Bootstrap" class="logo">
    </a>

    <a href="dashboard.php">
      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
      </svg> -->
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-house-gear-fill" viewBox="0 0 16 16">
        <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708z"/>
        <path d="M11.07 9.047a1.5 1.5 0 0 0-1.742.26l-.02.021a1.5 1.5 0 0 0-.261 1.742 1.5 1.5 0 0 0 0 2.86 1.504 1.504 0 0 0-.12 1.07H3.5A1.5 1.5 0 0 1 2 13.5V9.293l6-6 4.724 4.724a1.5 1.5 0 0 0-1.654 1.03Z"/>
        <path d="m13.158 9.608-.043-.148c-.181-.613-1.049-.613-1.23 0l-.043.148a.64.64 0 0 1-.921.382l-.136-.074c-.561-.306-1.175.308-.87.869l.075.136a.64.64 0 0 1-.382.92l-.148.045c-.613.18-.613 1.048 0 1.229l.148.043a.64.64 0 0 1 .382.921l-.074.136c-.306.561.308 1.175.869.87l.136-.075a.64.64 0 0 1 .92.382l.045.149c.18.612 1.048.612 1.229 0l.043-.15a.64.64 0 0 1 .921-.38l.136.074c.561.305 1.175-.309.87-.87l-.075-.136a.64.64 0 0 1 .382-.92l.149-.044c.612-.181.612-1.049 0-1.23l-.15-.043a.64.64 0 0 1-.38-.921l.074-.136c.305-.561-.309-1.175-.87-.87l-.136.075a.64.64 0 0 1-.92-.382ZM12.5 14a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
      </svg>
    </a>
    <span class="mx-2">|</span>
    Hi,&nbsp;
<?php
$whereConditions = ["id" => $_SESSION['udetails']];
$userDetails = selectFromTable("user", ["firstname"], $whereConditions);
if ($userDetails) {
  echo "<a href='profile.php'>".$userDetails['firstname']."</a>";
} else {
  echo "User";
}
?>
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