<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../auth/login.php");
    exit();
}
include '../backend/koneksi.php';
$sql = "SELECT * FROM buku ORDER BY tahun DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fade-in-out {
      0% { opacity: 0; transform: translateY(-10px); }
      10% { opacity: 1; transform: translateY(0); }
      90% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(-10px); }
    }
    .animate-fade-in-out {
      animation: fade-in-out 3s ease-in-out;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen">

  <!--Pop Up Notifikasi-->
  <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div id="popupSuccess" class="fixed top-6 right-6 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 animate-fade-in-out">
      ✅ Buku berhasil ditambahkan!
    </div>
    <script>
      setTimeout(() => {
        const popup = document.getElementById('popupSuccess');
        if (popup) popup.style.display = 'none';
      }, 3000);
    </script>
  <?php endif; ?>

  <!--Navbar-->
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
      <div class="flex items-center space-x-3">
        <img src="../img/logo.png" alt="Logo Libskul" class="h-10 w-10 object-contain rounded-full shadow" />
        <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Libskul Admin</h1>
      </div>
      <a href="dashboard.php" class="text-gray-700 hover:text-gray-900 font-medium transition">Kembali</a>
    </div>
  </nav>

  <main class="container mx-auto p-8 mt-10">
    <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center">Daftar Buku</h2>

    <!--Tambah Buku-->
    <form action="../backend/buku/tambah.php" method="post" enctype="multipart/form-data"
      class="grid md:grid-cols-2 gap-4 mb-10 bg-white rounded-xl shadow-lg p-6">
      <input type="text" name="judul" placeholder="Judul" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="text" name="penulis" placeholder="Penulis" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="text" name="penerbit" placeholder="Penerbit" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="number" name="tahun" placeholder="Tahun Terbit" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="number" name="stok" placeholder="Jumlah Buku" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <input type="file" name="cover" accept="image/*" class="p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
      <button type="submit" class="col-span-2 bg-gradient-to-r from-gray-500 to-gray-700 text-white py-2 px-4 rounded hover:from-gray-600 hover:to-gray-800 transition font-semibold shadow">
        Tambah Buku
      </button>
    </form>

    <!--Tabel Buku-->
    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded-xl shadow-lg table-auto overflow-hidden">
        <thead class="bg-gray-200 text-gray-700 font-semibold">
          <tr>
            <th class="p-3 border">Cover</th>
            <th class="p-3 border">Judul</th>
            <th class="p-3 border">Penulis</th>
            <th class="p-3 border">Tahun</th>
            <th class="p-3 border">Stok</th>
            <th class="p-3 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($buku = $result->fetch_assoc()): ?>
          <tr class="text-center border-t hover:bg-gray-50">
            <td class="p-3">
              <?php if (!empty($buku['gambar']) && file_exists("../uploads/" . $buku['gambar'])): ?>
                <img src="../uploads/<?= htmlspecialchars($buku['gambar']) ?>" alt="Cover" class="h-16 mx-auto object-contain rounded">
              <?php else: ?>
                <span class="text-gray-400 italic">Tidak ada</span>
              <?php endif; ?>
            </td>
            <td class="p-3"><?= htmlspecialchars($buku['judul']) ?></td>
            <td class="p-3"><?= htmlspecialchars($buku['penulis']) ?></td>
            <td class="p-3"><?= htmlspecialchars($buku['tahun']) ?></td>
            <td class="p-3"><?= htmlspecialchars($buku['stok']) ?></td>
            <td class="p-3 space-x-2">
              <a href="../backend/buku/edit.php?id=<?= $buku['id'] ?>" class="bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500 transition">Edit</a>
              <a href="../backend/buku/hapus.php?id=<?= $buku['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
