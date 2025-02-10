<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'views/dashboard.php';
?> 