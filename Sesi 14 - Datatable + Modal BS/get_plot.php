<?php
header('Content-Type: application/json');
require 'koneksi.php';

$allowed = [
    'tegangan',
    'arus',
    'daya',
    'frekuensi'
];

$parameter =
    $_GET['parameter'] ?? '';

if (!in_array($parameter, $allowed)) {

    http_response_code(400);

    echo json_encode([
        'message' => 'Parameter tidak valid'
    ]);

    exit;
}

try {

    $stmt = $conn->query("
        SELECT
            waktu,
            $parameter AS nilai
        FROM data_sensor_tb
        ORDER BY id DESC
        LIMIT 50
    ");

    $data =
        array_reverse(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );

    echo json_encode($data);

} catch (PDOException $e) {

    echo json_encode([
        'message' => 'Gagal ambil data',
        'error' => $e->getMessage()
    ]);
}