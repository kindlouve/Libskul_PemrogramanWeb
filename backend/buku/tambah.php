<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $stok = $_POST['stok'];
    $gambar = '';

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $uploadDir = '../../uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

        $namaFile = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $_FILES['cover']['name']);
        $pathSimpan = $uploadDir . $namaFile;
        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed_ext)) {
            header("Location: ../../admin/buku.php?status=invalid_file");
            exit();
        }

        if (move_uploaded_file($_FILES['cover']['tmp_name'], $pathSimpan)) {
            $gambar = $namaFile;
        } else {
            header("Location: ../../admin/buku.php?status=upload_error");
            exit();
        }
    }

    $sql = "INSERT INTO buku (judul, penulis, penerbit, tahun, stok, gambar) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiss", $judul, $penulis, $penerbit, $tahun, $stok, $gambar);

    if ($stmt->execute()) {
        header("Location: ../../admin/buku.php?status=success");
    } else {
        header("Location: ../../admin/buku.php?status=error");
    }
} else {
    header("Location: ../../admin/buku.php");
}
