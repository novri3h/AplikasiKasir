<!-- By : Nadhif Studio -->
<!-- Di Larang Memperjual Source Code ini -->
<?php
include "config.php";
session_start();
	if($_SESSION['status']!="login"){
		header("location:login.php");
	}
  function ribuan ($nilai){
    return number_format ($nilai, 0, ',', '.');
}
$result1 = mysqli_query($conn, "SELECT * FROM login");
while($data = mysqli_fetch_array($result1))
{
    $user = $data['username'];
    $id = $data['id_login'];
    $toko = $data['nama_toko'];
    $alamat = $data['alamat'];
    $telp = $data['telepon'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>APLIKASI KASIR</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="favicon.ico">
  <link rel="icon" href="icon.ico" type="image/ico">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/vendor/datatables/responsive.bootstrap4.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
<div class="container">
  <a class="navbar-brand px-3 bg-warning" href="https://www.youtube.com/@NadhifMedia"><?php echo $toko ?></a>
  <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarC" aria-controls="navbarC" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars muncul"></i>
    <i class="fa fa-times-circle fa-1x text-white close"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarC">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
        <span class="text-center d-block pt-2"><i class="fa fa-desktop fa-2x"></i></span>Transaksi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="produk.php">
        <span class="text-center d-block pt-2"><i class="fa fa-shopping-bag fa-2x"></i></span>Data Produk</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="kategori.php">
        <span class="text-center d-block pt-2"><i class="fa fa-box-open fa-2x"></i></span>Kategori</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="laporan.php">
        <span class="text-center d-block pt-2"><i class="fa fa-chart-bar fa-2x"></i></span>Data laporan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pelanggan.php">
        <span class="text-center d-block pt-2"><i class="fa fa-users fa-2x"></i></span>Pelanggan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pengaturan.php">
        <span class="text-center d-block pt-2"><i class="fa fa-cogs fa-2x"></i></span>Pengaturan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php" onclick="javascript:return confirm('Anda yakin ingin keluar ?');">
        <span class="text-center d-block pt-2"><i class="fa fa-sign-out-alt fa-2x"></i></span>Keluar</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

<div class="container">