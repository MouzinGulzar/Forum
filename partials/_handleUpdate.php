<?php
$showAlert = false;
include '_dbconnect.php';
include '_functions.php';

$location = $_GET['redirect'];
$update = $_GET['update'];
session_start();
$userid = $_SESSION['userid'];
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($update == "delete-thread") {
        $threadid = $_GET['threadid'];
        // Delete the thread from db
        $result = execute("DELETE FROM `threads` WHERE `threads`.`thread_id` = $threadid");
        // Delete all comments from db that are related to that thread
        $result = execute("DELETE FROM `comments` WHERE `comments`.`thread_id` = $threadid");

        // Update number of threads by user in users table
        $threads_number_in_user_table = get_data("SELECT `threads` FROM `users` WHERE user_id=$userid", "threads");
        execute("UPDATE `users` SET `threads` = $threads_number_in_user_table - 1 WHERE `users`.`user_id` = $userid");
    } else if ($update == "delete-comment") {
        $commentid = $_GET['commentid'];
        $threadid = $_GET['threadid'];
        // Delete the comment from db
        $result = execute("DELETE FROM `comments` WHERE `comments`.`comment_id` = $commentid");
        // Update number of comments on thread in threads table
        $comments = get_data("SELECT comments FROM `threads` WHERE thread_id= $threadid", "comments");
        execute("UPDATE `threads` SET `comments` = $comments - 1 WHERE `threads`.`thread_id` = $threadid");
        // Update number of comments by user in users table
        $comments_number_in_user_table = get_data("SELECT * FROM `users` WHERE user_id=$userid", "answers");
        execute("UPDATE `users` SET `answers` = $comments_number_in_user_table - 1 WHERE `users`.`user_id` = $userid");
        $result = execute("DELETE FROM `replies` WHERE `replies`.`comment_id` = $commentid");
    } else if ($update == "delete-reply") {
        $replyid = $_GET['replyid'];
        $commentid = $_GET['commentid'];
        // Delete the reply from db
        $result = execute("DELETE FROM `replies` WHERE `replies`.`reply_id` = $replyid");
        // Update number of replies on comment in comments table
        $replies = get_data("SELECT replies FROM `comments` WHERE comment_id= $commentid", "replies");
        execute("UPDATE `comments` SET `replies` = $replies - 1 WHERE `comments`.`comment_id` = $commentid");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $new = xss($_POST[$update]);
        if ($update == "new-name") {
            $result = execute("UPDATE `users` SET `name` = '$new' WHERE `users`.`user_id` = $userid");
        } else if ($update == "new-email") {
            $result = execute("UPDATE `users` SET `user_email` = '$new' WHERE `users`.`user_id` = $userid");
        } else if ($update == "new-gender") {
            $result = execute("UPDATE `users` SET `gender` = '$new' WHERE `users`.`user_id` = $userid");
        } else if ($update == "new-course") {
            $result = execute("UPDATE `users` SET `course` = '$new' WHERE `users`.`user_id` = $userid");
        } else if ($update == "new-semester") {
            $result = execute("UPDATE `users` SET `semester` = '$new' WHERE `users`.`user_id` = $userid");
        } else if ($update == "new-reply") {
            $commentid = $_GET['commentid'];
            $replyid = $_GET['replyid'];
            $reply = xss($_POST['reply-content']);
            $nested = $_GET['nested'];
            if ($nested) {
                $replyingTo = get_data("SELECT reply_by FROM `replies` WHERE `reply_id`=$replyid", "reply_by");
                $result = execute("INSERT INTO `replies` (`reply_content`, `comment_id`, `reply_by`, `nested`, `reply_to`) VALUES ('$reply', $commentid, $userid, $nested, $replyingTo)");
                console("Breakpoint 1");
            } else {
                $result = execute("INSERT INTO `replies` (`reply_content`, `comment_id`, `reply_by`, `nested`, `reply_to`) VALUES ('$reply', $commentid, $userid, $nested, 0)");
            }
            $replies = get_data("SELECT replies FROM `comments` WHERE comment_id = $commentid", "replies");
            $result = execute("UPDATE `comments` SET `replies` = replies + 1 WHERE `comments`.`comment_id` = $commentid");
        }
    }
}
header("location: $location");