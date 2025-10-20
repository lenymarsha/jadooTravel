<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapusberita']))
{
    $berita_KODE = $_GET["hapusberita"];
    mysqli_query($conn, "DELETE FROM berita
        WHERE berita_KODE = '$berita_KODE'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputberita.php'</script>";
}
?>