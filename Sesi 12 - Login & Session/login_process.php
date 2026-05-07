<?php

session_start();
header('Content-Type: application/json');
require 'koneksi.php';

try {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Username dan password wajib diisi'
        ]);

        exit;
    }

    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if (!$user) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Username tidak ditemukan'
        ]);

        exit;
    }

    if (!password_verify($password, $user['password'])) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Password salah'
        ]);

        exit;
    }

    $_SESSION['login'] = true;
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Selamat datang ' . $user['username']
    ]);

} catch (Exception $e) {

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
