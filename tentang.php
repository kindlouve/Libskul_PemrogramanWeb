<?php
session_start();

$beranda_link = isset($_SESSION['siswa_id']) ? 'dashboard_user.php' : 'index.php';

$extra_buttons = '';
if (isset($_SESSION['siswa_id'])) {
    $extra_buttons .= '<a href="katalog.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Katalog</a>';
    $extra_buttons .= '<a href="riwayat.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Riwayat</a>';
}

// tombol login/logout
$auth_button = isset($_SESSION['siswa_id']) 
  ? '<a href="backend/auth/logout.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Logout</a>'
  : '<a href="backend/auth/login.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Login</a>';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tentang</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">

<!--Navbar-->
<nav class="bg-white shadow-md p-4">
  <div class="container mx-auto flex justify-between items-center">
    <div class="flex items-center space-x-3">
      <img src="img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Libskul</h1>
    </div>
    <div class="space-x-4">
      <a href="<?= $beranda_link ?>" class="text-gray-700 hover:text-gray-900 font-medium transition">Beranda</a>
      <?= $extra_buttons ?>
      <?= $auth_button ?>
    </div>
  </div>
</nav>

<main class="container mx-auto flex flex-col items-center justify-center p-8 mt-12">
  <div class="bg-white rounded-xl shadow-lg p-10 max-w-xl w-full flex flex-col items-center">
    <img src="img/logo.png" alt="Logo Libskul" class="w-24 h-24 object-contain rounded-full shadow-lg mb-6 border-4 border-gray-200">
    <h2 class="text-3xl font-bold mb-4 text-gray-800 text-center">Tentang <span class="text-gray-500">Libskul</span></h2>
    <p class="text-gray-600 text-center mb-2">
      Libskul adalah sistem perpustakaan digital yang dibuat untuk memudahkan siswa dalam mencari dan meminjam buku secara online.
    </p>
    <p class="text-gray-500 text-center">
      Dibangun dengan cinta dan teknologi untuk mendukung literasi di lingkungan sekolah.
    </p>
  </div>
</main>

</body>
</html>
