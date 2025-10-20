<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tugasakhir";

    // membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // memeriksa koneksi benar atau salah
    if ($conn->connect_error) {
        die("Koneksi failed: " . $conn->connect_error);
    }
?>
