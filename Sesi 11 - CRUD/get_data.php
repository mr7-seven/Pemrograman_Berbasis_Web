<?php
header('Content-Type: application/json');
require 'koneksi.php';

try {
    $stmt = $conn->query("SELECT id, tegangan, arus, daya, waktu 
                          FROM data_sensor_tb 
                          ORDER BY id DESC");

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {
    echo json_encode([
        "message" => "Gagal ambil data",
        "error" => $e->getMessage()
    ]);
}