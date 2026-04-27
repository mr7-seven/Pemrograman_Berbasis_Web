<?php
header('Content-Type: application/json');
require 'koneksi.php';

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["message" => "JSON tidak valid"]);
    exit;
}

$id = $input['id'] ?? null;

if (!$id) {
    echo json_encode(["message" => "ID tidak valid"]);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM data_sensor_tb WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo json_encode(["message" => "Data berhasil dihapus"]);
    exit;

} catch (PDOException $e) {
    echo json_encode(["message" => "Gagal menghapus data"]);
    exit;
}