<?php
// login.php
session_start();

// Jika user sudah login sebelumnya, langsung alihkan ke dashboard masing-masing
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard-admin.php");
        exit();
    } else if ($_SESSION['role'] === 'anggota') {
        header("Location: anggota/dashboard-anggota.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="overlay"></div>

    <div class="container-fluid vh-100">
        <div class="row h-100">

            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-content">
                    <i class="fa-solid fa-book-open-reader hero-icon"></i>
                    <h1>
                        Sistem Manajemen
                        <span>Perpustakaan</span>
                    </h1>
                    <p>
                        Kelola buku, anggota, peminjaman, dan pengembalian
                        secara lebih mudah, cepat, dan terorganisir.
                    </p>
                </div>
            </div>

            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                <div class="login-card">

                    <div class="text-center mb-4">
                        <div class="logo-circle">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h2>Selamat Datang</h2>
                        <p>Silakan login untuk masuk ke sistem</p>
                    </div>

                    <?php if (isset($_GET['status']) && $_GET['status'] === 'failed'): ?>
                        <div id="loginError" class="alert alert-danger">
                            <i class="fa-solid fa-circle-exclamation"></i> Username atau password salah.
                        </div>
                    <?php endif; ?>

                    <form action="login_proses.php" method="POST" id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                <button type="button" class="input-group-text password-toggle" onclick="togglePassword()">
                                    <i id="eyeIcon" class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn login-btn w-100">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </button>
                    </form>

                    <div class="demo-account mt-4">
                        <h6>Akun Demo (Database MySQL)</h6>
                        <small>Admin : admin / admin123</small>
                        <br>
                        <small>Anggota : anggota / anggota123</small>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>
