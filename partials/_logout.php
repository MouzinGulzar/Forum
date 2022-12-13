<?php
session_start();

echo "Loggin you out. Please wait...";
session_destroy();

$location = $_GET['redirect'];

header("location: $location");
