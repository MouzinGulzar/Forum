<?php
echo '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/797f232dbd.js" crossorigin="anonymous"></script>
';

session_start();
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/forum">
        <img class="rounded" src="img/iitm-logo.jpeg" alt="" width="30">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/forum">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
            </ul>
            <form class="d-flex" role="search" method="get" action="search.php">
                <input class="form-control me-2" type="search" placeholder="Search the forum" name="query" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '
        <a href="profile.php?user=' . $_SESSION['userid'] . '">
            <button type="button" class="btn btn-light ml-2" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" style="border-radius:100%;"><i class="fa-solid fa-user-tie"></i></button>
        </a>
        <a href="partials/_logout.php?redirect=' . $_SERVER['REQUEST_URI'] . '"><button class="btn btn-outline-danger ml-2" >Logout</button></a>';
} else {
    echo
        '
                <div class="mx-2">
                    <button class="btn btn-outline-success ml-2"  data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
}


echo '</div>
        </div>
    </div>
</nav>';
include "partials/_loginModal.php";
include "partials/_signupModal.php";

if (isset($_GET['error']) && $_GET['error'] != "false") {
    $error = $_GET['error'];
    echo '
            <div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
                <strong>Sorry!</strong> ' . $error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
} else if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] = "true") {
    echo '
            <div class="alert alert-success alert-dismissible fade show my-0" role="alert">
                <strong>Welcome to IITM forum!</strong> You can now Login.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
}