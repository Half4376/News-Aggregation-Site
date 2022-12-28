<?php
// Destroy the session to log out the user
session_start();
$_SESSION['email'] = '';
$_SESSION['access_granted'] = false;
$_SESSION = [];
session_destroy();
header('Location: index.php');