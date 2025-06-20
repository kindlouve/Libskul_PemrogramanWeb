<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM buku WHERE id = $id");

    if ($result->num_rows === 0) {
        die("Buku tidak ditemukan.");
    }

    $buku = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'];
    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $penerbit  = $_POST['penerbit'];
    $tahun     = $_POST['tahun'];
    $stok      = $_POST['stok'];
    $gambar_lama = $_POST['gambar_lama'];

    $gambar_baru = $_FILES['gambar']['name'];
    $tmp         = $_FILES['gambar']['tmp_name'];

    $gambar = $gambar_lama;
    if ($gambar_baru != '') {
        $uploadDir = '../../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $namaFileBaru = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $gambar_baru);
        $pathSimpan = $uploadDir . $namaFileBaru;

        if (move_uploaded_file($tmp, $pathSimpan)) {
            $gambar = 'uploads/' . $namaFileBaru;
        }
    }

    $sql = "UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun=?, stok=?, gambar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissi", $judul, $penulis, $penerbit, $tahun, $stok, $gambar, $id);

    if ($stmt->execute()) {
        header("Location: ../../admin/buku.php?status=updated");
        exit();
    } else {
        echo "Gagal mengedit buku!";
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($buku)): ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Buku</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <form action="edit.php" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit Data Buku</h2>

    <input type="hidden" name="id" value="<?= $buku['id'] ?>">
    <input type="hidden" name="gambar_lama" value="<?= $buku['gambar'] ?>">

    <label class="block mb-4">
      <span class="text-gray-700">Judul</span>
      <input type="text" name="judul" value="<?= $buku['judul'] ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-gray-400">
    </label>

    <label class="block mb-4">
      <span class="text-gray-700">Penulis</span>
      <input type="text" name="penulis" value="<?= $buku['penulis'] ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-gray-400">
    </label>

    <label class="block mb-4">
      <span class="text-gray-700">Penerbit</span>
      <input type="text" name="penerbit" value="<?= $buku['penerbit'] ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-gray-400">
    </label>

    <label class="block mb-4">
      <span class="text-gray-700">Tahun Terbit</span>
      <input type="number" name="tahun" value="<?= $buku['tahun'] ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-gray-400">
    </label>

    <label class="block mb-4">
      <span class="text-gray-700">Jumlah Stok</span>
      <input type="number" name="stok" value="<?= $buku['stok'] ?>" required class="w-full p-2 border rounded focus:ring-2 focus:ring-gray-400">
    </label>

    <?php if (!empty($buku['gambar']) && file_exists("../../" . $buku['gambar'])): ?>
      <div class="mb-4">
        <span class="text-gray-700 block mb-2">Gambar Saat Ini:</span>
        <img src="../../<?= $buku['gambar'] ?>" alt="Gambar Buku" class="h-32 rounded shadow">
      </div>
    <?php endif; ?>

    <label class="block mb-6">
      <span class="text-gray-700">Ganti Gambar (kosongkan jika tidak diganti)</span>
      <input type="file" name="gambar" class="w-full p-2 border rounded">
    </label>

    <div class="flex justify-between">
      <a href="../../admin/buku.php" class="text-gray-600 underline">Kembali</a>
      <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Simpan</button>
    </div>
  </form>
</body>
</html>
<?php endif; ?>
