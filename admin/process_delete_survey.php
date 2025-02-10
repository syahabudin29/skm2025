<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Terima data JSON
$input = json_decode(file_get_contents('php://input'), true);

if(isset($input['ids']) && is_array($input['ids'])) {
    // Validasi dan bersihkan input
    $ids = array_map(function($id) {
        return (int)$id;
    }, $input['ids']);
    
    // Filter array untuk memastikan hanya nilai positif
    $ids = array_filter($ids, function($id) {
        return $id > 0;
    });
    
    if(empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'Invalid IDs']);
        exit();
    }

    // Buat string ID yang aman untuk query
    $idList = implode(',', $ids);
    
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);
    
    try {
        // Hapus data
        $query = "DELETE FROM survey_responses WHERE id IN ($idList)";
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            mysqli_commit($koneksi);
            echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            throw new Exception(mysqli_error($koneksi));
        }
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?> 