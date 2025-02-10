<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil statistik untuk dashboard
$totalResponden = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM survey_responses")->fetch_assoc()['total'];
$avgRating = mysqli_query($koneksi, "SELECT AVG((pertanyaan1 + pertanyaan2 + pertanyaan3 + pertanyaan4 + pertanyaan5)/5) as avg FROM survey_responses")->fetch_assoc()['avg'];
$latestResponses = mysqli_query($koneksi, "SELECT * FROM survey_responses ORDER BY id DESC LIMIT 5");

// Data untuk grafik
$ratingData = mysqli_query($koneksi, "SELECT 
    AVG(pertanyaan1) as p1,
    AVG(pertanyaan2) as p2,
    AVG(pertanyaan3) as p3,
    AVG(pertanyaan4) as p4,
    AVG(pertanyaan5) as p5
    FROM survey_responses")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Kepuasan | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="dist/css/custom.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed accent-navy">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'templates/navbar.php'; ?>
        
        <!-- Sidebar -->
        <?php include 'templates/sidebar.php'; ?>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <!-- Baris pertama: 3 card -->
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-navy"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Responden</span>
                                    <span class="info-box-number"><?php echo number_format($totalResponden); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-navy"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rata-rata Rating</span>
                                    <span class="info-box-number"><?php echo number_format($avgRating, 1); ?> / 5.0</span>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Ambil pertanyaan pertama untuk baris pertama
                        $questions = mysqli_query($koneksi, "SELECT * FROM questions ORDER BY question_order LIMIT 1");
                        $question = mysqli_fetch_assoc($questions);
                        $questionKey = $question['question_key'];
                        $ratingKey = substr($questionKey, 1);
                        $icon = 'far fa-clock';
                        ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-navy"><i class="<?php echo $icon; ?>"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text" title="<?php echo htmlspecialchars($question['question_text']); ?>">
                                        <?php echo htmlspecialchars($question['question_text']); ?>
                                    </span>
                                    <span class="info-box-number"><?php echo number_format($ratingData['p'.$ratingKey], 1); ?></span>
                                    <div class="progress">
                                        <div class="progress-bar bg-navy" style="width: <?php echo ($ratingData['p'.$ratingKey]/5)*100; ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Per Aspek: Baris kedua dan ketiga -->
                    <div class="row">
                        <?php
                        // Ambil sisa pertanyaan (skip pertanyaan pertama)
                        $questions = mysqli_query($koneksi, "SELECT * FROM questions ORDER BY question_order LIMIT 1, 4");
                        while($question = mysqli_fetch_assoc($questions)) {
                            $questionKey = $question['question_key'];
                            $ratingKey = substr($questionKey, 1);
                            $icon = '';
                            
                            switch($questionKey) {
                                case 'p2': $icon = 'fas fa-smile'; break;
                                case 'p3': $icon = 'fas fa-tasks'; break;
                                case 'p4': $icon = 'fas fa-clipboard-list'; break;
                                case 'p5': $icon = 'fas fa-star'; break;
                            }
                        ?>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-navy"><i class="<?php echo $icon; ?>"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text" title="<?php echo htmlspecialchars($question['question_text']); ?>">
                                            <?php echo htmlspecialchars($question['question_text']); ?>
                                        </span>
                                        <span class="info-box-number"><?php echo number_format($ratingData['p'.$ratingKey], 1); ?></span>
                                        <div class="progress">
                                            <div class="progress-bar bg-navy" style="width: <?php echo ($ratingData['p'.$ratingKey]/5)*100; ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Grafik -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Grafik Rating Per Aspek</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="ratingChart" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Responses -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Response Terbaru</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Rata-rata Rating</th>
                                                <th>Saran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = mysqli_fetch_assoc($latestResponses)): ?>
                                                <?php 
                                                $avgResponseRating = ($row['pertanyaan1'] + $row['pertanyaan2'] + 
                                                                     $row['pertanyaan3'] + $row['pertanyaan4'] + 
                                                                     $row['pertanyaan5']) / 5;
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                    <td><?php echo number_format($avgResponseRating, 1); ?></td>
                                                    <td><?php echo htmlspecialchars($row['saran']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/adminlte.js"></script>

    <script>
        // Setup grafik
        var ctx = document.getElementById('ratingChart').getContext('2d');
        var gradientStroke = ctx.createLinearGradient(0, 0, 0, 400);
        gradientStroke.addColorStop(0, 'rgba(0, 31, 63, 0.8)');
        gradientStroke.addColorStop(1, 'rgba(0, 31, 63, 0.2)');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Waktu Pelayanan', 'Keramahan Petugas', 'Prosedur Pelayanan', 'Persyaratan', 'Kualitas Hasil'],
                datasets: [{
                    label: 'Rating Rata-rata',
                    data: [
                        <?php echo $ratingData['p1']; ?>,
                        <?php echo $ratingData['p2']; ?>,
                        <?php echo $ratingData['p3']; ?>,
                        <?php echo $ratingData['p4']; ?>,
                        <?php echo $ratingData['p5']; ?>
                    ],
                    backgroundColor: gradientStroke,
                    borderColor: '#001f3f',
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });
    </script>

    <!-- Tambahkan CSS untuk tooltip -->
    <style>
    .info-box-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: help;
    }
    </style>

    <!-- Tambahkan script untuk tooltip -->
    <script>
    $(function() {
        $('.info-box-text').tooltip({
            placement: 'top',
            container: 'body'
        });
    });
    </script>

    <!-- Tambahkan CSS untuk memperbaiki tampilan -->
    <style>
    .info-box {
        min-height: 100px;
        margin-bottom: 1rem;
    }

    .info-box-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: help;
        font-size: 0.9rem;
    }

    .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-box-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }

    .progress {
        height: 5px;
        margin-bottom: 0;
    }

    @media (min-width: 992px) {
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        
        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    /* Memperbaiki spacing di mobile */
    @media (max-width: 576px) {
        .info-box {
            margin-bottom: 0.5rem;
        }
    }
    </style>
</body>
</html> 