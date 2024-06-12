<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('clientId', '', time() - 3600, '/');
    setcookie('clientSecret', '', time() - 3600, '/');
    header('Location: login.php');
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    require_once 'config_db.php';
    $db = new ConfigDB();
    $conn = $db->connect();

    $delete_id = $_GET['delete'];
    $query = "UPDATE beasiswa SET tanggal_hapus_data = ? WHERE id_beasiswa = ?";
    $stmt = $conn->prepare($query);
    $current_datetime = date('Y-m-d H:i:s');
    $stmt->bind_param('si', $current_datetime, $delete_id);
    $stmt->execute();
    $stmt->close();
    $db->close();

    header('Location: index.php');
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
    <title>Pendaftar Beasiswa</title>
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
        .judul-container {
            background-color: rgba(236, 240, 241, 0.9); 
            color: #ffffff; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            display: flex;
            justify-content: center; /* Memusatkan secara horizontal */
            align-items: center; /* Memusatkan secara vertikal */
        }

        .pendaftar-container {
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
        footer {
            background-color: #4b6cb7;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            position: relative;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="judul-container">
            <h1 class="text-center">Pendaftar Beasiswa</h1>
            <a id="logout-button" href="?logout=true" class="btn btn-danger">Logout</a>
        </div>

        <div class="pendaftar-container">
            <div class="row mb-3">
                <div class="d-flex justify-content-between">
                    <form action="" method="get" class="d-flex align-items-center">
                        <input class="form-control me-2" placeholder="Cari Data" name="search"/>
                        <select name="search_by" class="form-select me-2">
                            <option value="">Pilih Berdasarkan</option>
                            <option value="nama_beasiswa">Nama Beasiswa</option>
                            <option value="program_studi">Program Studi</option>
                            <option value="kategori">Kategori</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                    <a href="insert.php" class="ms-auto"><button class="btn btn-primary">Tambah Data</button></a>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Beasiswa</th>
                    <th>Program Studi</th>
                    <th>Kategori</th>
                    <th>Kuota</th>
                    <th>Tgl. Buat</th>
                    <th colspan="2">Pilihan</th>
                </tr>
                </thead>
                <tbody>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                ini_set('display_errors', '1');
                ini_set('display_startup_errors', '1');
                error_reporting(E_ALL);

                require_once 'config_db.php';

                $db = new ConfigDB();
                $conn = $db->connect();

                $conditional = [];
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $search_by = $_GET['search_by'];
                    if ($search_by == 'nama_beasiswa') {
                        $conditional['AND nama_beasiswa LIKE'] = "%$search%";
                    } else if ($search_by == 'program_studi') {
                        $conditional['AND ps.nama_program_studi LIKE'] = "%$search%";
                    } else if ($search_by == 'kategori') {
                        $conditional['AND k.nama_kategori LIKE'] = "%$search%";
                    } else if (isset($_GET['delete'])) {
                        $query = $db->update('beasiswa',[
                            'tanggal_hapus_data' => date('Y-m-d H:i:s')
                        ], $_GET['delete']);
                    }
                }

                // Pagination logic
                $limit = 5; // Jumlah data yang muncul perhalaman
                if (isset($_GET["page"])) {
                    $page  = $_GET["page"]; 
                } else { 
                    $page = 1; 
                }
                $start_from = ($page-1) * $limit;

                $query = "SELECT b.id_beasiswa, b.nama_beasiswa, ps.nama_program_studi, k.nama_kategori, b.kuota,
                                 b.tanggal_tambah_data 
                          FROM beasiswa b 
                          LEFT JOIN program_studi ps ON b.id_program_studi = ps.id_program_studi 
                          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                          WHERE b.tanggal_hapus_data IS NULL";

                if (!empty($conditional)) {
                    foreach ($conditional as $key => $value) {
                        $query .= " $key '$value'";
                    }
                }

                $query .= " LIMIT $start_from, $limit";

                $result = $conn->query($query);
                $totalRows = $result->num_rows;

                if ($totalRows > 0) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1 + $start_from)."</td>";
                        echo "<td>".$row['nama_beasiswa']."</td>";
                        echo "<td>".$row['nama_program_studi']."</td>";
                        echo "<td>".$row['nama_kategori']."</td>";
                        echo "<td>".$row['kuota']."</td>";
                        echo "<td>".$row['tanggal_tambah_data']."</td>";
                        echo "<td><a class='btn btn-sm btn-info' href='update.php?id=$row[id_beasiswa]'>Update</a></td>";
                        echo "<td><a class='btn btn-sm btn-danger delete-button' href='index.php?delete=$row[id_beasiswa]'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";
                }

                // Pagination
                $result_db = $conn->query("SELECT COUNT(id_beasiswa) FROM beasiswa WHERE tanggal_hapus_data IS NULL");
                $row_db = $result_db->fetch_row(); 
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit);

                // Move $db->close() to after echoing pagination
                ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php 
                    $pagLink = "";

                    for ($i=1; $i<=$total_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<li class='page-item active'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";
                        } else {
                            $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";
                        }
                    }
                    echo $pagLink;
                    $db->close(); // Close connection after pagination
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <footer class="mt-5">
        Tugas Project Praktisi Mengajar | Dibuat oleh Danny Bungai & Mohammad Fauzie Apriansyah
    </footer>
    
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const confirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
                if (confirmed) {
                    window.location.href = this.href;
                }
            });
        });

        document.getElementById('logout-button').addEventListener('click', function(event) {
            event.preventDefault();
            const confirmed = confirm('Apakah Anda yakin ingin logout?');
            if (confirmed) {
                window.location.href = this.href;
            }
        });
    </script>
</body>
</html>
