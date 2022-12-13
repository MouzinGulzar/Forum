<?php
session_start();
include '_dbconnect.php';
require '_functions.php';

$threadid = (int) $_GET['threadid'];
$limit = (int) $_GET['limit'];
$offset = (int) $_GET['offset'];
// $result = execute("SELECT * FROM `comments` WHERE thread_id = $threadid AND comment_id < $lastid ORDER BY comment_id DESC LIMIT 5");
$result = execute("SELECT * FROM `comments` WHERE thread_id=$threadid ORDER BY comment_time DESC LIMIT $limit OFFSET $offset");

$no_result = NULL;
if (!$offset)
    $no_result = true;

while ($row = mysqli_fetch_assoc($result)) {
    $no_result = false;
    $comment_id = $row['comment_id'];
    $content = $row['comment_content'];
    $comment_time = $row['comment_time'];
    $userid = $row['comment_by'];
    $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", "name");
    $username = get_data("SELECT * FROM `users` WHERE user_id=$userid", "username");
    $replies = get_data("SELECT * FROM `comments` WHERE comment_id=$comment_id", "replies");

    echo '
    <div class="comment media my-3" id="' . $comment_id . '">';

    echo '<div class="profileImage mr-3" style="width:35px; height:35px; line-height: 37px; font-size: 15px">' . profile($name) . '</div>';

    echo '<div class="media-body">
            <p class="my-0"> <small><a class="text-dark fw-bold text-decoration-none" href="profile.php?user=' . $userid . '">' . $name . '<span class="fw-light text-muted mx-1">@' . $username . '</span></a><small><span class="text-muted"><small>•</small></span><span class="mx-1 fw-light text-muted">' . time_elapsed($comment_time) . '</span></small></small></p>
            <p class="my-0 h6"><small>' . $content . ' </small></p>';
    if ($replies > 0) {
        echo '<div class="replies-div" id="c-' . $comment_id . '"></div>';
    }

    if ($replies > 0)
        echo '<a href="javascript:void(0);" class="text-secondary text-decoration-none reply-div-open-btn" id="r-' . $comment_id . '" data-comment-id="' . $comment_id . '"><small class=""><small><span class="mx-1 fw-light">';

    if ($replies == 1)
        echo '― View reply ―';
    else if ($replies > 1)
        echo '― View ' . $replies . ' replies ―';

    if ($replies > 0)
        echo '</span></small></small></a>';

    echo '</div>';

    echo '
            <p class="mx-1 my-1">
            <button type="button" class="btn btn-outline-secondary pop" data-comment-id="' . $comment_id . '" data-comment-by="' . $username . '" data-reply-id="0" data-nested=0 "data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true" data-bs-content=\'
            <a class="myBtn dropdown-item btn btn-outline-primary btn-sm">    
        <i class="fa-solid fa-reply mr-2"></i>Reply</a>';

    // <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateNameModal" style="border:none;">
    // <i class="fa-solid fa-pen-to-square"></i></button>

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['userid'] == $userid) {
        echo '
            <a class="dropdown-item" href="/forum/partials/_handleUpdate.php?update=delete-comment&commentid=' . $comment_id . '&threadid=' . $threadid . '&redirect=/forum/thread.php?threadid=' . $threadid . '"><i class="fa-solid fa-trash mr-2"></i>Delete</a>';
    }

    echo ' \' data-mdb-html="true" style="border:none;">
    <i class="fa-solid fa-ellipsis-vertical"></i>
    </button></p>
    </div>';

}
if ($no_result) {
    echo '
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Comments Found</p>
                    <p class="lead">Be the first person to comment.</p>
                </div>
            </div>';
}

// console("gmc");
