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
<div class="container mb-5 pb-5">
  <div class="row g-3 room_modules">

  </div>
  <div class="row suggestions py-5" id="suggestions">
    <h2>Suggested Touch Panels</h2>
    <div>
      <table class="table table-striped suggestions_list">
        <tr><th></th><th>Module</th><th>Module Type</th></tr>
      </table>
    </div>
  </div>
</div>
<div class="cart position-fixed" style="bottom:0">
    <div class="container">
        <div class="cart-title m-1">
          <h6>Total&nbsp;<b class="totalcount">0</b></h6>
          <button class="btn btn-blue-dark show-suggestion">Show Suggestions</button>
        </div>
        <div class="row totals my-2">

        </div>
    </div>
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

    setTimeout(function() {
    var checkboxIndicesMap = JSON.parse(sessionStorage.getItem('checkboxIndicesMap')) || {};
    var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;

    Object.keys(checkboxIndicesMap).forEach(function(room) {
      if(room == currentroom){
      $(".totalcount").html(checkboxIndicesMap[room].length);
        checkboxIndicesMap[room].forEach(function(index) {
            // console.log(index);
            var checkbox = $('.compo input[type="checkbox"]').eq(index);
            checkbox.prop('checked', true);
        });
      }
    });
    }, 500);

    $(document).on('change', '.compo input[type="checkbox"]', handleCheckboxChange);
    $(document).on('click', '.show-suggestion', gensugg);

});
function gensugg(){

  $(".suggestions").toggle();
  var checkboxCounts = {};
  var classes = $('[class*=compo]').map(function() {
      return this.className.match(/\bcompo\d+\b/g);
  }).get();
  var requestData = {};
  classes.forEach(function(checkboxClass) {
      var checkedCheckboxes = $('.' + checkboxClass + ' input[type="checkbox"]:checked');
      var count = checkedCheckboxes.length;
      checkboxCounts[checkboxClass] = count;
      variable_value = count;
      var variable_name = $("."+checkboxClass).attr('data-title');
      requestData[variable_name] = variable_value;
  });
  console.log(requestData);
  document.getElementsByClassName('suggestions')[0].scrollIntoView();
  $.ajax({
      url: 'fetch_suggestions.php',
      type: 'GET',
      data: {data: requestData},
      dataType: 'json',
      success: function(data) {
        console.log(data);
        var suggestionsContent = '';
        data.forEach(function(module){
          suggestionsContent += '<tr><td><input class="form-check-input al-room-check" type="checkbox" id="' + module.id + '" value="'+ module.name +'"></td><td>' + module.name + '</td><td>' + module.module + '</td></tr>';
        });
        $('.suggestions_list').append(suggestionsContent.trim());        
      },
      error: function(error) {
          console.error('Error fetching data:', error);
      }
  });

}
function handleCheckboxChange() {



  var compoContainer = $(this).closest('.compo');
  var maxAllowed = parseInt(compoContainer.data('max'));
  var checkedCheckboxes = compoContainer.find('.al-room-check:checked');
  if (checkedCheckboxes.length > maxAllowed) {
    $(this).prop('checked', false);
    alert('Maximum ' + maxAllowed + ' checkboxes allowed.');
  }else{
  
  var checkboxIndicesMap = JSON.parse(sessionStorage.getItem('checkboxIndicesMap')) || {};

  var compoClass = $(this).closest('.compo').attr('class').split(' ')[1];
  var checkedCount = $(this).closest('.compo').find('input[type="checkbox"]:checked').length;
  var currentRoom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
  var index = $('.compo input[type="checkbox"]').index(this);

  if (!checkboxIndicesMap[currentRoom]) {
      checkboxIndicesMap[currentRoom] = [];
  }
  var indexPosition = checkboxIndicesMap[currentRoom].indexOf(index);
  if (indexPosition === -1) {
      checkboxIndicesMap[currentRoom].push(index);
  } else {
      checkboxIndicesMap[currentRoom].splice(indexPosition, 1);
  }
  sessionStorage.setItem('checkboxIndicesMap', JSON.stringify(checkboxIndicesMap));
  console.log('Checkbox indices map:', checkboxIndicesMap);
  updateOrCreateCol(compoClass, checkedCount); 
  }
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

var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
var curroom = currentroom;
var component = compoClass.replace("compo","");
var checkboxid = checkedCount;

  var totalElement = $('.totalcount');
  var total = 0;

  $('.compo input[type="checkbox"]:checked').each(function () {
    total += 1;
  });
  totalElement.text(total);
}

</script>
<?php include("footer.php");?>