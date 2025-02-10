<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data settings
$settings = mysqli_query($koneksi, "SELECT * FROM settings ORDER BY id");
$questions = mysqli_query($koneksi, "SELECT * FROM questions ORDER BY question_order");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Kepuasan | Pengaturan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="dist/css/custom.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed accent-navy">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'templates/navbar.php'; ?>
        
        <!-- Sidebar -->
        <?php include 'templates/sidebar.php'; ?>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Pengaturan</h1>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Informasi Aplikasi -->
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Informasi Aplikasi</h3>
                        </div>
                        <div class="card-body">
                            <form id="settingsForm">
                                <?php while($setting = mysqli_fetch_assoc($settings)): ?>
                                <div class="form-group">
                                    <label><?php echo htmlspecialchars($setting['setting_description']); ?></label>
                                    <input type="text" class="form-control" name="settings[<?php echo $setting['setting_key']; ?>]" 
                                           value="<?php echo htmlspecialchars($setting['setting_value']); ?>" required>
                                </div>
                                <?php endwhile; ?>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>

                    <!-- Pertanyaan Survey -->
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Pertanyaan Survey</h3>
                        </div>
                        <div class="card-body">
                            <form id="questionsForm">
                                <?php while($question = mysqli_fetch_assoc($questions)): ?>
                                <div class="form-group">
                                    <label>Pertanyaan <?php echo $question['question_order']; ?></label>
                                    <input type="text" class="form-control" name="questions[<?php echo $question['question_key']; ?>]" 
                                           value="<?php echo htmlspecialchars($question['question_text']); ?>" required>
                                </div>
                                <?php endwhile; ?>
                                <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include 'templates/footer.php'; ?>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $(function() {
            // Handle Settings Form
            $('#settingsForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_settings.php',
                    type: 'POST',
                    data: $(this).serialize() + '&action=update_settings',
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Berhasil!', 'Pengaturan berhasil disimpan', 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            });

            // Handle Questions Form
            $('#questionsForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_settings.php',
                    type: 'POST',
                    data: $(this).serialize() + '&action=update_questions',
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Berhasil!', 'Pertanyaan berhasil disimpan', 'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html> 