<?php include("common.php");?>
<?php include("header.php");?>

<div class="container main dashboard">
    <h3>Select Rooms in Your Home</h3>
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist" style="white-space: nowrap;">
        <button class="nav-link active" id="nav-1" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Foyer</button>
        <button class="nav-link" id="nav-2" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Passage</button>
        <button class="nav-link" id="nav-3" data-bs-toggle="tab" data-bs-target="#nav3" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Living Room</button>
        <button class="nav-link" id="nav-4" data-bs-toggle="tab" data-bs-target="#nav4" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Drawing Room</button>
        <button class="nav-link" id="nav-5" data-bs-toggle="tab" data-bs-target="#nav5" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Dining Room</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Kitchen</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Bedroom 1</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Bedroom 2</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Bedroom 3</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Bathroom</button>
        <button class="nav-link" id="nav-6" data-bs-toggle="tab" data-bs-target="#nav6" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Garden / Outside Entrance / Balcony</button>

    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav-1" tabindex="0">
            <div class="tab1-lightswitch">
                <h4>Light Switch</h4>
            </div>
        </div>
        <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav-2" tabindex="1">
            test2
        </div>
        <div class="tab-pane fade" id="nav3" role="tabpanel" aria-labelledby="nav-3" tabindex="2">
            ...
        </div>
        <div class="tab-pane fade" id="nav4" role="tabpanel" aria-labelledby="nav-4" tabindex="3">
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
container.style.width = totalWidth + 200 + "px";
</script>
<?php include("footer.php");?>