<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "config.php";
$data = array();
$reg = "REG20240"; 
$no = 1; 

$query = mysqli_query($conn, "SELECT `kd_reg`, `pass`, `nama_lengkap` AS `nama`, `status` FROM pendaftaran");

if (!$query) {
    // Jika query gagal, tampilkan pesan kesalahan
    $result = json_encode(array('success' => false, 'error' => mysqli_error($conn)));
} else {
    // Jika query berhasil, ambil data
    while ($rows = mysqli_fetch_array($query)) {
        // Mengonversi nilai status menjadi teks
        $statusText = ($rows['status'] == 0) ? 'Menunggu Verifikasi Pendaftaran' : 'Verifikasi Pendaftaran OK.';

        $data[] = array(
            'no' => $no, 
            'kd_reg' => $reg . $rows['kd_reg'],
            'pass' => $rows['pass'],
            'nama' => $rows['nama'],
            'status' => $statusText
        );
        $no++;
    }

    // Jika data berhasil diambil
    $result = json_encode(array('success' => true, 'result' => $data));
}

echo $result;
?>
