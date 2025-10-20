<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapusprovinsi']))
{
    $provinsi_KODE = $_GET["hapusprovinsi"];
    $query = mysqli_query($conn, "DELETE FROM provinsi WHERE provinsi_KODE = '$provinsi_KODE'");
    if($query){
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='provinsi.php'</script>";
    } else {
        echo "<script>alert('DATA GAGAL DIHAPUS');
        document.location='provinsi.php'</script>";
    }
}
?>