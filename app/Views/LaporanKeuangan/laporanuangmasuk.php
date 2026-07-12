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
                LAPORAN UANG MASUK
            </h4>
        </div>
    </div>
</div>

    <!-- INFORMASI TANGGAL DAN PENCETAK -->
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

   <!-- FILTER UANG MASUK -->
<form action="<?= base_url('Laporanuangmasuk/filter') ?>" method="get" class="filter-bar bg-light p-3 rounded shadow-sm mb-4">

    <div class="row align-items-end g-3">

        <div class="col-md-2">
            <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control form-control-sm" 
                   value="<?= esc($tanggal_mulai ?? '') ?>">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold small text-secondary mb-1">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control form-control-sm" 
                   value="<?= esc($tanggal_akhir ?? '') ?>">
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold small text-secondary mb-1">Sumber</label>
            <select name="sumber" class="form-select form-select-sm">
                <option value="">-- Semua Sumber --</option>
                <option value="pembayaran" <?= (isset($sumber_terpilih) && $sumber_terpilih == 'pembayaran') ? 'selected' : '' ?>>Pembayaran Servis</option>
                <option value="penjualan" <?= (isset($sumber_terpilih) && $sumber_terpilih == 'penjualan') ? 'selected' : '' ?>>Penjualan Sparepart</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label fw-semibold small text-secondary mb-1">Periode</label>
            <select name="periode" class="form-select form-select-sm">
                <option value="">-- Semua Transaksi --</option>
                <option value="hari" <?= ($periode ?? '') == 'hari' ? 'selected' : '' ?>>Hari Ini</option>
                <option value="bulan" <?= ($periode ?? '') == 'bulan' ? 'selected' : '' ?>>Bulan Ini</option>
                <option value="tahun" <?= ($periode ?? '') == 'tahun' ? 'selected' : '' ?>>Tahun Ini</option>
            </select>
        </div>

        <div class="col-md-2 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary btn-sm shadow-sm" title="Filter Data">
                <i class="fa-solid fa-filter"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm shadow-sm" onclick="window.print()" title="Cetak Laporan">
                <i class="fa-solid fa-print"></i>
            </button>
            <a href="<?= base_url('Laporanuangmasuk/index') ?>" class="btn btn-secondary btn-sm shadow-sm" title="Reset Filter">
                <i class="fa-solid fa-arrows-rotate"></i>
            </a>
        </div>

    </div>
</form>


    <!-- TABEL DATA UANG MASUK -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="bg-dark text-white text-center">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Sumber</th>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dataUangMasuk)): ?>
                <?php $no = 1;
                foreach ($dataUangMasuk as $row): 
                    ?>
                    
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= esc($row['sumber']) ?></td>
                        <td><?= esc($row['keterangan']) ?></td>
                        <td class="text-end"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-success">
                <td colspan="4" class="text-end"><strong>Total Uang Masuk</strong></td>
                <td class="text-end"><strong>Rp <?= number_format($total_uang_masuk, 0, ',', '.') ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data uang masuk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    <!-- BAGIAN TANDA TANGAN -->
    <div class="mt-5" style="width: 40%; margin-left: auto; text-align: center;">
        <p>Padang, <?= date('d-m-Y') ?></p>
        <p><strong>Pimpinan</strong></p>
        <br><br><br>
        <p>(................................................)</p>
    </div>

</div>

<!-- STYLE TAMBAHAN -->
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

    th, td {
        vertical-align: middle !important;
    }

    .btn i {
        font-size: 14px;
    }

    .btn:hover {
        transform: scale(1.05);
        transition: 0.2s ease-in-out;
    }

    form label {
        font-size: 13px;
    }
    .filter-bar {
    border: 1px solid #dee2e6;
}
.text-end { text-align: right !important; }
.filter-bar .form-control-sm,
.filter-bar .form-select-sm {
    height: 32px !important;
    padding: 4px 8px !important;
    font-size: 13px !important;
}

.filter-bar label {
    margin-bottom: 4px;
    font-size: 13px;
    font-weight: 600;
    color: #555;
}

.filter-bar .btn {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-bar .btn i {
    font-size: 14px;
}

@media (max-width: 768px) {
    .filter-bar .row > div {
        flex: 0 0 100%;
        max-width: 100%;
    }
    .filter-bar .d-flex {
        justify-content: flex-start !important;
    }
}

</style>

<?= $this->endSection() ?>
