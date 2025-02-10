<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login");
    exit();
}

// Ambil data survey dari database
$stmt = $pdo->query("SELECT * FROM survey_responses ORDER BY id DESC");
$responses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Survey - Survey Kepuasan</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Hasil Survey Kepuasan</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>P1</th>
                    <th>P2</th>
                    <th>P3</th>
                    <th>P4</th>
                    <th>P5</th>
                    <th>Saran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($responses as $response): ?>
                <tr>
                    <td><?php echo htmlspecialchars($response['id']); ?></td>
                    <td><?php echo htmlspecialchars($response['nama']); ?></td>
                    <td><?php echo htmlspecialchars($response['email']); ?></td>
                    <td><?php echo htmlspecialchars($response['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($response['pertanyaan1']); ?></td>
                    <td><?php echo htmlspecialchars($response['pertanyaan2']); ?></td>
                    <td><?php echo htmlspecialchars($response['pertanyaan3']); ?></td>
                    <td><?php echo htmlspecialchars($response['pertanyaan4']); ?></td>
                    <td><?php echo htmlspecialchars($response['pertanyaan5']); ?></td>
                    <td><?php echo htmlspecialchars($response['saran']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 