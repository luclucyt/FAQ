<?php
//start session
ini_set('session.gc_maxlifetime', (3600 * 24 * 30 )); // 30 days
session_start();

//clear the session
// session_unset();

//show all errors
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//inc the needed files
include 'inc/header.php';
include 'inc/db.php';
include 'inc/sendMail.php';

