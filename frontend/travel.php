<?php
// Mengecek apakah file diakses secara langsung
if (!defined('aktif')) {
    die('Anda tidak dapat mengakses file ini secara langsung.');
} else {
    $query = mysqli_query($conn, "SELECT * FROM pengalaman");

    // Mengecek apakah ada data pengalaman di database
    if (mysqli_num_rows($query) > 0) {
?>
<link href="assets/css/theme.css" rel="stylesheet" />
<section style="padding-top: 7rem;">
    <div class="bg-holder" style="background-image:url(assets/img/hero/hero-bg.svg);">
    </div>
    <!--/.bg-holder-->

    <div class="container">
        <div class="row align-items-center">
            <?php
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end">
                <!-- untuk menampilkan gambar pengalaman -->
                <img class="pt-7 pt-md-0 hero-img" src="images/<?php echo $row['pengalaman_FOTO']; ?>" alt="hero-header" />
            </div>
            <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
                <!-- untuk menampilkan judul, subjudul, dan deskripsi -->
                <h4 class="fw-bold text-danger mb-3"><?php echo $row['pengalaman_SUBJUDUL']; ?></h4>
                <h1 class="hero-title" style="fotnt-size:12px;"><?php echo $row['pengalaman_JUDUL']; ?></h1>
                <p class="mb-4 fw-medium"><?php echo $row['pengalaman_KET']; ?></p>
                <div class="text-center text-md-start">
                    <a class="btn btn-primary btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow" href="#!" role="button">Find out more</a>
                    <div class="w-100 d-block d-md-none"></div>
                    <a href="#!" role="button" data-bs-toggle="modal" data-bs-target="#popupVideo-<?php echo $row['pengalaman_ID']; ?>">
                        <span class="btn btn-danger round-btn-lg rounded-circle me-3 danger-btn-shadow">
                            <img src="assets/img/hero/play.svg" width="15" alt="play" />
                        </span>
                    </a>
                    <span class="fw-medium">Play Demo</span>
                    <?php if (!empty($row['pengalaman_LINKVIDIO'])) { ?>
                        <div class="modal fade" id="popupVideo-<?php echo $row['pengalaman_ID']; ?>" tabindex="-1" aria-labelledby="popupVideo-<?php echo $row['pengalaman_ID']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <iframe width="560" height="315" src="<?php echo $row['pengalaman_LINKVIDIO']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
    } else {
        // Jika tidak ada data pengalaman di database
        echo "<p class='text-center'>Belum ada pengalaman yang tersedia.</p>";
    }
}
?>