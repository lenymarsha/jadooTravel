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
// Include the MySQL connection configuration
include("include/config.php");

$error_message = ""; // Variabel untuk pesan error

// Check if the 'Simpan' button was clicked
if (isset($_POST['Simpan'])) {
    $destinasi_KODE = $_POST['inputKODE'];
    $destinasi_NAMA = $_POST['inputNAMA'];
    $destinasi_ALAMAT = $_POST['inputALAMAT'];
    $destinasi_KET = $_POST['inputKET'];
    $kecamatan_KODE = $_POST['kecamatan_KODE'];

    // Mengambil informasi file
    $namafoto = $_FILES['fotodestinasi']['name'];
    $file_tmp = $_FILES['fotodestinasi']['tmp_name'];
    $file_size = $_FILES['fotodestinasi']['size']; 

    // Cek ukuran file (maksimal 2MB)
    if ($file_size > 2097152) { // 2MB = 2 * 1024 * 1024 bytes
        $error_message = "Foto yang Anda unggah lebih dari 2MB.";
    } else {
        // Jika ukuran file sesuai, lanjutkan upload
        move_uploaded_file($file_tmp, 'images/'.$namafoto);

        // Masukkan data ke database dengan foto yang telah diupload
        mysqli_query($conn, "INSERT INTO destinasi (destinasi_KODE, kategori_ID, destinasi_NAMA, destinasi_ALAMAT, destinasi_KET, kecamatan_KODE, destinasi_FOTO) 
        VALUES ('$destinasi_KODE', 'ID01', '$destinasi_NAMA', '$destinasi_ALAMAT', '$destinasi_KET', '$kecamatan_KODE', '$namafoto')");

        echo "<script>document.location='destinasi.php'</script>";
        exit;
    }
}

    // Bagian Pencarian Data
    if(isset($_POST["kirim"])) {
        $search = $_POST["search"];
        $query = mysqli_query($conn, "SELECT * FROM destinasi, kecamatann WHERE destinasi.kecamatan_KODE = kecamatann.kecamatan_KODE AND (destinasi.destinasi_NAMA LIKE '%".$search."%' OR kecamatann.kecamatan_NAMA LIKE '%".$search."%')");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM destinasi, kecamatann WHERE destinasi.kecamatan_KODE = kecamatann.kecamatan_KODE");
    }

    $datakecamatan = mysqli_query($conn, "select * from kecamatann");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Destinasi Wisata</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <!-- Form to input destination data -->
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Input Destinasi Wisata</h1>
                <form method="POST" enctype="multipart/form-data">
                    <!-- Kode Destinasi -->
                    <div class="row mb-3 mt-5">
                        <label for="destinasiKODE" class="col-sm-2 col-form-label">Kode Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiKODE" name="inputKODE" placeholder="Input Kode Destinasi">
                        </div>
                    </div>

                    <!-- Nama Destinasi -->
                    <div class="row mb-3">
                        <label for="destinasiNAMA" class="col-sm-2 col-form-label">Nama Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiNAMA" name="inputNAMA" placeholder="Input Nama Destinasi">
                        </div>
                    </div>

                    <!-- Alamat Destinasi -->
                    <div class="row mb-3 mt-5">
                        <label for="destinasiALAMAT" class="col-sm-2 col-form-label">Alamat Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiALAMAT" name="inputALAMAT" placeholder="Input Alamat Destinasi">
                        </div>
                    </div>

                    <!-- Keterangan Destinasi -->
                    <div class="row mb-3">
                        <label for="destinasiKET" class="col-sm-2 col-form-label">Keterangan Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasiKET" name="inputKET" placeholder="Input Keterangan Destinasi">
                        </div>
                    </div>

                    <!-- penggunaan select2 -->
                    <div class="row mb-3">
                        <label for="kecamatanKODE" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kecamatanKODE" name="kecamatan_KODE">
                                <option>Pilih Kecamatan</option>
                                <?php while ($row = mysqli_fetch_array($datakecamatan)) { ?>
                                    <option value="<?php echo $row["kecamatan_KODE"]; ?>">
                                        <?php echo $row["kecamatan_KODE"]; ?> 
                                        <?php echo $row["kecamatan_NAMA"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- end select2-->

                    <!-- Foto Destinasi -->
                    <!-- input file -->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Destinasi</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotodestinasi">
                            <p class="help-block">*Ukuran foto maksimal 2MB</p>
                            <?php if ($error_message): ?>
                                <p class="text-danger"><?php echo $error_message; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Submit and Reset Buttons -->
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                        <input type="reset" class="btn btn-danger" value="Batal">
                    </div>

                </form> <br>
                <!-- penutup form -->

                <h1>Output Destinasi Wisata</h1>

                <!-- Display Data Table -->
                <table class="table table-striped table-success table-hover mt-5">
                    
                    <!--form pencarian-data-->
                    <form method="POST">
                        <div class="form-group row mt-5">
                            <label for="search" class="col-sm-2">Cari Nama Destinasi</label>
                            <div class="col-sm-6">
                                <input type="text" name="search" class="form-control" id="search"
                                    value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" 
                                    placeholder="Cari Nama Destinasi">
                            </div>
                            <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                        </div>
                    </form>
                    <!--end-pencarian-data-->
                    
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
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr class="danger">
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
                                <a href="destinasi_edit.php?ubahdestinasi=<?php echo $row["destinasi_KODE"]?>" class="btn btn-success btn-sm" title="EDIT">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="destinasi_hapus.php?hapusdestinasi=<?php echo $row["destinasi_KODE"]?>" class="btn btn-danger btn-sm" title="HAPUS">
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
            $('#kecamatanKODE').select2({
                closeOnSelect: true,
                allowClear: true,
                placeholder: 'Pilih Kecamatan'
            });
        });
    </script>
</body>
</html>
