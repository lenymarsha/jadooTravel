<?php
if (!defined('aktif')) { 
    die('Anda tidak bisa akses langsung file ini'); 
} else { 
    // Memanggil koneksi ke mySQL
    include("../admin/includes/config.php");

    // Query untuk mengambil tabel leny
    $query = "SELECT * FROM leny";
    $result = mysqli_query($conn, $query); // Execute the query

    // Mengecek apakah ada data yang ditemukan
    if ($result) {
        $row = mysqli_fetch_assoc($result); // Mengambil data sebagai associative array
    }
?>
<!-- Menampilkan Informasi Diri -->
<div class="container-uas2">
    <!-- Menampilkan Foto Diri -->
    <img src="images/<?php echo $row['leny_FOTO']; ?>" class="foto" alt="">
    
    <!-- Menampilkan Keterangan -->
    <p class="ket">
      <?php echo $row['leny_KET']; ?>
    </p>
    
    <!-- Menampilkan Nama -->
    <h2 class="nama"><?php echo $row['Yleny']; ?></h2>
    
    <!-- DMenampilkan NIM -->
    <p class="nim"><?php echo $row['825230127leny']; ?></p>
</div>

<?php } ?> <!-- Close the block -->