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
</html>