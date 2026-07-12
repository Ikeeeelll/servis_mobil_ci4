<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container">
     <!-- HEADER -->
<div class="header mb-4 position-relative">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <!-- LOGO KIRI -->
        <div class="logo-container">
            <img src="<?= base_url('assets/dist/img/logouss.png') ?>" 
                 alt="Logo" 
                 style="width: 70px; height: auto;">
        </div>

        <!-- TEKS HEADER (TENGAH) -->
        <div class="text-center flex-grow-1">
            <h3 class="fw-bold mb-1 text-uppercase">UTAMA SERVICE STATION</h3>
            <p style="font-size: 14px; margin-bottom: 0;">
                Jl. S. Parman No.156 Padang
            </p>
            <p style="font-size: 13px; margin-bottom: 0;">
                Telp: (0751) 7054654 / 7052123
            </p>

            <h4 class="fw-bold text-decoration-underline mt-3" style="font-size: 16px;">
                LAPORAN DATA BOOKING
            </h4>
        </div>
    </div>
</div>

    <!-- Baris info tanggal dan dicetak oleh -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p style="font-size: 13px; margin-bottom: 0;">
                <strong>Tanggal:</strong> <?= date('d-m-Y') ?>
            </p>
        </div>
        <div class="text-right">
            <p style="font-size: 13px; margin-bottom: 2px;">
                <strong>Dicetak oleh:</strong>
            </p>
            <p style="font-size: 13px; margin-bottom: 0;">
                <?= esc($username) ?>
            </p>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <button class="print-btn btn btn-primary mb-3" onclick="window.print()">
        <i class="fa fa-print"></i> Cetak Laporan
    </button>

    <!-- Tabel Data Booking -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="text-center bg-dark text-white">
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Tanggal Servis</th>
                <th>Jam</th>
                <th>Nama Pelanggan</th>
                <th>Mobil</th>
                <th>Keluhan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pemesanan)): ?>
                <?php $no = 1; ?>
                <?php foreach ($pemesanan as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($row['kode_pemesanan']) ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal_servis'])) ?></td>
                        <td class="text-center"><?= esc($row['jam_servis']) ?></td>
                        <td><?= esc($row['nama_pelanggan']) ?></td>
                        <td><?= esc($row['tipe']) ?> (<?= esc($row['warna']) ?> - <?= esc($row['no_polisi']) ?>)</td>
                        <td><?= esc($row['keluhan']) ?></td>
                        <td class="text-center">
                            <?php if ($row['status'] == 'pesan'): ?>
                                <span class="badge badge-warning">Pesan</span>
                            <?php elseif ($row['status'] == 'proses'): ?>
                                <span class="badge badge-primary">Proses</span>
                            <?php elseif ($row['status'] == 'selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data booking</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
     <!-- TANDA TANGAN -->
    <div class="mt-5" style="width: 40%; margin-left: auto; text-align: center;">
        <p>Padang, <?= date('d-m-Y') ?></p>
        <p><strong>Pimpinan</strong></p>
        <br><br><br>
        <p>(................................................)</p>
    </div>

</div>

<style>
    @media print {
        .print-btn,
        header,
        .sidebar,
          footer,            
    .main-footer, 
        .main-header {
            display: none !important;
        }

        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
        }
    }

    .header h2, .header h3, .header h5 {
        margin: 0;
    }
</style>

<?= $this->endSection() ?>
