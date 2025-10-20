<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapustestimoni']))
{
    $testimoni_KODE = $_GET["hapustestimoni"];
    mysqli_query($conn, "DELETE FROM testimoni
        WHERE testimoni_KODE = '$testimoni_KODE'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='testimoni.php'</script>";
}
?>