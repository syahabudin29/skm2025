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
    case 'update_settings':
        $settings = $_POST['settings'] ?? [];
        $success = true;
        $message = '';

        foreach($settings as $key => $value) {
            $key = mysqli_real_escape_string($koneksi, $key);
            $value = mysqli_real_escape_string($koneksi, $value);
            
            $query = "UPDATE settings SET setting_value = '$value' WHERE setting_key = '$key'";
            if(!mysqli_query($koneksi, $query)) {
                $success = false;
                $message = mysqli_error($koneksi);
                break;
            }
        }

        echo json_encode(['success' => $success, 'message' => $message]);
        break;

    case 'update_questions':
        $questions = $_POST['questions'] ?? [];
        $success = true;
        $message = '';

        foreach($questions as $key => $value) {
            $key = mysqli_real_escape_string($koneksi, $key);
            $value = mysqli_real_escape_string($koneksi, $value);
            
            $query = "UPDATE questions SET question_text = '$value' WHERE question_key = '$key'";
            if(!mysqli_query($koneksi, $query)) {
                $success = false;
                $message = mysqli_error($koneksi);
                break;
            }
        }

        echo json_encode(['success' => $success, 'message' => $message]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?> 