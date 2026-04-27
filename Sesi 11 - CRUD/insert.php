<?php
header('Content-Type: application/json');
require 'koneksi.php';

// Ambil JSON dari body
$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["message" => "Invalid JSON"]);
    exit;
}

$tegangan = $input['tegangan'] ?? null;
$arus     = $input['arus'] ?? null;

// Validasi
if (!is_numeric($tegangan) || !is_numeric($arus)) {
    echo json_encode(["message" => "Tegangan dan arus harus angka"]);
    exit;
}

// Hitung daya di backend
$daya = $tegangan * $arus;
$daya = round($daya, 2);

// Waktu (opsional: dari server)
$waktu = date("Y-m-d H:i:s");

try {
    $stmt = $conn->prepare("
        INSERT INTO data_sensor_tb (tegangan, arus, daya, waktu)
        VALUES (:tegangan, :arus, :daya, :waktu)
    ");

    $stmt->execute([
        ':tegangan' => $tegangan,
        ':arus'     => $arus,
        ':daya'     => $daya,
        ':waktu'    => $waktu
    ]);

    echo json_encode([
        "message" => "Data berhasil disimpan",
        "data" => [
            "tegangan" => $tegangan,
            "arus" => $arus,
            "daya" => $daya,
            "waktu" => $waktu
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "message" => "Gagal menyimpan data",
        "error" => $e->getMessage()
    ]);
}