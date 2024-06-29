<?php 
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/index.php');
    } else {
        header('Location: member/index.php');
    }
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            font-family: 'Roboto', sans-serif;
        }
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .register-card h1 {
            margin-bottom: 20px;
            font-weight: 500;
            color: #182848;
        }
        .form-group label {
            color: #4b6cb7;
        }
        .form-control {
            border-radius: 5px;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(75, 108, 183, 0.5);
            border-color: #4b6cb7;
        }
        .btn-primary {
            background-color: #4b6cb7;
            border-color: #4b6cb7;
        }
        .btn-primary:hover {
            background-color: #182848;
            border-color: #182848;
        }
        .btn-link {
            color: #4b6cb7;
        }
        .btn-link:hover {
            color: #182848;
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container register-container">
        <div class="register-card">
            <h1 class="text-center">Register</h1>
            <?php
                ini_set('display_errors', '0');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once 'config_db.php';
                require 'vendor/autoload.php';

                \Sentry\init([
                    'dsn' => 'https://999693e7f94de0beef314eb509a4411b@o4507427977822208.ingest.us.sentry.io/4507427981230080',
                    // Specify a fixed sample rate
                    'traces_sample_rate' => 1.0,
                    // Set a sampling rate for profiling - this is relative to traces_sample_rate
                    'profiles_sample_rate' => 1.0,
                  ]);

                $db = new ConfigDB();
                $conn = $db->connect();

                $message = '';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = htmlspecialchars($_POST['name']);
                    $email = htmlspecialchars($_POST['email']);
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $createAt = date('Y-m-d H:i:s');

                    // Check if email already exists
                    $checkQuery = "SELECT * FROM users WHERE email='$email'";
                    $result = $conn->query($checkQuery);

                    if ($result->num_rows > 0) {
                        $message = "<div class='alert alert-danger mt-3' role='alert'>Email sudah terdaftar</div>";
                    } else {
                        // Insert user with 'member' role
                        $query = "INSERT INTO users (email, full_name, password, role, created_at) VALUES ('$email', '$name', '$password', 'member', '$createAt')";
                        $queryExecute = $conn->query($query);

                        if ($queryExecute) {
                            $message = "<div class='alert alert-success mt-3' role='alert'>Berhasil mendaftar akun</div>";
                        } else {
                            $message = "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
                        }
                    }
                }

                echo $message;
            ?>
            <form action="" method="post" onsubmit="return validateForm()">
                <div class="form-group mb-3">
                    <label for="nameInput">Nama</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Masukkan nama" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="emailInput">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="emailInput" name="email" placeholder="Masukkan email" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="passwordInput">Password</label>
                    <div class="input-group">
                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Masukkan password" required maxlength="128">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mb-3 text-center">
                    <a href="login.php" class="btn btn-link">Sudah punya akun? Login sekarang</a>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    const togglePasswordButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    togglePasswordButton.addEventListener('click', togglePassword);

    function togglePassword() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('bi-eye-slash');
            togglePasswordIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('bi-eye');
            togglePasswordIcon.classList.add('bi-eye-slash');
        }
    }

    function validateForm() {
        // Ambil nilai input
        var password = document.getElementById('passwordInput').value;

        // Periksa panjang password (minimal 8 karakter)
        if (password.length < 8) {
            alert('Password harus terdiri dari minimal 8 karakter');
            return false;
        }

        // Periksa kekuatan password (misalnya: minimal satu huruf besar, satu huruf kecil, dan satu angka)
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (!regex.test(password)) {
            alert('Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka');
            return false;
        }

        // Jika lolos validasi, kembalikan true untuk mengirimkan data
        return true;
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>