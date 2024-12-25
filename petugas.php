<?php
// database
$servername = "localhost";
$username = "root";  
$password = "";   
$dbname = "db_petugas";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menambahkan data
if (isset($_POST['tambah'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $pendidikan = $_POST['pendidikan'];

    $sql = "INSERT INTO tbl_petugas (nik, nama, alamat, jenis_kelamin, tempat_lahir, tgl_lahir, pendidikan) 
            VALUES ('$nik', '$nama', '$alamat', '$jenis_kelamin', '$tempat_lahir', '$tgl_lahir', '$pendidikan')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fungsi untuk mengedit data
if (isset($_POST['ubah'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $pendidikan = $_POST['pendidikan'];

    $sql = "UPDATE tbl_petugas SET nama='$nama', alamat='$alamat', jenis_kelamin='
    $jenis_kelamin', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir',
    pendidikan='$pendidikan' WHERE nik='$nik'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diubah!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fungsi untuk menghapus data
if (isset($_GET['hapus'])) {
    $nik = $_GET['hapus'];
    $sql = "DELETE FROM tbl_petugas WHERE nik='$nik'";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Menampilkan data petugas
$sql = "SELECT * FROM tbl_petugas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi CRUD Petugas</title>
</head>
<body>
    <h2>Aplikasi CRUD Petugas</h2>

    <!-- Form untuk tambah data -->
    <h3>Tambah Data Petugas</h3>
    <form method="POST">
        NIK: <input type="text" name="nik" required><br>
        Nama: <input type="text" name="nama" required><br>
        Alamat: <input type="text" name="alamat" required><br>
        Jenis Kelamin: <input type="text" name="jenis_kelamin" required><br>
        Tempat Lahir: <input type="text" name="tempat_lahir" required><br>
        Tanggal Lahir: <input type="date" name="tgl_lahir" required><br>
        Pendidikan: <input type="text" name="pendidikan" required><br>
        <input type="submit" name="tambah" value="Tambah Data">
    </form>

    <hr>

    <!-- Menampilkan Data Petugas -->
    <h3>Data Petugas</h3>
    <table border="1">
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Pendidikan</th>
            <th>Aksi</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row["nik"]. "</td>
                    <td>" . $row["nama"]. "</td>
                    <td>" . $row["alamat"]. "</td>
                    <td>" . $row["jenis_kelamin"]. "</td>
                    <td>" . $row["tempat_lahir"]. "</td>
                    <td>" . $row["tgl_lahir"]. "</td>
                    <td>" . $row["pendidikan"]. "</td>
                    <td>
                        <a href='?edit=" . $row["nik"] . "'>Edit</a> |
                        <a href='?hapus=" . $row["nik"] . "'>Hapus</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
        }
        ?>
    </table>

    <?php
    // Form Edit Data
    if (isset($_GET['edit'])) {
        $nik = $_GET['edit'];
        $sql_edit = "SELECT * FROM tbl_petugas WHERE nik='$nik'";
        $result_edit = $conn->query($sql_edit);
        $data_edit = $result_edit->fetch_assoc();
        ?>

        <h3>Edit Data Petugas</h3>
        <form method="POST">
            NIK: <input type="text" name="nik" value="<?= $data_edit['nik']; ?>" readonly><br>
            Nama: <input type="text" name="nama" value="<?= $data_edit['nama']; ?>" required><br>
            Alamat: <input type="text" name="alamat" value="<?= $data_edit['alamat']; ?>" required><br>
            Jenis Kelamin: <input type="text" name="jenis_kelamin" value="<?= $data_edit['jenis_kelamin']; ?>" required><br>
            Tempat Lahir: <input type="text" name="tempat_lahir" value="<?= $data_edit['tempat_lahir']; ?>" required><br>
            Tanggal Lahir: <input type="date" name="tgl_lahir" value="<?= $data_edit['tgl_lahir']; ?>" required><br>
            Pendidikan: <input type="text" name="pendidikan" value="<?= $data_edit['pendidikan']; ?>" required><br>
            <input type="submit" name="ubah" value="Ubah Data">
        </form>
        <?php
    }

    $conn->close();
    ?>
</body>
</html>
