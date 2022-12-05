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
$kat = query("SELECT kata.kataid, kate.nama_kategori, kata.nama, kata.ukuran, kata.warna, kata.img
FROM katalog kata
LEFT JOIN kategori kate
ON kate.kateid = kata.kategori_id 
WHERE kataid = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>
    <h1>Detail</h1>

    <a href="index.php">Home</a><br><br>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="kataid" value="<?= $kat['kataid']; ?>">
        <input type="hidden" name="imglama" value="<?= $kat['img']; ?>">
        <ul>
            <li>
                <label for="img">Gambar:</label><br>
                <img src="gambar/<?= $kat['img']; ?>" height="250" width="250" alt="">
            </li><br>
            <li>
                <label for="nama_kategori">Nama Kategori:</label>
                <input type="text" name="nama_kategori" id="nama_kategori" readonly value="<?= $kat['nama_kategori']; ?>">
            </li><br>
            <li>
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" readonly value="<?= $kat['nama']; ?>">
            </li><br>
            <li>
                <label for="ukuran">Ukuran:</label>
                <input type="text" name="ukuran" id="ukuran" readonly value="<?= $kat['ukuran']; ?>">
            </li><br>
            <li>
                <label for="warna">Warna:</label>
                <input type="text" name="warna" id="warna" readonly value="<?= $kat['warna']; ?>">
            </li>
        </ul>
    </form>
    
</body>
</html>