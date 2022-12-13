<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        body {
            animation: fadeIn .5s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php include 'partials/_functions.php' ?>
    <?php include 'partials/_updateModal.php' ?>

    <?php
    $userid = $_GET['user'];
    $result = execute("SELECT * FROM `users` WHERE user_id=$userid");
    $row = mysqli_num_rows($result);
    if (!isset($_GET['user']) || $row == 0) {
        echo '
        <div class="container text-center">
        <img src="img/user_not_found.png" width="50%" class="position-absolute top-50 right-50 translate-middle" alt="Profile">
        </div>
        ';
        exit();
    }
    // session_start();
    $loggedin = false;
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['userid'] == $userid)
        $loggedin = true;
    $username = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'username');
    $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'name');
    $email = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'user_email');
    $gender = get_data("SELECT * FROM `users` WHERE user_id=$userid", "gender");
    $course = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'course');
    $semester = get_data("SELECT * FROM `users` WHERE user_id=$userid", 'semester');
    $threads = get_data("SELECT * FROM `users` WHERE user_id=$userid", "threads");
    $answers = get_data("SELECT * FROM `users` WHERE user_id=$userid", "answers");

    if ($gender == 'm') {
        echo '<img src="img/mdpp.jpg" width="100px" class="rounded mx-auto d-block mt-5 mb-2" alt="Profile">';
    } else if ($gender == 'f') {
        echo '<img src="img/fdpp.jpg" width="100px" class="rounded mx-auto d-block mt-5 mb-2" alt="Profile">';
    } else if ($gender == 'o') {
        echo '<img src="img/tdpp.png" width="100px" class="rounded mx-auto d-block mt-5 mb-2" alt="Profile">';
    }

    if ($gender == 'm')
        $gender = "Male";
    else if ($gender == 'f')
        $gender = "Female";
    else if ($gender == 'o')
        $gender = "Other";

    if ($course == 'bca')
        $course = "Bachleor of Computer Applications";
    else if ($course == 'mca')
        $course = "Master of Computer Applications";
    else if ($course == 'bba')
        $course = "Bachelor of Business Administrations";
    else if ($course == 'mba')
        $course = "Mater of Business Administrations";

    if ($semester == '1')
        $semester = "1st";
    else if ($semester == '2')
        $semester = "2nd";
    else if ($semester == '3')
        $semester = "3rd";
    else if ($semester == '4')
        $semester = "4th";
    else if ($semester == '5')
        $semester = "5th";
    else if ($semester == '6')
        $semester = "6th";

    echo '<div class="container position-relative">
    <p class="text-center fw-bold lead ">' . $name;
    if ($loggedin)
        // echo '<a href="" class="text-decoration-none mx-2" data-bs-target="#staticBackdrop"><i class="fa-solid fa-pen-to-square"></i></a>';
        echo '<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateNameModal" style="border:none;">
        <i class="fa-solid fa-pen-to-square"></i></button>';

    echo '<br><span class="fw-lighter fs-6"> Pursuing ' . $course . '</span> </p>
        </div>';
    ?>

    <div class="container col-md-6">
        <div class="card position-relative">
            <div class="card-header text-center">
                <?php
                if ($loggedin == true)
                    echo 'Your Details';
                else
                    echo 'Student Details';

                ?>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><span class="text-muted">Username :</span>
                    <?php echo $username ?>
                </li>
                <li class="list-group-item"><span class="text-muted">Email: </span>
                    <?php echo $email ?>
                    <?php
                    if ($loggedin == true) {
                        echo '<button type="button" class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle mx-0" data-bs-toggle="modal" data-bs-target="#updateEmailModal" style="border:none;"><i class="fa-solid fa-pen-to-square"></i></button>';
                    }
                    ?>
                </li>
                <li class="list-group-item"><span class="text-muted">Gender: </span>
                    <?php echo $gender ?>
                    <?php
                    if ($loggedin == true)
                        echo '<button type="button" class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle mx-0" data-bs-toggle="modal" data-bs-target="#updateGenderModal" style="border:none;"><i class="fa-solid fa-pen-to-square"></i></button>';
                    ?>
                </li>
                <li class="list-group-item"><span class="text-muted">Course: </span>
                    <?php echo $course ?>
                    <?php
                    if ($loggedin == true)
                        echo '<button type="button" class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle mx-0" data-bs-toggle="modal" data-bs-target="#updateCourseModal" style="border:none;"><i class="fa-solid fa-pen-to-square"></i></button>';
                    ?>
                </li>
                <li class="list-group-item"><span class="text-muted">Current Semester: </span>
                    <?php echo $semester ?>
                    <?php
                    if ($loggedin == true)
                        echo '<button type="button" class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle mx-0" data-bs-toggle="modal" data-bs-target="#updateSemesterModal" style="border:none;"><i class="fa-solid fa-pen-to-square"></i></button>';
                    ?>
                </li>
                <?php
                if ($loggedin == true)
                    echo '<li class="list-group-item"><span class="text-muted">Password: </span> ●●●●●●●●
                <button type="button" class="btn btn-outline-primary position-absolute top-50 end-0 translate-middle mx-0" data-bs-toggle="modal" data-bs-target="#updatePasswordModal" style="border:none;"><i class="fa-solid fa-pen-to-square"></i></button>
                </li>
               
                ';
                ?>
            </ul>
        </div>
    </div>

    <div class="container mt-5 col-md-6">
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-normal">Threads Posted by
                        <?php echo $name ?>
                    </div>
                    <a class="text-decoration-none" href="userthreads.php?user=<?php echo $userid ?>">See all</a>
                </div>
                <span class="badge bg-primary rounded-pill">
                    <?php echo $threads ?>
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-normal">Answers Posted by
                        <?php echo $name ?>
                    </div>
                    <a class="text-decoration-none" href="usercomments.php?user=<?php echo $userid ?>">See all</a>
                </div>
                <span class="badge bg-primary rounded-pill">
                    <?php echo $answers ?>
                </span>
            </li>
        </ul>
    </div>

    <!-- <div class="container col-md-6">
        <h4 class="text-center mt-5 mb-3">Updates form
            <?php echo $name ?>
        </h4>
        <div class="list-group">
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small class="text-muted">3 days ago</small>
                </div>
                <p class="mb-1">Some placeholder content in a paragraph.</p>
                <small class="text-muted">And some muted small print.</small>
            </div>
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small class="text-muted">3 days ago</small>
                </div>
                <p class="mb-1">Some placeholder content in a paragraph.</p>
                <small class="text-muted">And some muted small print.</small>
            </div>
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">List group item heading</h5>
                    <small class="text-muted">3 days ago</small>
                </div>
                <p class="mb-1">Some placeholder content in a paragraph.</p>
                <small class="text-muted">And some muted small print.</small>
            </div>
        </div>
    </div> -->

    <?php include 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>

</html>