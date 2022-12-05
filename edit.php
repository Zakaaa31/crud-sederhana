<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require('functions.php');

// ambil data di url
$id = $_GET['id'];

// query data katalog berdasarkan id
$kat = query("SELECT * FROM katalog WHERE kataid = $id")[0];

// cek apakah tombol tambah sudah ditekan atau belum
if(isset($_POST["submit"])) {

    // cek apakah data berhasil diedit atau tidak
    if(edit($_POST) > 0 ) {
        echo "<script>alert('Data Berhasil Diedit'); 
        document.location.href = 'index.php'; 
        </script>";
    } else {
        echo "<script>alert('Data Gagal Diedit'); 
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
    <title>Edit</title>
</head>
<body>
    <h1>Edit</h1>

    <a href="index.php">Home</a><br><br>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="kataid" value="<?= $kat['kataid']; ?>">
        <input type="hidden" name="imglama" value="<?= $kat['img']; ?>">
        <ul>
            <li>
                <img src="gambar/<?= $kat['img']; ?>" height="250" width="250" alt="">
            </li><br>
            <!-- <li>
                <label for="kategori_id">Nama Kategori:</label>
                <input type="text" name="kategori_id" id="kategori_id" required value="<?= $kat['kategori_id']; ?>">
            </li><br> -->
            <li>
                <label for="sukmadik">Nama Kategori:</label>
                <select name="kategori_id" id="kategori_id">
                <?php
                $result=mysqli_query($conn,"SELECT * FROM kategori");
				while($row=mysqli_fetch_array($result)) {
                ?>
                <option value="<?= $row['kateid']; ?>" <?php echo $row['kateid'] == $kat['kategori_id'] ? 'selected' : ''; ?>>
                <?= $row['nama_kategori']; ?></option>
				<?php
				}
			    ?>
				</select>
            </li><br>
            <li>
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" value="<?= $kat['nama']; ?>">
            </li><br>
            <li>
                <label for="ukuran">Ukuran:</label>
                <input type="text" name="ukuran" id="ukuran" value="<?= $kat['ukuran']; ?>">
            </li><br>
            <li>
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" value="<?= $kat['warna']; ?>">
            </li><br>
            <li>
                <label for="img">Gambar:</label>
                <input type="file" name="img" id="img">
            </li><br>
            <li>
                <button type="submit" name="submit">Edit</button>
            </li>
        </ul>
    </form>
    
</body>
</html>