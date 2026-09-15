<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class PetugasController extends Controller
{
    private function previewData(): array
    {
        $officer = ['name' => 'Ibu Sri Wahyuni', 'role' => 'Petugas / Koordinator'];
        $stats = [
            'todayDeposits' => '23 Setoran',
            'todayDepositsDesc' => 'Naik 5 setoran dari kemarin',
            'todayWeight' => '148.6 Kg',
            'todayWeightDesc' => 'Rata-rata 6.5 kg / setoran',
            'todayTransactions' => '21 Transaksi',
            'todayTransactionsDesc' => 'Semua sudah dibayar tunai',
            'todayBalance' => 'Rp 412.500',
            'todayBalanceDesc' => 'Naik Rp 68.000 dari kemarin',
            'totalTransactions' => '128',
            'totalTransactionsChange' => '+14.2% dari pekan lalu',
            'totalWeight' => '356.5 Kg',
            'totalWeightDesc' => '42% Plastik & Kertas',
            'totalBalance' => 'Rp 1.250.000',
            'totalBalanceDesc' => 'Kredit ke 46 Buku Nasabah',
            'avgTransaction' => 'Rp 9.765',
            'avgTransactionDesc' => 'Konversi 2.78 Kg/setoran',
            'totalStudents' => '228',
            'totalStudentsDesc' => '93% partisipasi per kelas kejuruan',
            'totalTeachers' => '17',
            'totalTeachersDesc' => 'Nasabah Teladan',
            'totalPages' => '26',
            'currentDate' => 'Senin, 07 September 2026',
        ];
        $transactions = [
            ['id'=>'ST-00128','date'=>'07 Sep 2026','time'=>'16:14 WIB','name'=>'Budi Santoso','number'=>'NS003','class'=>'XII RPL B','jenis'=>'Plastik Daur Ulang','weight'=>'4.5','price'=>'3.000','total'=>'13.500','officer'=>'Ibu Sri Wahyuni','status'=>'Terverifikasi'],
            ['id'=>'ST-00127','date'=>'07 Sep 2026','time'=>'15:48 WIB','name'=>'Siti Aisyah','number'=>'NS012','class'=>'X AKL 1','jenis'=>'Kardus & Box Tebal','weight'=>'8.2','price'=>'2.000','total'=>'16.400','officer'=>'Ibu Sri Wahyuni','status'=>'Terverifikasi'],
            ['id'=>'ST-00126','date'=>'07 Sep 2026','time'=>'15:12 WIB','name'=>'Pak Hendra, S.Pd.','number'=>'NS001','class'=>'Guru BK / Tendik','jenis'=>'Logam & Kaleng','weight'=>'3.0','price'=>'6.000','total'=>'18.000','officer'=>'Ahmad Fauzi','status'=>'Terverifikasi'],
            ['id'=>'ST-00125','date'=>'07 Sep 2026','time'=>'14:35 WIB','name'=>'Dewi Anggraeni','number'=>'NS078','class'=>'XI TBSM 2','jenis'=>'Botol Kaca Utuh','weight'=>'6.0','price'=>'1.500','total'=>'9.000','officer'=>'Ibu Sri Wahyuni','status'=>'Pending'],
            ['id'=>'ST-00124','date'=>'07 Sep 2026','time'=>'12:58 WIB','name'=>'Rizky Maulana','number'=>'NS045','class'=>'X DKV 3','jenis'=>'Plastik Daur Ulang','weight'=>'2.8','price'=>'3.000','total'=>'8.400','officer'=>'Ahmad Fauzi','status'=>'Terverifikasi'],
        ];
        $students = [
            ['number'=>'NS003','name'=>'Budi Santoso','class'=>'XII RPL B','phone'=>'0812-3456-7890','balance'=>'42.000','count'=>'7','initial'=>'BS','status'=>'Aktif'],
            ['number'=>'NS012','name'=>'Siti Aisyah','class'=>'X AKL 1','phone'=>'0857-1122-3344','balance'=>'28.500','count'=>'5','initial'=>'SA','status'=>'Aktif'],
            ['number'=>'NS001','name'=>'Pak Hendra Pratama','class'=>'Guru BK','phone'=>'0813-9988-7766','balance'=>'115.000','count'=>'12','initial'=>'HP','status'=>'Aktif'],
            ['number'=>'NS045','name'=>'Rian Pratama','class'=>'XI TKJ 2','phone'=>'0878-4455-6677','balance'=>'18.200','count'=>'4','initial'=>'RP','status'=>'Aktif'],
            ['number'=>'NS078','name'=>'Dewi Sartika','class'=>'X DKV 3','phone'=>'0896-3322-1100','balance'=>'7.500','count'=>'1','initial'=>'DS','status'=>'Aktif'],
            ['number'=>'NS099','name'=>'Ahmad Fauzi','class'=>'XII TBSM 1','phone'=>'0821-5566-7788','balance'=>'0','count'=>'0','initial'=>'AF','status'=>'Baru'],
        ];
        $waste = [
            ['code'=>'K-01','name'=>'Plastik Daur Ulang','detail'=>'PET bening, tutup botol & botol mineral bersih','price'=>'3.000','unit'=>'Kg','month'=>'142,5'],
            ['code'=>'K-02','name'=>'Kardus & Box Tebal','detail'=>'Karton gelombang cokelat, kemasan kering & terikat','price'=>'2.000','unit'=>'Kg','month'=>'115,0'],
            ['code'=>'K-03','name'=>'Kertas HVS & Arsip','detail'=>'Buku tulis, kertas dokumen putih, majalah bebas staples','price'=>'2.500','unit'=>'Kg','month'=>'68,0'],
            ['code'=>'K-04','name'=>'Botol Kaca Utuh','detail'=>'Botol kecap, sirup, saus tanpa retak dan sudah dibilas','price'=>'1.500','unit'=>'Kg','month'=>'22,0'],
            ['code'=>'K-05','name'=>'Kaleng & Aluminium','detail'=>'Kaleng soft drink pipih, seng lembaran, panci aluminium','price'=>'6.000','unit'=>'Kg','month'=>'45,2'],
            ['code'=>'K-06','name'=>'Minyak Jelantah (UCO)','detail'=>'Minyak goreng jernih disaring, wadah jerigen tertutup','price'=>'4.500','unit'=>'Liter','month'=>'18,0'],
        ];
        return compact('officer','stats','transactions','students','waste');
    }
    public function dashboard() { return view('petugas.dashboard', $this->previewData()); }
    public function setoran() { return view('petugas.setoran', $this->previewData()); }
    public function nasabah() { return view('petugas.nasabah', $this->previewData()); }
    public function jenisSampah() { return view('petugas.jenis-sampah', $this->previewData()); }
    public function riwayat() { return view('petugas.riwayat', $this->previewData()); }
}
