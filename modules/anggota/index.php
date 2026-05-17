<?php
$page_title = "Data Anggota";
require_once '../../config/database.php';
require_once '../../includes/header.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize($_GET['status']) : '';
$jk_filter = isset($_GET['jenis_kelamin']) ? sanitize($_GET['jenis_kelamin']) : '';

$where = "WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $where .= " AND (nama LIKE ? OR email LIKE ? OR telepon LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if (!empty($status_filter)) {
    $where .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($jk_filter)) {
    $where .= " AND jenis_kelamin = ?";
    $params[] = $jk_filter;
    $types .= "s";
}

$query = "SELECT * FROM anggota $where ORDER BY kode_anggota ASC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$count_query = "SELECT COUNT(*) as total FROM anggota $where";

if (!empty($search) || !empty($status_filter) || !empty($jk_filter)) {
    $count_stmt = $conn->prepare($count_query);

    $count_params = $params;
    array_pop($count_params);
    array_pop($count_params);

    $count_types = substr($types, 0, -2);

    $count_stmt->bind_param($count_types, ...$count_params);
    $count_stmt->execute();
    $total_rows = $count_stmt->get_result()->fetch_assoc()['total'];
} else {
    $total_rows = $conn->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];
}

$total_pages = ceil($total_rows / $limit);
?>
<style>
    .bg-pink {
    background-color: #ff69b4;
    color: white;
}
</style>
<?php
$total = $conn->query("SELECT COUNT(*) as total FROM anggota")->fetch_assoc()['total'];

$aktif = $conn->query("SELECT COUNT(*) as total FROM anggota WHERE status='Aktif'")->fetch_assoc()['total'];

$nonaktif = $conn->query("SELECT COUNT(*) as total FROM anggota WHERE status='Nonaktif'")->fetch_assoc()['total'];
?>

<div class="row mb-3">

<div class="col-md-4">
<div class="card bg-primary text-white">
<div class="card-body">
<h5>Total Anggota</h5>
<h3><?php echo $total; ?></h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-success text-white">
<div class="card-body">
<h5>Anggota Aktif</h5>
<h3><?php echo $aktif; ?></h3>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card bg-danger text-white">
<div class="card-body">
<h5>Anggota Nonaktif</h5>
<h3><?php echo $nonaktif; ?></h3>
</div>
</div>
</div>

</div>
<div class="container">

<div class="d-flex justify-content-between mb-3">
    <h2>Data Anggota</h2>

    <a href="create.php" class="btn btn-primary">
        Tambah Anggota
    </a>
</div>

<form method="GET" class="row g-2 mb-3">

    <div class="col-md-4">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari nama/email/telepon"
               value="<?php echo htmlspecialchars($search); ?>">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="Aktif" <?php echo ($status_filter == 'Aktif') ? 'selected' : ''; ?>>
                Aktif
            </option>
            <option value="Nonaktif" <?php echo ($status_filter == 'Nonaktif') ? 'selected' : ''; ?>>
                Nonaktif
            </option>
        </select>
    </div>

    <div class="col-md-3">
        <select name="jenis_kelamin" class="form-select">
            <option value="">Semua Gender</option>
            <option value="Laki-laki" <?php echo ($jk_filter == 'Laki-laki') ? 'selected' : ''; ?>>
                Laki-laki
            </option>
            <option value="Perempuan" <?php echo ($jk_filter == 'Perempuan') ? 'selected' : ''; ?>>
                Perempuan
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Cari</button>
    </div>

</form>

<div class="card">
<div class="card-body">

<?php if ($result->num_rows > 0): ?>

<table class="table table-bordered table-hover">

<thead>
<tr>
    <th>No</th>
    <th>Foto</th>
    <th>Kode</th>
    <th>Nama</th>
    <th>Email</th>
    <th>Telepon</th>
    <th>Alamat</th>
    <th>JK</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no = $offset + 1;

while ($row = $result->fetch_assoc()):
?>

<tr>

<td><?php echo $no++; ?></td>

<td>
<?php if (!empty($row['foto'])): ?>
    <img src="uploads/<?php echo $row['foto']; ?>"
         width="60"
         height="60"
         style="object-fit:cover;">
<?php else: ?>
    -
<?php endif; ?>
</td>

<td><?php echo htmlspecialchars($row['kode_anggota']); ?></td>

<td><?php echo htmlspecialchars($row['nama']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['telepon']); ?></td>

<td><?php echo htmlspecialchars($row['alamat']); ?></td>

<td>
<?php if ($row['jenis_kelamin'] == 'Laki-laki'): ?>
    <span class="badge bg-primary">Laki-laki</span>
<?php else: ?>
    <span class="badge bg-pink text-dark">Perempuan</span>
<?php endif; ?>
</td>

<td>
<?php if ($row['status'] == 'Aktif'): ?>
    <span class="badge bg-success">Aktif</span>
<?php else: ?>
    <span class="badge bg-danger">Nonaktif</span>
<?php endif; ?>
</td>

<td>
    <a href="edit.php?id=<?php echo $row['id_anggota']; ?>"
       class="btn btn-warning btn-sm">
        Edit
    </a>

    <a href="delete.php?id=<?php echo $row['id_anggota']; ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Yakin ingin hapus?')">
        Hapus
    </a>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

<?php endif; ?>

</div>
</div>

</div>

<?php
closeConnection();
require_once '../../includes/footer.php';
?>