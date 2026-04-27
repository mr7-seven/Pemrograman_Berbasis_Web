<?php
header('Content-Type: application/json');
require 'koneksi.php';

$input = json_decode(file_get_contents("php://input"), true);


$id       = $input['id'] ?? null;
$tegangan = $input['tegangan'] ?? null;
$arus     = $input['arus'] ?? null;

if (!$id || !is_numeric($tegangan) || !is_numeric($arus)) {
    echo json_encode(["message" => "Data tidak valid"]);
    exit;
}

$daya = round($tegangan * $arus, 2);

try {
    $stmt = $conn->prepare("
        UPDATE data_sensor_tb 
        SET tegangan = :tegangan,
            arus = :arus,
            daya = :daya
        WHERE id = :id
    ");

    $stmt->execute([
        ':id'       => $id,
        ':tegangan' => $tegangan,
        ':arus'     => $arus,
        ':daya'     => $daya
    ]);

    echo json_encode(["message" => "Data berhasil diupdate"]);

} catch (PDOException $e) {
    echo json_encode([
        "message" => "Gagal update",
        "error" => $e->getMessage()
    ]);
}