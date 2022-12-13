<?php session_start() ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IITM Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script type="text/javascript" src="jquery-3.6.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="partials/style.css">

    <style>
        /* The Modal (background) */
        .m {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            -webkit-animation-name: fadeIn;
            /* Fade in the background */
            -webkit-animation-duration: 0.4s;
            animation-name: fadeIn;
            animation-duration: 0.4s;
            /* border-radius: 15px 15px 0px 0px; */
        }

        /* Modal Content */
        .m-content {
            position: fixed;
            bottom: 0;
            background-color: #fefefe;
            width: 100%;
            -webkit-animation-name: slideIn;
            -webkit-animation-duration: 0.4s;
            animation-name: slideIn;
            animation-duration: 0.4s;
            border-radius: 15px 15px 0px 0px;
        }

        /* The Close Button */
        /* .cl {
            color: grey;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .cl:hover,
        .cl:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        } */

        .m-header {
            padding: 10px 16px;
            background-color: #fefefe;
            border-radius: 15px 15px 0px 0px;
            color: #000;
            border: 1px solid grey;
            border-width: 0px 0px 1px 0px;
        }

        .m-body {
            padding: 2px 16px;
            color: #000;
        }

        .m-footer {
            padding: 2px 16px;
            background-color: #fefefe;
            border: 1px solid grey;
            border-width: 1px 0px 0px 0px;
            color: black;
        }

        /* Add Animation */
        @-webkit-keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0;
            }

            to {
                bottom: 0;
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                bottom: -300px;
                opacity: 0;
            }

            to {
                bottom: 0;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <script>

        $(document).ready(function () {
            var firstName = $('#firstName').text();
            var lastName = $('#lastName').text();
            var intials = firstName.charAt(0) + lastName.charAt(0);
            var profileImage = $('#profileImage').text(intials);
        });
    </script>
</head>

<body>

    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php require 'partials/_functions.php' ?>

    <?php
    $thread_id = $_GET['threadid'];
    // $cat_id = $_GET['catid'];
    $result = execute("SELECT * FROM `threads` WHERE thread_id=$thread_id");
    $noResult = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
    ?>

    <?php
    $showAlert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Insert comment in db
        $thread_id = $_GET['threadid'];
        $comment = xss($_POST['comment']);
        $uid = $_SESSION['userid'];

        if ($comment == "") {
            goto skip_comment;
        }

        $result = execute("INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$thread_id', '$uid', CURRENT_TIMESTAMP)");
        $comments = get_data("SELECT * FROM `users` WHERE user_id=$uid", "answers");

        execute("UPDATE `users` SET `answers` = $comments + 1 WHERE `users`.`user_id` = $uid");
        $comments_on_thread = get_data("SELECT `comments` FROM `threads` WHERE thread_id=$thread_id", "comments");
        execute("UPDATE `threads` SET `comments` = $comments_on_thread + 1 WHERE `threads`.`thread_id` = $thread_id");
        $showAlert = true;
        if ($showAlert) {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Comment added successfully!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }
    skip_comment:
    ?>
    <div class="container my-4">
        <div class="jumbotron py-4">
            <h1 class="">
                <?php echo $title; ?>
            </h1>
            <p class="lead">
                <?php echo $desc; ?>
            </p>
            <hr class="my-1">
            <?php

            $uid = get_data("SELECT thread_user_id FROM `threads` WHERE thread_id=$thread_id", "thread_user_id");
            $name = get_data("SELECT * FROM `users` WHERE user_id=$uid", "name");
            ?>
            <p class="cont-name">Posted by: <b><a class="text-dark text-decoration-none"
                        href="profile.php?user=<?php echo $uid ?>">
                        <?php echo $name ?>
                    </a></b></p>
            <button class="btn btn-success" disabled>Invite a teacher to this thread</button>
            <div id="emailHelp" class="form-text">This freature will be soon enabled. Please cooperate.</div>
        </div>
    </div>

    <div class="container my-5">

        <h1>Post a comment</h1>

        <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
            <div class="mb-3">
                <label for="comment" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>


            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                echo '
        <button type="submit" class="btn btn-success btn-block">Post Comment</button>
        ';
            } else {
                echo '
        <button type="submit" class="btn btn-success btn-block" disabled>Post Comment</button>
        <div id="emailHelp" class="form-text">You aren\'t logged in. Please login to post a comment.</div>

        ';
            }
            echo '</form>
            </div>
            ';
            ?>
            <div class="container">

                <button class="myBtn btn btn-primary d-none"></button>
                <h1>Browse Comments</h1>
                <div id="all-comments">

                </div>

                <!-- /forum/partials/_handleUpdate.php?update=new-reply&commentid=' . $_COOKIE['comment-to-reply'] . '&redirect=' . $_SERVER['REQUEST_URI'] . ' -->

                <?php
                echo '
                    <div id="myModal" class="m">
                        <div class="m-content">
                            <div class="m-body py-4" id="mb">
                                <form action="/forum/partials/_handleUpdate.php?update=new-reply&redirect=' . $_SERVER['REQUEST_URI'] . '" method="post" class="m-2 position-relative mt-4" id="reply">
                                    <div class="form-floating my-3">
                                        <textarea class="form-control mb-3" placeholder="Leave a comment here" id="reply-content" name="reply-content"></textarea>
                                        <label for="reply-content">Reply to <span class="text-primary">@</span><span id="reply-to" class="text-primary"></span></label>
                                    </div>';
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<button type="submit" class="btn btn-primary my-2 btn-block btn-sm">Submit</button>';
                } else {
                    echo '<button type="submit" class="btn btn-primary my-2 btn-block btn-sm" disabled>Submit</button><div id="emailHelp" class="form-text">You aren\'t logged in. Please login to post a reply.</div>';
                }

                echo '<a type="close" class="btn btn-secondary cl my-2 btn-block btn-sm">Close</a>
                                </form>
                            </div>
                        </div>
                    </div>';
                ?>
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
            <script src="partials/_functions.js"></script>
            <script>
                var m = document.getElementById("myModal");
                function x() {
                    // Get the modal
                    // setup the event listeners
                    // await sleep(100);
                    var btnList = document.querySelectorAll(".pop");
                    var btnArr = Array.from(btnList);
                    var dModal = document.querySelector("#mb");
                    var reply = document.querySelector("#reply");
                    var reply_to = document.querySelector("#reply-to");
                    btnArr.forEach((btn) => {
                        btn.onclick = function () {
                            async function cb() {
                                await sleep(100); // Note: there should be a delay to ensure that the anchor element is completely visible in the DOM.
                                var nested = btn.getAttribute("data-nested");
                                console.log(nested);
                                let myBtnNodeList = document.querySelectorAll(".myBtn");
                                myBtnNodeList.forEach((b) => {
                                    b.onclick = function () {
                                        var commentid = btn.getAttribute("data-comment-id");
                                        var replyid = btn.getAttribute("data-reply-id");
                                        var replyto = btn.getAttribute("data-comment-by");
                                        m.style.display = "block";
                                        document.querySelector("#reply-content").focus();
                                        var comment_to_reply = getCookie("comment-to-reply");
                                        var redirect = document.URL.replace("http://localhost", "");
                                        var action =
                                            "/forum/partials/_handleUpdate.php?update=new-reply&commentid=" +
                                            commentid + "&nested=" + nested + "&replyid=" + replyid +
                                            "&redirect=" +
                                            window.location.href;
                                        reply.setAttribute("action", action);
                                        // reply_to.insertAdjacentHTML("beforeend", replyto);
                                        reply_to.innerHTML = replyto;
                                        $('[data-bs-toggle="popover"]').popover("hide");
                                    };
                                });
                                // myBtnNodeList2.forEach((b) => {
                                //     b.onclick = function () {
                                //         var commentid = btn.getAttribute("data-comment-id");
                                //         var replyid = btn.getAttribute("data-reply-id");
                                //         var replyto = btn.getAttribute("data-comment-by");
                                //         m.style.display = "block";
                                //         document.querySelector("#reply-content").focus();
                                //         var comment_to_reply = getCookie("comment-to-reply");
                                //         var redirect = document.URL.replace("http://localhost", "");
                                //         var action =
                                //             "/forum/partials/_handleUpdate.php?update=new-reply&commentid=" +
                                //             commentid + "&replyid=" + replyid + "&nested=" + nested +
                                //             "&redirect=" +
                                //             window.location.href;
                                //         reply.setAttribute("action", action);
                                //         // reply_to.insertAdjacentHTML("beforeend", replyto);
                                //         reply_to.innerHTML += replyto;
                                //         $('[data-bs-toggle="popover"]').popover("hide");
                                //     };
                                // })
                            }
                            cb();
                        };
                    });

                    var repList = document.querySelectorAll(".reply-div-open-btn");
                    var repArr = Array.from(repList);
                    repArr.forEach(btn => {
                        btn.onclick = function () {
                            var commentId = btn.getAttribute("data-comment-id");
                            var replyDiv = document.querySelector(`#c-${commentId}`);
                            if (btn.getAttribute("data-clicked") == "1") {
                                replyDiv.style.display = "block";
                                btn.style.display = "none";
                                return;
                            }
                            btn.setAttribute("data-clicked", "1");
                            console.log(commentId);
                            var html = `<a href="javascript:void(0)" class="text-secondary text-decoration-none hide-btn ml-5" id="rh-${commentId}"><small class=""><small><span class="mx-1 fw-light">― Hide ―</span></small></small></a>`;
                            $.ajax({
                                type: "GET",
                                url: "partials/_getReplies.php",
                                data: {
                                    commentid: commentId,
                                    threadid: threadId,
                                },
                                success: function (data) {
                                    $(`#c-${commentId}`).append(data);
                                    $(`#c-${commentId}`).append(html);
                                    document.querySelector(`#rh-${commentId}`).onclick = function () {
                                        replyDiv.style.display = "none";
                                        btn.style.display = "inline";
                                    }
                                    x();
                                    popoverScript();
                                },
                                error: function (data) {
                                    $(`#c-${commentId}`).append("Cannot load comments.Try refreshing the page.")
                                }
                            });
                            btn.style.display = "none";
                        }
                    })
                }
                // Get the button that opens the modal
                var btn = document.querySelector(".myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("cl")[0];

                // When the user clicks the button, open the modal
                btn.onclick = function () {
                    m.style.display = "block";
                };

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    m.style.display = "none";
                };

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == m) {
                        m.style.display = "none";
                    }
                };

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
            <script>
                var threadId = getUrlParameter("threadid")
                $(document).ready(function () {
                    var flag = 0;
                    $.ajax({
                        type: "GET",
                        // url: 'index2.php',
                        url: "partials/_getComments.php",
                        data: {
                            threadid: threadId,
                            offset: flag,
                            limit: 10,
                        },
                        success: function (data) {
                            $("#all-comments").append(data);
                            flag += 10;
                            x();
                            popoverScript();
                        }
                    });

                    $(window).scroll(function () {
                        if (
                            $(window).scrollTop() >=
                            $(document).height() - $(window).height() - 1 && flag
                        ) {
                            $.ajax({
                                type: "GET",
                                // url: 'index2.php',
                                url: "partials/_getComments.php",
                                data: {
                                    threadid: threadId,
                                    offset: flag,
                                    limit: 10,
                                },
                                success: function (data) {
                                    $("#all-comments").append(data);
                                    flag += 10;
                                    x();
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

</body>