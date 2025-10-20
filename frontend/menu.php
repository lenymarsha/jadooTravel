<?php
// Menolak akses langsung ke file
if (!defined('aktif')) {
    die('Anda tidak bisa akses langsung file ini');
} else {
    // Memanggil koneksi ke MySQL
    include("../admin/includes/config.php");

    // Query untuk mengambil data kategori (DROPDOWN KATEGORI)
    $query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
    // Query untuk mengambil data kabupaten (DROPDOWN DESTINASI)
    $query_destinasi = mysqli_query($conn, "SELECT * FROM kabupaten");
    // Query untuk mengambil data destinasi wisata (DROPDOWN BOOKING)
    $query_booking = mysqli_query($conn, "SELECT * FROM destinasi");
    // Query untuk mengambil data testimoni (DROPDOWN TESTIMONI)
    $query_testimoni = mysqli_query($conn, "SELECT * FROM testimoni");

    // Memastikan query berhasil
    if (!$query_kategori) {
        die("Query kategori gagal: " . mysqli_error($conn));
    }
    if (!$query_destinasi) {
        die("Query kabupaten gagal: " . mysqli_error($conn));
    }
    if (!$query_booking) {
        die("Query booking gagal: " . mysqli_error($conn));
    }
    if (!$query_testimoni) {
        die("Query testimoni gagal: " . mysqli_error($conn));
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-5 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="assets/img/logo.svg" height="34" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-lg-center align-items-start">
                <!-- Kategori Dropdown -->
                <li class="nav-item dropdown px-3 px-lg-0">
                    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" 
                       href="#" id="navbarDropdownKategori" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownKategori">
                        <?php if (mysqli_num_rows($query_kategori) > 0) { ?>
                            <?php while ($row = mysqli_fetch_array($query_kategori)) { ?>
                                <li>
                                    <a class="dropdown-item" href="inputkategori.php?kodekategori=<?php echo $row["kategori_ID"]; ?>">
                                        <?php echo $row["kategori_NAMA"]; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>

                <!-- Destinasi Dropdown -->
                <li class="nav-item dropdown px-3 px-lg-0">
                    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" 
                       href="#" id="navbarDropdownDestinasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">Destinasi</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownDestinasi">
                        <?php if (mysqli_num_rows($query_destinasi) > 0) { ?>
                            <?php while ($row = mysqli_fetch_array($query_destinasi)) { ?>
                                <li>
                                    <a class="dropdown-item" href="kabupaten.php?kodekabupaten=<?php echo $row["kabupaten_KODE"]; ?>">
                                        <?php echo $row["kabupaten_NAMA"]; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>

                <!-- Booking Dropdown -->
                <li class="nav-item dropdown px-3 px-lg-0">
                    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" 
                       href="#" id="navbarDropdownBooking" role="button" data-bs-toggle="dropdown" aria-expanded="false">Booking</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownBooking">
                        <?php if (mysqli_num_rows($query_booking) > 0) { ?>
                            <?php while ($row = mysqli_fetch_array($query_booking)) { ?>
                                <li>
                                    <a class="dropdown-item" href="destinasi.php?kodedestinasi=<?php echo $row["destinasi_KODE"]; ?>">
                                        <?php echo $row["destinasi_NAMA"]; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>

                <!-- Testimoni Dropdown -->
                <li class="nav-item dropdown px-3 px-lg-0">
                    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" 
                       href="#" id="navbarDropdownTestimoni" role="button" data-bs-toggle="dropdown" aria-expanded="false">Testimoni</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownTestimoni">
                        <?php if (mysqli_num_rows($query_testimoni) > 0) { ?>
                            <?php while ($row = mysqli_fetch_array($query_testimoni)) { ?>
                                <li>
                                    <a class="dropdown-item" href="testimoni.php?kodetestimoni=<?php echo $row["testimoni_KODE"]; ?>">
                                        <?php echo $row["testimoni_NAMA"]; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                
                <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" href="#!">Login</a></li>
                <li class="nav-item px-3 px-xl-4"><a class="btn btn-outline-dark order-1 order-lg-0 fw-medium" href="#!">Sign Up</a></li>

                <!-- Language Dropdown -->
                <li class="nav-item dropdown px-3 px-lg-0">
                    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" 
                       href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">EN</a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownLang">
                        <li><a class="dropdown-item" href="#!">EN</a></li>
                        <li><a class="dropdown-item" href="#!">BN</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
