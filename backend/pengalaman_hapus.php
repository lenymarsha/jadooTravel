<?php 
// memanggil koneksi ke MYSQL
include "include/config.php";
if(isset($_GET['hapuspengalaman']))
{
    $pengalaman_ID = $_GET["hapuspengalaman"];
    mysqli_query($conn, "DELETE FROM pengalaman
        WHERE pengalaman_ID = '$pengalaman_ID'");
    echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='pengalaman.php'</script>";
}
?>