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

$kabupaten_KODE = $_GET["ubahkabupaten"];
$query = mysqli_query($conn, "SELECT * FROM kabupaten WHERE kabupaten_KODE = '$kabupaten_KODE'");
$row_edit = mysqli_fetch_array($query);

// Mengecek apakah tombol Simpan sudah diklik
if (isset($_POST['ubah'])) {
    $kabupaten_KODE = $_POST['inputKODE'];
    $kabupaten_NAMA = $_POST['inputNAMA'];
    $provinsi_KODE = $_POST['provinsi_KODE'];

    // Mengambil informasi file
    $namafoto = $_FILES['fotokabupaten']['name'];
    $file_tmp = $_FILES['fotokabupaten']['tmp_name'];
    $file_size = $_FILES['fotokabupaten']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah ukuran file lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        // Memindahkan file ke folder images
        move_uploaded_file($file_tmp, 'images/' . $namafoto);

        if ($namafoto == "") {
            $query = mysqli_query($conn, "UPDATE kabupaten SET kabupaten_NAMA = '$kabupaten_NAMA', provinsi_KODE = '$provinsi_KODE'
            WHERE kabupaten_KODE = '$kabupaten_KODE'");
        } else {
            mysqli_query($conn, "UPDATE kabupaten SET kabupaten_NAMA = '$kabupaten_NAMA', provinsi_KODE = '$provinsi_KODE',
            kabupaten_FOTO = '$namafoto' WHERE kabupaten_KODE = '$kabupaten_KODE'");
        }
        echo "<script>document.location='kabupaten.php'</script>";
        exit();
    }
}

$dataprovinsi = mysqli_query($conn, "SELECT * FROM provinsi");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kabupaten</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
</head>

<body>
    <!-- Membuat form input data Kabupaten -->
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Edit Kabupaten</h1>
                <form method="POST" enctype="multipart/form-data">
                    <!-- kode kabupaten -->
                    <div class="row mb-3 mt-5">
                        <label for="kabupatenKODE" class="col-sm-2 col-form-label">Kode Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kabupatenKODE" name="inputKODE" value="<?php echo $row_edit["kabupaten_KODE"] ?>" readonly>
                        </div>
                    </div>
                    <!-- nama kabupaten -->
                    <div class="row mb-3">
                        <label for="kabupatenNAMA" class="col-sm-2 col-form-label">Nama Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kabupatenNAMA" name="inputNAMA" value="<?php echo $row_edit["kabupaten_NAMA"] ?>">
                        </div>
                    </div>

                    <!-- penggunaan select2 -->
                    <div class="row mb-3">
                        <label for="provinsiKODE" class="col-sm-2 col-form-label">Kode Provinsi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="provinsiKODE" name="provinsi_KODE">
                                <option><?php echo $row_edit["provinsi_KODE"] ?></option>
                                <?php if (mysqli_num_rows($dataprovinsi) > 0) { ?>
                                    <?php while ($row = mysqli_fetch_array($dataprovinsi)) { ?>
                                        <option value="<?php echo $row["provinsi_KODE"] ?>">
                                            <?php echo $row["provinsi_KODE"] ?> 
                                            <?php echo $row["provinsi_NAMA"] ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!-- end select 2 -->

                    <!-- Input file dengan keterangan ukuran maksimum -->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotokabupaten">
                            <p class="help-block">*Ukuran foto maksimal 2MB</p>
                            <?php if ($row_edit["kabupaten_FOTO"]) { ?>
                                <img src="images/<?php echo $row_edit["kabupaten_FOTO"]; ?>" width="200" class="img-responsive mt-2">
                            <?php } ?>
                            <?php if (isset($error_message)) { ?>
                                <p class="text-danger"><?php echo $error_message; ?></p> <!-- Menampilkan pesan kesalahan -->
                            <?php } ?>
                        </div>
                    </div>
                    <!-- end input file -->

                    <!-- Submit Button -->
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-success" value="Simpan" name="ubah">
                        <input type="reset" class="btn btn-danger" value="Batal">
                    </div>
                </form> <br><br>

                <h1>Output Kabupaten</h1>
                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Kabupaten</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                   value="<?php if (isset($_POST["search"])) { echo $_POST["search"]; } ?>" 
                                   placeholder="Cari Nama Kabupaten">
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" name="kirim" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form> <br> <br>
                
                <table class="table table-striped table-success table-hover mt-5">
                    <tr class="info">
                        <th>Kabupaten Kode</th>
                        <th>Nama Kabupaten</th>
                        <th>Provinsi Kode</th>
                        <th>Nama Provinsi</th>
                        <th>Foto Kabupaten</th>
                        <th colspan="2"> Aksi </th>
                    </tr>

                    <!-- menampilkan data dari tabel kabupaten -->
                    <?php 
                    if (isset($_POST["kirim"])) {
                        $search = $_POST["search"];
                        $query = mysqli_query($conn, "SELECT * FROM kabupaten, provinsi WHERE kabupaten.provinsi_KODE = provinsi.provinsi_KODE AND (kabupaten.kabupaten_NAMA LIKE '%" . $search . "%' OR provinsi.provinsi_NAMA LIKE '%" . $search . "%')");
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM kabupaten, provinsi WHERE kabupaten.provinsi_KODE = provinsi.provinsi_KODE");
                    }
                    while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $row['kabupaten_KODE']; ?> </td>
                            <td><?php echo $row['kabupaten_NAMA']; ?> </td>
                            <td><?php echo $row['provinsi_KODE']; ?> </td>
                            <td><?php echo $row['provinsi_NAMA']; ?> </td>
                            <td>
                                <?php if ($row['kabupaten_FOTO'] == "") {
                                    echo "<img src='images/noimage.png' width='88' />";
                                } else { ?>
                                    <img src="images/<?php echo $row['kabupaten_FOTO']; ?>" width="88" class="img-responsive" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm" title="EDIT">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
                                         class="bi bi-pencil-square " viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" title="HAPUS"
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
            $('#provinsiKODE').select2({
                closeOnSelect: true,
                allowClear: true,
                placeholder: 'Pilih Provinsi'
            });
        });
    </script>
</body>
</html>