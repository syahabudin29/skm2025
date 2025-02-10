<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data survey
$query = "SELECT * FROM survey_responses ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Kepuasan | Data Survey</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Data Survey</h1>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Data Survey Kepuasan</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="surveyTable" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px;">
                                                <input type="checkbox" id="checkAll">
                                            </th>
                                            <th style="min-width: 50px">No</th>
                                            <th style="min-width: 150px">Nama</th>
                                            <th style="min-width: 150px">Email</th>
                                            <th style="min-width: 120px">Jenis Kelamin</th>
                                            <th style="min-width: 150px">Waktu Pelayanan</th>
                                            <th style="min-width: 150px">Keramahan Petugas</th>
                                            <th style="min-width: 150px">Prosedur Pelayanan</th>
                                            <th style="min-width: 150px">Persyaratan</th>
                                            <th style="min-width: 150px">Kualitas Hasil</th>
                                            <th style="min-width: 200px">Saran</th>
                                            <th style="min-width: 150px">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        while($row = mysqli_fetch_assoc($result)) { 
                                            // Hitung rata-rata rating
                                            $avgRating = ($row['pertanyaan1'] + $row['pertanyaan2'] + 
                                                         $row['pertanyaan3'] + $row['pertanyaan4'] + 
                                                         $row['pertanyaan5']) / 5;
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="checkItem" value="<?php echo $row['id']; ?>">
                                            </td>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                            <td data-toggle="tooltip" title="Kesesuaian waktu pelayanan dengan jadwal">
                                                <?php echo $row['pertanyaan1']; ?>
                                            </td>
                                            <td data-toggle="tooltip" title="Keramahan dan kesopanan petugas">
                                                <?php echo $row['pertanyaan2']; ?>
                                            </td>
                                            <td data-toggle="tooltip" title="Kemudahan prosedur pelayanan">
                                                <?php echo $row['pertanyaan3']; ?>
                                            </td>
                                            <td data-toggle="tooltip" title="Kesesuaian persyaratan pelayanan">
                                                <?php echo $row['pertanyaan4']; ?>
                                            </td>
                                            <td data-toggle="tooltip" title="Kualitas hasil pelayanan">
                                                <?php echo $row['pertanyaan5']; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['saran']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <!-- Tombol hapus di bawah tombol export -->
                                <div class="mt-2">
                                    <button id="deleteSelected" class="btn btn-danger btn-sm" style="display: none;">
                                        <i class="fas fa-trash"></i> Hapus Data Terpilih
                                    </button>
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
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(function () {
            var table = $('#surveyTable').DataTable({
                "scrollX": true,
                "scrollCollapse": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "dom": 'Bfrtip',
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Export Excel',
                        className: 'btn btn-navy btn-sm',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> Export PDF',
                        className: 'btn btn-navy btn-sm',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-navy btn-sm',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    }
                ],
                "order": [[10, "desc"]] // Mengurutkan berdasarkan kolom tanggal (index 10) secara descending
            });

            // Aktifkan tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Tambahkan event listener untuk reset posisi scroll horizontal saat pindah halaman
            table.on('page.dt', function() {
                $('html, body').animate({
                    scrollTop: $(".dataTables_wrapper").offset().top
                }, 'fast');
            });

            // Handle checkbox "Check All"
            $('#checkAll').change(function() {
                $('.checkItem').prop('checked', this.checked);
                toggleDeleteButton();
            });

            // Handle checkbox individual
            $(document).on('change', '.checkItem', function() {
                toggleDeleteButton();
                
                // Update "Check All" status
                var totalCheckboxes = $('.checkItem').length;
                var checkedCheckboxes = $('.checkItem:checked').length;
                $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            // Toggle tombol delete
            function toggleDeleteButton() {
                var checkedCount = $('.checkItem:checked').length;
                if(checkedCount > 0) {
                    $('#deleteSelected').show();
                } else {
                    $('#deleteSelected').hide();
                }
            }

            // Handle tombol delete
            $('#deleteSelected').click(function() {
                var selectedIds = [];
                $('.checkItem:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if(selectedIds.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dipilih akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'process_delete_survey.php',
                                type: 'POST',
                                data: JSON.stringify({ ids: selectedIds }),
                                contentType: 'application/json',
                                dataType: 'json',
                                success: function(response) {
                                    if(response.success) {
                                        Swal.fire({
                                            title: 'Terhapus!',
                                            text: 'Data berhasil dihapus.',
                                            icon: 'success'
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            response.message || 'Gagal menghapus data.',
                                            'error'
                                        );
                                    }
                                },
                                error: function() {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menghapus data.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <!-- Tambahkan CSS custom untuk mengatur tampilan scroll -->
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .dataTables_wrapper .dataTables_scroll {
            margin-bottom: 1rem;
        }

        .table th, .table td {
            white-space: nowrap;
            vertical-align: middle !important;
        }

        /* Memperbaiki tampilan button group di atas tabel */
        .dt-buttons {
            margin-bottom: 1rem;
            position: sticky;
            left: 0;
            z-index: 1;
        }

        /* Memperbaiki tampilan search box */
        .dataTables_filter {
            margin-bottom: 1rem;
            position: sticky;
            right: 0;
            z-index: 1;
        }

        .checkItem, #checkAll {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        #deleteSelected {
            transition: all 0.3s ease;
            height: 31px;
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            margin-top: 10px;
        }

        #deleteSelected i {
            margin-right: 5px;
        }

        /* Memperbaiki margin tombol DataTables */
        .dt-buttons .btn {
            margin-left: 0;
        }

        /* Memperbaiki tampilan di mobile */
        @media (max-width: 576px) {
            .dt-buttons .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            #deleteSelected {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</body>
</html> 