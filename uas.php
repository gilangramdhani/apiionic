<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "config.php";

function generateRandomPassword($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

$randomPassword = generateRandomPassword();
$status = 0;

if (
    isset($_POST['nama_lengkap'], $_POST['jenis_kelamin'], $_POST['no_handphone'], $_POST['email'],
           $_POST['asal_sekolah'], $_POST['program_studi'], $_POST['jenjang'], $_POST['kelas'], $_POST['info_kampus'])
) {
    $insert = mysqli_query($kon, "INSERT INTO pendaftaran (
        `kd_reg`, `nama_lengkap`, `jenis_kelamin`, `no_handphone`, `email`, `asal_sekolah`, `program_studi`, `jenjang`, `kelas`, `info_kampus`, `pass`, `status`)
            VALUES (
            '',
            '$_POST[nama_lengkap]',
            '$_POST[jenis_kelamin]',
            '$_POST[no_handphone]',
            '$_POST[email]',
            '$_POST[asal_sekolah]',
            '$_POST[program_studi]',  -- Fix the column name here
            '$_POST[jenjang]',
            '$_POST[kelas]',
            '$_POST[info_kampus]',
            '$randomPassword',
            '$status')");

    if ($insert) {
        $result = json_encode(array('error' => false, 'msg' => 'Data berhasil disimpan'));
    } else {
        $result = json_encode(array('error' => true, 'msg' => 'Data gagal disimpan: ' . mysqli_error($kon)));
    }
} else {
    $result = json_encode(array('error' => true, 'msg' => 'Form fields are missing or not set in $_POST'));
}

echo $result;
?>
