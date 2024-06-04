<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftar Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        footer {
            background-color: #FFBF7A;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Pendaftar Beasiswa</h1>
        <div class="row">
            <div class="d-flex justify-content-between">
                <form action="" method="get" class="d-flex align-items-center">
                    <input class="form-control" placeholder="Cari Data" name="search"/>
                    <select name="search_by" class="form-select">
                        <option value="">Pilih Berdasarkan</option>
                        <option value="nama_mahasiswa">Nama</option>
                        <option value="nim_mahasiswa">NIM</option>
                    </select>
                    <button type="submit" class="btn btn-success mx-2">Cari</button>
                </form>
                <a href="insert.php" class="ml-auto mb-2"><button class="btn btn-success">Tambah Data</button></a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Program Studi</th>
                    <th>Semester</th>
                    <th>IPK</th>
                    <th>Beasiswa</th>
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
                    if ($search_by == 'nama_mahasiswa') {
                        $conditional['AND nama_mahasiswa LIKE'] = "%$search%";
                    } else if ($search_by == 'nim_mahasiswa') {
                        $conditional['AND nim_mahasiswa LIKE'] = "%$search%";
                    }
                } else if (isset($_GET['delete'])) {
                    $query = $db->update('pendaftar', [
                        'tanggal_hapus_data' => date('Y-m-d H:i:s')
                    ], $_GET['delete']);
                }

                $query = "SELECT m.id_pendaftar, m.nama_mahasiswa, m.nim_mahasiswa, m.email_mahasiswa, m.alamat_mahasiswa, 
                                 m.no_hp_mahasiswa, ps.nama_program_studi, m.semester_mahasiswa, m.ipk_terakhir_mahasiswa, 
                                 pb.nama_beasiswa, m.tanggal_tambah_data 
                          FROM pendaftar m 
                          LEFT JOIN program_studi ps ON m.id_program_studi = ps.id_program_studi 
                          LEFT JOIN pilihan_beasiswa pb ON m.id_pilihan_beasiswa = pb.id_pilihan_beasiswa
                          WHERE m.tanggal_hapus_data IS NULL";

                if (!empty($conditional)) {
                    foreach ($conditional as $key => $value) {
                        $query .= " $key '$value'";
                    }
                }

                $result = $conn->query($query);
                $totalRows = $result->num_rows;

                if ($totalRows > 0) {
                    foreach ($result as $key => $row) {
                        echo "<tr>";
                        echo "<td>".($key + 1)."</td>";
                        echo "<td>".$row['nama_mahasiswa']."</td>";
                        echo "<td>".$row['nim_mahasiswa']."</td>";
                        echo "<td>".$row['email_mahasiswa']."</td>";
                        echo "<td>".$row['alamat_mahasiswa']."</td>";
                        echo "<td>".$row['no_hp_mahasiswa']."</td>";
                        echo "<td>".$row['nama_program_studi']."</td>";
                        echo "<td>".$row['semester_mahasiswa']."</td>";
                        echo "<td>".$row['ipk_terakhir_mahasiswa']."</td>";
                        echo "<td>".$row['nama_beasiswa']."</td>";
                        echo "<td>".$row['tanggal_tambah_data']."</td>";
                        echo "<td><a class='btn btn-sm btn-info' href='update.php?id=$row[id_pendaftar]'>Update</a></td>";
                        echo "<td><a class='btn btn-sm btn-danger delete-button' href='index.php?delete=$row[id_pendaftar]'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' class='text-center'>Tidak ada data</td></tr>";
                }

                $db->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="text-center mt-5">Tugas Project Praktisi Mengajar | Dibuat oleh Danny Bungai & Mohammad Fauzie Apriansyah</footer>
    
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
    </script>
</body>
</html>