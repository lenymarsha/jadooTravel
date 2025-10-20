<?php
// Pilih kategori secara random
// Kita bikin query buat ngambil satu kategori secara acak dari tabel 'kategori'
$randomKategoriQuery = mysqli_query($conn, "SELECT * FROM kategori ORDER BY RAND() LIMIT 1"); 

// Cek dulu query-nya ada hasilnya nggak
if (mysqli_num_rows($randomKategoriQuery) > 0) { 
    // Kalau ada, simpen hasilnya di variabel $kategori
    $kategori = mysqli_fetch_array($randomKategoriQuery); 

    // Ambil ID dan Nama dari kategori yang ke-select
    $kategori_ID = $kategori['kategori_ID']; 
    $kategori_NAMA = $kategori['kategori_NAMA']; 

    // cari destinasi yang sesuai sama kategori ini
    $destinasiQuery = mysqli_query($conn, "SELECT * FROM destinasi WHERE kategori_ID = '$kategori_ID'"); 
} else { 
    // Kalau nggak ada kategori yang ke-pilih, kasih pesan default
    $kategori_NAMA = "No Categories Available"; 
    $destinasiQuery = null; 
}
?>

<section class="pt-5 pt-md-9" id="service">
    <div class="container">
        <div class="position-absolute z-index--1 end-0 d-none d-lg-block">
            <img src="assets/img/category/shape.svg" style="max-width: 200px" alt="service" />
        </div>
        
        <!-- Judul kategori yang lagi ditampilkan -->
        <div class="mb-7 text-center">
            <h5 class="text-secondary">CATEGORY</h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">
                <?php echo ($kategori_NAMA); ?> <!-- Nama kategori hasil random tadi -->
            </h3>
        </div>

        <!-- Daftar destinasi -->
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php 
            // Kalau query buat destinasi ada hasilnya, tampilkan datanya
            if ($destinasiQuery && mysqli_num_rows($destinasiQuery) > 0) { 
                while ($row = mysqli_fetch_array($destinasiQuery)) { 
            ?>
            <div class="col">
                <!-- Tampilan card buat tiap destinasi -->
                <div class="card service-card shadow-hover rounded-3 text-center h-100">
                    <div class="card-body p-xxl-5 p-4 d-flex flex-column justify-content-center align-items-center">
                        <!-- Bagian gambar destinasi -->
                        <div class="mb-3" style="width: 150px; height: 150px; display: flex; align-items: center; justify-content: center;">
                            <img src="images/<?php echo $row['destinasi_FOTO']; ?>" 
                                 style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                 alt="" />
                        </div>
                        <!-- Nama dan trip destinasi -->
                        <h4 class="mb-3"><?php echo $row['destinasi_NAMA']; ?></h4>
                        <p class="mb-0 fw-medium text-center"><?php echo $row['destinasi_KET']; ?></p>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else { 
                // Kalau nggak ada destinasi yang sesuai kategori, kasih pesan ini
                echo "<p class='text-center'>Tidak ada destinasi ditemukan untuk kategori ini.</p>"; 
            } 
            ?>
        </div>
    </div>
</section>
