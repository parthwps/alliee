<?php include("common.php");?>
<?php include("header.php");?>
<style>
    .o_room_h4{
        padding:1rem;
        margin:0;
        background:#eee;
    }
    .o_room_panel{
        padding:.25rem 1rem;
        margin:0;
        font-size: 1rem;
    }
    .o_room_panel h5{
        padding: 1rem;
        margin:0;
    }
    .o_room_sugg_title{
        padding: 1rem;
        margin:0;
    }
    .o_room_sugg{
        padding:1rem;
        margin:0;
    }
    .table-div{
        padding:1rem;
        border:1px solid #ccc;
    }
</style>
<div class="container select-room d-flex align-items-center justify-content-between mt-3">
    <div class="room-arrows">
        <a href="rooms.php" class="room-arrow room-arrow-left"><span><</span> Back</a>
    </div>
    <div class="room-titles">
        <div><h2 class="h1 room-h2 justify-content-center">Generate</h2>
        <h5 class="panel-h5">PDF</h5></div>
    </div>
    <div class="">
        <button class="room-arrow room-arrow-right" id="invoice_download_btn" type="button">Download</button>
    </div>
</div>
<!-- Progress Bar -->
<div class="progress" id="progress_bar" style="display: none;">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>
<div class="container">
    <div id="invoice_wrapper">
        <div class="container-fluid py-3">

<nav class="navbar bg-body-tertiary">
  <div class="container-fluid mx-3">
    <a class="navbar-brand" href="./">
      <img src="assets/img/logo.svg" alt="Bootstrap" class="logo">
    </a>
    Email: email@gmail.com | Mo. 99 999 88888
  </div>
</nav>

<div class="m-5">
    <h3>Selected Rooms & Panels</h3>
    <div id="content">

    </div>
</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>


$(document).ready(function() {
    var panelselected = JSON.parse(sessionStorage.getItem("panelselected"));
    var checkedItems = JSON.parse(sessionStorage.getItem('checkedItems'));
    
    console.log(panelselected);
    console.log(checkedItems);

    $.ajax({
        url: 'output.php',
        type: 'POST',
        data: {
            panelselected: panelselected,
            checkedItems: checkedItems,
        },
        dataType: 'text',
        success: function(response) {
            // Handle successful response
            $("#content").html(response);
        },
        error: function(xhr, status, error) {
        // Handle error
            console.error("AJAX Error:", xhr.status, error);
        }
    });

});
    /**
     * Generate HTML to PDF
     *
     * @constructor
     */
    function CreatePDFfromHTML(domElement) {
        var contentWidth = $(domElement).width();
        var contentHeight = $(domElement).height();
        var topTeftMargin = 10;
        var pdfWidth = contentWidth+(topTeftMargin*2);
        var pdfHeight = (pdfWidth*1.5)+(topTeftMargin*2);
        var canvasImageWidth = contentWidth;
        var canvasImageHeight = contentHeight;
        var totalPDFPages = Math.ceil(contentHeight/pdfHeight)-1;

// Show progress bar
var progressBar = $('#progress_bar');
progressBar.show();

// Update progress bar
var progress = 0;
var progressInterval = setInterval(function() {
    progress += 5; // Increment progress by 5%
    if (progress <= 100) {
        $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    } else {
        clearInterval(progressInterval); // Stop progress interval
    }
}, 500);

        html2canvas($(domElement)[0],{allowTaint:true}).then(function(canvas) {
            canvas.getContext('2d');
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt',  [pdfWidth, pdfHeight]);
            pdf.addImage(imgData, 'JPG', topTeftMargin, topTeftMargin,canvasImageWidth,canvasImageHeight);
            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(pdfWidth, pdfHeight);
                pdf.addImage(imgData, 'JPG', topTeftMargin, -(pdfHeight*i)+(topTeftMargin*4),canvasImageWidth,canvasImageHeight);
            }
            pdf.save("html-to-pdf.pdf");
            // Hide progress bar after PDF generation
            progressBar.hide();
        });
    }

    $('#invoice_download_btn').click(function () {
        CreatePDFfromHTML("#invoice_wrapper");
    });
</script>
</body>
</html>

<?php include("footer.php");?>