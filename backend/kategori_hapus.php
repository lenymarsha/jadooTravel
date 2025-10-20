<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapuskategori']))
{
    $kategori_ID = $_GET["hapuskategori"];
    $query = mysqli_query($conn, "DELETE FROM kategori WHERE kategori_ID = '$kategori_ID'");
    if($query){
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputkategori.php'</script>";
    } else {
        echo "<script>alert('DATA GAGAL DIHAPUS');
        document.location='inputkategori.php'</script>";
    }
}
?>