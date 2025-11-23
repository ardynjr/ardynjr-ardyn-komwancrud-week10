<?php
// Detail Koneksi Azure MySQL - Flexible Server Anda
// Server name: ardyn-tugas-crud1-server
// Database name: ardyn-tugas-crud1-database

$host = "ardyn-tugas-crud1-server.mysql.database.azure.com"; 
$username = "glnsktvtfn";
$password = "nAWWwmuh1uSj\$oxR"; // Perhatikan penambahan backslash sebelum $ untuk menghindari kesalahan parsing PHP
$database = "ardyn-tugas-crud1-database";

// Nama file sertifikat SSL Azure. 
// Pastikan Anda telah mengunduh file sertifikat ini (biasanya bernama digicertglobalroot.cer atau BaltimoreCyberTrustRoot.crt.pem)
// dan menempatkannya di direktori yang sama dengan config.php atau memberikan path yang benar.
$ssl_cert = "BaltimoreCyberTrustRoot.crt.pem"; 

// SSL connection untuk Azure MySQL Flexible Server
$conn = mysqli_init();

if (!$conn) {
    die("mysqli_init failed");
}

// Menggunakan path ke sertifikat SSL yang diunduh
// Ganti path/nama file jika berbeda.
mysqli_ssl_set($conn, NULL, NULL, $ssl_cert, NULL, NULL);

// Koneksi ke database
// Perhatikan: Flexible Server default port-nya 3306, tapi pastikan konfigurasi firewall (networking) Anda mengizinkan koneksi.
if (!mysqli_real_connect($conn, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set karakter default ke utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// Opsional: Baris untuk menguji koneksi berhasil
// echo "Koneksi ke Azure MySQL berhasil!"; 
?>
