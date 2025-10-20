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
    $kecamatan_KODE = $_POST['inputKODE'];
    $kecamatan_NAMA = $_POST['inputNAMA'];
    $kabupaten_KODE = $_POST['kabupatenKODE'];

    // Mengambil informasi file
    $namafoto = $_FILES['fotokabupaten']['name'];
    $file_tmp = $_FILES['fotokabupaten']['tmp_name'];
    $file_size = $_FILES['fotokabupaten']['size'];

    // Cek ukuran file (maksimal 2MB)
    if ($file_size > 2097152) { // 2MB = 2 * 1024 * 1024 bytes
        $error_message = "Foto yang Anda unggah lebih dari 2MB.";
    } else {
        // Jika ukuran file sesuai, lanjutkan upload
        move_uploaded_file($file_tmp, 'images/' . $namafoto);

        // Masukkan data ke database dengan foto yang telah diupload
        mysqli_query($conn, "INSERT INTO kecamatann (kecamatan_KODE, kecamatan_NAMA, kabupaten_KODE, kecamatan_FOTO) VALUES ('$kecamatan_KODE', '$kecamatan_NAMA', '$kabupaten_KODE', '$namafoto')");
        echo "<script>document.location='kecamatan.php'</script>";
        exit;
    }
}

// Bagian Pencarian Data
if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kecamatann, kabupaten 
                WHERE kecamatann.kabupaten_KODE = kabupaten.kabupaten_KODE 
                AND kecamatann.kecamatan_NAMA LIKE '%" . $search . "%' ");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kecamatann, kabupaten 
                WHERE kecamatann.kabupaten_KODE = kabupaten.kabupaten_KODE");
}

$datakabupaten = mysqli_query($conn, "SELECT * FROM kabupaten");
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
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Input Kecamatan</h1>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3 mt-5">
                        <label for="kecamatanKODE" class="col-sm-2 col-form-label">Kode Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kecamatanKODE" name="inputKODE" placeholder="Input Kode Kecamatan">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="kecamatanNAMA" class="col-sm-2 col-form-label">Nama Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kecamatanNAMA" name="inputNAMA" placeholder="Input Nama Kecamatan">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kabupatenKODE" class="col-sm-2 col-form-label">Kode Kabupaten</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kabupatenKODE" name="kabupatenKODE">
                                <option value="">Pilih Kode Kabupaten</option>
                                <?php while($row = mysqli_fetch_array($datakabupaten)) { ?>
                                    <option value="<?php echo $row["kabupaten_KODE"]; ?>">
                                        <?php echo $row["kabupaten_KODE"] . " - " . $row["kabupaten_NAMA"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">Foto Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotokabupaten">
                            <p class="help-block">*Ukuran foto maksimal 2MB</p>
                            <?php if ($error_message): ?>
                                <p class="text-danger"><?php echo $error_message; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                        <input type="reset" class="btn btn-danger" value="Batal">
                    </div>
                </form> <br><br>

            <h1>Output Kecamatan</h1>
            <table class="table table-striped table-success table-hover mt-5">
                <form method="POST">

                <!--form pencarian-data-->
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Kecamatan</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" 
                                placeholder="Cari Nama Kecamatan">
                        </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                    </div>
                </form>
                 <!--end-pencarian-data-->

                <tr class="info">
                    <th>Kecamatan Kode</th>
                    <th>Nama Kecamatan</th>
                    <th>Kabupaten Kode</th>
                    <th>Nama Kabupaten</th>
                    <th>Foto Kecamatan</th>
                    <th colspan="2"> Aksi </th>
                </tr>

                <!-- menampilkan data dari tabel kategori -->

                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <tr class="danger">
                        <td><?php echo $row['kecamatan_KODE']; ?> </td>
                        <td><?php echo $row['kecamatan_NAMA']; ?> </td>
                        <td><?php echo $row['kabupaten_KODE']; ?> </td>
                        <td><?php echo $row['kabupaten_NAMA']; ?> </td>
                        <td>
                            <?php if($row['kecamatan_FOTO'] == "") { echo "<img src='images/noimage.png' width='88' />"; } else { ?>
                            <img src="images/<?php echo $row['kecamatan_FOTO']; ?>" width="88" class="img-responsive" />
                            <?php } ?>
                        </td>
                        <td>
                            <a href="kecamatan_edit.php?ubahkecamatan=<?php echo $row["kecamatan_KODE"]?>" class="btn btn-success btn-sm" title="EDIT">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <a href="kecamatan_hapus.php?hapuskecamatan=<?php echo $row["kecamatan_KODE"]?>" class="btn btn-danger btn-sm" title="HAPUS">
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
            $('#kabupatenKODE').select2({
                closeOnSelect: true,
                allowClear: true,
                placeholder: 'Pilih Kabupaten'
            });
        });
    </script>
</body>
</html>
