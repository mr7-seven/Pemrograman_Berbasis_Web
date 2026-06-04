<?php
header('Content-Type: application/json');
require 'koneksi.php';

$draw   = $_GET['draw'];
$start  = $_GET['start'];
$length = $_GET['length'];
$search = $_GET['search']['value'];

try {

    // 1. TOTAL DATA
    $stmtTotal = $conn->query("SELECT COUNT(*) FROM data_sensor_tb");
    $recordsTotal = $stmtTotal->fetchColumn();

    // 2. BASE QUERY
    $baseQuery = "FROM data_sensor_tb WHERE 1=1";

    $params = [];

    // 3. SEARCH 
    if (!empty($search)) {
        $baseQuery .= " AND (
            id LIKE :search OR
            tegangan LIKE :search OR
            arus LIKE :search OR
            daya LIKE :search
        )";
        $params[':search'] = "%$search%";
    }

    // 4. COUNT FILTERED 
    $stmtFiltered = $conn->prepare("SELECT COUNT(*) " . $baseQuery);
    $stmtFiltered->execute($params);
    $recordsFiltered = $stmtFiltered->fetchColumn();

    // 5. DATA QUERY 
    $dataQuery = "SELECT id, tegangan, arus, daya, waktu "
               . $baseQuery
               . " ORDER BY id DESC
                  LIMIT :start, :length";

    $stmt = $conn->prepare($dataQuery);

    // bind search
    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }

    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 6. RESPONSE FORMAT DATATABLES
    echo json_encode([
        "draw" => intval($draw),
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data" => $data
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}