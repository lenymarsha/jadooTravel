<?php
if (!defined('aktif')) { 
    die('anda tidak bisa akses langsung file ini'); 
} else { 
    // Include database connection
    include("../admin/includes/config.php"); 

    // Fetch data from different tables
    $pengalaman_query = mysqli_query($conn, "SELECT * FROM pengalaman");
    $kategori_query = mysqli_query($conn, "SELECT * FROM kategori");
    $destinasi_query = mysqli_query($conn, "SELECT * FROM destinasi");
    $testimoni_query = mysqli_query($conn, "SELECT * FROM testimoni");

    // Fetch individual rows
    $pengalaman = mysqli_fetch_assoc($pengalaman_query);
    $kategori = mysqli_fetch_assoc($kategori_query);
    $destinasi = mysqli_fetch_assoc($destinasi_query);
    $testimoni = mysqli_fetch_assoc($testimoni_query);
?>

<!-- <section> begin ============================-->
<section id="booking">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-4 text-start">
                    <h5 class="text-secondary"><?php echo ($pengalaman['pengalaman_SUBJUDUL']); ?></h5>
                    <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">
                        <?php echo ($pengalaman['pengalaman_JUDUL']); ?>
                    </h3>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-primary me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="images/<?php echo ($kategori['kategori_FOTO']); ?>" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0"><?php echo ($kategori['kategori_NAMA']); ?></h5>
                        <p><?php echo ($kategori['kategori_KET']); ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-danger me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="images/<?php echo ($destinasi['destinasi_FOTO']); ?>" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0"><?php echo ($destinasi['destinasi_NAMA']); ?></h5>
                        <p><?php echo ($destinasi['destinasi_KET']); ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-info me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="images/<?php echo ($pengalaman['pengalaman_FOTO']); ?>" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0"><?php echo ($testimoni['testimoni_JUDUL']); ?></h5>
                        <p><?php echo ($testimoni['testimoni_ISI']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Bagian kanan tetap -->
            <div class="col-lg-6 d-flex justify-content-center align-items-start">
                <div class="card position-relative shadow" style="max-width: 370px;">
                    <div class="position-absolute z-index--1 me-10 me-xxl-0" style="right:-160px;top:-210px;">
                        <img src="assets/img/steps/bg.png" style="max-width:550px;" alt="shape" />
                    </div>
                    <div class="card-body p-3">
                        <img class="mb-4 mt-2 rounded-2 w-100" src="images/<?php echo ($testimoni['testimoni_FOTO']); ?>" alt="booking" />
                        <div>
                            <h5 class="fw-medium"><?php echo ($testimoni['testimoni_NAMA']); ?></h5>
                            <p class="fs--1 mb-3 fw-medium"><?php echo ($testimoni['testimoni_KOTANEGARA']); ?></p>
                            <div class="icon-group mb-4">
                                <span class="btn icon-item">
                                    <img src="assets/img/steps/leaf.svg" alt="" />
                                </span>
                                <span class="btn icon-item">
                                    <img src="assets/img/steps/map.svg" alt="" />
                                </span>
                                <span class="btn icon-item">
                                    <img src="assets/img/steps/send.svg" alt="" />
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center mt-n1">
                                    <img class="me-3" src="assets/img/steps/building.svg" width="18" alt="building" />
                                    <span class="fs--1 fw-medium"><?php echo ($kategori['kategori_NAMA']); ?></span>
                                </div>
                                <div class="show-onhover position-relative">
                                    <button class="btn">
                                        <img src="assets/img/steps/heart.svg" width="20" alt="step" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end of .container-->
</section>
<!-- <section> close ============================-->
<?php 
} 
?>