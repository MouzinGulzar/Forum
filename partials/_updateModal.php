<!-- Name Modal -->
<div class="modal fade" id="updateNameModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Name</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-name&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-name" class="form-label">New Name</label>
                        <input type="text" class="form-control" id="new-name" name="new-name" aria-describedby="emailHelp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="updateEmailModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Email</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-email&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-email" class="form-label">Email address</label>
                        <input required type="email" class="form-control" id="new-email" name="new-email" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Beware! This email will be displayed to other users in your profile.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Gender Modal -->
<div class="modal fade" id="updateGenderModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Gender</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-gender&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-gender" class="form-label">Gender</label>
                        <select required class="form-select" aria-label="Default select example" id="new-gender" name="new-gender">
                            <option selected value="m">Male</option>
                            <option value="f">Female</option>
                            <option value="o">Other</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Course Modal -->
<div class="modal fade" id="updateCourseModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Coure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-course&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-course" class="form-label">New Course</label>
                        <select required class="form-select" aria-label="Default select example" id="new-course" name="new-course">
                            <option selected value="bca">BCA</option>
                            <option value="bba">BBA</option>
                            <option value="mca">MCA</option>
                            <option value="mba">MBA</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Semester Modal -->
<div class="modal fade" id="updateSemesterModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Semester</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-semester&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new-semester" class="form-label">New Semester</label>
                        <select required class="form-select" aria-label="Default select example" id="new-semester" name="new-semester">
                            <?php
                            include '_dbconnect.php';
                            $userid = $_GET['user'];
                            $course = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'course');
                            if ($course == 'bca' || $course == 'bba') {
                                echo '
                                <option selected value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                <option value="5">5th</option>
                                <option value="6">6th</option>
                                ';
                            } else {
                                echo '
                                <option selected value="1">1st</option>
                                <option value="2">2nd</option>
                                <option value="3">3rd</option>
                                <option value="4">4th</option>
                                ';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Update Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handleUpdate.php?update=new-password&redirect=<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current-password" class="form-label">Current Password</label>
                        <input required type="password" class="form-control" id="current-password" name="current-password">
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">New Password</label>
                        <input required type="password" class="form-control" id="new-password" name="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="new-cpassword" class="form-label">Confirm New Password</label>
                        <input required type="password" class="form-control" id="new-cpassword" name="new-cpassword">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
</button> -->