<!DOCTYPE html>
<html lang="en">

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
// Memanggil koneksi ke MySQL
include("include/config.php");

$destinasi_KODE = $_GET["ubahdestinasi"];
$query = mysqli_query($conn, "SELECT * FROM destinasi WHERE destinasi_KODE = '$destinasi_KODE'");
$row_edit = mysqli_fetch_array($query);

// Mengecek apakah tombol Simpan sudah diklik
if (isset($_POST['ubah'])) {
    $destinasi_KODE = $_POST['inputKODE'];
    $destinasi_NAMA = $_POST['inputNAMA'];
    $destinasi_ALAMAT = $_POST['inputALAMAT'];
    $destinasi_KET = $_POST['inputKET'];
    $kecamatan_KODE = $_POST['kecamatan_KODE'];

    // Mengambil informasi file
    $namafoto = $_FILES['fotodestinasi']['name'];
    $file_tmp = $_FILES['fotodestinasi']['tmp_name'];
    $file_size = $_FILES['fotodestinasi']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah file yang diupload lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        // Jika tidak ada foto yang diupload
        if ($namafoto == "") {
            $query = mysqli_query($conn, "UPDATE destinasi SET 
                destinasi_NAMA = '$destinasi_NAMA', 
                destinasi_ALAMAT = '$destinasi_ALAMAT',
                destinasi_KET = '$destinasi_KET',
                kecamatan_KODE = '$kecamatan_KODE'
                WHERE destinasi_KODE = '$destinasi_KODE'");
        } else {
            // Memindahkan file ke folder images
            move_uploaded_file($file_tmp, 'images/' . $namafoto);
            $query = mysqli_query($conn, "UPDATE destinasi SET 
                destinasi_NAMA = '$destinasi_NAMA',
                destinasi_ALAMAT = '$destinasi_ALAMAT',
                destinasi_KET = '$destinasi_KET',
                kecamatan_KODE = '$kecamatan_KODE',
                destinasi_FOTO = '$namafoto'
                WHERE destinasi_KODE = '$destinasi_KODE'");
        }
        echo "<script>document.location='destinasi.php'</script>"; // Redirect setelah berhasil
        exit();
    }
}

$datakecamatan = mysqli_query($conn, "SELECT * FROM kecamatann");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Destinasi Wisata</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
</head>

<body>
    <!-- Form to edit destination data -->
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Edit Destinasi Wisata</h1>
                <form method="POST" enctype="multipart/form-data">
                    <!-- Kode Destinasi -->
                    <div class="row mb-3 mt-5">
                        <label for="destinasiKODE" class="col-sm-2 col-form-label">Kode Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiKODE" name="inputKODE" value="<?php echo $row_edit["destinasi_KODE"]; ?>" readonly>
                        </div>
                    </div>

                    <!-- Nama Destinasi -->
                    <div class="row mb-3">
                        <label for="destinasiNAMA" class="col-sm-2 col-form-label">Nama Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form -control" id="destinasiNAMA" name="inputNAMA" value="<?php echo $row_edit["destinasi_NAMA"]; ?>">
                        </div>
                    </div>

                    <!-- Alamat Destinasi -->
                    <div class="row mb-3">
                        <label for="destinasiALAMAT" class="col-sm-2 col-form-label">Alamat Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiALAMAT" name="inputALAMAT" value="<?php echo $row_edit["destinasi_ALAMAT"]; ?>">
                        </div>
                    </div>

                    <!-- Keterangan Destinasi -->
                    <div class="row mb-3">
                        <label for="destinasiKET" class="col-sm-2 col-form-label">Keterangan Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiKET" name="inputKET" value="<?php echo $row_edit["destinasi_KET"]; ?>">
                        </div>
                    </div>

                    <!-- Kode Kecamatan Select -->
                    <div class="row mb-3">
                        <label for="kecamatan_KODE" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kecamatan_KODE" name="kecamatan_KODE">
                                <option><?php echo $row_edit["kecamatan_KODE"]?></option>
                                <?php if(mysqli_num_rows($datakecamatan) > 0) {?>
                                <?php while ($row = mysqli_fetch_array($datakecamatan)) { ?>
                                    <option value="<?php echo $row["kecamatan_KODE"]; ?>">
                                        <?php echo $row["kecamatan_KODE"] . " - " . $row["kecamatan_NAMA"]; ?>
                                    </option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Input File -->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Destinasi</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotodestinasi">
                            <p class="help-block">*Ukuran foto maksimal 2MB</p>
                            <?php if ($row_edit["destinasi_FOTO"]) { ?>
                                <img src="images/<?php echo $row_edit["destinasi_FOTO"]; ?>" width="200" class="img-responsive mt-2">
                            <?php } ?>
                            <?php if (isset($error_message)) { ?>
                                <p class="text-danger"><?php echo $error_message; ?></p> <!-- Menampilkan pesan kesalahan -->
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Submit and Reset Buttons -->
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-success" value="Update" name="ubah">
                        <input type="reset" class="btn btn-danger" value="Batal">
                    </div>

                </form> <br>
                <!-- penutup form -->

            <h1>Output Destinasi Wisata</h1>
                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Destinasi</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                            value="<?php if(isset($_POST["search"])) {echo $_POST["search"];} ?>" 
                            placeholder="Cari Nama Destinasi">
                        </div>
                        <div class="col-sm-1">
                            <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                        </div>
                    </div>
                </form> <br> <br>
                    
                <table class="table table-striped table-success table-hover mt-5">
                    <tr class="info">
                        <th>Kode Destinasi</th>
                        <th>Nama Destinasi</th>
                        <th>Alamat Destinasi</th>
                        <th>Keterangan Destinasi</th>
                        <th>Kode Kecamatan</th>
                        <th>Nama Kecamatan</th>
                        <th>Foto Destinasi</th>
                        <th colspan="2"> Aksi </th>
                    </tr>

                    <?php
                    if(isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "SELECT * FROM destinasi, kecamatann WHERE destinasi.kecamatan_KODE = kecamatann.kecamatan_KODE AND (destinasi.destinasi_NAMA LIKE '%".$search."%' OR kecamatann.kecamatan_NAMA LIKE '%".$search."%')");
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM destinasi, kecamatann WHERE destinasi.kecamatan_KODE = kecamatann.kecamatan_KODE");
                    }

                    while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['destinasi_KODE']; ?></td>
                            <td><?php echo $row['destinasi_NAMA']; ?></td>
                            <td><?php echo $row['destinasi_ALAMAT']; ?></td>
                            <td><?php echo $row['destinasi_KET']; ?></td>
                            <td><?php echo $row['kecamatan_KODE']; ?></td>
                            <td><?php echo $row['kecamatan_NAMA']; ?></td>
                            <td>
                                <?php if ($row['destinasi_FOTO'] == "") { ?>
                                    <img src='images/noimage.png' width="88" />
                                <?php } else { ?>
                                    <img src="images/<?php echo $row['destinasi_FOTO']; ?>" width="88" class="img-responsive" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="#" 
                                class="btn btn-success btn-sm" title="EDIT">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="#" 
                                class="btn btn-danger btn-sm" title="HAPUS"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    </main>
    <?php include "include/footer.php";?>
            </div>
        </div>
    <?php include "include/jsscript.php";?>

    <script>
        $(document).ready(function() {
            $('#kecamatan_KODE').select2({
                closeOnSelect: true,
                allowClear: true,
                placeholder: 'Pilih Kecamatan'
            });
        });
    </script>
</body>
</html>