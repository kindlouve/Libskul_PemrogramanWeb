<?php
include '../backend/koneksi.php';

$conn->query("
  UPDATE peminjaman
  SET status = 'terlambat'
  WHERE status = 'dipinjam'
    AND tanggal_kembali < CURDATE()
");

// Ambil data peminjaman
$sql = "SELECT 
            p.id, 
            s.nama AS nama_siswa, 
            b.judul AS judul_buku, 
            p.tanggal_pinjam, 
            p.tanggal_kembali, 
            p.status 
        FROM peminjaman p 
        JOIN siswa s ON p.siswa_id = s.id 
        JOIN buku b ON p.buku_id = b.id
        ORDER BY p.tanggal_pinjam DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Laporan Peminjaman</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">

<?php if (isset($_GET['status']) && $_GET['status'] == 'returned'): ?>
  <div class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
    ✅ Buku berhasil dikembalikan!
  </div>
  <script>
    setTimeout(() => {
      document.querySelector('.fixed.top-6').style.display = 'none';
    }, 5000);
  </script>
<?php endif; ?>

<nav class="bg-white shadow-md p-4 sticky top-0 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <div class="flex items-center space-x-3">
      <img src="../img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
      <h1 class="font-extrabold text-2xl text-gray-800 tracking-wide">Libskul Admin</h1>
    </div>
    <a href="dashboard.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Kembali</a>
  </div>
</nav>

<main class="container mx-auto p-8 mt-10">
  <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Laporan Peminjaman</h2>
  <div class="overflow-x-auto">
    <table class="w-full table-auto bg-white rounded-xl shadow-lg overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 border">Nama Siswa</th>
          <th class="p-2 border">Judul Buku</th>
          <th class="p-2 border">Tanggal Pinjam</th>
          <th class="p-2 border">Tanggal Kembali</th>
          <th class="p-2 border">Status</th>
          <th class="p-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="text-center">
              <td class="p-2 border"><?= htmlspecialchars($row['nama_siswa']) ?></td>
              <td class="p-2 border"><?= htmlspecialchars($row['judul_buku']) ?></td>
              <td class="p-2 border"><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
              <td class="p-2 border">
                <?= $row['tanggal_kembali'] ? htmlspecialchars($row['tanggal_kembali']) : '-' ?>
              </td>
              <td class="p-2 border font-semibold 
                <?php
                  if ($row['status'] === 'dikembalikan') echo 'text-green-600';
                  elseif ($row['status'] === 'terlambat') echo 'text-red-600';
                  else echo 'text-yellow-600';
                ?>">
                <?php
                  if ($row['status'] === 'dikembalikan') echo 'Dikembalikan';
                  elseif ($row['status'] === 'terlambat') echo 'Terlambat';
                  else echo 'Belum Dikembalikan';
                ?>
              </td>
              <td class="p-2 border text-center">
                <?php if ($row['status'] === 'dipinjam' || $row['status'] === 'terlambat'): ?>
                  <form method="post" action="../backend/peminjaman/kembalikan.php" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition text-sm shadow">
                      Kembalikan
                    </button>
                  </form>
                <?php else: ?>
                  <span class="text-gray-400 text-sm">-</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data peminjaman.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
