<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM buku WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../admin/buku.php?status=deleted");
        exit();
    } else {
        echo "Gagal menghapus buku!";
    }
} else {
    echo "ID buku tidak ditemukan!";
}
?>
