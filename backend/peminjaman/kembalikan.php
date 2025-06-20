<?php
date_default_timezone_set('Asia/Jakarta');

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!is_numeric($id)) {
        die("ID tidak valid.");
    }

    $tanggal_kembali = date('Y-m-d');
    $status = 'dikembalikan';

    $stmt_get = $conn->prepare("SELECT buku_id FROM peminjaman WHERE id = ?");
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $stmt_get->bind_result($buku_id);
    $stmt_get->fetch();
    $stmt_get->close();

    $stmt = $conn->prepare("UPDATE peminjaman SET tanggal_kembali = ?, status = ? WHERE id = ?");
    $stmt->bind_param("ssi", $tanggal_kembali, $status, $id);

    if ($stmt->execute()) {
        $conn->query("UPDATE buku SET stok = stok + 1 WHERE id = $buku_id");

        header("Location: ../../admin/laporan.php?status=returned");
        exit();
    } else {
        echo "Gagal mengupdate: " . $stmt->error;
    }
} else {
    header("Location: ../../admin/laporan.php");
    exit();
}
