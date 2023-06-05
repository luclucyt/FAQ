<?php
//start session
ini_set('session.gc_maxlifetime', (3600 * 24 * 30 )); // 30 days
session_start();

//clear the session
// session_unset();

//show all errors
error_reporting(E_ALL);

//include the needed files
include 'include/db.php';
include 'include/sendMail.php';

include 'include/header.php';