<?php
include '../backend/koneksi.php';

$sql = "SELECT * FROM siswa ORDER BY nama ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Data Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">
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
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Siswa Terdaftar</h2>
    <div class="overflow-x-auto">
      <table class="w-full table-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">NIS</th>
            <th class="p-2 border">Kelas</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td class="p-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="p-2 border"><?= htmlspecialchars($row['nis']) ?></td>
                <td class="p-2 border"><?= htmlspecialchars($row['kelas']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data siswa.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
