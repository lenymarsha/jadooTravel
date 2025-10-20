<?php
// Mengecek apakah file diakses secara langsung
if (!defined('aktif')) {
    die('Anda tidak dapat mengakses file ini secara langsung.');
} else {
    $query = mysqli_query($conn, "SELECT * FROM testimoni");

    // Mengecek apakah ada data testimoni di database
    if (mysqli_num_rows($query) > 0) {
?>
<section id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="mb-8 text-start">
                    <h5 class="text-secondary">Testimonials</h5>
                    <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">
                        What people say about us.
                    </h3>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <!-- kolom kanan untuk carousel testimonial -->
            <div class="col-lg-6">
                <div class="pe-7 ps-5 ps-lg-0">
                    <div class="carousel slide carousel-fade position-static" id="testimonialIndicator" data-bs-ride="carousel">
                        <!-- Indikator untuk carousel -->
                        <div class="carousel-indicators">
                            <?php
                            $index = 0;
                            while ($row = mysqli_fetch_array($query)) {
                                // buat tombol indikator untuk setiap testimoni
                                echo '<button type="button" data-bs-target="#testimonialIndicator" data-bs-slide-to="' . $index . '" ' . ($index === 0 ? 'class="active"' : '') . ' aria-label="Testimonial ' . $index . '"></button>';
                                $index++;
                            }
                            // ngembaliin pointer hasil query ke awal
                            mysqli_data_seek($query, 0);
                            ?>
                        </div>

                        <!-- Isi carousel -->
                        <div class="carousel-inner">
                            <?php
                            $active = true;
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <!-- isi dalam setiap item carousel -->
                                <div class="carousel-item position-relative <?php echo $active ? 'active' : ''; ?>">
                                    <div class="card shadow" style="border-radius:10px;">
                                        <!-- UNTUK JUDUL DAN FOTO -->
                                        <div class="d-flex align-items-center mb-4">
                                            <img class="rounded-circle fit-cover me-3" src="images/<?php echo $row['testimoni_FOTO']; ?>" height="65" width="65" alt="<?php echo $row['testimoni_NAMA']; ?>" />
                                            <h3 class="text-secondary mb-0"><?php echo $row['testimoni_JUDUL']; ?></h3>
                                        </div>
                                        <!-- BAGIAN ISINYA -->
                                        <div class="card-body p-4">
                                            <p class="fw-medium mb-4"><?php echo $row['testimoni_ISI']; ?></p>
                                            <h5 class="text-secondary"><?php echo $row['testimoni_NAMA']; ?></h5>
                                            <p class="fw-medium fs--1 mb-0"><?php echo $row['testimoni_KOTANEGARA']; ?></p>
                                        </div>
                                    </div>
                                     <!-- hover untuk item carousel -->
                                    <div class="card shadow-sm position-absolute top-0 z-index--1 mb-3 w-100 h-100" style="border-radius:10px;transform:translate(25px, 25px)"> </div>
                                </div>
                            <?php
                                $active = false;
                            }
                            ?>
                        </div>
                        <!-- tombol navigasi untuk carousel -->
                        <div class="carousel-navigation d-flex flex-column flex-between-center position-absolute end-0 top-lg-50 bottom-0 translate-middle-y z-index-1 me-3 me-lg-0" style="height:60px;width:20px;">
                            <button class="carousel-control-prev position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="prev"><img src="assets/img/icons/up.svg" width="16" alt="icon" /></button>
                            <button class="carousel-control-next position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="next"><img src="assets/img/icons/down.svg" width="16" alt="icon" /></button>
                        </div>
                    </div>
                    <!-- Akhir carousel -->
                </div>
            </div>
        </div>
    </div><!-- end container -->
</section>
<?php
    } else {
        // Jika tidak ada data testimoni di database
        echo "<p class='text-center'>Belum ada testimonial.</p>";
    }
}
?>
