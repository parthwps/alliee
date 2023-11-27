<?php include("common.php");?>
<?php include("header.php");?>
<?php
$whereConditions = ["id" => $_SESSION['udetails']];
$userDetails = selectFromTable("user", ["firstname","lastname","mobile"], $whereConditions);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Update Name
                </div>
                <div class="card-body">
                    <form id="updateNameForm">
                        <div class="form-group mb-4">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" value="<?php if($userDetails){echo $userDetails['firstname'];}?>">
                        </div>
                        <div class="form-group mb-4">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" value="<?php if($userDetails){echo $userDetails['lastname'];}?>">
                        </div>
                        <div class="form-group mb-4">
                            <label for="lastName">Mobile</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Mobile No." value="<?php if($userDetails){echo $userDetails['mobile'];}?>" disabled>
                        </div>
                        <button type="button" class="btn btn-blue" onclick="updateName()">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateName() {
        var firstName = $("#firstName").val();
        var lastName = $("#lastName").val();

        // Check if first name and last name are not blank
        if (firstName.trim() === '' || lastName.trim() === '') {
            alert("First name and last name cannot be blank.");
            return;
        }
        $("#ajax-progress").show();

        $.ajax({
            type: "POST",
            url: "updateName.php",
            data: { firstName: firstName, lastName: lastName },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        // Update the width of the progress bar
                        $("#ajax-progress .progress-bar").css("width", percentComplete + "%");
                        // Update the aria-valuenow attribute
                        $("#ajax-progress .progress-bar").attr("aria-valuenow", percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log("Error:", error);
            },
            complete: function() {
                $("#ajax-progress").hide();
            }
        });
    }
</script>
<?php include("footer.php");?>