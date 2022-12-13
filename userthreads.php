<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php require 'partials/_functions.php' ?>
    <?php
    $user = $_GET['user'];
    $name = get_data("SELECT * FROM `users` WHERE user_id=$user", 'name');
    $course = get_data("SELECT * FROM `users` WHERE user_id=$user", 'course');
    $semester = get_data("SELECT * FROM `users` WHERE user_id=$user", 'semester');

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
    ?>

    <div class=" container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Threads by
                <?php echo $name ?>
            </h1>
            <hr class="my-1">
            <p>Pursuing
                <?php echo $course ?>. Currently in
                <?php echo $semester ?> semester
            </p>
            <a class="btn btn-success btn-lg" href="profile.php?user=<?php echo $user ?>" role="button">Visit
                Profile</a>
        </div>
    </div>

    <div class="container">
        <h1>Browse Threads</h1>
        <?php
        $result = execute("SELECT * FROM `threads` WHERE thread_user_id=$user ORDER BY timestamp DESC");
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $userid = $row['thread_user_id'];
            $name = get_data("SELECT * FROM `users` WHERE user_id=$user", "name");

            echo '
                        <div class="media my-3">';

            echo '<div class="profileImage mr-3" style="margin: px 0;">' . profile($name) . '</div>';


            echo '
                        <div class="media-body">
                            <h5 class="mt-0"> <a class="text-dark text-decoration-none" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                            <p>' . $desc . '<br>
                            <span class="text-primary">
                            <small>
                            <small>
                            <span class="text-muted">Asked ' . time_elapsed($thread_time) . '</span> 
                            </small>
                            </small>
                            </span>
                            </p>
                           </div>
                    </div>';
        }
        if ($noResult) {
            echo '
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-4">No Threads Found</p>
                                <p class="lead">Be the first person to ask a quesiton.</p>
                            </div>
                        </div>';
        }
        ?>
    </div>
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