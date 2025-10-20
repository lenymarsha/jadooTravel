<!DOCTYPE html>
<html>

<body class="sb-nav-fixed">
    <?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>

        <div id="layoutSidenav">
        <?php include "include/menu.php";?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                
<?php
/** Memanggil koneksi ke MySQL */
include("include/config.php");

$berita_KODE = $_GET["ubahberita"];
$edit = mysqli_query($conn, "SELECT * FROM berita WHERE berita_KODE = '$berita_KODE'");
$row_edit = mysqli_fetch_array($edit);

/** Mengecek apakah tombol ubah sudah dipilih/diklik atau belum */
if (isset($_POST['ubah'])) {
    $berita_KODE = $_POST['inputID'];
    $beritaJUDUL = $_POST['inputJUDUL'];
    $berita_ISI = $_POST['inputISI'];
    $berita_SUMBER = $_POST['inputSUMBER'];
    $kategori_ID = $_POST['kategori_ID'];

    $namafoto = $_FILES['fotoberita']['name']; /** Untuk menampung data foto atau gambar */
    $file_tmp = $_FILES['fotoberita']['tmp_name'];
    $file_size = $_FILES['fotoberita']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah ukuran file lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        // Memindahkan file ke folder images
        move_uploaded_file($file_tmp, 'images/' . $namafoto); /** Untuk upload file gambarnya */

        if ($namafoto == "") {
            mysqli_query($conn, "UPDATE berita SET berita_JUDUL = '$beritaJUDUL', berita_ISI = '$berita_ISI', berita_SUMBER = '$berita_SUMBER',
            kategori_ID = '$kategori_ID' WHERE berita_KODE = '$berita_KODE'");
        } else {
            mysqli_query($conn, "UPDATE berita SET berita_JUDUL = '$beritaJUDUL', berita_ISI = '$berita_ISI', berita_SUMBER = '$berita_SUMBER',
            kategori_ID = '$kategori_ID', berita_FOTO = '$namafoto' WHERE berita_KODE = '$berita_KODE'");
        }
        echo "<script>document.location='inputberita.php'</script>";
        exit();
    }
}

// Mengambil data kategori untuk dropdown
$datakategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Berita Wisata</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <!-- Membuat form input data berita -->
    <div class="container">
        <div class="judulinput" style="margin-left: 100px; margin-top: 25px;">
            <h1>Edit Berita Wisata</h1>
            <p>Berita Destinasi Wisata</p>
        </div>

        <div class="row">
            <!-- Kolom -->
            <div class="col-1"></div>
            <div class="col-10">

                <!-- Form -->
                <form method="POST" enctype="multipart/form-data">

                    <!-- Kode berita wisata -->
                    <div class="row mb-3 mt-5">
                        <label for="berita_KODE" class="col-sm-2 col-form-label">Kode Berita</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="berita_KODE" name="inputID" value="<?php echo $row_edit["berita_KODE"] ?>" readonly>
                        </div>
                    </div>

                    <!-- Judul berita wisata -->
                    <div class="row mb-3">
                        <label for="beritaJUDUL" class="col-sm-2 col-form-label">Judul Berita Wisata</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="beritaJUDUL" name="inputJUDUL" value="<?php echo $row_edit["berita_JUDUL"] ?>">
                        </ div>
                    </div>
                    <!-- Penutup row -->

                    <!-- Isi berita wisata -->
                    <div class="row mb-3">
                        <label for="berita_ISI" class="col-sm-2 col-form-label">Isi Berita Wisata</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="berita_ISI" name="inputISI" value="<?php echo $row_edit["berita_ISI"] ?>">
                        </div>
                    </div>

                    <!-- Sumber berita wisata -->
                    <div class="row mb-3">
                        <label for="berita_SUMBER" class="col-sm-2 col-form-label">Sumber Berita</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="berita_SUMBER" name="inputSUMBER" value="<?php echo $row_edit["berita_SUMBER"] ?>">
                        </div>
                    </div>

                    <!-- Penggunaan select2 -->
                    <div class="row mb-3">
                        <label for="kategori_ID" class="col-sm-2 col-form-label">Kode Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori_ID" name="kategori_ID">
                                <option><?php echo $row_edit["kategori_ID"] ?></option>
                                <?php if (mysqli_num_rows($datakategori) > 0) { ?>
                                    <?php while ($row = mysqli_fetch_array($datakategori)) { ?>
                                        <option value="<?php echo $row["kategori_ID"] ?>">
                                            <?php echo $row["kategori_ID"] ?> - <?php echo $row["kategori_NAMA"] ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- End select2 -->

                    <!-- Input file -->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Berita</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotoberita" value="<?php echo $row_edit["berita_FOTO"] ?>">
                            <p class="help-block">Unggah Foto Berita</p>
                            <?php if (isset($error_message)) { ?>
                                <p class="text-danger"><?php echo $error_message; ?></p> <!-- Menampilkan pesan kesalahan -->
                            <?php } ?>
                        </div>
                    </div>
                    <!-- End input file -->

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-success" value="Update" name="ubah">
                            <input type="reset" class="btn btn-danger" value="Batal">
                        </div>
                    </div>

                </form>
                <!-- Penutup form -->

                <h1 style="margin-top: 50px; margin-bottom: 25px">Daftar Berita Wisata</h1>

                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Judul Berita</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                   value="<?php if (isset($_POST["search"])) { echo $_POST["search"]; } ?>" placeholder="Cari Judul Berita">
                        </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                    </div>
                </form>

                <table class="table table-striped table-success table-hover mt-5">
                    <!-- Membuat judul -->
                    <tr class="info">
                        <th>Kode</th>
                        <th>Judul Berita</th>
                        <th>Isi Berita</th>
                        <th>Sumber Berita</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Foto Berita</th>
                        <th colspan="2">Aksi</th>
                    </tr>

                    <!-- Menampilkan data dari tabel kategori -->
                    <?php
                    /** Pencarian data */
                    if (isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "SELECT * FROM kategori, berita 
                            WHERE kategori.kategori_ID = berita.kategori_ID AND berita_JUDUL LIKE '%" . $search . "%'");
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM kategori, berita 
                            WHERE kategori.kategori_ID = berita.kategori_ID");
                    }
                    /** End pencarian data */

                    while ($row = mysqli_fetch_array($query)) { ?>
                        <tr class="danger">
                            <td><?php echo $row['berita_KODE']; ?></td>
                            <td><?php echo $row['berita_JUDUL']; ?></td>
                            <td><?php echo $row['berita_ISI']; ?></td>
                            <td><?php echo $row['berita_SUMBER']; ?></td>
                            <td><?php echo $row['kategori_ID']; ?></td>
                            <td><?php echo $row['kategori_NAMA']; ?></td>
                            <td>
                                <?php if ($row['berita_FOTO'] == "") {
                                    echo "<img src='images/noimage.png' width='88'/>";
                                } else { ?>
                                    <img src="images/<?php echo $row['berita_FOTO']; ?>" width="88" class="img-responsive" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm" title="EDIT">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" title="HAPUS">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
            <div class="col-1"></div>
        </div>

         </main>
        <?php include "include/footer.php";?>
                </div>
            </div>
        <?php include "include/jsscript.php";?>

        <script>
            $(document).ready(function() {
                $('#kategori_ID').select2({
                    closeOnSelect: true,
                    allowClear: true,
                    placeholder: 'Pilih Kategori'
                });
            });
        </script>

    </div>
</body>
</html>