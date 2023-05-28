<?php
//start session
ini_set('session.gc_maxlifetime', (3600 * 24 * 30 )); // 30 days
session_start();

//hide all errors
// error_reporting(0);

//include the needed files
include 'include/db.php';
include 'include/sendMail.php';

include 'include/header.html';