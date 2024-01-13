<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include "config.php";

// Ambil data dari frontend (Angular)
$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    // Tambahkan pesan kesalahan jika data tidak dapat diuraikan
    echo json_encode(array('status' => 'error', 'message' => 'Data tidak valid'));
    exit;
}

// Escape string untuk mencegah SQL Injection
$username = $conn->real_escape_string($data->username);
$password = $conn->real_escape_string($data->password);

// Query untuk melakukan login (contoh tabel: users)
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($query);

// Periksa apakah login berhasil
if ($result->num_rows > 0) {
    echo json_encode(array('status' => 'success', 'message' => 'Login berhasil'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Login gagal'));
}


// Tutup koneksi
$conn->close();
?>
