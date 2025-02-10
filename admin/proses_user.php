<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Tambah User
if(isset($_POST['add'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    
    mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, level) 
                           VALUES ('$username', '$password', '$nama_lengkap', '$level')");
    
    header("Location: users.php?success=add");
    exit();
}

// Edit User
if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    
    if(!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE users SET 
                               username = '$username',
                               password = '$password',
                               nama_lengkap = '$nama_lengkap',
                               level = '$level'
                               WHERE id = $id");
    } else {
        mysqli_query($koneksi, "UPDATE users SET 
                               username = '$username',
                               nama_lengkap = '$nama_lengkap',
                               level = '$level'
                               WHERE id = $id");
    }
    
    header("Location: users.php?success=edit");
    exit();
} 