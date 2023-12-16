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
  var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
  console.log("Current Room: " + currentroom);
  if(currentroom == null){
    sessionStorage.setItem('currentroom',0);
  }
  var nextroom = currentroom + 1;
  var checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
  var storedRooms = sessionStorage.getItem('allRooms');
  var storedPanels = sessionStorage.getItem('allPanels');
  var checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
  $.ajax({
      type: "GET",
      url: "ajaxfunctions.php",
      dataType: "json",
      data: { wf: "1" },
      success: function(response) {
          if (response.success) {
              if (storedRooms === null) {
                  sessionStorage.setItem('allRooms', JSON.stringify(response.rooms));
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
                  sessionStorage.setItem('allPanels', JSON.stringify(response.panels));
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
  
  var storedItems = sessionStorage.getItem('checkedItems');
  if (storedItems) {
      storedItems = JSON.parse(storedItems);
      storedItems.forEach(function(item) {
          $('#' + item.p).prop('checked', true);
      });
  }
});
function updaterooms(){
  var rooms = JSON.parse(sessionStorage.getItem('rooms'));
  var allRooms = JSON.parse(sessionStorage.getItem('allRooms'));
  if(rooms != null){
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
}
function prevroom(){
  var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
  var prevroom = currentroom - 1;
  if(currentroom !== 0){
    sessionStorage.setItem('currentroom', prevroom);
    location.reload();
  }
}
function nextroom(){
  var currentroom = parseInt(sessionStorage.getItem('currentroom'), 10) || 0;
  var nextroom = currentroom + 1;
  var checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
  if(currentroom < checkedItems.length-1){
  sessionStorage.setItem('currentroom', nextroom);
  location.reload();
  }
}
function roomsphp(){
  var storedItems = sessionStorage.getItem('checkedItems');
  storedItems = JSON.parse(storedItems);
  console.log(storedItems,storedItems.length);
  if (storedItems) {
    if(storedItems.length !== 0){   
      if(sessionStorage.getItem('currentroom') == null){
        // console.log(storedItems[0]);
        sessionStorage.setItem('currentroom', 0);
      }
      let currentroom = sessionStorage.getItem('currentroom');
      let allRooms = JSON.parse(sessionStorage.getItem('allRooms'));
      let allpanels = JSON.parse(sessionStorage.getItem('allPanels'));
      allRooms.forEach(function(room){
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