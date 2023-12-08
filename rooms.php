<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex align-items-center justify-content-between mt-3">
    <div class="room-arrows">
        <a href="javascript:void(0)" onclick="prevroom()" class="room-arrow room-arrow-left"><span><</span> Prev Room</a>
    </div>
    <div class="room-titles">
        <div><h2 class="h1 room-h2 justify-content-center">Room</h2>
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

<div class="cart position-fixed" style="bottom:0">
    <div class="container pb-2">
        <h6 class="mt-3">Total Things required in <b class="totalcount">0</b></h6>
        <div class="row totals">

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        roomsphp();
        $('.compo').each(function () {
            // Get the class of the current .compo element
            var compoClass = $(this).attr('class').split(' ')[1];

            // Create a new col element with initial count set to 0
            var newColElement = $('<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ' + compoClass + '">' +
            compoClass.charAt(0).toUpperCase() + compoClass.slice(1) + ': <span class="' + compoClass + 'count">0</span>' +
            '</div>');

            // Append the new col element to the totals row
            $('.totals').append(newColElement);
        });

        // Attach the change event handler to dynamically loaded content
        $(document).on('change', '.compo input[type="checkbox"]', handleCheckboxChange);
    });
function handleCheckboxChange() {
  var compoClass = $(this).closest('.compo').attr('class').split(' ')[1];
  var checkedCount = $(this).closest('.compo').find('input[type="checkbox"]:checked').length;
  updateOrCreateCol(compoClass, checkedCount);
}

function updateOrCreateCol(compoClass, checkedCount) {
  var colElement = $('.totals .col.' + compoClass);

  if (colElement.length > 0) {
    colElement.find('span').text(checkedCount);
  } else {
    var title = $('.compo.' + compoClass).attr('title');
    var newColElement = $('<div class="col ' + compoClass + '">' + title + ': <span class="' + compoClass + 'count">' + checkedCount + '</span>' + '</div>');
    $('.totals').append(newColElement);
  }

  // Update total count
  var totalElement = $('.totalcount');
  var total = 0;

  // Calculate total count based on selected checkboxes within .compo
  $('.compo input[type="checkbox"]:checked').each(function () {
    total += 1; // You can modify this logic based on your checkbox value or requirement
  });

  totalElement.text(total);
}

</script>
<?php include("footer.php");?>