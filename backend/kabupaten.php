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

$error_message = ""; // Variabel untuk pesan error

// Mengecek apakah tombol Simpan sudah diklik
if (isset($_POST['Simpan'])) {
    $kabupaten_KODE = $_POST['inputKODE'];
    $kabupaten_NAMA = $_POST['inputNAMA'];
    $provinsi_KODE = $_POST['provinsi_KODE']; 

    // Mengambil informasi file
    $namafoto = $_FILES['fotokabupaten']['name'];
    $file_tmp = $_FILES['fotokabupaten']['tmp_name'];
    $file_size = $_FILES['fotokabupaten']['size'];

    // Cek ukuran file (maksimal 2MB)
    if ($file_size > 2097152) { // 2MB = 2 * 1024 * 1024 bytes
        $error_message = "Foto yang Anda unggah lebih dari 2MB.";
    } else {
        // Jika ukuran file sesuai, lanjutkan upload
        move_uploaded_file($file_tmp, 'images/'.$namafoto);

        // Masukkan data ke database dengan foto yang telah diupload
        mysqli_query($conn, "INSERT INTO kabupaten (kabupaten_KODE, kabupaten_NAMA, provinsi_KODE, kabupaten_FOTO) VALUES ('$kabupaten_KODE', '$kabupaten_NAMA', '$provinsi_KODE', '$namafoto')");
        echo "<script>document.location='kabupaten.php'</script>";
        exit;
    }
}

    // Bagian Pencarian Data
    if(isset($_POST["kirim"])) {
        $search = $_POST["search"];
        $query = mysqli_query($conn, "SELECT * FROM kabupaten, provinsi WHERE kabupaten.provinsi_KODE = provinsi.provinsi_KODE AND (kabupaten.kabupaten_NAMA LIKE '%".$search."%' OR provinsi.provinsi_NAMA LIKE '%".$search."%')");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM kabupaten, provinsi WHERE kabupaten.provinsi_KODE = provinsi.provinsi_KODE");
    }

    $dataprovinsi = mysqli_query($conn, "SELECT * FROM provinsi");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kategori Wisata</title>
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
                <h1>Input Kabupaten</h1>
                <form method="POST" enctype="multipart/form-data">
                    <!-- Kabupaten Kode -->
                    <div class="row mb-3 mt-5">
                        <label for="kabupatenKODE" class="col-sm-2 col-form-label">Kode Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kabupatenKODE" name="inputKODE" placeholder="Masukkan Kode Kabupaten">
                        </div>
                    </div>
                    
                    <!-- Nama Kabupaten Wisata -->
                    <div class="row mb-3">
                        <label for="kabupatenNAMA" class="col-sm-2 col-form-label">Nama Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kabupatenNAMA" name="inputNAMA" placeholder="Masukkan Nama Kabupaten">
                        </div>
                    </div>

                    <!-- penggunaan select2 -->
                    <div class="row mb-3">
                        <label for="provinsiKODE" class="col-sm-2 col-form-label">Kode Provinsi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="provinsiKODE" name="provinsi_KODE">
                                <option>Pilih Kode Provinsi</option>
                                <?php while($row = mysqli_fetch_array($dataprovinsi)) { ?>
                                    <option value="<?php echo $row["provinsi_KODE"]; ?>">
                                        <?php echo $row["provinsi_KODE"] . " - " . $row["provinsi_NAMA"]; ?>
                                    </option>
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
                            <?php if ($error_message): ?>
                                <p class="text-danger"><?php echo $error_message; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- end input file -->

                    <!-- Submit Button -->
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                        <input type="reset" class="btn btn-danger" value="Batal">
                    </div>
                </form> <br><br>

                <h1>Output Kabupaten</h1>
                
                <table class="table table-striped table-success table-hover mt-5">
                    <!--form pencarian-data-->
                    <form method="POST">
                        <div class="form-group row mt-5">
                            <label for="search" class="col-sm-2">Cari Nama Kabupaten</label>
                            <div class="col-sm-6">
                                <input type="text" name="search" class="form-control" id="search"
                                    value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" 
                                    placeholder="Cari Nama Kabupaten">
                            </div>
                            <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                        </div>
                    </form>
                    <!--end-pencarian-data-->

                    <tr class="info">
                        <th>Kabupaten Kode</th>
                        <th>Nama Kabupaten</th>
                        <th>Provinsi Kode</th>
                        <th>Nama Provinsi</th>
                        <th>Foto Kabupaten</th>
                        <th colspan="2"> Aksi </th>
                    </tr>

                    <!-- menampilkan data dari tabel kategori -->
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr class="danger">
                            <td><?php echo $row['kabupaten_KODE']; ?> </td>
                            <td><?php echo $row['kabupaten_NAMA']; ?> </td>
                            <td><?php echo $row['provinsi_KODE']; ?> </td>
                            <td><?php echo $row['provinsi_NAMA']; ?> </td>
                            <td>
                                <?php if($row['kabupaten_FOTO']==""){echo "<img src='images/noimage.png' width='88' />";} else {?>
                                <img src="images/<?php echo $row['kabupaten_FOTO']; ?>" width="88" class="img-responsive" />
                                <?php }?>
                            </td>
                            <td>
                                <a href="kabupaten_edit.php?ubahkabupaten=<?php echo $row["kabupaten_KODE"]?>" class="btn btn-success btn-sm" title="EDIT">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="kabupaten_hapus.php?hapuskabupaten=<?php echo $row["kabupaten_KODE"]?>" class="btn btn-danger btn-sm" title="HAPUS">
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
