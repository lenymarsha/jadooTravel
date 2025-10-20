<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapuskabupaten']))
{
    $kabupaten_KODE = $_GET["hapuskabupaten"];
    mysqli_query($conn, "DELETE FROM kabupaten
        WHERE kabupaten_KODE = '$kabupaten_KODE'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='kabupaten.php'</script>";
}
?>