<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Sistem Perhitungan Diskon Bertingkat</h1>
        
        <?php
        // TODO: Isi data pembeli dan buku di sini
        $nama_pembeli = "mas anis";
        $judul_buku = "Laravel Advanced";
        $harga_satuan = 150000;
        $jumlah_beli = 4;
        $is_member = true; // true atau false
        
        // TODO: Hitung subtotal
        $subtotal = $harga_satuan * $jumlah_beli;
        
        // TODO: Tentukan persentase diskon berdasarkan jumlah
        $persentase_diskon = 0;
        if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
            $persentase_diskon = 0;
        } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
            $persentase_diskon = 0.10;
        } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
            $persentase_diskon = 0.15;
        } else {
            $persentase_diskon = 0.20;
        }
        
        // TODO: Hitung diskon
        $diskon = $subtotal * $persentase_diskon;
        
        // TODO: Total setelah diskon pertama
        $total_setelah_diskon1 = $subtotal - $diskon;
        
        // TODO: Hitung diskon member jika member
        $diskon_member = 0;
        if ($is_member) {
            $diskon_member = $total_setelah_diskon1 * 0.05;
        }
        
        // TODO: Total setelah semua diskon
        $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;
        
        // TODO: Hitung PPN
        $ppn = $total_setelah_diskon * 0.11;
        
        // TODO: Total akhir
        $total_akhir = $total_setelah_diskon + $ppn;
        
        // TODO: Total penghematan
        $total_hemat = $diskon + $diskon_member;

        // Format Rupiah
        function rupiah($angka) {
            return "Rp " . number_format($angka, 0, ',', '.');
        }
        ?>
        
        <!-- TODO: Tampilkan hasil perhitungan dengan Bootstrap -->
        <!-- Gunakan card, table, dan badge -->

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5>Hasil Perhitungan</h5>
            </div>
            <div class="card-body">

                <p><strong>Nama Pembeli:</strong> <?= $nama_pembeli ?></p>

                <p><strong>Status Member:</strong>
                    <?php if ($is_member): ?>
                        <span class="badge bg-success">Member</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Non Member</span>
                    <?php endif; ?>
                </p>

                <table class="table table-bordered">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                    <tr>
                        <td><?= $judul_buku ?></td>
                        <td><?= rupiah($harga_satuan) ?></td>
                        <td><?= $jumlah_beli ?></td>
                        <td><?= rupiah($subtotal) ?></td>
                    </tr>
                </table>

                <hr>

                <p><strong>Diskon (<?= $persentase_diskon * 100 ?>%):</strong> <?= rupiah($diskon) ?></p>

                <?php if ($is_member): ?>
                    <p><strong>Diskon Member (5%):</strong> <?= rupiah($diskon_member) ?></p>
                <?php endif; ?>

                <p><strong>Total Setelah Diskon:</strong> <?= rupiah($total_setelah_diskon) ?></p>

                <p><strong>PPN (11%):</strong> <?= rupiah($ppn) ?></p>

                <h4 class="text-primary">Total Akhir: <?= rupiah($total_akhir) ?></h4>

                <p class="text-success"><strong>Total Hemat:</strong> <?= rupiah($total_hemat) ?></p>

            </div>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>