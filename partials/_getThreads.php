<?php
session_start();
include '_dbconnect.php';
require '_functions.php';
// $threadid = (int) $_GET['threadid'];
// $limit = (int) $_GET['limit'];
// $offset = (int) $_GET['offset'];
$catid = $_GET['catid'];
$limit = (int) $_GET['limit'];
$offset = (int) $_GET['offset'];
// $result = execute("SELECT * FROM `threads` WHERE thread_cat_id=$cat_id ORDER BY timestamp DESC");
$result = execute("SELECT * FROM `threads` WHERE thread_cat_id=$catid ORDER BY timestamp DESC LIMIT $limit OFFSET $offset");

$no_result = NULL;
if (!$offset)
    $no_result = true;

while ($row = mysqli_fetch_assoc($result)) {
    $no_result = false;
    $thread_id = $row['thread_id'];
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_time = $row['timestamp'];
    $userid = $row['thread_user_id'];
    $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", "name");
    $comments = get_data("SELECT `comments` FROM `threads` WHERE thread_id=$thread_id", "comments");


    echo '
<div class="media my-4">';
    $gender = get_data("SELECT gender FROM `users` WHERE user_id=$userid", "gender");
    // if ($gender == 'm') {
    //     echo '<a href="profile.php?user=' . $userid . '"><img src="img/mdpp.jpg" width="50px" class="mr-3" alt="..."></a>';
    // } else if ($gender == 'f') {
    //     echo '<a href="profile.php?user=' . $userid . '"><img src="img/fdpp.jpg" width="50px" class="mr-3" alt="..."></a>';
    // } else {
    //     echo '<a href="profile.php?user=' . $userid . '"><img src="img/tdpp.png" width="50px" class="mr-3" alt="..."></a>';
    // }
    echo '<div class="profileImage mr-3" style="margin: 20px 0;">' . profile($name) . '</div>';
    echo '
    <div class="media-body position-relative">
        <span class="text-primary">
            <small>
                <small>
                    Asked by <a class="text-primary text-decoration-none" href="profile.php?user=' . $userid . '"><b>' .
        $name . '</b> </a><span class="mx-1 text-muted"> ' . time_elapsed($thread_time) . '
                    </span></small>
            </small>
        </span>
        <h5 class="mt-0"> <a class="text-dark text-decoration-none" href="thread.php?threadid=' . $thread_id . '&catid=' . $catid . '">' .
        $title . '</a> </h5>
        <a class="text-dark text-decoration-none" href="thread.php?threadid=' . $thread_id . '&catid=' . $catid . '">
            <p class="my-0">' . $desc . '</p>
        </a>
        <small class="text-muted"><small><span class="mx-1 fw-light">';
    if ($comments == 0)
        echo 'No comments';
    else if ($comments == 1)
        echo $comments . ' comment';
    else
        echo $comments . ' comments';
    echo '</span></small></small>
    </div>';

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['userid'] == $userid) {
        echo ' <p class="mx-1 my-1"><button type="button" class="btn btn-outline-secondary" data-bs-container="body"
            data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true" data-bs-content=\' <a
            class="dropdown-item"
            href="/forum/partials/_handleUpdate.php?update=delete-thread&threadid=' . $thread_id . '&redirect=/forum/threadlist.php?catid=' . $catid . '"><i
                class="fa-solid fa-trash mr-2"></i>Delete</a>\' data-mdb-html="true" style="border:none;">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button></p>';
    }
    echo '
</div>
<hr color="secondary">';
}
if ($no_result) {
    echo '
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <p class="display-4">No Threads Found</p>
        <p class="lead">Be the first person to ask a quesiton.</p>
    </div>
</div>';
}