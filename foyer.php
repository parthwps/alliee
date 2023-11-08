<?php include("common.php");?>
<?php include("header.php");?>

<div class="container select-room d-flex justify-content-between mt-3">
    <h2>Foyer</h2>
    <button class="btn btn-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      Select Room
    </button>
  </div>

<!-- Green #adebff; -->
<!-- Green #feeef0; -->
<!-- Green #adebff; -->
<div class="container main room">
    <div class="row room-select">
        <div class="col form-check">
            <input class="form-check-input" type="checkbox" id="roompanel1">
            <label class="form-check-label">
                Entry Foyer
            </label>
        </div>
        <div class="col form-check">
            <input class="form-check-input" type="checkbox" id="roompanel2">
            <label class="form-check-label">
                Extra Switch
            </label>
        </div>
        <div class="col" style="text-align:right;">
            <button class="btn btn-blue-dark">Show Suggestions</button>
        </div>
    </div>
    
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist" style="white-space: nowrap;">
            <button class="nav-loop nav-link active" id="nav-1" data-bs-toggle="tab" data-bs-target="#nav1" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Entry Foyer</button>
            <button class="nav-loop nav-link" id="nav-2" data-bs-toggle="tab" data-bs-target="#nav2" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Extra Switch</button>
        </div>
    </nav>
    
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav1" role="tabpanel" aria-labelledby="nav-1" tabindex="0">
            <div id="foyer-light-switch">
                <form class="form-group" id="1" name="1">
                    <?php require 'sel_component.php'; ?>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="nav2" role="tabpanel" aria-labelledby="nav-2" tabindex="1">
            <div id="foyer-extra-switch">
                <form class="form-group" id="2" name="2">
                    <?php require 'sel_component.php'; ?>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="cart position-fixed" style="bottom:0">
    <div class="container pb-2">
        <h6 class="mt-3">Total Things required in <b class="totalcount">n/a</b></h6>
        <div class="row">
            <div class="col">
                Lights: <span class="lightcount">0</span>
            </div>
            <div class="col">
                Plug: <span class="plugcount">0</span>
            </div>
            <div class="col">
                Scenes: <span class="scenecount">0</span>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const checkedCounts = {}; // Create an object to store the checked counts
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    let lastCheckedIndex = 0;
    calculateCheckedCount();
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', calculateCheckedCount);
    });
    
    $('.nav-tabs .nav-link').on('click', function() {
        var index = $('.nav-tabs .nav-link').index(this);
        changetabs(index + 1);
    });

    function calculateCheckedCount() {
        const forms = document.querySelectorAll('.form-group');
        forms.forEach((form, formIndex) => {
            const groups = form.querySelectorAll('.group');
            groups.forEach((group, groupIndex) => {
                const groupCheckboxes = group.querySelectorAll('input[type="checkbox"]');
                const checkedCount = Array.from(groupCheckboxes).filter(checkbox => checkbox.checked).length;
                const variableName = `form${formIndex + 1}group${groupIndex + 1}`;
                checkedCounts[variableName] = checkedCount; // Store the checkedCount in the dynamically named variable
            });
        });
        const mchecks = document.querySelectorAll('.room-select .form-check-input');
        mchecks.forEach((mcheck, index) => {
            if (mcheck.checked) {
                lastCheckedIndex = index;
            }
        });
            let lci = lastCheckedIndex + 1;
            var formid1 = 'form' + lci + 'group1';
            var formid2 = 'form' + lci + 'group2';
            var formid3 = 'form' + lci + 'group3';
            $('.totalcount').html(checkedCounts[formid1] + checkedCounts[formid2] + checkedCounts[formid3]);
            $('.lightcount').html(checkedCounts[formid1]);
            $('.plugcount').html(checkedCounts[formid2]);
            $('.scenecount').html(checkedCounts[formid3]);
            
    }
    //roompanel
    $('#nav-1').hide();$('#nav1').hide();
    $('#nav-2').hide();$('#nav2').hide();
    $('#nav-3').hide();$('#nav3').hide();
    var i = 0;
    $('#roompanel1').change(function() {
        selectroom(this.checked, 1);
    });
    $('#roompanel2').change(function() {
        selectroom(this.checked, 2);
    });
    $('#roompanel3').change(function() {
        selectroom(this.checked, 3);
    });
    $('#roompanel4').change(function() {
        selectroom(this.checked, 4);
    });
    $('#roompanel5').change(function() {
        selectroom(this.checked, 5);
    });
    $('#roompanel6').change(function() {
        selectroom(this.checked, 6);
    });
    $('#roompanel7').change(function() {
        selectroom(this.checked, 7);
    });
    $('#roompanel8').change(function() {
        selectroom(this.checked, 8);
    });
    $('#roompanel9').change(function() {
        selectroom(this.checked, 9);
    });
    function selectroom(check, id){
        if(check){
            $(".nav-link").removeClass("active");
            $(".tab-pane").removeClass("show active");
            $('#nav-'+id).addClass('active');
            $('#nav'+id).addClass('show active');
            $('#nav-'+id).show();
            $('#nav'+id).show();
        } else {
            $('#nav-'+id).removeClass('active');
            $('#nav'+id).removeClass('show active');
            $('#nav-'+id).hide();
            $('#nav'+id).hide();
            $('.nav-loop').each(function() {
                if ($(this).css('display') !== 'none') {
                    $(".nav-link").removeClass("active");
                    $(".tab-pane").removeClass("show active");
                    $('#'+$(this).attr("id")).addClass('active');
                    $($(this).attr("data-bs-target")).addClass('show active');
                    $('#'+$(this).attr("id")).show();
                    $($(this).attr("data-bs-target")).show();
                    return false; 
                }
            });
        }
    }
    function changetabs(id){
        var formid1 = 'form' + id + 'group1';
        var formid2 = 'form' + id + 'group2';
        var formid3 = 'form' + id + 'group3';
        $('.totalcount').html(checkedCounts[formid1] + checkedCounts[formid2] + checkedCounts[formid3]);
        $('.lightcount').html(checkedCounts[formid1]);
        $('.plugcount').html(checkedCounts[formid2]);
        $('.scenecount').html(checkedCounts[formid3]);
    }
});

const container = document.getElementById("nav-tab");
const items = container.children;
let totalWidth = 0;
for (let i = 0; i < items.length; i++) {
  totalWidth += items[i].offsetWidth;
}
container.style.width = totalWidth+ 50 + "px";

</script>
<?php include("footer.php");?>