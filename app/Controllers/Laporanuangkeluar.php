<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mpembeliansparepart;
use App\Models\Mpemasok;
use App\Models\Muangkeluar;

class Laporanuangkeluar extends BaseController
{
    protected $pembelianModel;
    protected $pemasokModel;
    protected $uangKeluarModel;

    public function __construct()
    {
        $this->pembelianModel = new Mpembeliansparepart();
        $this->pemasokModel = new Mpemasok();
        $this->uangKeluarModel = new Muangkeluar();
    }

    public function index()
    {
        $dataUangKeluar = $this->getDataUangKeluar();
        
        $data = [
            'title' => 'Laporan Uang Keluar',
            'username' => session()->get('nama'),
            'dataUangKeluar' => $dataUangKeluar,
            'total_uang_keluar' => array_sum(array_column($dataUangKeluar, 'jumlah')),
            'pemasok' => $this->pemasokModel->findAll(),
            'tanggal_mulai' => '',
            'tanggal_akhir' => '',
            'pemasok_terpilih' => '',
            'periode' => ''
        ];

        return view('LaporanKeuangan/laporanuangkeluar', $data);
    }

    public function filter()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $pemasok = $this->request->getGet('pemasok');
        $periode = $this->request->getGet('periode');

        $dataUangKeluar = $this->getDataUangKeluar($tanggal_mulai, $tanggal_akhir, $pemasok, $periode);

        $data = [
            'title' => 'Laporan Uang Keluar',
            'username' => session()->get('nama'),
            'dataUangKeluar' => $dataUangKeluar,
            'total_uang_keluar' => array_sum(array_column($dataUangKeluar, 'jumlah')),
            'pemasok' => $this->pemasokModel->findAll(),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir,
            'pemasok_terpilih' => $pemasok,
            'periode' => $periode
        ];

        return view('LaporanKeuangan/laporanuangkeluar', $data);
    }

    private function getDataUangKeluar($tanggal_mulai = null, $tanggal_akhir = null, $pemasok = null, $periode = null)
    {
        // 1. Ambil data Pembelian Sparepart
        $builderPembelian = $this->pembelianModel
            ->select('pembelian.*, pemasok.nama_pemasok, (SELECT SUM(jumlah_beli * harga_beli) FROM detail_pembelian WHERE detail_pembelian.id_pembelian = pembelian.id_pembelian) as total_pengeluaran')
            ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok');

        // Filter tanggal
        if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
            $builderPembelian->where('pembelian.tanggal_pembelian >=', $tanggal_mulai)
                    ->where('pembelian.tanggal_pembelian <=', $tanggal_akhir);
        }

        // Filter pemasok
        if (!empty($pemasok)) {
            $builderPembelian->where('pembelian.id_pemasok', $pemasok);
        }

        // Filter periode
        if (!empty($periode)) {
            $today = date('Y-m-d');
            if ($periode == 'hari') {
                $builderPembelian->where('pembelian.tanggal_pembelian', $today);
            } elseif ($periode == 'bulan') {
                $builderPembelian->where('MONTH(pembelian.tanggal_pembelian)', date('m'))
                        ->where('YEAR(pembelian.tanggal_pembelian)', date('Y'));
            } elseif ($periode == 'tahun') {
                $builderPembelian->where('YEAR(pembelian.tanggal_pembelian)', date('Y'));
            }
        }

        $dataPembelian = $builderPembelian->findAll();

        // 2. Ambil data Uang Keluar (Hanya jika TIDAK filter pemasok)
        $dataUangKeluarLain = [];
        if (empty($pemasok)) {
            $builderUK = $this->uangKeluarModel->select('*');
            if (!empty($tanggal_mulai) && !empty($tanggal_akhir)) {
                $builderUK->where('tanggal >=', $tanggal_mulai)
                          ->where('tanggal <=', $tanggal_akhir);
            }
            if (!empty($periode)) {
                $today = date('Y-m-d');
                if ($periode == 'hari') {
                    $builderUK->where('tanggal', $today);
                } elseif ($periode == 'bulan') {
                    $builderUK->where('MONTH(tanggal)', date('m'))
                              ->where('YEAR(tanggal)', date('Y'));
                } elseif ($periode == 'tahun') {
                    $builderUK->where('YEAR(tanggal)', date('Y'));
                }
            }
            $dataUangKeluarLain = $builderUK->findAll();
        }

        // 3. Gabungkan dan format data
        $mergedData = [];
        
        foreach ($dataPembelian as $row) {
            $mergedData[] = [
                'id_ref' => 'PB-' . $row['id_pembelian'],
                'tanggal' => $row['tanggal_pembelian'],
                'jenis' => 'Pembelian Sparepart',
                'pemasok' => $row['nama_pemasok'],
                'keterangan' => (!empty($row['keterangan'])) ? $row['keterangan'] : '-',
                'jumlah' => $row['total_pengeluaran'] ?? 0
            ];
        }

        foreach ($dataUangKeluarLain as $row) {
            $mergedData[] = [
                'id_ref' => 'UK-' . $row['id_uang_keluar'],
                'tanggal' => $row['tanggal'],
                'jenis' => $row['jenis_pengeluaran'],
                'pemasok' => '-',
                'keterangan' => (!empty($row['keterangan'])) ? $row['keterangan'] : '-',
                'jumlah' => $row['jumlah']
            ];
        }

        // 4. Urutkan berdasarkan tanggal descending
        usort($mergedData, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return $mergedData;
    }
}
