<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class PortalController extends Controller
{
    private function previewData(): array
    {
        $stats = [
            'totalDepositsDesc' => 'transaksi terverifikasi',
            'totalWeight' => '24,5 Kg',
            'totalWeightDesc' => 'tereduksi dari TPA sekolah',
            'totalIncomeDesc' => 'bebas potongan admin',
            'lastChange' => '+ Rp 7.500',
            'lastChangeDesc' => '+Rp 7.500 (07 Sep 2026)',
            'bookNumber' => 'Reg. 042-SMK-2026',
            'monthlyWeight' => '7,5 Kg',
            'monthlyWeightDesc' => '3 setoran terkonfirmasi pada September 2026',
            'monthlyIncome' => 'Rp 18.500',
            'monthlyIncomeDesc' => 'Terkreditasi langsung ke saldo utama',
            'activeOfficers' => 'Andi & Ibu Sri',
            'totalTransactionsDesc' => 'Setoran sampah terverifikasi',
            'totalIncomeDesc' => 'Kumulatif kredit masuk aktif',
            'lastDepositDate' => '07 Sep 2026',
            'totalPages' => '2',
        ];
        $transactions = [
            ['id' => 'ST-00021', 'date' => '07 Sep 2026', 'time' => '08:21 WIB', 'jenis' => 'Plastik Bersih', 'detail' => 'PET / Tutup Botol Bersih', 'weight' => '2,5', 'price' => '3.000', 'total' => '7.500', 'officer' => 'Andi', 'initial' => 'A', 'balance' => '42.500'],
            ['id' => 'ST-00018', 'date' => '05 Sep 2026', 'time' => '10:15 WIB', 'jenis' => 'Kardus Box', 'detail' => 'Kardus Pilah', 'weight' => '3,0', 'price' => '2.000', 'total' => '6.000', 'officer' => 'Andi', 'initial' => 'A', 'balance' => '35.000'],
            ['id' => 'ST-00014', 'date' => '02 Sep 2026', 'time' => '09:30 WIB', 'jenis' => 'Kertas HVS & Arsip', 'detail' => 'Kertas Arsip', 'weight' => '2,0', 'price' => '2.500', 'total' => '5.000', 'officer' => 'Ibu Sri', 'initial' => 'IS', 'balance' => '29.000'],
            ['id' => 'ST-00011', 'date' => '25 Agu 2026', 'time' => '11:00 WIB', 'jenis' => 'Botol Kaca', 'detail' => 'Botol Kaca', 'weight' => '4,0', 'price' => '3.000', 'total' => '12.000', 'officer' => 'Andi', 'initial' => 'A', 'balance' => '24.000'],
            ['id' => 'ST-00008', 'date' => '18 Agu 2026', 'time' => '08:45 WIB', 'jenis' => 'Kaleng Logam', 'detail' => 'Kaleng Pilah', 'weight' => '1,5', 'price' => '6.000', 'total' => '9.000', 'officer' => 'Pak Joko', 'initial' => 'PJ', 'balance' => '12.000'],
            ['id' => 'ST-00003', 'date' => '10 Agu 2026', 'time' => '09:10 WIB', 'jenis' => 'Kardus Lipat', 'detail' => 'Kardus Pilah', 'weight' => '1,5', 'price' => '2.000', 'total' => '3.000', 'officer' => 'Ibu Sri', 'initial' => 'IS', 'balance' => '3.000'],
        ];

        return compact('stats','transactions') + [
            'student' => ['name' => 'Budi Santoso', 'number' => 'NS003', 'class' => 'XII RPL B', 'phone' => '0812-3456-7890', 'username' => 'budi.santoso', 'balance' => '42.500'],
        ];
    }

    public function login() { return view('auth.login'); }
    public function dashboard() { return view('nasabah.dashboard', $this->previewData()); }
    public function riwayat() { return view('nasabah.riwayat', $this->previewData()); }
    public function saldo() { return view('nasabah.saldo', $this->previewData()); }
    public function profil() { return view('nasabah.profil', $this->previewData()); }
}
