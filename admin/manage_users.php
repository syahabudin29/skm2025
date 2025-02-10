<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data admin users
$query = "SELECT * FROM admin_users ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Kepuasan | Manajemen Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
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
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">Manajemen Admin</h1>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <h3 class="card-title">Daftar Admin</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button type="button" class="btn btn-navy btn-sm" data-toggle="modal" data-target="#addAdminModal">
                                    <i class="fas fa-plus"></i> Tambah Admin
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="adminTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        while($row = mysqli_fetch_assoc($result)) { 
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm edit-user" 
                                                        data-id="<?php echo $row['id']; ?>"
                                                        data-username="<?php echo htmlspecialchars($row['username']); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-user"
                                                        data-id="<?php echo $row['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <?php include 'templates/footer.php'; ?>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-navy">
                    <h5 class="modal-title" id="addAdminModalLabel">Tambah Admin</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAdminForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-navy">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-navy">
                    <h5 class="modal-title">Edit Admin</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editUserForm">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $(function() {
            // Handle Add User
            $('#addAdminForm').on('submit', function(e) {
                e.preventDefault();
                
                // Validasi password match
                if($('#password').val() !== $('#confirm_password').val()) {
                    Swal.fire('Error!', 'Konfirmasi password tidak cocok!', 'error');
                    return;
                }

                $.ajax({
                    url: 'process_user.php',
                    type: 'POST',
                    data: {
                        action: 'add',
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    success: function(response) {
                        if(response.success) {
                            $('#addAdminModal').modal('hide');
                            Swal.fire('Berhasil!', 'Admin baru berhasil ditambahkan', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            });

            // Handle Edit User
            $('.edit-user').click(function() {
                var id = $(this).data('id');
                var username = $(this).data('username');
                $('#editUserForm input[name="id"]').val(id);
                $('#editUserForm input[name="username"]').val(username);
                $('#editUserModal').modal('show');
            });

            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'process_user.php',
                    type: 'POST',
                    data: $(this).serialize() + '&action=edit',
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Berhasil!', 'Data admin berhasil diupdate', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    }
                });
            });

            // Handle Delete User
            $('.delete-user').click(function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data admin akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'process_user.php',
                            type: 'POST',
                            data: {
                                action: 'delete',
                                id: id
                            },
                            success: function(response) {
                                if(response.success) {
                                    Swal.fire('Berhasil!', 'Data admin berhasil dihapus', 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

    <!-- CSS untuk styling -->
    <style>
    .btn-sm {
        padding: 0.4rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-navy {
        background-color: #001f3f;
        border-color: #001f3f;
        color: white;
    }

    .btn-navy:hover {
        background-color: #003366;
        border-color: #003366;
        color: white;
    }

    .btn-navy:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 31, 63, 0.25);
    }

    .btn-sm i {
        font-size: 0.875rem;
    }

    /* Memperbaiki spacing */
    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Responsif untuk mobile */
    @media (max-width: 576px) {
        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }

    .modal-header.bg-navy {
        color: white;
    }

    .modal-header .close {
        opacity: 1;
    }

    .modal-content {
        border-radius: 0.3rem;
    }

    .form-group label {
        font-weight: 600;
    }
    </style>
</body>
</html> 