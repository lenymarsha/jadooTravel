<link href="assets/css/uas.css" rel="stylesheet" />
<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {
    /*** Memanggil koneksi ke MySQL ***/
    include("../admin/includes/config.php");

    
    // Query untuk memanggil data destinasi, dan kecamatan
    $query = mysqli_query($conn, "SELECT d.destinasi_NAMA, d.destinasi_KET, d.destinasi_FOTO, k.kecamatan_NAMA 
                                   FROM destinasi d 
                                   JOIN kecamatann k ON k.kecamatan_KODE = d.kecamatan_KODE 
                                   LIMIT 3"); // Mengambil 3 data menggunakan LIMIT
}
?>
<body>
    <h1 style="text-align: center;">PLAN YOUR TRIP NOW</h1>
    <div class="container-uas3">
        <?php
        while ($row = mysqli_fetch_assoc($query)) {
            ?>
           <div class="card-uas3">
            <!-- menampilkan foto destinasi -->
           <img src="images/<?php echo $row['destinasi_FOTO']?>" alt="">
           <!-- menampilkan nama kecamatan -->
           <h6> <?php echo $row['kecamatan_NAMA'] ?></h6>
           <!-- menampilkan nam destinasi -->
           <h2> <?php echo $row['destinasi_NAMA'] ?></h2>
           <!-- menampilkan icon gambar -->
           <div class="icons">
           <i class="fas fa-user-alt" style="margin: 10px;"></i><span>Leny Marsha</span>
           <i class="fas fa-eye" style="margin: 10px;"></i><span>1375</span>
           <i class="fas fa-comment" style="margin: 10px;"></i><span>50</span>
           </div>
           <!-- menampilkan destinasi keterangan -->
           <p> <?php echo $row['destinasi_KET'] ?></p>
           </div>
        <?php
        }
        ?>
    </div>
</body>