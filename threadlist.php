<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thread List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script type="text/javascript" src="jquery-3.6.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="partials/style.css">
</head>

<body>
    <?php
    // session_start();
    // echo 'username:' . $_SESSION['username'];
    
    ?>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php require 'partials/_functions.php' ?>

    <?php
    $cat_id = $_GET['catid'];
    $result = execute("SELECT * FROM `categories` WHERE category_id=$cat_id");

    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <?php
    $showAlert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Insert thread in db
        $cat_id = $_GET['catid'];
        $th_title = xss($_POST['title']);
        $th_desc = xss($_POST['desc']);
        session_start();
        $uid = $_SESSION['userid'];

        $result = execute("INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$th_title', '$th_desc', '$cat_id', '$uid')");
        $threads = get_data("SELECT `threads` FROM `users` WHERE user_id=$uid", "threads");
        execute("UPDATE `users` SET `threads` = $threads + 1 WHERE `users`.`user_id` = $uid");
        $showAlert = true;
        if ($showAlert) {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thread added successfully!</strong> Please wait while the community responds.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    ?>

    <div class="container my-4">
        <div class="jumbotron">

            <h1 class="display-4">
                <?php echo $catname; ?>
            </h1>
            <p class="lead">
                <?php echo $catdesc; ?>
            </p>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed btn-danger fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo">
                            Rules
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul class="list-group">
                                <li class="list-group-item">Keep it friendly.</li>
                                <li class="list-group-item">Be courteous and respectful.</li>
                                <li class="list-group-item">Appreciate that others may have an opinion different from
                                    yours.</li>
                                <li class="list-group-item">Stay on topic.</li>
                                <li class="list-group-item">Refrain from demeaning, discriminatory, or harassing
                                    behaviour and speech.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h1>Ask a question</h1>

        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Question Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep the title as short as possible</div>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo '
            <button type="submit" class="btn btn-success btn-block">Post</button>
        </form>
        </div>';
            } else {
                echo '
        <button type="submit" class="btn btn-secondary btn-block" disabled>Post</button>
        <div id="emailHelp" class="form-text">You aren\'t logged in. Please login to post a thread.</div>

    </form>
    </div>';
            }

            ?>


            <div class="container">
                <h1>Browse Questions</h1>
                <div id="all-threads"></div>
            </div>

            <?php include 'partials/_footer.php' ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
                crossorigin="anonymous"></script>

            <script type="text/javascript" src="partials/_functions.js"></script>
            <script>
                var catId = getUrlParameter("catid");

                $(document).ready(function () {
                    var flag = 0;
                    $.ajax({
                        type: "GET",
                        // url: 'index2.php',
                        url: "partials/_getThreads.php",
                        data: {
                            catid: catId,
                            offset: flag,
                            limit: 10,
                        },
                        success: function (data) {
                            $("#all-threads").append(data);
                            flag += 10;
                            popoverScript();
                        }
                    });

                    $(window).scroll(function () {
                        if ($(window).scrollTop() >= $(document).height() - $(window).height() && flag) {
                            $.ajax({
                                type: "GET",
                                // url: 'index2.php',
                                url: "partials/_getThreads.php",
                                data: {
                                    catid: catId,
                                    offset: flag,
                                    limit: 10,
                                },
                                success: function (data) {
                                    $("#all-threads").append(data);
                                    flag += 10;
                                    popoverScript();
                                },
                                error: function (data) {
                                    alert("fail");
                                }
                            });
                        }
                    });
                });
            </script>

            <script>
                function popoverScript() {
                    // await sleep(100);
                    $(function () {
                        $('[data-bs-toggle="popover"]').popover();
                    });
                    var popover = new bootstrap.Popover(
                        document?.querySelector(".popover-dismiss"),
                        {
                            trigger: "focus",
                        }
                    );
                }
            </script>
</body>

</html>