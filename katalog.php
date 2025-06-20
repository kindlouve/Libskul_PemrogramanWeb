<?php
session_start();
require_once __DIR__ . '/backend/koneksi.php'; 

$beranda_link = isset($_SESSION['siswa_id']) ? 'dashboard_user.php' : 'index.php';
$query = mysqli_query($conn, "SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Katalog Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">

<!--Navbar-->
<nav class="bg-white shadow-md p-4 sticky top-0 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <div class="flex items-center space-x-3">
      <img src="img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
      <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Libskul</h1>
    </div>
    <div class="space-x-4">
      <a href="<?= $beranda_link ?>" class="text-gray-700 hover:text-gray-900 font-medium transition">Beranda</a>
      <a href="tentang.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Tentang</a>

      <?php if (isset($_SESSION['siswa_id'])): ?>
        <a href="riwayat.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Riwayat</a>
        <a href="backend/auth/logout.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Logout</a>
      <?php else: ?>
        <a href="backend/auth/login.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<main class="container mx-auto p-8 mt-10">
  <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Katalog Buku</h2>

  <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil') : ?>
    <div class="mb-6 text-center text-green-700 font-semibold" id="notif">Peminjaman berhasil!</div>
    <script>
      setTimeout(() => {
        const popup = document.getElementById('notif');
        if (popup) popup.style.display = 'none';
      }, 7000);
    </script>
  <?php endif; ?>

  <div class="flex flex-wrap gap-6 justify-center">
    <?php while ($buku = mysqli_fetch_assoc($query)) : ?>
      <div class="bg-white rounded-xl shadow-lg p-5 flex flex-col items-center hover:shadow-2xl transition w-56 text-center">
        <div class="w-full aspect-[2/3] mb-4 rounded-lg shadow overflow-hidden bg-gray-100">
          <img src="uploads/<?= htmlspecialchars($buku['gambar']) ?>" alt="Cover <?= htmlspecialchars($buku['judul']) ?>" class="object-cover w-full h-full" />
        </div>
        <h3 class="font-semibold text-lg text-gray-800 mb-1"><?= htmlspecialchars($buku['judul']) ?></h3>
        <p class="text-sm text-gray-500 mb-1"><?= htmlspecialchars($buku['penulis']) ?></p>
        <p class="text-xs text-gray-400 mb-1">Penerbit: <?= htmlspecialchars($buku['penerbit']) ?></p>
        <p class="text-xs text-gray-400 mb-3">Tahun: <?= htmlspecialchars($buku['tahun']) ?></p>

    <!--Tombol Pinjam-->
        <?php if (isset($_SESSION['siswa_id'])) : ?>
          <form action="backend/peminjaman/pinjam.php" method="POST" class="w-full text-center mt-2" onsubmit="return konfirmasiPinjam()">
            <input type="hidden" name="buku_id" value="<?= $buku['id'] ?>">
            <button type="submit" class="bg-gradient-to-r from-gray-500 to-gray-700 text-white px-6 py-2 rounded-lg shadow hover:from-gray-600 hover:to-gray-800 transition font-semibold text-base">
              Pinjam
            </button>
          </form>
        <?php else : ?>
          <p class="text-red-500 text-sm mt-3">Login untuk meminjam</p>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<!--Footer-->
<footer class="mt-16 text-center text-gray-500 text-sm py-4">
  &copy; 2025 Libskul. All rights reserved.
</footer>

<!--js konfirmasi-->
<script>
function konfirmasiPinjam() {
  return confirm("Apakah Anda yakin ingin meminjam buku ini?");
}
</script>

</body>
</html>