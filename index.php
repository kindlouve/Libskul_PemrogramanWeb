<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Libskul - Beranda</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
        <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Libskul</h1>
      </div>
      <div class="space-x-4">
        <a href="katalog.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Katalog</a>
        <a href="tentang.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Tentang</a>
        <a href="backend/auth/login.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Login</a>
      </div>
    </div>
  </nav>

  <section class="container mx-auto flex flex-col items-center justify-center p-8 mt-12">
    <div class="flex flex-col items-center bg-white rounded-xl shadow-lg p-10 max-w-xl w-full">
      <img src="img/logo.png" alt="Logo Libskul" class="w-32 h-32 object-contain rounded-full shadow-lg mb-6 border-4 border-gray-200">
      <h2 class="text-4xl font-bold mb-4 text-gray-800 text-center">Selamat Datang di <span class="text-gray-500">Libskul</span></h2>
      <p class="text-gray-600 mb-8 text-center">Platform peminjaman buku modern untuk siswa sekolah. Temukan dan pinjam buku favoritmu dengan mudah!</p>
      <a href="katalog.php" class="mt-4 inline-block bg-gradient-to-r from-gray-500 to-gray-700 text-white px-8 py-3 rounded-lg shadow hover:from-gray-600 hover:to-gray-800 transition font-semibold text-lg">Lihat Katalog</a>
    </div>
  </section>

  <footer class="mt-16 text-center text-gray-500 text-sm py-4">
    &copy; 2025 Libskul. All rights reserved.
  </footer>
</body>
</html>
