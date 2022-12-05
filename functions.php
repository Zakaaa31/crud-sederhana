<?php

// koneksi ke database
$conn = mysqli_connect("localhost","root","","crud");
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}


function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// tambah
function tambah($data) {

    // ambil data dari tiap elemen dalam form
    global $conn;
    $kategori_id = $data['kategori_id'];
    $nama = $data['nama'];
    $ukuran = $data['ukuran'];
    $warna = $data['warna'];
    
    // upload gambar
    $img = upload();
    if(!$img) {
    return false;
    }

    // query insert data
    $query = "INSERT INTO katalog (kategori_id, nama, ukuran, warna, img) 
    VALUES ('$kategori_id', '$nama', '$ukuran', '$warna', '$img')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// upload
function upload() {
    $namafile = $_FILES['img']['name'];
    $ukuranfile = $_FILES['img']['size'];
    $error = $_FILES['img']['error'];
    $tmpname = $_FILES['img']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "<script>
        alert('Pilih Gambar Terlebih Dahulu');
        </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstimgval = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstimg = explode('.', $namafile);
    $ekstimg = strtolower(end($ekstimg));
    if(!in_array($ekstimg, $ekstimgval)) {
        echo "<script>
        alert('Yang Kamu Upload Bukan Gambar!');
        </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if($ukuranfile > 1000000) {
        echo "<script>
        alert('Ukuran Gambar Terlalu Besar!');
        </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstimg;
    move_uploaded_file($tmpname, 'gambar/' . $namafilebaru);
    return $namafilebaru;
}

// hapus
function hapus($id) {
    global $conn;
    mysqli_query($conn,"DELETE FROM katalog WHERE kataid='$id'");
    return mysqli_affected_rows($conn);
}

// edit
function edit($data) {
global $conn;
    $kataid = $data['kataid'];
    $kategori_id = htmlspecialchars($data['kategori_id']);
    $nama = htmlspecialchars($data['nama']);
    $ukuran = htmlspecialchars($data['ukuran']);
    $warna = htmlspecialchars($data['warna']);
    $imglama = htmlspecialchars($data['imglama']);

    // cek apakah user memilih gambar baru atau tidak
    if($_FILES['img']['error'] === 4) {
        $img = $imglama;
    } else {
        $img = upload();
    }

    // query insert data
    $query = "UPDATE katalog
    SET kategori_id='$kategori_id', nama='$nama', ukuran='$ukuran', warna='$warna', img='$img'
    WHERE kataid = $kataid";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// cari
function cari($keyword) {
    $query = "SELECT * FROM katalog
    WHERE kategori_id LIKE '%$keyword%' OR
    nama LIKE '%$keyword%' OR
    ukuran LIKE '%$keyword%' OR
    warna LIKE '%$keyword%'";
    return query($query);
}

// registrasi
function registrasi($data) {
    global $conn;
    $username = stripslashes($data["username"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek konfirmasi password
    if($password !== $password2) {
        echo "<script>alert('Konfirmasi Password Tidak Sesuai!');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username, password)
    VALUES ('$username', '$password')");

    return mysqli_affected_rows($conn);
}
?>