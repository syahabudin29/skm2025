<?php 
require_once 'config.php';
require_once 'admin/config.php';

// Ambil pengaturan
$settings = [];
$result = mysqli_query($koneksi, "SELECT * FROM settings");
while($row = mysqli_fetch_assoc($result)) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Ambil pertanyaan
$questions = [];
$result = mysqli_query($koneksi, "SELECT * FROM questions ORDER BY question_order");
while($row = mysqli_fetch_assoc($result)) {
    $questions[$row['question_key']] = $row['question_text'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO survey_responses (nama, email, jenis_kelamin, pertanyaan1, pertanyaan2, pertanyaan3, pertanyaan4, pertanyaan5, saran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['nama'],
            $_POST['email'],
            $_POST['jenis_kelamin'],
            $_POST['pertanyaan1'],
            $_POST['pertanyaan2'],
            $_POST['pertanyaan3'],
            $_POST['pertanyaan4'],
            $_POST['pertanyaan5'],
            $_POST['saran']
        ]);
        
        $success = "Terima kasih! Survey Anda telah berhasil disimpan.";
    } catch(PDOException $e) {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Kepuasan - MAN Bulungan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <h1><?php echo htmlspecialchars($settings['app_name']); ?></h1>
            <h2><?php echo htmlspecialchars($settings['institution_name']); ?></h2>
            <p class="institution-address"><?php echo htmlspecialchars($settings['institution_address']); ?></p>
        </div>

        <?php if (isset($success)): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="form-content">
            <form method="POST" action="">
            <div class="question-card">
                <h3><i class="fas fa-user"></i> Data Responden</h3>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap Anda">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Masukkan alamat email Anda">
                </div>

                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <input type="radio" id="laki" name="jenis_kelamin" value="Laki-laki" required>
                        <label for="laki"><i class="fas fa-male"></i> Laki-laki</label>
                        <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan">
                        <label for="perempuan"><i class="fas fa-female"></i> Perempuan</label>
                    </div>
                </div>
            </div>

            <div class="question-card">
                <h3><i class="fas fa-star"></i> Penilaian</h3>
                <p class="scale-legend">
                    <span>1 = Sangat Tidak Puas</span>
                    <span>5 = Sangat Puas</span>
                </p>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($questions['p1']); ?></label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="rating-item">
                                <input type="radio" id="q1_<?php echo $i; ?>" name="pertanyaan1" value="<?php echo $i; ?>" required>
                                <label for="q1_<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($questions['p2']); ?></label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="rating-item">
                                <input type="radio" id="q2_<?php echo $i; ?>" name="pertanyaan2" value="<?php echo $i; ?>" required>
                                <label for="q2_<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($questions['p3']); ?></label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="rating-item">
                                <input type="radio" id="q3_<?php echo $i; ?>" name="pertanyaan3" value="<?php echo $i; ?>" required>
                                <label for="q3_<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($questions['p4']); ?></label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="rating-item">
                                <input type="radio" id="q4_<?php echo $i; ?>" name="pertanyaan4" value="<?php echo $i; ?>" required>
                                <label for="q4_<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo htmlspecialchars($questions['p5']); ?></label>
                    <div class="rating-container">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <div class="rating-item">
                                <input type="radio" id="q5_<?php echo $i; ?>" name="pertanyaan5" value="<?php echo $i; ?>" required>
                                <label for="q5_<?php echo $i; ?>"><?php echo $i; ?></label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="saran">Saran dan Masukan</label>
                    <textarea id="saran" name="saran" rows="4" placeholder="Berikan saran dan masukan Anda untuk peningkatan kualitas sekolah"></textarea>
                </div>
            </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Survey
                </button>
            </form>

            <footer>
                <a href="admin/login.php" class="admin-btn">
                    <i class="fas fa-lock"></i>
                    <span>Admin Login</span>
                </a>
            </footer>
        </div>
    </div>
</body>
</html>
