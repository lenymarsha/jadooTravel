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
// Memanggil koneksi ke MYSQL
include("include/config.php");

$kategori_ID = $_GET["ubahkategori"];
$query = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_ID = '$kategori_ID'");
$row_edit = mysqli_fetch_array($query);

// Mengecek apakah tombol simpan sudah dipilih/klik atau belum
if (isset($_POST['ubah'])) {
    $kategori_ID = $_POST['inputID'];
    $kategori_NAMA = $_POST['inputNAMA'];
    $kategori_KET = $_POST['inputKETERANGAN'];

    $namafoto = $_FILES['fotokategori']['name'];
    $file_tmp = $_FILES['fotokategori']['tmp_name'];
    $file_size = $_FILES['fotokategori']['size']; // Mendapatkan ukuran file

    // Memeriksa apakah ukuran file lebih dari 2MB
    if ($file_size > 2 * 1024 * 1024) { // 2MB dalam byte
        $error_message = "*Maksimal foto 2MB"; // Pesan kesalahan
    } else {
        // Memindahkan file ke folder images
        move_uploaded_file($file_tmp, 'images/' . $namafoto);

        if ($namafoto == "") {
            mysqli_query($conn, "UPDATE kategori SET kategori_NAMA = '$kategori_NAMA', kategori_KET = '$kategori_KET'
            WHERE kategori_ID = '$kategori_ID'");
        } else {
            mysqli_query($conn, "UPDATE kategori SET kategori_NAMA = '$kategori_NAMA', kategori_KET = '$kategori_KET',
            kategori_FOTO = '$namafoto' WHERE kategori_ID = '$kategori_ID'");
        }
        echo "<script>document.location='inputkategori.php'</script>";
        exit();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kategori Wisata</title>
    <!-- Bootstrap CSS link -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <!-- Membuat form input data kategori -->
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Edit Kategori Wisata</h1>
                <p>Kategori mengenai wisata</p>
                <form method="POST" enctype="multipart/form-data">
                    <!-- Kategori Wisata -->
                    <div class="row mb-3 mt-5">
                        <label for="kategori_ID" class="col-sm-2 col-form-label">Kode Kategori Wisata</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kategori_ID" name="inputID" value="<?php echo $row_edit['kategori_ID']; ?>" readonly>
                        </div>
                    </div>
                    
                    <!-- Nama Kategori Wisata -->
                    <div class="row mb-3">
                        <label for="kategori_NAMA" class="col-sm-2 col-form-label">Nama Kategori Wisata</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kategori_NAMA" name="inputNAMA" value="<?php echo $row_edit['kategori_NAMA']; ?>">
                        </div>
                    </div>

                    <!-- Keterangan Kategori Wisata -->
                    <div class="row mb-3">
                        <label for="kategori_KET" class="col-sm-2 col-form-label">Keterangan Kategori Wisata</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kategori_KET" name ="inputKETERANGAN" value="<?php echo $row_edit['kategori_KET']; ?>">
                        </div>
                    </div>

                    <!-- Input file-->
                    <div class="form-group row mb-3">
                        <label for="file" class="col-sm-2 coll-form-label">Foto Kategori</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="file" name="fotokategori" value="<?php echo $row_edit["kategori_FOTO"]?>">
                            <p class="help-block">Unggah Foto Kategori</p>
                            <?php if (isset($error_message)) { ?>
                                <p class="text-danger"><?php echo $error_message; ?></p> <!-- Menampilkan pesan kesalahan -->
                            <?php } ?>
                        </div>
                    </div>
                    <!-- end input file -->

                    <!-- Submit Button -->
                    <div class="form-group row">  
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-success" value="Update" name="ubah">
                            <input type="reset" class="btn btn-danger" value="Batal">
                        </div>
                    </div>
                    <!-- End submit button -->
                </form>
                <!-- penutup form -->

                <h1>Output Kategori Wisata</h1>

                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Kategori</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                            value="<?php if(isset($_POST["search"])) {echo $_POST["search"];}?>" placeholder="Cari Nama Kategori">
                        </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                    </div>
                </form>
                <!--end-pencarian-data-->

                <table class="table table-striped table-success table-hover mt-5">           
                    <!-- membuat judul -->
                    <tr class="info">
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan Kategori</th>
                        <th>Foto Kategori</th>
                        <th colspan="2"> Aksi </th>
                    </tr>
                    <!-- menampilkan data dari tabel kategori -->
                    <?php { 
                        /** pencarian data */
                        if(isset($_POST["kirim"])) {
                            $search = $_POST["search"];
                            $query = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_NAMA LIKE '%".$search."%'");
                        } else {
                            $query = mysqli_query($conn, "SELECT * FROM kategori");
                        }
                        /** end pencarian data */
                        ?>

                        <?php while ($row = mysqli_fetch_array($query)) { ?>
                            <tr class="danger">
                                <td><?php echo $row['kategori_ID']; ?></td>
                                <td><?php echo $row['kategori_NAMA']; ?></td>
                                <td><?php echo $row['kategori_KET']; ?></td>
                                <td>
                                    <?php if($row['kategori_FOTO'] == "") { echo "<img src='images/noimage.png' width='88'/>"; } else { ?>
                                    <img src="images/<?php echo $row['kategori_FOTO']; ?>" width="88" class="img-responsive" />
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="kategori_edit.php?ubahkategori=<?php echo $row["kategori_ID"]?>" class="btn btn-success btn-sm" title="EDIT">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 ```php
                                        0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </td>
                                <td>
                                    <a href="kategori_hapus.php?hapuskategori=<?php echo $row["kategori_ID"]?>" class="btn btn-danger btn-sm" title="HAPUS">
                                    <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }?>
                </table>
            </div>
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