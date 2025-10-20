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

$kecamatan_KODE = $_GET["ubahkecamatan"];
$query = mysqli_query($conn, "SELECT * FROM kecamatann WHERE kecamatan_KODE = '$kecamatan_KODE'");
$row_edit = mysqli_fetch_array($query);

// Mengecek apakah tombol Simpan sudah diklik
if (isset($_POST['ubah'])) {
    $kecamatan_KODE = $_POST['inputKODE'];
    $kecamatan_NAMA = $_POST['inputNAMA'];
    $kabupaten_KODE = $_POST['kabupaten_KODE'];

    // Mengambil informasi file
    $namafoto = $_FILES['fotokecamatan']['name'];
    $file_tmp = $_FILES['fotokecamatan']['tmp_name'];
    $file_size = $_FILES['fotokecamatan']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah ukuran file lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        // Memindahkan file ke folder images
        move_uploaded_file($file_tmp, 'images/' . $namafoto);

        if ($namafoto == "") {
            $query = mysqli_query($conn, "UPDATE kecamatann SET kecamatan_NAMA = '$kecamatan_NAMA', kabupaten_KODE = '$kabupaten_KODE' WHERE kecamatan_KODE = '$kecamatan_KODE'");
        } else {
            $query = mysqli_query($conn, "UPDATE kecamatann SET kecamatan_NAMA = '$kecamatan_NAMA', kabupaten_KODE = '$kabupaten_KODE', kecamatan_FOTO = '$namafoto' WHERE kecamatan_KODE = '$kecamatan_KODE'");
        }
        echo "<script>document.location='kecamatan.php'</script>";
        exit();
    }
}

$datakabupaten = mysqli_query($conn, "SELECT * FROM kabupaten");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kecamatan</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
</head>

<body>

    <!-- Membuat form input data Kecamatan -->
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Edit Kecamatan</h1>
                <form method="POST" enctype="multipart/form-data">
                    <!-- Kecamatan Kode -->
                    <div class="row mb-3 mt-5">
                        <label for="kecamatanKODE" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kecamatanKODE" name="inputKODE" value="<?php echo $row_edit["kecamatan_KODE"]; ?>" readonly>
                        </div>
                    </div>

                    <!-- Nama Kecamatan -->
                    <div class="row mb-3">
                        <label for="kecamatanNAMA" class="col-sm-2 col-form-label">Nama Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kecamatanNAMA" name="inputNAMA" value="<?php echo $row_edit["kecamatan_NAMA"]; ?>">
                        </div>
                    </div>

                    <!-- Kode Kabupaten Select -->
                    <div class="row mb-3">
                        <label for="kabupaten_KODE" class="col-sm-2 col-form-label">Kode Kabupaten</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kabupaten_KODE" name="kabupaten_KODE">
                                <option value="<?php echo $row_edit["kabupaten_KODE"]; ?>"><?php echo $row_edit["kabupaten_KODE"]; ?></option>
                                <?php while ($row = mysqli_fetch_array($datakabupaten)) { ?>
                                    <option value="<?php echo $row["kabupaten_KODE"]; ?>">
                                        <?php echo $row["kabupaten_KODE"] . " - " . $row["kabupaten_NAMA"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Input File -->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotokecamatan">
                            <p class="help-block">Unggah Foto Kecamatan (Maksimal 2MB)</p>
                            <?php if (isset($error_message)) { ?>
                                <p class="text-danger"><?php echo $error_message; ?></p> <!-- Menampilkan pesan kesalahan -->
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group row">  
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success" name="ubah">Update</button>
                            <a href="provinsi.php" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </form> <br><br>

                <h1>Output Kecamatan</h1>
                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Kecamatan</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                   value="<?php if (isset($_POST["search"])) { echo $_POST["search"]; } ?>" 
                                   placeholder="Cari Nama Kecamatan">
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" name="kirim" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form> <br> <br>

                <table class="table table-striped table-success table-hover mt-5">
                    <tr class="info">
                        <th>Kecamatan Kode</th>
                        <th>Nama Kecamatan</th>
                        <th>Kabupaten Kode</th>
                        <th>Nama Kabupaten</th>
                        <th>Foto Kecamatan</th>
                        <th colspan="2"> Aksi </th>
                    </tr>

                    <?php
                    if (isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "SELECT * FROM kecamatann, kabupaten 
                            WHERE kecamatann.kabupaten_KODE = kabupaten.kabupaten_KODE 
                            AND kecamatann.kecamatan_NAMA LIKE '%" . $search . "%' ");
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM kecamatann, kabupaten 
                            WHERE kecamatann.kabupaten_KODE = kabupaten.kabupaten_KODE");
                    }

                    while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['kecamatan_KODE']; ?> </td>
                            <td><?php echo $row['kecamatan_NAMA']; ?> </td>
                            <td><?php echo $row['kabupaten_KODE']; ?> </td>
                            <td><?php echo $row['kabupaten_NAMA']; ?> </td>
                            <td>
                                <?php if ($row['kecamatan_FOTO'] == "") { 
                                    echo "<img src='images/noimage.png' width='88' />"; 
                                } else { ?>
                                    <img src="images/<?php echo $row['kecamatan_FOTO']; ?>" width="88" class="img-responsive" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm" title="EDIT">
                                <i class="bi bi-pencil-square"></i>
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
        </div>
    </div>

    </main>
    <?php include "include/footer.php";?>
            </div>
        </div>
    <?php include "include/jsscript.php";?>
    <script>
        $(document).ready(function() {
            $('#kabupaten_KODE').select2({
                closeOnSelect: true,
                allowClear: true,
                placeholder: 'Pilih Kabupaten'
            });
        });
    </script>
</body>
</html>