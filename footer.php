<!-- Progress Bar -->
<div class="progress" id="ajax-progress" style="display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="m-5"></div>
</body>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
$(document).ajaxStart(function() {
    $("#ajax-progress").show();
});
$(document).ajaxStop(function() {
    $("#ajax-progress").hide();
});
$(document).ready(function() {
  console.log(localStorage.getItem('currentroom'));
  var storedRooms = localStorage.getItem('allRooms');
  var storedPanels = localStorage.getItem('allPanels');
  var checkedItems = JSON.parse(localStorage.getItem('checkedItems'));
  console.log(checkedItems.length);
  $.ajax({
      type: "GET",
      url: "ajaxfunctions.php",
      dataType: "json",
      data: { wf: "1" },
      success: function(response) {
          if (response.success) {
              if (storedRooms === null) {
                  localStorage.setItem('allRooms', JSON.stringify(response.rooms));
              }
              updaterooms();
          } else {
              console.error("Error fetching rooms: " + response.message);
          }
      },
      error: function(error) {
          console.error("AJAX Error:", error);
      }
  });
  $.ajax({
      type: "GET",
      url: "ajaxfunctions.php",
      dataType: "json",
      data: { wf: "2" },
      success: function(response) {
          if (response.success) {
              if (storedPanels === null) {
                  localStorage.setItem('allPanels', JSON.stringify(response.panels));
              }

              updaterooms();
          } else {
              console.error("Error fetching rooms: " + response.message);
          }
      },
      error: function(error) {
          console.error("AJAX Error:", error);
      }
  });
  
  var storedItems = localStorage.getItem('checkedItems');
  if (storedItems) {
      storedItems = JSON.parse(storedItems);
      storedItems.forEach(function(item) {
          $('#' + item.p).prop('checked', true);
      });
  }
});
function updaterooms(){
  var rooms = JSON.parse(localStorage.getItem('rooms'));
  var allRooms = JSON.parse(localStorage.getItem('allRooms'));
  var roomsContainer = $('#roomsContainer');
  roomsContainer.empty(); 
  rooms.forEach(function(roomId) {
      allRooms.forEach(function(room) {
          if(room.id == roomId){
              var roomHtml = '<li class="nav-item"><a class="nav-link" href="foyer.php">' + room.name + '</a></li>';
              roomsContainer.append(roomHtml);
          }
      });
  });
}
function prevroom(){
  var currentroom = parseInt(localStorage.getItem('currentroom'), 10) || 0;
  var prevroom = currentroom - 1;
  if(currentroom !== 1){
    localStorage.setItem('currentroom', prevroom);
    location.reload();
  }
}
function nextroom(){
  var currentroom = parseInt(localStorage.getItem('currentroom'), 10) || 0;
  var nextroom = currentroom + 1;
  localStorage.setItem('currentroom', nextroom);
  location.reload();
  var checkedItems = JSON.parse(localStorage.getItem('checkedItems'));
  console.log(checkedItems.length);
}
function roomsphp(){
  var storedItems = localStorage.getItem('checkedItems');
  if (storedItems) {
    storedItems = JSON.parse(storedItems);
    if(storedItems.length !== 0){   
      if(localStorage.getItem('currentroom') == null){
        // console.log(storedItems[0]);
        localStorage.setItem('currentroom', 0);
      }
      var currentroom = localStorage.getItem('currentroom');
      var allrooms = JSON.parse(localStorage.getItem('allRooms'));
      var allpanels = JSON.parse(localStorage.getItem('allPanels'));
      // console.log(allpanels);
      allrooms.forEach(function(room){
        if(room.id == storedItems[currentroom].r){
            document.querySelector(".room-h2").innerHTML = room.name;
        }
      });
      allpanels.forEach(function(panel){
        if(panel.id == storedItems[currentroom].p){
          document.querySelector(".panel-h5").innerHTML = panel.panel;
          console.log(panel.modules);
          let numbersArray = panel.modules.split(',');
          let numbers = numbersArray.map(Number);
          for (let i = 0; i < numbers.length; i++) {
            let currentNumber = numbers[i];
            if(currentNumber !== 0)
            fetch('components/'+currentNumber+'.html').then(response => response.text()).then(html => {document.querySelector(".room_modules").innerHTML += html;});
          }

        }
      });
      // console.log(storedItems);
    }else{
      alert("There is no Rooms selected. Select Rooms & Panels");
    }
  }
}
</script>
</html>