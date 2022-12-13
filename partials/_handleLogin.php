<?php
$showError = "false";
$location = $_GET['redirect'];
if ($_SERVER['REQUEST_METHOD'] = "POST") {
    include '_dbconnect.php';
    include '_functions.php';

    $email = xss($_POST['loginEmail']);
    $password = xss($_POST['loginPass']);

    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $userid = $row['user_id'];

        if (password_verify($password, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['useremail'] = $email;
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userid;
            header("location: $location");
            exit();
        } else {
            $showError = "Please enter correct password.";
        }
        if (strpos($location, "?")) {
            header("location: $location&error=$showError");
        } else {
            header("location: $location?error=$showError");
        }
    } else {
        $showError = "User not found.";
    }
    if (strpos($location, "?")) {
        header("location: $location&error=$showError");
    } else {
        header("location: $location?error=$showError");

    }
}