<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapuskecamatan']))
{
    $kecamatan_KODE = $_GET["hapuskecamatan"];
    mysqli_query($conn, "DELETE FROM kecamatann
        WHERE kecamatan_KODE = '$kecamatan_KODE'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='kecamatan.php'</script>";
}
?>