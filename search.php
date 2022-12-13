<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/797f232dbd.js" crossorigin="anonymous"></script>
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

        .container {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php require 'partials/_functions.php' ?>



    <div class="container">
        <h1 class="my-5 display-4">You Searched For<em> "
                <?php echo $_GET['query'] ?>"
            </em></h1>
        <?php
        $query = $_GET['query'];
        $result = execute("SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST ('$query') ORDER BY timestamp DESC");
        $no_result = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $no_result = false;
            $id = $row['thread_id'];
            $title = xss($row['thread_title']);
            $desc = xss($row['thread_desc']);
            $time = $row['timestamp'];
            $userid = $row['thread_user_id'];
            $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", "name");

            echo '
           
                        <div class="media my-4">';

            $gender = get_data("SELECT gender FROM `users` WHERE user_id=$userid", "gender");
            if ($gender == 'm') {
                echo '<a href="profile.php?user=' . $userid . '"><img src="img/mdpp.jpg" width="50px" class="mr-3" alt="..."></a>';
            } else if ($gender == 'f') {
                echo '<a href="profile.php?user=' . $userid . '"><img src="img/fdpp.jpg" width="50px" class="mr-3" alt="..."></a>';
            } else {
                echo '<a href="profile.php?user=' . $userid . '"><img src="img/tdpp.png" width="50px" class="mr-3" alt="..."></a>';
            }
            echo '
                        <div class="media-body">
                            <h5 class="mt-0"> <a class="text-dark text-decoration-none" href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
                            <p class="my-0">' . $desc . '</p>
                            <span class="text-primary">
                            <small>
                            <small>
                            Asked by <a class="text-primary text-decoration-none" href="profile.php?user=' . $userid . '"><b>' . $name . '</b> </a><span class="mx-1 text-muted"> ' . time_elapsed($time) . '
                            </span></small>
                            </small>
                            </span>
                        </div>
                    </div>';
        }
        if ($no_result) {
            echo '
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <p class="display-4">No Results Found</p>
                                <p>
                                Suggestions:
                                <ul>
                                    <li>Make sure that all words are spelled correctly.</li>
                                    <li>Try different keywords.</li>
                                    <li>Try more general keywords.</li>
                                    <li>Try fewer keywords.</li>
                                </ul>
                                </p>
                            </div>
                            <a><button class="btn btn-success"></button></a>
                        </div>';
        }
        ?>
    </div>


    <?php include 'partials/_footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>