<?php
include '../koneksi.php';

$sql = "SELECT p.id, s.nama AS siswa, b.judul AS buku, p.tanggal_pinjam, p.tanggal_kembali, p.status
        FROM peminjaman p
        JOIN siswa s ON p.siswa_id = s.id
        JOIN buku b ON p.buku_id = b.id
        ORDER BY p.tanggal_pinjam DESC";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
