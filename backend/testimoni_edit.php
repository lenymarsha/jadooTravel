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

$testimoni_KODE = $_GET["ubahtestimoni"];
$query = mysqli_query($conn, "SELECT * FROM testimoni WHERE testimoni_KODE = '$testimoni_KODE'");
$row_edit = mysqli_fetch_array($query);
$error_message = ""; // Variable for error messages

// Check if the 'Simpan' button was clicked
if (isset($_POST['ubah'])) {
    $testimoni_KODE = $_POST['inputKODE'];
    $testimoni_JUDUL = $_POST['inputJUDUL'];
    $testimoni_ISI = $_POST['inputISI'];
    $testimoni_NAMA = $_POST['inputNAMA'];
    $testimoni_KOTANEGARA = $_POST['inputKOTANEGARA'];

    // Check if a new file is uploaded
    if (isset($_FILES['fototestimoni']) && $_FILES['fototestimoni']['error'] === UPLOAD_ERR_OK) {
        $namafoto = $_FILES['fototestimoni']['name'];
        $file_tmp = $_FILES['fototestimoni']['tmp_name'];
        $file_size = $_FILES['fototestimoni']['size'];

        // Validate file size (max 2MB)
        if ($file_size > 2097152) { // 2MB = 2 * 1024 * 1024 bytes
            $error_message = "Foto yang Anda unggah lebih dari 2MB.";
        } else {
            // Move uploaded file to 'images/' directory
            move_uploaded_file($file_tmp, 'images/' . $namafoto);

            // Update the database with the new photo
            $query = "UPDATE testimoni SET 
                        testimoni_JUDUL = '$testimoni_JUDUL',
                        testimoni_FOTO = '$namafoto',
                        testimoni_ISI = '$testimoni_ISI',
                        testimoni_NAMA = '$testimoni_NAMA',
                        testimoni_KOTANEGARA = '$testimoni_KOTANEGARA' 
                      WHERE testimoni_KODE = '$testimoni_KODE'";
        }
    } else {
        // If no file is uploaded, update other fields only
        $query = "UPDATE testimoni SET 
                    testimoni_JUDUL = '$testimoni_JUDUL',
                    testimoni_ISI = '$testimoni_ISI',
                    testimoni_NAMA = '$testimoni_NAMA',
                    testimoni_KOTANEGARA = '$testimoni_KOTANEGARA' 
                  WHERE testimoni_KODE = '$testimoni_KODE'";
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "<script>document.location='testimoni.php'</script>";
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Testimoni</title>
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
            <h1>Edit Data Testimoni</h1>
            <form method="POST" enctype="multipart/form-data">
                <!-- Testimoni Kode -->
                <div class="row mb-3 mt-5">
                    <label for="testimoniKODE" class="col-sm-2 col-form-label">Kode Testimoni</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="testimoniKODE" name="inputKODE" 
                        value="<?php echo isset($row_edit['testimoni_KODE']) ? $row_edit['testimoni_KODE'] : ''; ?>" readonly>
                    </div>
                </div>

                <!-- Testimoni Judul -->
                <div class="row mb-3">
                    <label for="testimoniJUDUL" class="col-sm-2 col-form-label">Nama Testimoni</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="testimoniJUDUL" name="inputJUDUL" 
                        value="<?php echo isset($row_edit['testimoni_JUDUL']) ? $row_edit['testimoni_JUDUL'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Foto Testimoni -->
                <div class="form-group row mb-3">
                    <label for="file" class="col-sm-2 col-form-label">Foto Testimoni</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="file" name="fototestimoni">
                        <p class="help-block">*Ukuran foto maksimal 2MB</p>
                        <?php if ($error_message): ?>
                            <p class="text-danger"><?php echo $error_message; ?></p> <!-- Tampilkan pesan error jika ada -->
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Testimoni Isi -->
                <div class="row mb-3 mt-5">
                    <label for="testimoniISI" class="col-sm-2 col-form-label">Isi Testimoni</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="testimoniISI" name="inputISI" 
                        value="<?php echo isset($row_edit['testimoni_ISI']) ? $row_edit['testimoni_ISI'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Testimoni Nama -->
                <div class="row mb-3">
                    <label for="testimoniNAMA" class="col-sm-2 col-form-label">Nama Testimoni</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="testimoniNAMA" name="inputNAMA" 
                        value="<?php echo isset($row_edit['testimoni_NAMA']) ? $row_edit['testimoni_NAMA'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Testimoni Kota Negara -->
                <div class="row mb-3">
                    <label for="testimoniKOTANEGARA" class="col-sm-2 col-form-label">Testimoni Kota Negara</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="testimoniKOTANEGARA" name="inputKOTANEGARA" 
                        value="<?php echo isset($row_edit['testimoni_KOTANEGARA']) ? $row_edit['testimoni_KOTANEGARA'] : ''; ?>" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">  
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success" name="ubah">Update</button>
                        <a href="testimoni.php" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </form>

            <h1>Output Testimoni</h1>

            <table class="table table-striped table-success table-hover mt-5">

                <!--form pencarian-data-->
                <form method="POST">
                    <div class="form-group row mt-5">
                        <label for="search" class="col-sm-2">Cari Nama Testimoni</label>
                        <div class="col-sm-6">
                            <input type="text" name="search" class="form-control" id="search"
                                value="<?php if(isset($_POST['search'])) {echo $_POST['search'];} ?>" 
                                placeholder="Cari Nama Testimoni">
                        </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                    </div>
                </form>
                <!--end-pencarian-data-->

                <tr class="info">
                    <th>Kode Testimoni</th>
                    <th>Judul Testimoni</th>
                    <th>Foto Testimoni</th>
                    <th>Isi Testimoni</th>
                    <th>Nama Testimoni</th>
                    <th>Kota Negara Testimoni</th>
                    <th colspan="2">Aksi</th>
                </tr>

                <?php 
                if(isset($_POST["kirim"])) {
                    $search = mysqli_real_escape_string($conn, $_POST["search"]);
                    $query = mysqli_query($conn, "SELECT * FROM testimoni WHERE testimoni_NAMA LIKE '%$search%'");
                } else {
                    $query = mysqli_query($conn, "SELECT * FROM testimoni");
                }
                while ($row = mysqli_fetch_array($query)) { ?>
                    <tr class="danger">
                        <td><?php echo $row['testimoni_KODE']; ?></td>
                        <td><?php echo $row['testimoni_JUDUL']; ?></td>
                        <td>
                            <?php if ($row['testimoni_FOTO'] == "") {
                                echo "<img src='images/noimage.png' width='88' />";
                            } else { ?>
                                <img src="images/<?php echo $row['testimoni_FOTO']; ?>" width="88" class="img-responsive" />
                            <?php } ?>
                        </td>
                        <td><?php echo $row['testimoni_ISI']; ?></td>
                        <td><?php echo $row['testimoni_NAMA']; ?></td>
                        <td><?php echo $row['testimoni_KOTANEGARA']; ?></td>
                        
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
