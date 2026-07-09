<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mpembayaran;
use App\Models\Mpenjualansparepart;

class Laporanuangmasuk extends BaseController
{
    protected $pembayaranModel;
    protected $penjualanModel;

    public function __construct()
    {
        $this->pembayaranModel = new Mpembayaran();
        $this->penjualanModel = new Mpenjualansparepart();
    }

    public function index()
    {
        $dataUangMasuk = $this->getDataUangMasuk();
        
        $data = [
            'title' => 'Laporan Uang Masuk',
            'username' => session()->get('nama'),
            'dataUangMasuk' => $dataUangMasuk,
            'total_uang_masuk' => array_sum(array_column($dataUangMasuk, 'jumlah')),
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'sumber_terpilih' => '',
            'periode' => ''
        ];

        return view('LaporanKeuangan/laporanuangmasuk', $data);
    }

    public function filter()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $sumber = $this->request->getGet('sumber');
        $periode = $this->request->getGet('periode');

        $dataUangMasuk = $this->getDataUangMasuk($tanggal_mulai, $tanggal_akhir, $sumber, $periode);

        $data = [
            'title' => 'Laporan Uang Masuk',
            'username' => session()->get('nama'),
            'dataUangMasuk' => $dataUangMasuk,
            'total_uang_masuk' => array_sum(array_column($dataUangMasuk, 'jumlah')),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'sumber_terpilih' => $sumber,
            'periode' => $periode
        ];

        return view('LaporanKeuangan/laporanuangmasuk', $data);
    }

    private function getDataUangMasuk($tanggal_mulai = null, $tanggal_akhir = null, $sumber = null, $periode = null)
    {
        $dataUangMasuk = [];

        // Data dari pembayaran servis
        if (empty($sumber) || $sumber == 'pembayaran') {
            $pembayaranBuilder = $this->pembayaranModel
                ->select('pembayaran.*, transaksi_servis.id_transaksi, pelanggan.nama_pelanggan, pemesanan.kode_pemesanan')
                ->join('transaksi_servis', 'transaksi_servis.id_transaksi = pembayaran.id_transaksi')
                ->join('pemesanan','pemesanan.id_pemesanan = transaksi_servis.id_pemesanan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = transaksi_servis.id_pelanggan');

            // Filter tanggal
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $pembayaranBuilder->where('pembayaran.tanggal_diambil >=', $tanggal_mulai)
                                  ->where('pembayaran.tanggal_diambil <=', $tanggal_akhir);
            }

            // Filter periode
            if (!empty($periode)) {
                $today = date('Y-m-d');
                if ($periode == 'hari') {
                    $pembayaranBuilder->where('pembayaran.tanggal_diambil', $today);
                } elseif ($periode == 'bulan') {
                    $pembayaranBuilder->where('MONTH(pembayaran.tanggal_diambil)', date('m'))
                                      ->where('YEAR(pembayaran.tanggal_diambil)', date('Y'));
                } elseif ($periode == 'tahun') {
                    $pembayaranBuilder->where('YEAR(pembayaran.tanggal_diambil)', date('Y'));
                }
            }

            $pembayaranData = $pembayaranBuilder->findAll();

            foreach ($pembayaranData as $row) {
                $dataUangMasuk[] = [
                    'tanggal' => $row['tanggal_diambil'],
                    'sumber' => 'Pembayaran Servis',
                    'keterangan' => 'Pembayaran dari ' . $row['nama_pelanggan'] . ' (' . $row['kode_pemesanan'].')',
                    'jumlah' => $row['total_bayar']
                ];
            }
        }

        // Data dari penjualan sparepart
        if (empty($sumber) || $sumber == 'penjualan') {
            $penjualanBuilder = $this->penjualanModel
                ->select('penjualan.*, pelanggan.nama_pelanggan, (SELECT SUM(jumlah_jual * harga_jual) FROM detail_penjualan WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as total_pemasukan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left');

            // Filter tanggal
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $penjualanBuilder->where('penjualan.tanggal_penjualan >=', $tanggal_mulai)
                                 ->where('penjualan.tanggal_penjualan <=', $tanggal_akhir);
            }

            // Filter periode
            if (!empty($periode)) {
                $today = date('Y-m-d');
                if ($periode == 'hari') {
                    $penjualanBuilder->where('penjualan.tanggal_penjualan', $today);
                } elseif ($periode == 'bulan') {
                    $penjualanBuilder->where('MONTH(penjualan.tanggal_penjualan)', date('m'))
                                     ->where('YEAR(penjualan.tanggal_penjualan)', date('Y'));
                } elseif ($periode == 'tahun') {
                    $penjualanBuilder->where('YEAR(penjualan.tanggal_penjualan)', date('Y'));
                }
            }

            $penjualanData = $penjualanBuilder->findAll();

            foreach ($penjualanData as $row) {
                $namaPelanggan = $row['nama_pelanggan'] ?? 'Umum';
                $dataUangMasuk[] = [
                    'tanggal' => $row['tanggal_penjualan'],
                    'sumber' => 'Penjualan Sparepart',
                    'keterangan' => 'Penjualan ke ' . $namaPelanggan . ' (' . ($row['kode_penjualan'] ?? 'PNJ-' . $row['id_penjualan']) . ')',
                    'jumlah' => $row['total_pemasukan'] ?? 0
                ];
            }
        }

        // Sort by tanggal descending
        usort($dataUangMasuk, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return $dataUangMasuk;
    }
}
