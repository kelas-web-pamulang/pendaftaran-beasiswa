<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            font-family: 'Roboto', sans-serif;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .login-card h1 {
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
    <div class="container login-container">
        <div class="login-card">
            <h1 class="text-center">Login</h1>
            <?php
                ini_set('display_errors', '0');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                session_start();
                if (isset($_SESSION['login'])) {
                    if ($_SESSION['role'] === 'admin') {
                        header('Location: admin/index.php');
                    } else {
                        header('Location: member/index.php');
                    }
                    exit();
                }

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
                    $email = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = "SELECT id, email, full_name, password, role FROM users WHERE email = '$email'";
                    $queryExecute = $conn->query($query);

                    if ($queryExecute->num_rows > 0) {
                        $user = $queryExecute->fetch_assoc();
                        $isPasswordMatch = password_verify($password, $user['password']);
                        if ($isPasswordMatch) {
                            $_SESSION['login'] = true;
                            $_SESSION['userId'] = $user['id'];
                            $_SESSION['userName'] = $user['full_name'];
                            $_SESSION['role'] = $user['role'];

                            setcookie('clientId', $user['id'], time() + 86400, '/');
                            setcookie('clientSecret', hash('sha256', $user['email']), time() + 86400, '/');

                            if ($user['role'] == 'admin') {
                                header('Location: admin/index.php');
                            } else {
                                header('Location: member/index.php');
                            }
                        } else {
                            $message = "<div class='alert alert-danger' role='alert'>Email/Password salah</div>";
                        }
                    } else {
                        $message = "<div class='alert alert-danger' role='alert'>Email/Password salah</div>";
                    }
                }

                echo $message;
            ?>
            <form action="" method="post">
                <div class="form-group mb-3">
                    <label for="emailInput">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="emailInput" name="email" placeholder="Masukkan email" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="passwordInput">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Masukkan password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mb-3 text-center">
                    <a href="register.php" class="btn btn-link">Belum punya akun? Register sekarang</a>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>