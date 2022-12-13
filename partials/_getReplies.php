<?php
session_start();
include '_dbconnect.php';
require '_functions.php';

$commentid = (int) $_GET['commentid'];
$threadid = (int) $_GET['threadid'];
// $result = execute("SELECT * FROM `comments` WHERE thread_id = $threadid AND comment_id < $lastid ORDER BY comment_id DESC LIMIT 5");
$result = execute("SELECT * FROM `replies` WHERE comment_id=$commentid ORDER BY reply_time DESC");

while ($row = mysqli_fetch_assoc($result)) {
    $reply_id = $row['reply_id'];
    $content = $row['reply_content'];
    $reply_time = $row['reply_time'];
    $comment_id = $row['comment_id'];
    $userid = $row['reply_by'];
    $nested = $row['nested'];
    $reply_to = $row['reply_to'];
    $name = get_data("SELECT * FROM `users` WHERE user_id=$userid", "name");
    $username = get_data("SELECT * FROM `users` WHERE user_id=$userid", "username");
    $nested = get_data("SELECT nested FROM `replies` WHERE `reply_id`=$reply_id", "nested");

    echo '
    <div class="media mt-3" id="' . $reply_id . '">';

    echo '<div class="profileImage mr-3" style="width:30px; height:30px; line-height: 31px; font-size: 14px">' . profile($name) . '</div>';


    echo '
        <div class="media-body">
            <p class="font-weight-bold my-0 lh-1"> <small><a class="text-dark fw-bold text-decoration-none" href="profile.php?user=' . $userid . '">' . $name . '<span class="fw-light text-muted mx-1">@' . $username . '</span></a><small><span class="text-muted"><small>•</small></span><span class="mx-1 fw-light text-muted">' . time_elapsed($reply_time) . '</span>';
    if ($nested) {
        $replying_to = get_data("SELECT username FROM `users` WHERE user_id=$reply_to", "username");
        echo '<br><span class="text-muted">Replying to <a href="profile.php?user=' . $reply_to . '" class="text-decoration-none text-primary">@' . $replying_to . '</a></span>';
    }
    echo '</small></small></p>
            <p class="my-1"><small>';
    echo $content . '</small></p>
        </div>';

    echo '
            <p class="mx-1 my-1">
            <button type="button" class="btn btn-outline-secondary pop" data-comment-id="' . $comment_id . '" data-reply-id="' . $reply_id . '" data-nested="1" data-comment-by="' . $username . '" "data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-html="true" data-bs-content=\'
            <a class="myBtn dropdown-item btn btn-outline-primary btn-sm">    
        <i class="fa-solid fa-reply mr-2"></i>Reply</a>';

    // <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateNameModal" style="border:none;">
    // <i class="fa-solid fa-pen-to-square"></i></button>

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['userid'] == $userid) {
        echo '
            <a class="dropdown-item" href="/forum/partials/_handleUpdate.php?update=delete-reply&replyid=' . $reply_id . '&commentid=' . $commentid . '&redirect=/forum/thread.php?threadid=' . $threadid . '"><i class="fa-solid fa-trash mr-2"></i>Delete</a>';
    }

    echo ' \' data-mdb-html="true" style="border:none;">
    <i class="fa-solid fa-ellipsis-vertical"></i>
    </button></p>
    </div>';
}
// include 'forum/script.js';
// console("gmc");
