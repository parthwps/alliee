<?php include("common.php");?>
<?php include("header.php");?>

<div class="container main dashboard">
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="white-space: nowrap;">
        <button style="background-color:#cce7d3;" class="nav-link active" id="nav-1" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Light Switch</button>
        <button style="background-color:#feeef0;" class="nav-link" id="nav-2" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Plug</button>
        <button style="background-color:#adebff;" class="nav-link" id="nav-3" data-bs-toggle="tab" data-bs-target="#nav3" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Scenario</button>

    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav-1" tabindex="0" style="background-color:#cce7d3;">

    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Down Light
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Wall Light
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Panel Light
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Rope Light
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        <input type="text" class="form-control mobile-input otpf">
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        <input type="text" class="form-control mobile-input otpf">
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        <input type="text" class="form-control mobile-input otpf">
    </label>
    </div>
    <div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        <input type="text" class="form-control mobile-input otpf">
    </label>
    </div>

        </div>
        <div style="background-color:#feeef0;" class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav-2" tabindex="1">
            test2
        </div>
        <div style="background-color:#adebff;" class="tab-pane fade" id="nav3" role="tabpanel" aria-labelledby="nav-3" tabindex="2">
            ...
        </div>
    </div>
</div>

<script>
const container = document.getElementById("nav-tab");
const items = container.children;
let totalWidth = 0;
for (let i = 0; i < items.length; i++) {
  totalWidth += items[i].offsetWidth;
}
container.style.width = totalWidth+ 50 + "px";
</script>
<?php include("footer.php");?>