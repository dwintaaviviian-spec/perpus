<?php
$page_title = "Edit Anggota";
require_once '../../config/database.php';

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM anggota WHERE id_anggota = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$data = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $telepon = sanitize($_POST['telepon']);
    $status = sanitize($_POST['status']);

    $foto = $data['foto'];

    if (!empty($_FILES['foto']['name'])) {

        if (!empty($foto) && file_exists('uploads/' . $foto)) {
            unlink('uploads/' . $foto);
        }

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        $foto = time() . '.' . $ext;

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            'uploads/' . $foto
        );
    }

    $update = $conn->prepare("
    UPDATE anggota
    SET nama=?, email=?, telepon=?, status=?, foto=?
    WHERE id_anggota=?
    ");

    $update->bind_param(
        "sssssi",
        $nama,
        $email,
        $telepon,
        $status,
        $foto,
        $id
    );

    if ($update->execute()) {
        header("Location: index.php?success=Data berhasil diupdate");
        exit();
    }
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-warning">
            <h4>Edit Anggota</h4>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= $data['nama']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= $data['email']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text"
                           name="telepon"
                           class="form-control"
                           value="<?= $data['telepon']; ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">

                        <option value="Aktif"
                        <?= ($data['status'] == 'Aktif') ? 'selected' : ''; ?>>
                            Aktif
                        </option>

                        <option value="Nonaktif"
                        <?= ($data['status'] == 'Nonaktif') ? 'selected' : ''; ?>>
                            Nonaktif
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Foto Sekarang</label><br>

                    <?php if(!empty($data['foto'])): ?>

                        <img src="uploads/<?= $data['foto']; ?>"
                             width="120"
                             class="img-thumbnail">

                    <?php else: ?>

                        <p class="text-muted">Belum ada foto</p>

                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label>Upload Foto Baru</label>
                    <input type="file"
                           name="foto"
                           class="form-control">
                </div>

                <button type="submit" class="btn btn-warning">
                    Update
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>