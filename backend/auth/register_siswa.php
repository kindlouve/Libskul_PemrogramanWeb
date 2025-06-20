<?php
session_start();
include '../../backend/koneksi.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $nis = $_POST['nis'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $password_plain = $_POST['password'] ?? '';

    if (empty($nama) || empty($nis) || empty($kelas) || empty($password_plain)) {
        $error = "Semua field wajib diisi.";
    } else {
        $cek = $conn->prepare("SELECT id FROM siswa WHERE nis = ?");
        $cek->bind_param("s", $nis);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            $error = "NIS sudah terdaftar.";
        } else {
            $password = password_hash($password_plain, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO siswa (nama, nis, kelas, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $nis, $kelas, $password);
            if ($stmt->execute()) {
                header("Location: ../auth/login.php");
                exit();
            } else {
                $error = "Gagal mendaftar: " . $conn->error;
            }
        }
        $cek->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Registrasi Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-sm flex flex-col items-center">
    <img src="../../img/logo.png" alt="Logo Libskul" class="w-20 h-20 object-contain rounded-full shadow mb-4 border-4 border-gray-200">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Daftar Akun <span class="text-gray-500">Siswa</span></h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-800 p-3 mb-4 w-full rounded text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="w-full">
      <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full p-2 mb-3 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="text" name="nis" placeholder="NIS" class="w-full p-2 mb-3 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="text" name="kelas" placeholder="Kelas" class="w-full p-2 mb-3 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded focus:ring-2 focus:ring-gray-400" required>
      <button type="submit" class="bg-gradient-to-r from-gray-500 to-gray-700 text-white px-4 py-2 rounded-lg w-full hover:from-gray-600 hover:to-gray-800 transition font-semibold text-base shadow">
        Daftar
      </button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
      Sudah punya akun? <a href="login.php" class="text-gray-700 underline hover:text-gray-900">Login di sini</a>
    </p>
  </div>
</body>
</html>

