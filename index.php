<?php

// Inialize session
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['username'])) {
header('Location: beer.php');
}
else
{
header('Location: login.php');
}
?>
