<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'app_local');
define('DB_USER', 'root');
define('DB_PASS', '');
date_default_timezone_set('Asia/Makassar');

try{
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

    $conn = new PDO($dsn, DB_USER, DB_PASS);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Koneksi Berhasil";

}
catch(PDOException $e){
  die("Koneksi Gagal: ". $e->getMessage());
}