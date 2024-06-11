<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Data Beasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
        date_default_timezone_set('Asia/Jakarta');
        require_once 'config_db.php';

        $db = new ConfigDB();
        $conn = $db->connect();

        $id_pendaftar = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_mahasiswa = $_POST['nama_mahasiswa'];
            $nim_mahasiswa = $_POST['nim_mahasiswa'];
            $email_mahasiswa = $_POST['email_mahasiswa'];
            $alamat_mahasiswa = $_POST['alamat_mahasiswa'];
            $no_hp_mahasiswa = $_POST['no_hp_mahasiswa'];
            $id_program_studi = $_POST['id_program_studi'];
            $semester_mahasiswa = $_POST['semester_mahasiswa'];
            $ipk_terakhir_mahasiswa = $_POST['ipk_terakhir_mahasiswa'];
            $id_pilihan_beasiswa = $_POST['id_pilihan_beasiswa'];

            $data = [
                'nama_mahasiswa' => $nama_mahasiswa,
                'nim_mahasiswa' => $nim_mahasiswa,
                'email_mahasiswa' => $email_mahasiswa,
                'alamat_mahasiswa' => $alamat_mahasiswa,
                'no_hp_mahasiswa' => $no_hp_mahasiswa,
                'id_program_studi' => $id_program_studi,
                'semester_mahasiswa' => $semester_mahasiswa,
                'ipk_terakhir_mahasiswa' => $ipk_terakhir_mahasiswa,
                'id_pilihan_beasiswa' => $id_pilihan_beasiswa
            ];

            // Mulai transaksi
            $conn->begin_transaction();

            $query = $db->update('pendaftar', $data, $id_pendaftar);

            if ($query) {
                // Commit transaksi jika berhasil
                $conn->commit();
                echo "<div class='alert alert-success mt-3' role='alert'>Data berhasil diperbahui</div>";
            } else {
                // Rollback transaksi jika gagal
                $conn->rollback();
                echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $conn->error . "</div>";
            }

            $result = $db->select("pendaftar", ['AND id_pendaftar=' => $id_pendaftar]);
        } else {
            $result = $db->select("pendaftar", ['AND id_pendaftar=' => $id_pendaftar]);
        }

        $pendaftar = $result[0];
    ?>
    <div class="container">
        <h1 class="text-center mt-5">Update Data Beasiswa</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="namaMahasiswa">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="namaMahasiswa" name="nama_mahasiswa" placeholder="Masukkan Nama" required value="<?php echo $pendaftar['nama_mahasiswa'] ?>">
            </div>
            <div class="form-group">
                <label for="nimMahasiswa">NIM</label>
                <input type="text" class="form-control" id="nimMahasiswa" name="nim_mahasiswa" placeholder="Masukkan NIM" required value="<?php echo $pendaftar['nim_mahasiswa'] ?>">
            </div>
            <div class="form-group">
                <label for="emailMahasiswa">Email</label>
                <input type="email" class="form-control" id="emailMahasiswa" name="email_mahasiswa" placeholder="Masukkan Email" required value="<?php echo $pendaftar['email_mahasiswa'] ?>">
            </div>
            <div class="form-group">
                <label for="alamatMahasiswa">Alamat</label>
                <textarea class="form-control" id="alamatMahasiswa" name="alamat_mahasiswa" placeholder="Masukkan Alamat" required><?php echo $pendaftar['alamat_mahasiswa'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="noHpMahasiswa">No. HP</label>
                <input type="text" class="form-control" id="noHpMahasiswa" name="no_hp_mahasiswa" placeholder="Masukkan No. HP" required value="<?php echo $pendaftar['no_hp_mahasiswa'] ?>">
            </div>
            <div class="form-group">
                <label for="programStudi">Program Studi</label>
                <?php
                    $programStudi = $conn->query("SELECT id_program_studi, nama_program_studi FROM program_studi");
                    echo "<select class='form-control' id='programStudi' name='id_program_studi' required>";
                    echo "<option value=''>Pilih Program Studi</option>";
                    while ($row = $programStudi->fetch_assoc()) {
                        $selected = ($pendaftar['id_program_studi'] == $row['id_program_studi']) ? 'selected' : '';
                        echo "<option value='{$row['id_program_studi']}' $selected>{$row['nama_program_studi']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <div class="form-group">
                <label for="semesterMahasiswa">Semester Saat ini:</label>
                <select class="form-control" id="semesterMahasiswa" name="semester_mahasiswa" required>
                    <option value="">Pilih Semester</option>
                    <?php
                        $semester_mahasiswa_mahasiswa = ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8'];
                        foreach ($semester_mahasiswa_mahasiswa as $semester_mahasiswa) {
                            $selected = ($pendaftar['semester_mahasiswa'] == $semester_mahasiswa) ? 'selected' : '';
                            echo "<option value='$semester_mahasiswa' $selected>$semester_mahasiswa</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ipkTerakhir">IPK Terakhir</label>
                <input type="text" class="form-control" id="ipkTerakhir" name="ipk_terakhir_mahasiswa" placeholder="Masukkan IPK Terakhir" required value="<?php echo $pendaftar['ipk_terakhir_mahasiswa'] ?>">
            </div>
            <div class="form-group">
                <label for="pilihanBeasiswa">Pilihan Beasiswa</label>
                <?php
                    $pilihanBeasiswa = $conn->query("SELECT id_pilihan_beasiswa, nama_beasiswa FROM pilihan_beasiswa");
                    echo "<select class='form-control' id='pilihanBeasiswa' name='id_pilihan_beasiswa' required>";
                    echo "<option value=''>Pilih Beasiswa</option>";
                    while ($row = $pilihanBeasiswa->fetch_assoc()) {
                        $selected = ($pendaftar['id_pilihan_beasiswa'] == $row['id_pilihan_beasiswa']) ? 'selected' : '';
                        echo "<option value='{$row['id_pilihan_beasiswa']}' $selected>{$row['nama_beasiswa']}</option>";
                    }
                    echo "</select>";
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="index.php" class="btn btn-info">Kembali</a>
        </form>

        <?php
            $conn->close();
        ?>
    </div>
</body>
</html>