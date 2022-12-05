<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require('functions.php');

// cek apakah tombol tambah sudah ditekan atau belum
if(isset($_POST["submit"])) {

    // cek apakah data berhasil ditambahkan atau tidak
    if(tambah($_POST) > 0 ) {
        echo "<script>alert('Data Berhasil Ditambahkan'); 
        document.location.href = 'index.php'; 
        </script>";
    } else {
        echo "<script>alert('Data Gagal Ditambahkan'); 
        document.location.href = 'index.php'; 
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
</head>
<body>
    <h1>Tambah</h1>

    <a href="index.php">Home</a><br><br>

    <form method="POST" enctype="multipart/form-data">
        <ul>
            <!-- <li>
                <label for="kategori_id">Nama Kategori:</label>
                <input type="text" name="kategori_id" id="kategori_id" required>
            </li><br> -->
            <li>
                <label for="sukmadik">Nama Kategori:</label>
                <select name="kategori_id" id="kategori_id">
                <option selected>Pilih Kategori</option>
                <?php
                $result=mysqli_query($conn,"SELECT * FROM kategori");
				while($row=mysqli_fetch_array($result)) {
					?>
                    <option value="<?= $row['kateid']; ?>"><?= $row['nama_kategori']; ?></option>
					<?php
				}
			        ?>
				</select>
            </li><br>
            <li>
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" required>
            </li><br>
            <li>
                <label for="ukuran">Ukuran:</label>
                <input type="text" name="ukuran" id="ukuran" required>
            </li><br>
            <li>
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" required>
            </li><br>
            <li>
                <label for="img">Gambar:</label>
                <input type="file" name="img" id="img">
            </li><br>
            <li>
                <button type="submit" name="submit">[+] Tambah</button>
            </li>
        </ul>
    </form>
    
</body>
</html>