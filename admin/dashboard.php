<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">
  <nav class="bg-white shadow-md p-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="../img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
        <h1 class="font-extrabold text-2xl text-gray-800 tracking-wide">Libskul Admin</h1>
      </div>
      <div class="space-x-4">
        <a href="buku.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Buku</a>
        <a href="siswa.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Siswa</a>
        <a href="laporan.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Laporan</a>
        <a href="../backend/auth/logout.php" class="text-red-500 hover:text-red-700 font-medium transition">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container mx-auto flex flex-col items-center justify-center p-8 mt-16">
    <div class="bg-white rounded-xl shadow-lg p-10 max-w-lg w-full flex flex-col items-center">
      <img src="../img/logo.png" alt="Logo Libskul" class="w-24 h-24 object-contain rounded-full shadow-lg mb-6 border-4 border-gray-200">
      <h2 class="text-2xl font-bold mb-2 text-gray-800 text-center">Selamat Datang, <?= htmlspecialchars($_SESSION['admin']) ?></h2>
      <p class="text-gray-600 text-center mb-2">Gunakan menu di atas untuk mengelola data buku, siswa, dan laporan perpustakaan sekolah.</p>
    </div>
  </main>
</body>
</html>
