<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container">

    <!-- HEADER -->
    <div class="header mb-4 position-relative">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

            <!-- LOGO -->
            <div class="logo-container">
                <img src="<?= base_url('assets/dist/img/logouss.png') ?>" alt="Logo" style="width: 70px; height: auto;">
            </div>

            <!-- TEKS HEADER -->
            <div class="text-center flex-grow-1">
                <h3 class="fw-bold mb-1 text-uppercase">UTAMA SERVICE STATION</h3>
                <p style="font-size: 14px; margin-bottom: 0;">Jl. S. Parman No.156 Padang</p>
                <p style="font-size: 13px; margin-bottom: 0;">Telp: (0751) 7054654 / 7052123</p>

                <h4 class="fw-bold text-decoration-underline mt-3" style="font-size: 16px;">
                    LAPORAN DATA SERVIS
                </h4>
            </div>

        </div>
    </div>

    <!-- INFORMASI -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p style="font-size: 13px; margin-bottom: 0;">
                <strong>Tanggal:</strong> <?= date('d-m-Y') ?>
            </p>
        </div>

        <div class="text-end">
            <p style="font-size: 13px; margin-bottom: 2px;"><strong>Dicetak oleh:</strong></p>
            <p style="font-size: 13px; margin-bottom: 0;"><?= esc($username) ?></p>
        </div>
    </div>

    <!-- FILTER PEMBAYARAN -->
    <form method="get" action="" class="filter-bar bg-light p-3 rounded shadow-sm mb-4">
        <div class="row align-items-end g-3">

            <div class="col-md-3">
                <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Mulai</label>
                <input type="date" name="tgl_awal" class="form-control form-control-sm"
                    value="<?= esc($tgl_awal ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" class="form-control form-control-sm"
                    value="<?= esc($tgl_akhir ?? '') ?>">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm shadow-sm" title="Filter Data">
                    <i class="fa-solid fa-filter"></i>
                </button>

                <button type="button" class="btn btn-success btn-sm shadow-sm print-btn" onclick="window.print()"
                    title="Cetak Laporan">
                    <i class="fa-solid fa-print"></i>
                </button>

                <a href="<?= base_url('Pembayaran/laporan') ?>" class="btn btn-secondary btn-sm shadow-sm"
                    title="Reset Filter">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </a>
            </div>

        </div>
    </form>

    <!-- STYLE TABEL -->
    <style>
        .table thead th {
            text-align: center;
            vertical-align: middle;
        }

        .table td,
        .table th {
            font-size: 14px;
            vertical-align: middle !important;
        }

        .bg-header {
            background-color: #343a40;
            color: white;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }
    </style>

    <!-- TABEL PEMBAYARAN -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="bg-header">
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Tanggal Servis</th>
                <th>Tanggal Diambil</th>
                <th>Pelanggan</th>
                <th>Mobil</th>
                <th>Mekanik</th>
                <th>Total Biaya (Rp)</th>
                <th>Diskon (Rp)</th>
                <th>Total Bayar (Rp)</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $totalAkhir = 0;
            $no = 1;

            if (!empty($laporan)):
                foreach ($laporan as $row):

                    $total_biaya = $row['total_biaya'];
                    $diskon = $row['diskon'];
                    $total_bayar = $total_biaya - $diskon;

                    // akumulasi pemasukan
                    $totalAkhir += $total_bayar;
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= esc($row['kode_pemesanan']); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_servis'])); ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal_diambil'])); ?></td>
                        <td><?= esc($row['nama_pelanggan']); ?></td>
                        <td><?= esc($row['tipe'] . ' - ' . $row['no_polisi']); ?></td>

                        <td><?= esc($row['nama_mekanik']); ?></td>

                        <td class="text-end"><?= number_format($total_biaya, 0, ',', '.'); ?></td>
                        <td class="text-end"><?= number_format($diskon, 0, ',', '.'); ?></td>
                        <td class="text-end"><?= number_format($total_bayar, 0, ',', '.'); ?></td>
                    </tr>

                <?php endforeach; else: ?>

                <tr>
                    <td colspan="10" class="text-center">Tidak ada data pembayaran.</td>
                </tr>

            <?php endif; ?>

            <tr class="table-info">
                <td colspan="9" class="text-end"><strong>Total Pemasukan (Rp)</strong></td>
                <td class="text-end"><strong><?= number_format($totalAkhir, 0, ',', '.'); ?></strong></td>
            </tr>
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

<!-- STYLE PRINT -->
<style>
    @media print {

        .print-btn,
        form,
        header,
        footer,
        .sidebar,
        .main-footer,
        .main-header {
            display: none !important;
        }

        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            font-size: 13px;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
        }
    }
</style>

<?= $this->endSection() ?>