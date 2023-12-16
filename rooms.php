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
<style>
  .cart-title{
    display:flex;
  }
  .cart-title button{
    margin-left:auto;
  }
</style>
<div class="cart position-fixed" style="bottom:0">
    <div class="container">
        <div class="cart-title m-1">
          <h6>Total&nbsp;<b class="totalcount">0</b></h6>
          <button class="btn btn-blue">Show Suggestions</button>
        </div>
        <div class="row totals my-2">

        </div>
    </div>
    <!-- <div class="text-center suggestion-box">
      <button class="btn btn-blue">Show Suggestions</button>
    </div> -->
</div>
<script>
    $(document).ready(function() {
        roomsphp();
        $('.compo').each(function () {
            var compoClass = $(this).attr('class').split(' ')[1];

            var newColElement = $('<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ' + compoClass + '">' +
            compoClass.charAt(0).toUpperCase() + compoClass.slice(1) + ': <span class="' + compoClass + 'count">0</span>' +
            '</div>');
            $('.totals').append(newColElement);
        });

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

//check uncheck checkbox
var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
var curroom = currentroom;
var component = compoClass.replace("compo","");
var checkboxid = checkedCount;

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