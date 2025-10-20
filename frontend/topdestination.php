<link href="assets/css/theme.css" rel="stylesheet" />
<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {
    /*** Memanggil koneksi ke MySQL ***/
    include("../admin/includes/config.php");
    $query = mysqli_query($conn, "SELECT * FROM kategori, kecamatann, destinasi
                                  WHERE kategori.kategori_ID = destinasi.kategori_ID
                                  AND kecamatann.kecamatan_KODE = destinasi.kecamatan_KODE");
}
?>
<section class="pt-5" id="destination">
        <div class="container">
          <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4">
            <img src="assets/img/dest/shape.svg" alt="destination" />
          </div>
          <div class="mb-7 text-center">
            <h5 class="text-secondary">Top Selling </h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Top Destinations</h3>
          </div>
          <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (mysqli_num_rows($query) > 0) { ?> 
            <?php while($row = mysqli_fetch_array($query)) { ?>
            <div class="col">
              <div class="card h-100 overflow-hidden shadow"> 
                <div class="position-relative" style="height: 300px;">
                  <img class="card-img-top position-absolute w-100 h-100" 
                       src="images/<?php echo $row['destinasi_FOTO']?>" 
                       alt="Tidak ada Foto" 
                       style="object-fit: cover;"
                  />
                </div>
                <div class="card-body py-4 px-3 d-flex flex-column">
                  <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                    <h4 class="text-secondary fw-medium mb-0">
                      <a class="link-900 text-decoration-none stretched-link" href="#!">
                        <?php echo $row['destinasi_NAMA']?>
                      </a>
                    </h4>
                    <span class="fs-1 fw-medium"><?php echo $row['kecamatan_NAMA']?></span>
                  </div>
                  <div class="d-flex align-items-center mt-auto"> 
                    <img src="assets/img/dest/navigation.svg" 
                         style="margin-right: 14px" 
                         width="20" 
                         alt="navigation" />
                    <span class="fs-0 fw-medium"><?php echo $row['destinasi_ALAMAT']?></span>
                  </div>
                </div>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
</section>
<?php ?>