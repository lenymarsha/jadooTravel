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

$pengalaman_ID = $_GET["ubahpengalaman"];
$query = mysqli_query($conn, "SELECT * FROM pengalaman WHERE pengalaman_ID = '$pengalaman_ID'");
$row_edit = mysqli_fetch_array($query);
$error_message = ""; // Variable for error messages

// Check if the 'Simpan' button was clicked
if (isset($_POST['ubah'])) {
    $pengalaman_ID = $_POST['inputID'];
    $pengalaman_JUDUL = $_POST['inputJUDUL'];
    $pengalaman_SUBJUDUL = $_POST['inputSUBJUDUL'];
    $pengalaman_KET = $_POST['inputKET'];
    $pengalaman_LINKVIDIO = $_POST['inputLINKVIDIO'];

    // Check if a new file is uploaded
    if (isset($_FILES['fotopengalaman']) && $_FILES['fotopengalaman']['error'] === UPLOAD_ERR_OK) {
        $namafoto = $_FILES['fotopengalaman']['name'];
        $file_tmp = $_FILES['fotopengalaman']['tmp_name'];
        $file_size = $_FILES['fotopengalaman']['size'];

        // Validate file size (max 2MB)
        if ($file_size > 2097152) { // 2MB = 2 * 1024 * 1024 bytes
            $error_message = "Foto yang Anda unggah lebih dari 2MB.";
        } else {
            // Move uploaded file to 'images/' directory
            move_uploaded_file($file_tmp, 'images/' . $namafoto);

            // Update the database with the new photo
            $query = "UPDATE pengalaman SET 
                        pengalaman_JUDUL = '$pengalaman_JUDUL',
                        pengalaman_SUBJUDUL = '$pengalaman_SUBJUDUL',
                        pengalaman_KET = '$pengalaman_KET',
                        pengalaman_LINKVIDIO = '$pengalaman_LINKVIDIO',
                        pengalaman_FOTO = '$namafoto'
                      WHERE pengalaman_ID = '$pengalaman_ID'";
        }
    } else {
        // If no file is uploaded, update other fields only
        $query = "UPDATE pengalaman SET 
                    pengalaman_JUDUL = '$pengalaman_JUDUL',
                    pengalaman_SUBJUDUL = '$pengalaman_SUBJUDUL',
                    pengalaman_KET = '$pengalaman_KET',
                    pengalaman_LINKVIDIO = '$pengalaman_LINKVIDIO' 
                  WHERE pengalaman_ID = '$pengalaman_ID'";
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>document.location='pengalaman.php'</script>";
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pengalaman</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <h1>Edit Data Pengalaman</h1>
            <form method="POST" enctype="multipart/form-data">
                <!-- Pengalaman Kode -->
                <div class="row mb-3 mt-5">
                    <label for="pengalamanID" class="col-sm-2 col-form-label">Kode Pengalaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pengalamanID" name="inputID" value="<?php echo $row_edit["pengalaman_ID"] ?>" readonly>
                    </div>
                </div>

                <!-- Pengalaman Judul -->
                <div class="row mb-3">
                    <label for="pengalamanJUDUL" class="col-sm-2 col-form-label">Judul Pengalaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pengalamanJUDUL" name="inputJUDUL" value="<?php echo $row_edit["pengalaman_JUDUL"] ?>">
                    </div>
                </div>

                <!-- Pengalaman Subjudul -->
                <div class="row mb-3 mt-5">
                    <label for="pengalamanSUBJUDUL" class="col-sm-2 col-form-label">Subjudul Pengalaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pengalamanSUBJUDUL" name="inputSUBJUDUL" value="<?php echo $row_edit["pengalaman_SUBJUDUL"] ?>">
                    </div>
                </div>

                <!-- Pengalaman Nama -->
                <div class="row mb-3">
                    <label for="pengalamanKET" class="col-sm-2 col-form-label">Keterangan Pengalaman</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pengalamanKET" name="inputKET" value="<?php echo $row_edit["pengalaman_KET"] ?>">
                    </div>
                </div>

                <!-- Pengalaman Kota Negara -->
                <div class="row mb-3">
                    <label for="pengalamanLINKVIDIO" class="col-sm-2 col-form-label">Pengalaman Link Video</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pengalamanLINKVIDIO" name="inputLINKVIDIO" value="<?php echo $row_edit["pengalaman_LINKVIDIO"] ?>">
                    </div>
                </div>

                <!-- Foto Pengalaman -->
                <div class="form-group row mb-3">
                    <label for="file" class="col-sm-2 col-form-label">Foto Pengalaman</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file" name="fotopengalaman">
                        <p class="help-block">*Ukuran foto maksimal 2MB</p>
                        <?php if ($error_message): ?>
                            <p class="text-danger"><?php echo $error_message; ?></p> <!-- Tampilkan pesan error jika ada -->
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">  
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success" name="ubah">Update</button>
                        <a href="pengalaman.php" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </form>

            <h1>Output Pengalaman</h1>

            <table class="table table-striped table-success table-hover mt-5">

                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Judul Pengalaman</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" 
                                placeholder="Cari Judul Pengalaman">
                        </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                    </div>
                </form>
                <!--end-pencarian-data-->

                <tr class="info">
                    <th>ID Pengalaman</th>
                    <th>Judul Pengalaman</th>
                    <th>Subjudul Pengalaman</th>
                    <th>Ket Pengalaman</th>
                    <th>Linkvidio Pengalaman</th>
                    <th>Foto Pengalaman</th>
                    <th colspan="2">Aksi</th>
                </tr>

                <?php 
                if(isset($_POST["kirim"])) {
                    $search = mysqli_real_escape_string($conn, $_POST["search"]);
                    $query = mysqli_query($conn, "SELECT * FROM pengalaman WHERE pengalaman_JUDUL LIKE '%$search%'");
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM pengalaman");
                }
                while ($row = mysqli_fetch_array($query)) { ?>
                    <tr class="danger">
                        <td><?php echo $row['pengalaman_ID']; ?></td>
                        <td><?php echo $row['pengalaman_JUDUL']; ?></td>
                        <td><?php echo $row['pengalaman_SUBJUDUL']; ?></td>
                        <td><?php echo $row['pengalaman_KET']; ?></td>
                        <td><?php echo $row['pengalaman_LINKVIDIO']; ?></td>
                        <td>
                            <?php if ($row['pengalaman_FOTO'] == "") {
                                echo "<img src='images/noimage.png' width='88' />";
                            } else { ?>
                                <img src="images/<?php echo $row['pengalaman_FOTO']; ?>" width="88" class="img-responsive" />
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
