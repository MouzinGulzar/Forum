<!-- Modal -->
<div class="modal fade" id="signupModal" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupModalLabel">Signup</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/forum/partials/_handleSignup.php" method="post" class="needs-validation">
                    <!-- <div class="mb-3">
                        <label for="signupflname" class="form-label">First and Last name</label>
                        <input required type="text" class="form-control" id="signupflname" name="signupflname"
                        aria-describedby="emailHelp">
                    </div> -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <!-- <label for="signupFName" class="form-label">First Name</label> -->
                                <input type="text" class="form-control" placeholder="First Name" aria-label="First name"
                                    name="signupFName" required value="Mouzin">
                            </div>
                            <div class="col">
                                <!-- <label for="signupLName" class="form-label">Last Name</label> -->
                                <input type="text" class="form-control" placeholder="Last Name" aria-label="Last name"
                                    name="signupLName" required value="Gulzar">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <!-- <label for="signupName" class="form-label">Username</label> -->

                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" class="form-control" id="signupName" name="signupName"
                                aria-describedby="inputGroupPrepend" placeholder="Username" required>
                        </div>

                        <!-- <input required type="text" class="form-control" id="signupName" name="signupName" aria-describedby="emailHelp"> -->
                    </div>
                    <div class="mb-3">
                        <!-- <label for="signupEmail" class="form-label">Email address</label> -->
                        <input required type="email" class="form-control" id="signupEmail" name="signupEmail"
                            aria-describedby="emailHelp" placeholder="Email address">
                        <div id="emailHelp" class="form-text">Beware! This email will be displayed to other users in
                            your profile.</div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="profile" class="form-label">Upload a decent profile</label>
                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="profile" name="profile"
                            required>
                    </div> -->
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select required class="form-select" aria-label="Default select example" id="gender"
                            name="gender">
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                            <option value="o">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="course" class="form-label">Course</label>
                        <select required class="form-select" aria-label="Default select example" id="course"
                            name="course">
                            <option selected value="bca">BCA</option>
                            <option value="bba">BBA</option>
                            <option value="mca">MCA</option>
                            <option value="mba">MBA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Current Semester</label>
                        <select required class="form-select" aria-label="Default select example" id="semester"
                            name="semester">
                            <!-- <option selected>Select an option</option> -->
                            <option selected value="1">1st</option>
                            <option value="2">2nd</option>
                            <option value="3">3rd</option>
                            <option value="4">4th</option>
                            <option value="5">5th</option>
                            <option value="6">6th</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <!-- <label for="password" class="form-label">Password</label> -->
                        <input required type="password" class="form-control" id="password" placeholder="Password"
                            name="signupPassword" value="qwertyuiop">
                    </div>
                    <div class="mb-3">
                        <!-- <label for="cpassword" class="form-label">Confirm Password</label> -->
                        <input required type="password" class="form-control" id="cpassword"
                            placeholder="Confirm Password" name="signupCpassword" value="qwertyuiop">
                    </div>
                    <div class="mb-3 form-check">
                        <input required type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            I solemnly declare the information mentioned herein is true and correct to the best of my
                            beliefs.</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
$bachelors = '<option selected value="1">1st</option><option value="2">2nd</option><option value="3">3rd</option><option value="4">4th</option><option value="5">5th</option><option value="6">6th</option>';
$masters = '<option selected value="1">1st</option><option value="2">2nd</option><option value="3">3rd</option><option value="4">4th</option>';

echo '<script> $(document).ready(function () {
    $("#course").change(function () {
        var val = $(this).val();
        if (val == "bca" || val == "bba") {
            $("#semester").html("' . $bachelors . '");
        } else if (val == "mca" || val == "mba") {
            $("#semester").html("' . $masters . '");
        }
    });
});
</script>
';
?>