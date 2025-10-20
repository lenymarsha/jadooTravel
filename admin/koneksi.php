<?php
// Memanggil koneksi ke MYSQL
include("includes/config.php");

// Mengecek apakah tombol simpan sudah di pilih/klik atau belum
if(isset($_POST['Simpan'])) {
  $kategoriID = $_POST['inputID'];
  $kategoriNAMA = $_POST['inputNAMA'];
  $kategoriKET = $_POST['inputKETERANGAN'];

  mysqli_query($conn, "insert into kategori values('$kategoriID', '$kategoriNAMA', '$kategoriKET')");
  header("location:kategori.php");
}
?>
</head>