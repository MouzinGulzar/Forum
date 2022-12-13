<?php
// include 'partials/_functions.php';
$showError = "false";
if ($_SERVER['REQUEST_METHOD'] = "POST") {
    include '_dbconnect.php';
    require '_functions.php';

    $username = xss($_POST['signupName']);
    // $name = xss($_POST['signupflname']);
    $fname = xss($_POST['signupFName']);
    $lname = xss($_POST['signupLName']);
    $name = $fname . ' ' . $lname;
    $email = xss($_POST['signupEmail']);
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $course = $_POST['course'];
    $semester = $_POST['semester'];
    $password = xss($_POST['signupPassword']);
    $cpassword = xss($_POST['signupCpassword']);

    // Check where this email exist;
    $exist_email_sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result1 = mysqli_query($conn, $exist_email_sql);
    $num_rows1 = mysqli_num_rows($result1);
    $exist_username_sql = "SELECT * FROM `users` WHERE username='$username'";
    $result2 = mysqli_query($conn, $exist_username_sql);
    $num_rows2 = mysqli_num_rows($result2);
    if ($num_rows1 > 0) {
        $showError = "A user with this email already exists.";
    } else if ($num_rows2 > 0) {
        $showError = "A user with this username already exists.";
    } else {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `name`, `user_email`, `gender`, `course`, `semester`, `user_pass`) VALUES ('$username', '$name', '$email', '$gender', '$course', '$semester', '$hash')";
            // console("Breakpoint 1");
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("location: /forum/index.php?signupsuccess=true");
                exit();
            }
        } else {
            $showError = "Passwords do not match";
            // header("location: /forum/index.php?signupsuccess=$showError");
            header("location: /forum/index.php?signupsuccess=false&error=$showError");
        }
    }


}
header("location: /forum/index.php?signupsuccess=false&error=$showError");