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
        <a href="javascript:void(0)" onclick="nextroom()" class="room-arrow room-next room-arrow-right">Next Room <span>></span></a>
        <a href="finish.php" class="room-arrow room-finish room-arrow-right">Finish <span>></span></a>
    </div>
</div>
<div class="container mb-5 pb-5">
  <div class="row g-3 room_modules">
  </div>
  <div class="row suggestions py-5" id="suggestions">
    <h2>Suggested Touch Panels</h2>
    <div class="suggestions_list">

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
    var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
    var storedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
    if(storedItems.length == currentroom + 1){
      $(".room-finish").css("display","flex");
      $(".room-next").css("display","none");
    }else{
      $(".room-finish").css("display","none");
      $(".room-next").css("display","flex");
    }
    $('.compo').each(function () {
        var compoClass = $(this).attr('class').split(' ')[1];
        var newColElement = $('<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ' + compoClass + '">' +
        compoClass.charAt(0).toUpperCase() + compoClass.slice(1) + ': <span class="' + compoClass + 'count">0</span>' +
        '</div>');
        $('.totals').append(newColElement);
    });
    setTimeout(function() {
      var checkboxIndicesMap = JSON.parse(sessionStorage.getItem('checkboxIndicesMap')) || {};
      Object.keys(checkboxIndicesMap).forEach(function(room) {
        if(room == currentroom){
        $(".totalcount").html(checkboxIndicesMap[room].length);
          checkboxIndicesMap[room].forEach(function(index) {
              var checkbox = $('.compo input[type="checkbox"]').eq(index);
              checkbox.prop('checked', true);
          });
        }
      });
    }, 500);

    $(document).on('change', '.compo input[type="checkbox"]', handleCheckboxChange);
    $(document).on('click', '.show-suggestion', gensugg);
    $(document).on('click', '.panel-select', updateSessionStorage);
    console.log("Selected Panel: ",sessionStorage.getItem("panelselected"));

});
// Function to update selected panel per room
function updateSessionStorage() {
  var panelselected = JSON.parse(sessionStorage.getItem('panelselected')) || {};
  var currentRoom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
  var index = $(this).attr("id");

  if (!panelselected[currentRoom]) {
      panelselected[currentRoom] = [];
  }
  var indexPosition = panelselected[currentRoom].indexOf(index);
  if (indexPosition === -1) {
      panelselected[currentRoom].push(index);
  } else {
      panelselected[currentRoom].splice(indexPosition, 1);
  }
  sessionStorage.setItem('panelselected', JSON.stringify(panelselected));
  console.log('Checkbox selected Panel:', panelselected);

}
function gensugg(){

  setTimeout(function() {
    var checkboxIndicesMap = JSON.parse(sessionStorage.getItem('panelselected')) || {};
    var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
    console.log("Current Room for Panel Selected on load", currentroom);
    Object.keys(checkboxIndicesMap).forEach(function(room) {
      if(room == currentroom){
        checkboxIndicesMap[room].forEach(function(index) {
            var checkbox = $('#'+index);
            checkbox.prop('checked', true);
        });
      }
    });
  }, 500);


  $('.suggestions_list').html("");
  const checkboxcount = sessionStorage.getItem('checkboxIndicesMap');
  // console.log("handleCheckboxChange",handleCheckboxChange);
  $(".suggestions").show();
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
  console.log("requestData 124:",requestData);
  document.getElementsByClassName('suggestions')[0].scrollIntoView();
  // let data = JSON.parse(sessionStorage.getItem('panel_sugg'))
  $.ajax({
      url: 'fetch_suggestions.php',
      type: 'POST',
      data: JSON.stringify(requestData), // Send requestData as JSON
      contentType: 'application/json',
      success: function(dataar) {
        
if (Array.isArray(dataar)) {
    // Data is already an array, no need to convert
    var data = dataar;
} else {
    // Data is an object, convert to array using Object.values()
    var data = Object.values(dataar);
}


        var modules = {};
    // Group the data by the 'module' field
    data.forEach(function(module) {
        if (!modules.hasOwnProperty(module.module)) {
            modules[module.module] = [];
        }
        modules[module.module].push(module);
    });

    // Iterate over each unique module
    Object.keys(modules).forEach(function(moduleName) {
        var moduleData = modules[moduleName];
        
        table = $('<table class="table table-striped"></table>');
        // Create table header
        // var headerRow = $('<tr scope="col"></tr>');
        // var headers = ['', 'Module'];
        // headers.forEach(function(headerText) {
        //     var th = $('<th></th>').text(headerText);
        //     headerRow.append(th);
        // });
        // table.append(headerRow);

        // Populate table rows with module data
        moduleData.forEach(function(module) {
            var row = $('<tr></tr>');
            var checkboxCell = $('<td></td>').html('<input class="form-check-input al-room-check  panel-select" type="checkbox" id="' + module.id + '" value="'+ module.name +'">');

            var nameCell = $('<td></td>').text('alliée ' + module.name);
            // var typeCell = $('<td></td>').text(module.module);
            
            row.append(checkboxCell, nameCell);
            table.append(row);
        });
        $('.suggestions_list').append('<h3>'+moduleName+'</h3>');
        // Append the table to the suggestions list
        $('.suggestions_list').append(table);
    });
},

      error: function(xhr, status, error) {
      console.error('Error fetching data:', xhr + status +error);
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