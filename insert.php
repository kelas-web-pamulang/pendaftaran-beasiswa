<<<<<<< HEAD
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            font-family: 'Roboto', sans-serif;
        }
        .registration-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .registration-card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .registration-card h1 {
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
        .btn-success {
            background-color: #3FA320;
            border-color: #3FA320;
        }
        .btn-success:hover {
            background-color: #225711;
            border-color: #225711;
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
    <?php
        session_start();

        if (!isset($_SESSION['login'])) {
            header('Location: login.php');
            exit();
        }

        //Handle logout
        if (isset($_GET['logout'])) {
            session_destroy();
            setcookie('clientId', '', time() - 3600, '/');
            setcookie('clientSecret', '', time() - 3600, '/');
            header('Location: login.php');
            exit();
        }
    
        date_default_timezone_set('Asia/Jakarta');
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();

        $message = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_beasiswa = htmlspecialchars($_POST['nama_beasiswa']);
            $id_program_studi = htmlspecialchars($_POST['id_program_studi']);
            $id_kategori = htmlspecialchars($_POST['id_kategori']);
            $kuota = htmlspecialchars($_POST['kuota']);
            $tanggal_tambah_data = date('Y-m-d H:i:s');

            $query = "INSERT INTO beasiswa (nama_beasiswa, id_program_studi, id_kategori, kuota, tanggal_tambah_data) 
                      VALUES ('$nama_beasiswa', '$id_program_studi', '$id_kategori', '$kuota', '$tanggal_tambah_data')";

            if ($conn->query($query) === TRUE) {
                $message = "<div class='alert alert-success mt-3' role='alert'>Pendaftaran berhasil</div>";
            } else {
                $message = "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
            }
        }
    ?>
    <div class="container registration-container">
        <div class="registration-card">
            <h1 class="text-center">Pendaftaran Beasiswa</h1>
            <?php echo $message; ?>
            <form action="" method="post">
                <div class="form-group mb-3">
                    <label for="namaBeasiswa">Nama Beasiswa</label>
                    <input type="text" class="form-control" id="namaBeasiswa" name="nama_beasiswa" placeholder="Masukkan Nama Beasiswa" required>
                </div>
                <div class="form-group mb-3">
                    <label for="programStudi">Program Studi</label>
                    <?php
                        $programStudi = $conn->query("SELECT id_program_studi, nama_program_studi FROM program_studi");
                        echo "<select class='form-control form-select' id='programStudi' name='id_program_studi' required>";
                        echo "<option value=''>Pilih Program Studi</option>";
                        while ($row = $programStudi->fetch_assoc()) {
                            $selected = ($beasiswa['id_program_studi'] == $row['id_program_studi']) ? 'selected' : '';
                            echo "<option value='{$row['id_program_studi']}' $selected>{$row['nama_program_studi']}</option>";
                        }
                        echo "</select>";
                    ?>
                </div>
                <div class="form-group mb-3">
                    <label for="pilihanKategori">Kategori</label>
                    <?php
                        $pilihanKategori = $conn->query("SELECT id_kategori, nama_kategori FROM kategori");
                        echo "<select class='form-control form-select' id='pilihanKategori' name='id_kategori' required>";
                        echo "<option value=''>Pilih Kategori</option>";
                        while ($row = $pilihanKategori->fetch_assoc()) {
                            $selected = ($beasiswa['id_kategori'] == $row['id_kategori']) ? 'selected' : '';
                            echo "<option value='{$row['id_kategori']}' $selected>{$row['nama_kategori']}</option>";
                        }
                        echo "</select>";
                    ?>
                </div>
                <div class="form-group mb-3">
                    <label for="inpt_kuota">Kuota</label>
                    <input type="number" step="0.01" class="form-control" id="inpt_kuota" name="kuota" placeholder="Masukkan Kuota" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">Submit</button>
                    <a href="index.php" class="btn btn-primary flex-grow-1">Kembali</a>
                </div>
            </form>
            <?php
                $conn->close();
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
=======
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pendaftaran Beasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        date_default_timezone_set('Asia/Jakarta');
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Pendaftaran Beasiswa</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="namaMahasiswa">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="namaMahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
                <label for="nimMahasiswa">NIM</label>
                <input type="text" class="form-control" id="nimMahasiswa" name="nim_mahasiswa" placeholder="Masukkan NIM" required>
            </div>
            <div class="form-group">
                <label for="emailMahasiswa">Email</label>
                <input type="email" class="form-control" id="emailMahasiswa" name="email_mahasiswa" placeholder="Masukkan Email" required>
            </div>
            <div class="form-group">
                <label for="alamatMahasiswa">Alamat</label>
                <textarea class="form-control" id="alamatMahasiswa" name="alamat_mahasiswa" placeholder="Masukkan Alamat" required></textarea>
            </div>
            <div class="form-group">
                <label for="noHpMahasiswa">No. HP</label>
                <input type="text" class="form-control" id="noHpMahasiswa" name="no_hp_mahasiswa" placeholder="Masukkan No. HP" required>
            </div>
            <div class="form-group">
                <label for="programStudi">Program Studi</label>
                <?php
                    $programStudi = $conn->query("SELECT id_program_studi, nama_program_studi FROM program_studi");
                    echo "<select class='form-control' id='programStudi' name='id_program_studi' required>";
                    echo "<option value=''>Pilih Program Studi</option>";
                    while ($row = $programStudi->fetch_assoc()) {
                        echo "<option value='{$row['id_program_studi']}'>{$row['nama_program_studi']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <div class="form-group">
                <label for="semester_mahasiswa">Semester Saat ini</label>
                <select class="form-control" id="semester_mahasiswa" name="semester_mahasiswa" required>
                    <option value="" >Pilih Semester</option>
                    <option value="Semester 1">Semester 1</option>
                    <option value="Semester 2">Semester 2</option>
                    <option value="Semester 3">Semester 3</option>
                    <option value="Semester 4">Semester 4</option>
                    <option value="Semester 5">Semester 5</option>
                    <option value="Semester 6">Semester 6</option>
                    <option value="Semester 7">Semester 7</option>
                    <option value="Semester 8">Semester 8</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ipkTerakhir">IPK Terakhir</label>
                <input type="number" step="0.01" class="form-control" id="ipkTerakhir" name="ipk_terakhir_mahasiswa" placeholder="Masukkan IPK Terakhir" required>
            </div>
            <div class="form-group">
                <label for="pilihanBeasiswa">Pilihan Beasiswa</label>
                <?php
                    $pilihanBeasiswa = $conn->query("SELECT id_pilihan_beasiswa, nama_beasiswa FROM pilihan_beasiswa");
                    echo "<select class='form-control' id='pilihanBeasiswa' name='id_pilihan_beasiswa' required>";
                    echo "<option value=''>Pilih Beasiswa</option>";
                    while ($row = $pilihanBeasiswa->fetch_assoc()) {
                        echo "<option value='{$row['id_pilihan_beasiswa']}'>{$row['nama_beasiswa']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-success">Kembali</a>
        </form>

        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nama = $_POST['nama_mahasiswa'];
                $nim = $_POST['nim_mahasiswa'];
                $email = $_POST['email_mahasiswa'];
                $alamat = $_POST['alamat_mahasiswa'];
                $no_hp = $_POST['no_hp_mahasiswa'];
                $id_program_studi = $_POST['id_program_studi'];
                $semester = $_POST['semester_mahasiswa'];
                $ipk = $_POST['ipk_terakhir_mahasiswa'];
                $id_pilihan_beasiswa = $_POST['id_pilihan_beasiswa'];
                $tanggal_tambah_data = date('Y-m-d H:i:s');

                $query = "INSERT INTO pendaftar (nama_mahasiswa, nim_mahasiswa, email_mahasiswa, alamat_mahasiswa, no_hp_mahasiswa, id_program_studi, semester_mahasiswa, ipk_terakhir_mahasiswa, id_pilihan_beasiswa, tanggal_tambah_data) 
                         VALUES ('$nama', '$nim', '$email', '$alamat', '$no_hp', '$id_program_studi', '$semester', '$ipk', '$id_pilihan_beasiswa', '$tanggal_tambah_data')";

                if ($conn->query($query) === TRUE) {
                    echo "<div class='alert alert-success mt-3' role='alert'>Pendaftaran berhasil</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $query . "<br>" . $conn->error . "</div>";
                }
            }
            $conn->close();
        ?>
    </div>
</body>
>>>>>>> 373e2754106ab890165fdf1baf3cb5f0a70aa80b
</html>