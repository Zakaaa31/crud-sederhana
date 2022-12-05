<?php
session_start();

if(!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require('functions.php');

//pagination
//konfigurasi
$dataperpage = 3;
$jumlahdata = count(query("SELECT * FROM katalog"));
$jumlahhalaman = ceil($jumlahdata / $dataperpage);
$halamanaktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$dataawal = ($dataperpage * $halamanaktif) - $dataperpage;

//ambil data dari tabel katalog
$kat = query ("SELECT kata.kataid, kate.nama_kategori, kata.nama, kata.ukuran, kata.warna, kata.img
FROM katalog kata
LEFT JOIN kategori kate
ON kate.kateid = kata.kategori_id
-- left join kelas on 3
LIMIT $dataawal, $dataperpage");

//tombol cari ditekan
if(isset($_POST["cari"])) {
    $kat = cari($_POST["keyword"]);

}
//ambil data (fetch) katalog dari object result
//mysqli_fetch_row() //mengembalikan array numerik
//mysqli_fetch_assoc() //mengembalikan array associative
//mysqli_fetch_array() //mengembalikan keduanya
//mysqli_fetch_object() //
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>

</head>
<body>
    <h1>Data Katalog Fashion</h1>

    <!-- logout -->
    <a href="logout.php">Logout</a><br><br>

    <!-- tambah -->
    <a href="tambah.php">[+] Tambah</a>
    <br><br>

    <!-- search -->
    <form action="" method="POST">
        <input type="text" name="keyword" autofocus placeholder="Masukkan Yang Mau Dicari" autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form><br>

    <!-- page -->
    <?php for($i = 1; $i <= $dataperpage; $i++) : ?>
        <?php if($i == $halamanaktif) : ?>
        <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: blue;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?><br><br>

    <table border="1" cellpadding="20" cellspacing="5">
        <thead>
            <th>Id</th>
            <th>Nama Kategori</th>
            <th>Nama</th>
            <th>Ukuran</th>
            <th>Warna</th>
            <th>Gambar</th>
            <th>Opsi</th>
        </thead>

        <?php $i = 1; ?>
        <?php foreach($kat as $row) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= ucwords($row['nama_kategori']); ?></td>
            <td><?= ucwords($row['nama']); ?></td>
            <td><?= ucwords($row['ukuran']); ?></td>
            <td><?= ucwords($row['warna']); ?></td>
            <td><img src="gambar/<?= $row['img']; ?>" height="85" width="85" alt=""></td>
            <td>
                <a href="hapus.php?id=<?= $row["kataid"]; ?>" onclick="return confirm('Yakin?');">Hapus</a> ||
                <a href="edit.php?id=<?= $row["kataid"]; ?>">Edit</a> ||
                <a href="detail.php?id=<?= $row["kataid"]; ?>">Detail</a>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    
</body>
</html>