<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapusdestinasi']))
{
    $destinasi_KODE = $_GET["hapusdestinasi"];
    mysqli_query($conn, "DELETE FROM destinasi
        WHERE destinasi_KODE = '$destinasi_KODE'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='destinasi.php'</script>";
}
?>