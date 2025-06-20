<?php
session_start();
require_once __DIR__ . '/../koneksi.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['siswa_id'])) {
    header("Location: ../../backend/auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buku_id'])) {
    $siswa_id = $_SESSION['siswa_id'];
    $buku_id = intval($_POST['buku_id']);

    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

    $status = 'dipinjam';

    $cekStok = $conn->query("SELECT stok FROM buku WHERE id = $buku_id")->fetch_assoc();
    if (!$cekStok || $cekStok['stok'] <= 0) {
        header("Location: ../../katalog.php?status=habis");
        exit();
    }

    $conn->query("UPDATE buku SET stok = stok - 1 WHERE id = $buku_id");

    $stmt = $conn->prepare("INSERT INTO peminjaman (siswa_id, buku_id, tanggal_pinjam, tanggal_kembali, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $siswa_id, $buku_id, $tanggal_pinjam, $tanggal_kembali, $status);

    if ($stmt->execute()) {
        header("Location: ../../katalog.php?status=berhasil");
        exit();
    } else {
        die("Gagal menyimpan peminjaman: " . $stmt->error);
    }
} else {
    header("Location: ../../katalog.php");
    exit();
}
