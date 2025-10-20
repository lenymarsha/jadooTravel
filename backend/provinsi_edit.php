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

if (isset($_GET["ubahprovinsi"])) {
    $provinsi_KODE = $_GET["ubahprovinsi"];
    $query = mysqli_query($conn, "SELECT * FROM provinsi WHERE provinsi_KODE = '$provinsi_KODE'");
    $row_edit = mysqli_fetch_array($query);
} else {
    $provinsi_KODE = "";
    $row_edit = ["provinsi_KODE" => "", "provinsi_NAMA" => "", "provinsi_FOTO" => ""];
}

// Memeriksa apakah tombol 'Update' diklik
if (isset($_POST['ubah'])) {
    $provinsi_KODE = $_POST['inputKODE'];
    $provinsi_NAMA = $_POST['inputNAMA'];
    $namafoto = $_FILES['fotoprovinsi']['name'];
    $file_tmp = $_FILES['fotoprovinsi']['tmp_name'];
    $file_size = $_FILES['fotoprovinsi']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah ukuran file lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        move_uploaded_file($file_tmp, 'images/' . $namafoto);

        if ($namafoto == "") {
            mysqli_query($conn, "UPDATE provinsi SET provinsi_NAMA = '$provinsi_NAMA'
            WHERE provinsi_KODE = '$provinsi_KODE'");
        } else {
            mysqli_query($conn, "UPDATE provinsi SET provinsi_NAMA = '$provinsi_NAMA',
            provinsi_FOTO = '$namafoto' WHERE provinsi_KODE = '$provinsi_KODE'");
        }

        echo "<script>document.location='provinsi.php'</script>";
        exit();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Provinsi</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <h1>Edit Provinsi</h1>
            <form method="POST" enctype="multipart/form-data">
                <!-- Provinsi Kode -->
                <div class="row mb-3 mt-5">
                    <label for="provinsiKODE" class="col-sm-2 col-form-label">Kode Provinsi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="provinsiKODE" name="inputKODE" 
                            value="<?php echo isset($row_edit['provinsi_KODE']) ? $row_edit['provinsi_KODE'] : ''; ?>" readonly>
                    </div>
                </div>

                <!-- Provinsi Name -->
                <div class="row mb-3">
                    <label for="provinsiNAMA" class="col-sm-2 col-form-label">Nama Provinsi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="provinsiNAMA" name="inputNAMA" 
                            value="<?php echo isset($row_edit['provinsi_NAMA']) ? $row_edit['provinsi_NAMA'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Foto Provinsi -->
                <div class="form-group row mb-3">
                    <label for="file" class="col-sm-2 col-form-label">Foto Provinsi</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file" name="fotoprovinsi">
                        <p class="help-block">Unggah Foto Provinsi</p>
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
            </form> <br>

            <h1>Output Provinsi</h1>

            <!--form pencarian-data-->
            <form method="POST">
                <div class="form-group row mt-5">
                    <label for="search" class="col-sm-2">Cari Nama Provinsi</label>
                    <div class="col-sm-6">
                        <input type="text" name="search" class="form-control" id="search"
                        value="<?php if(isset($_POST["search"])) {echo $_POST["search"];} ?>" 
                        placeholder="Cari Nama Provinsi">
                    </div>
                    <div class="col-sm-1">
                        <button type="submit" name="kirim" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-success table-hover mt-5">
                <tr class="info">
                    <th>Kode Provinsi</th>
                    <th>Nama Provinsi</th>
                    <th>Foto Provinsi</th>
                    <th colspan="2">Aksi</th>
                </tr>

                <?php
                if(isset($_POST["kirim"])) {
                    $search = mysqli_real_escape_string($conn, $_POST["search"]);
                    $query = mysqli_query($conn, "SELECT * FROM provinsi WHERE provinsi_NAMA LIKE '%$search%'");
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM provinsi");
                }

                while ($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['provinsi_KODE']); ?></td>
                        <td><?php echo htmlspecialchars($row['provinsi_NAMA']); ?></td>
                        <td>
                            <?php if (empty($row['provinsi_FOTO'])) { ?>
                                <img src="images/noimage.png" width="88" alt="No Image" />
                            <?php } else { ?>
                                <img src="images/<?php echo htmlspecialchars($row['provinsi_FOTO']); ?>" width="88" class="img-responsive" alt="Province Image" />
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
</body>
</html>