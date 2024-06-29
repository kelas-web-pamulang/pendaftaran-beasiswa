<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: ../login.php');
    exit();
}

// Redirect users based on role
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('clientId', '', time() - 3600, '/');
    setcookie('clientSecret', '', time() - 3600, '/');
    header('Location: ../login.php');
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    require_once '../config_db.php';
    $db = new ConfigDB();
    $conn = $db->connect();

    $delete_id = $_GET['delete'];
    $query = "UPDATE users SET deleted_at = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $current_datetime = date('Y-m-d H:i:s');
    $stmt->bind_param('si', $current_datetime, $delete_id);
    $stmt->execute();
    $stmt->close();
    $db->close();

    header('Location: users.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            font-family: 'Roboto', sans-serif; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .pendaftar-container {
            margin-top: 50px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #ffffff; 
        }
        h1 {
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
        }
        .btn-primary {
            background-color: #4b6cb7;
            border-color: #4b6cb7;
        }
        .btn-primary:hover {
            background-color: #182848;
            border-color: #182848; 
        }
        .btn-info {
            color: #ffffff;
            background-color: #0097D9;
            border-color: #0097D9;
        }
        .btn-info:hover {
            color: #ffffff;
            background-color: #004D6E;
            border-color: #004D6E;  
        }
        .btn-member {
            color: #ffffff;
            background-color: #918A00;
            border-color: #918A00;
        }
        .btn-member:hover {
            color: #ffffff;
            background-color: #474400;
            border-color: #474400;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #7D1E27;
            border-color: #7D1E27; 
        }
        .btn-link {
            color: #4b6cb7; 
        }
        .btn-link:hover {
            color: #182848; 
        }
        .pagination .page-link.page-label {
            color: #000000;
        }
        .pagination .page-item.active .page-link.page-label {
            color: #000000;
        }
        .pagination .page-link.page-label:hover {
            color: #000000;
            background-color: transparent;
        }
        .pagination .page-link {
            color: #000000;
            background-color: #ffffff; 
        }
        .pagination .page-link:hover {
            color: #ffffff; 
            background-color: #A1A1A1; 
        }
        .pagination .page-item.active .page-link {
            color: #ffffff;
            background-color: #4b6cb7; 
        }
        .alert {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pendaftar-container">
            <h1 class="text-center">Kelola Pengguna</h1>
            <div class="row mb-3">
                <div class="d-flex justify-content-between">
                    <form action="" method="get" class="d-flex align-items-center">
                        <input class="form-control me-2" placeholder="Cari Data" name="search"/>
                        <select name="search_by" class="form-select me-2">
                            <option value="">Pilih Berdasarkan</option>
                            <option value="full_name">Nama Lengkap</option>
                            <option value="email">Email</option>
                            <option value="role">Role</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                    <a href="index.php" class="ms-auto"><button class="btn btn-primary">Kembali</button></a>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tgl. Buat</th>
                    <th colspan="2">Pilihan</th>
                </tr>
                </thead>
                <tbody>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                ini_set('display_errors', '0');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once '../config_db.php';
                require '../vendor/autoload.php';

                \Sentry\init([
                    'dsn' => 'https://999693e7f94de0beef314eb509a4411b@o4507427977822208.ingest.us.sentry.io/4507427981230080',
                    'traces_sample_rate' => 1.0,
                    'profiles_sample_rate' => 1.0,
                ]);

                $db = new ConfigDB();
                $conn = $db->connect();

                if (isset($_POST['make_admin'])) {
                    $id = intval($_POST['user_id']);
                    $updateQuery = "UPDATE users SET role = 'admin' WHERE id = $id";
                    if ($conn->query($updateQuery) === TRUE) {
                        echo "<div class='alert alert-success'>Peran pengguna berhasil diubah menjadi admin</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
                    }
                }

                if (isset($_POST['make_member'])) {
                    $id = intval($_POST['user_id']);
                    $updateQuery = "UPDATE users SET role = 'member' WHERE id = $id";
                    if ($conn->query($updateQuery) === TRUE) {
                        echo "<div class='alert alert-success'>Peran pengguna berhasil diubah menjadi member</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
                    }
                }

                $conditional = [];
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $search_by = $_GET['search_by'];
                    if ($search_by == 'full_name') {
                        $conditional['AND full_name LIKE'] = "%$search%";
                    } else if ($search_by == 'email') {
                        $conditional['AND email LIKE'] = "%$search%";
                    } else if ($search_by == 'role') {
                        $conditional['AND role LIKE'] = "%$search%";
                    }
                }

                // Pagination logic
                $limit = 5; // Jumlah data default per halaman
                if (isset($_GET["limit"])) {
                    $limit = $_GET["limit"];
                }

                $page = isset($_GET["page"]) ? $_GET["page"] : 1; 
                $start_from = ($page - 1) * $limit;

                $current_user_email = $_SESSION['email'];

                $query = "SELECT id, email, full_name, role, created_at
                        FROM users
                        WHERE deleted_at IS NULL AND email <> '$current_user_email'";

                if (!empty($conditional)) {
                    foreach ($conditional as $key => $value) {
                        $query .= " $key '$value'";
                    }
                }

                $query .= " ORDER BY created_at DESC LIMIT $start_from, $limit";

                $result = $conn->query($query);
                $totalRows = $result->num_rows;

                if ($totalRows > 0) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1 + $start_from)."</td>";
                        echo "<td>".$row['full_name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['role']."</td>";
                        echo "<td>".$row['created_at']."</td>";

                        if ($row['role'] !== 'admin') {
                            echo "<td>
                                    <form method='POST' action='' onsubmit='return confirmMakeAdmin()'>
                                        <input type='hidden' name='user_id' value='$row[id]' />
                                        <button type='submit' name='make_admin' class='btn btn-sm btn-info'>Jadikan Admin</button>
                                    </form>
                                  </td>";
                        } else {
                            echo "<td>
                                    <form method='POST' action='' onsubmit='return confirmMakeMember()'>
                                        <input type='hidden' name='user_id' value='$row[id]' />
                                        <button type='submit' name='make_member' class='btn btn-sm btn-member'>Cabut Hak Admin</button>
                                    </form>
                                  </td>";
                        }

                        echo "<td><a class='btn btn-sm btn-danger delete-button' href='users.php?delete=$row[id]'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                }

                // Pagination
                $result_db = $conn->query("SELECT COUNT(id) FROM users WHERE deleted_at IS NULL");
                $row_db = $result_db->fetch_row(); 
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit);

                ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php 
                    $pagLink = "";
                    $pagLink .= '<li class="page-item"><span class="page-link ms-5 page-label">Halaman:</span></li>';

                    for ($i = 1; $i <= $total_pages; $i++) {
                        $activeClass = ($i == $page) ? 'active' : '';
                        $pagLink .= '<li class="page-item ' . $activeClass . '">';
                        $pagLink .= '<a class="page-link" href="users.php?page=' . $i . '&limit=' . $limit . '">' . $i . '</a>';
                        $pagLink .= '</li>';
                    }

                    echo $pagLink;
                    $db->close(); // Close connection after pagination
                    ?>
                </ul>
            </nav>

        </div>
    </div>
    
    <script>
        function confirmMakeAdmin() {
            return confirm('Apakah Anda yakin ingin menjadikan pengguna ini sebagai admin?');
        }

        function confirmMakeMember() {
            return confirm('Apakah Anda yakin ingin mencabut role pengguna ini sebagai admin?');
        }

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const confirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
                if (confirmed) {
                    window.location.href = this.href;
                }
            });
        });
    </script>
</body>
</html>
