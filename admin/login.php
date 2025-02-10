<?php
session_start();

if (isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey Kepuasan | Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        :root {
            --primary: #001f3f;
            --secondary: #003366;
        }

        .login-page {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-page::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect fill="rgba(255,255,255,0.03)" x="0" y="0" width="100" height="100"/></svg>');
            transform: rotate(30deg);
            animation: backgroundMove 30s linear infinite;
        }

        @keyframes backgroundMove {
            0% { transform: rotate(30deg) translateY(0); }
            100% { transform: rotate(30deg) translateY(-50%); }
        }

        .login-box {
            width: 400px;
            position: relative;
            z-index: 1;
        }

        .login-logo {
            margin-bottom: 2rem;
        }

        .login-logo a {
            color: white !important;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .card-body {
            padding: 2.5rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            border: none;
            background: var(--primary);
            color: white;
            border-radius: 8px 0 0 8px;
            width: 45px;
            justify-content: center;
        }

        .form-control {
            border: 2px solid #e1e1e1;
            border-left: none;
            border-radius: 0 8px 8px 0;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, var(--secondary), var(--primary));
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .back-to-site {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .back-to-site:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../index.php">Survey Kepuasan</a>
        </div>
        <div class="card">
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="proses_login.php" method="post">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <a href="../index.php" class="back-to-site">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Survey</span>
    </a>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html> 