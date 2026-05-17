<?php
require_once '../../config/database.php';

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT foto FROM anggota WHERE id_anggota=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

if (!empty($data['foto']) && file_exists('uploads/' . $data['foto'])) {
    unlink('uploads/' . $data['foto']);
}

$delete = $conn->prepare("DELETE FROM anggota WHERE id_anggota=?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    header("Location: index.php?success=Data berhasil dihapus");
    exit();
}
?>