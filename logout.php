<?php
session_start();
unset($_SESSION['first_name']);
unset($_SESSION['logged_in']);
$_SESSION = array();


header("Location: login.php");
