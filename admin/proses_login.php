<?php
session_start();
include 'config.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    
    $query = mysqli_query($koneksi, "SELECT * FROM admin_users WHERE username='$username'");
    
    if(mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_array($query);
        if(password_verify($password, $data['password'])) {
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $data['id'];
            $_SESSION['admin_username'] = $data['username'];
            
            header("Location: index.php");
            exit();
        }
    }
    header("Location: login.php?error=1");
    exit();
}
?> 