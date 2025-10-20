<link href="assets/css/uas.css" rel="stylesheet" />
<?php
// Mengecek apakah file diakses secara langsung
if (!defined('aktif')) {
    die('Anda tidak dapat mengakses file ini secara langsung.');
} else {
    // Memanggil koneksi ke MySQL 
    include("../admin/includes/config.php");
    
    // Query untuk mengambil nama kategori
    $query = mysqli_query($conn, "SELECT * FROM kategori");
?>
<footer class="footer">
  <!-- Informasi Umum -->
  <div class="footer-section">
    <h6>pesonajawa.com</h6>
    <p>Wisata Jawa Mempesona</p>
    <h6>Pariwisata Solo</h6>
    <h6>Download SLPP-App</h6>
  </div>

  <!-- Informasi Travel & Hotel -->
  <div class="footer-section">
    <h6>Travel & Hotel Informations</h6>
    <?php if (mysqli_num_rows($query) > 0) { ?>
        <?php while ($row = mysqli_fetch_array($query)) { ?>
            <p><?php echo $row['kategori_NAMA'] ?></p>
        <?php } ?>
    <?php } ?>
  </div>

  <!-- Informasi Kontak -->
  <div class="footer-section">
    <h6>Contact Us</h6>
    <p>admin@pesonajawa.com</p>
  </div>
</footer>

<?php } ?> <!-- Close the block -->