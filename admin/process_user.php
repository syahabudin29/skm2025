<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$action = $_POST['action'] ?? '';

switch($action) {
    case 'add':
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Cek username sudah ada atau belum
        $check = mysqli_query($koneksi, "SELECT id FROM admin_users WHERE username = '$username'");
        if(mysqli_num_rows($check) > 0) {
            echo json_encode(['success' => false, 'message' => 'Username sudah digunakan']);
            exit();
        }
        
        $query = "INSERT INTO admin_users (username, password) VALUES ('$username', '$password')";
        if(mysqli_query($koneksi, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($koneksi)]);
        }
        break;

    case 'edit':
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        
        if(!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "UPDATE admin_users SET username = '$username', password = '$password' WHERE id = $id";
        } else {
            $query = "UPDATE admin_users SET username = '$username' WHERE id = $id";
        }
        
        if(mysqli_query($koneksi, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($koneksi)]);
        }
        break;

    case 'delete':
        $id = (int)$_POST['id'];
        
        // Cek jika ini bukan admin terakhir
        $check = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM admin_users");
        $total = mysqli_fetch_assoc($check)['total'];
        
        if($total <= 1) {
            echo json_encode(['success' => false, 'message' => 'Tidak dapat menghapus admin terakhir']);
            exit();
        }
        
        $query = "DELETE FROM admin_users WHERE id = $id";
        if(mysqli_query($koneksi, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($koneksi)]);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?> 