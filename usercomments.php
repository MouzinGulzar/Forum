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

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Comments by Mouzin Gulzar
            </h1>
            <hr class="my-4">
            <p>Pursuing Bachelor of Computer Applications. Currently in 4th semester</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Visit Profile</a>
        </div>
    </div>

    <div class="container">
        <h1>Browse Comments</h1>
        <?php
        $userid = $_GET['user'];
        $result = execute("SELECT * FROM `comments` WHERE comment_by=$userid ORDER BY comment_time DESC");
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $thread_id = $row['thread_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", "name");

            echo '
                        <div class="media my-3">';

            echo '<div class="profileImage mr-3" style="margin-top: 10px; width:40px; height:40px; line-height: 40px; font-size: 15px">' . profile($name) . '</div>';

            echo '
            <div class="media-body">
                <p class="font-weight-bold my-0"> <small><span class="fw-bold"><a class="text-dark fw-bold text-decoration-none" href="profile.php?user=' . $userid . '">' . $name . '</a></span><small><span class="text-muted mx-1"> ' . time_elapsed($comment_time) . '</span> </small></small></p>
                <p>' . $content . '<br><small><small><a class="text-decoration-none" href="thread.php?threadid=' . $thread_id . '">See thread...</a></small></small></p>
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