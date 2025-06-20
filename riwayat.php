<?php
session_start();
require_once __DIR__ . '/backend/koneksi.php';

if (!isset($_SESSION['siswa_id'])) {
    header("Location: backend/auth/login.php");
    exit;
}

$siswa_id = $_SESSION['siswa_id'];

$conn->query("
    UPDATE peminjaman
    SET status = 'terlambat'
    WHERE siswa_id = $siswa_id 
      AND status = 'dipinjam'
      AND tanggal_kembali < CURDATE()
");

$query = $conn->query("
  SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
  FROM peminjaman p
  JOIN buku b ON p.buku_id = b.id
  WHERE p.siswa_id = $siswa_id
  ORDER BY p.tanggal_pinjam DESC
");

$beranda_link = 'dashboard_user.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Riwayat Peminjaman</title>
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
      <a href="backend/auth/logout.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Logout</a>
    </div>
  </div>
</nav>

<main class="container mx-auto p-8 mt-10">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">📖 Riwayat Peminjaman Buku</h2>

  <?php if ($query->num_rows > 0): ?>
    <div class="overflow-x-auto">
      <table class="w-full table-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
          <tr>
            <th class="p-3 border">Judul Buku</th>
            <th class="p-3 border">Tanggal Pinjam</th>
            <th class="p-3 border">Tanggal Kembali</th>
            <th class="p-3 border">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $query->fetch_assoc()): ?>
          <tr class="text-center text-sm">
            <td class="p-2 border"><?= htmlspecialchars($row['judul']) ?></td>
            <td class="p-2 border"><?= date('d-m-Y', strtotime($row['tanggal_pinjam'])) ?></td>
            <td class="p-2 border"><?= $row['tanggal_kembali'] ? date('d-m-Y', strtotime($row['tanggal_kembali'])) : '-' ?></td>
            <td class="p-2 border font-semibold 
              <?php
                if ($row['status'] == 'terlambat') echo 'text-red-600';
                elseif ($row['status'] == 'dipinjam') echo 'text-yellow-600';
                else echo 'text-green-600';
              ?>">
              <?php
                if ($row['status'] == 'terlambat') echo 'Terlambat';
                elseif ($row['status'] == 'dipinjam') echo 'Belum Dikembalikan';
                else echo 'Dikembalikan';
              ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500 mt-6">Belum ada buku yang dipinjam.</p>
  <?php endif; ?>
</main>

</body>
</html>