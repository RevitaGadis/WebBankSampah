<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private function data(): array
    {
        $admin = ['name' => 'Ibu Sri Wahyuni', 'role' => 'Administrator Sekolah'];
        $stats = [
            'totalTransactions' => '128',
            'totalTransactionsDesc' => '19 slip tercatat hari ini',
            'totalTransactionsChange' => '+14,2% dari pekan lalu',
            'totalWeight' => '356.5 Kg',
            'totalWeightDesc' => 'Dari 4 zona pilah gedung sekolah',
            'totalBalance' => 'Rp 1.250.000',
            'totalBalanceDesc' => 'Dana tabungan aktif nasabah',
            'totalStudents' => '228',
            'totalStudentsDesc' => '93% partisipasi per kelas kejuruan',
            'totalTeachers' => '17',
            'totalTeachersDesc' => 'Nasabah Teladan',
            'totalAccounts' => '248',
            'totalStudentAccounts' => '216',
            'totalTeacherAccounts' => '24',
            'totalStaffAccounts' => '8',
            'totalCategories' => '6',
            'activeCategoriesDesc' => '100% aktif di loket piket harian',
            'avgPrice' => '3.160',
            'avgPriceDesc' => 'Penyesuaian SK 01 Sep 2026',
            'highestPrice' => '6.000',
            'highestPriceItem' => 'Kaleng & Aluminium',
            'avgTransaction' => '9.765',
            'avgTransactionDesc' => 'Konversi 2,78 Kg/setoran',
            'totalPages' => '26',
            'lastUpdatedBy' => 'Ibu Sri Wahyuni',
            'wasteComposition' => [
                ['name' => 'Plastik Daur Ulang', 'weight' => '142.5 Kg', 'percentage' => '40'],
                ['name' => 'Kardus & Box Tebal', 'weight' => '115.0 Kg', 'percentage' => '32'],
                ['name' => 'Kertas HVS & Arsip', 'weight' => '68.0 Kg', 'percentage' => '17'],
                ['name' => 'Botol Kaca Utuh', 'weight' => '22.0 Kg', 'percentage' => '11'],
            ],
            'currentDate' => 'Senin, 07 September 2026',
        ];
        $students = [
            ['number'=>'NS003','name'=>'Budi Santoso','class'=>'XII RPL B','phone'=>'0812-3456-7890','balance'=>'42.500','count'=>'7','initial'=>'BS','status'=>'Aktif'], ['number'=>'NS012','name'=>'Siti Aisyah','class'=>'X AKL 1','phone'=>'0857-1122-3344','balance'=>'28.500','count'=>'5','initial'=>'SA','status'=>'Aktif'], ['number'=>'NS001','name'=>'Pak Hendra Pratama','class'=>'Guru BK','phone'=>'0813-9988-7766','balance'=>'115.000','count'=>'12','initial'=>'HP','status'=>'Aktif'], ['number'=>'NS045','name'=>'Rian Pratama','class'=>'XI TKJ 2','phone'=>'0878-4455-6677','balance'=>'18.200','count'=>'4','initial'=>'RP','status'=>'Aktif'], ['number'=>'NS078','name'=>'Dewi Sartika','class'=>'X DKV 3','phone'=>'0896-3322-1100','balance'=>'7.500','count'=>'1','initial'=>'DS','status'=>'Aktif'], ['number'=>'NS099','name'=>'Ahmad Fauzi','class'=>'XII TBSM 1','phone'=>'0821-5566-7788','balance'=>'0','count'=>'0','initial'=>'AF','status'=>'Baru'],
        ];
        $waste = [['code'=>'K-01','name'=>'Plastik Daur Ulang','detail'=>'PET bening, tutup botol & botol mineral bersih','price'=>'3.000','unit'=>'Kg','month'=>'142,5'],['code'=>'K-02','name'=>'Kardus & Box Tebal','detail'=>'Karton gelombang cokelat, kemasan kering & terikat','price'=>'2.000','unit'=>'Kg','month'=>'115,0'],['code'=>'K-03','name'=>'Kertas HVS & Arsip','detail'=>'Buku tulis, kertas dokumen putih, majalah bebas staples','price'=>'2.500','unit'=>'Kg','month'=>'68,0'],['code'=>'K-04','name'=>'Botol Kaca Utuh','detail'=>'Botol kecap, sirup, saus tanpa retak dan sudah dibilas','price'=>'1.500','unit'=>'Kg','month'=>'22,0'],['code'=>'K-05','name'=>'Kaleng & Aluminium','detail'=>'Kaleng soft drink, piring seng lembaran, panci aluminium','price'=>'6.000','unit'=>'Kg','month'=>'45,2'],['code'=>'K-06','name'=>'Minyak Jelantah (UCO)','detail'=>'Minyak goreng jelantah jernih disaring, wadah jerigen tertutup','price'=>'4.500','unit'=>'Liter','month'=>'18,0']];
        $transactions = [
            ['id'=>'ST-00021','date'=>'07 Sep 2026','time'=>'08:21 WIB','name'=>'Budi Santoso','number'=>'NS003','class'=>'XII RPL B','jenis'=>'Plastik Daur Ulang','weight'=>'2.5','price'=>'3.000','total'=>'7.500','officer'=>'Ibu Sri Wahyuni','status'=>'Sukses','phone'=>'0812-3456-7890'],
            ['id'=>'ST-00020','date'=>'07 Sep 2026','time'=>'07:50 WIB','name'=>'Siti Aisyah','number'=>'NS012','class'=>'X AKL 1','jenis'=>'Kardus Box','weight'=>'4.0','price'=>'2.000','total'=>'8.000','officer'=>'Ibu Sri Wahyuni','status'=>'Sukses','phone'=>'0857-1122-3344'],
            ['id'=>'ST-00019','date'=>'06 Sep 2026','time'=>'14:10 WIB','name'=>'Pak Hendra Pratama','number'=>'NS001','class'=>'Guru BK','jenis'=>'Kertas Arsip & HVS','weight'=>'6.2','price'=>'2.500','total'=>'15.500','officer'=>'Pak Joko','status'=>'Sukses','phone'=>'0813-9988-7766'],
            ['id'=>'ST-00018','date'=>'06 Sep 2026','time'=>'11:30 WIB','name'=>'Rian Pratama','number'=>'NS045','class'=>'XI TKJ 2','jenis'=>'Botol Plastik Bersih','weight'=>'1.8','price'=>'4.000','total'=>'7.200','officer'=>'Ibu Sri Wahyuni','status'=>'Sukses','phone'=>'0878-4455-6677'],
            ['id'=>'ST-00017','date'=>'05 Sep 2026','time'=>'10:15 WIB','name'=>'Dewi Sartika','number'=>'NS078','class'=>'X DKV 3','jenis'=>'Kaleng & Aluminium','weight'=>'3.0','price'=>'6.000','total'=>'18.000','officer'=>'Pak Joko','status'=>'Sukses','phone'=>'0896-3322-1100'],
        ];
        $accounts = [['number'=>'NS003','name'=>'Budi Santoso','username'=>'@budi.santoso','role'=>'Siswa Nasabah','class'=>'XII RPL B','phone'=>'0812-3456-7890','initial'=>'BS','status'=>'Aktif'],['number'=>'NS012','name'=>'Dra. Endang Purwanti','username'=>'@endang.purwanti','role'=>'Guru / Tendik','class'=>'Wali Kelas XII RPL','phone'=>'0813-8899-2211','initial'=>'EP','status'=>'Aktif'],['number'=>'NS045','name'=>'Andi Saputra','username'=>'@andi.petugas','role'=>'Petugas Loket','class'=>'Unit Piket Mandiri','phone'=>'0857-1122-3344','initial'=>'AS','status'=>'Aktif'],['number'=>'NS078','name'=>'Siti Aisyah','username'=>'@siti.aisyah','role'=>'Siswa Nasabah','class'=>'X AKL 1','phone'=>'0878-9900-1122','initial'=>'SA','status'=>'Aktif'],['number'=>'NS099','name'=>'Bambang Wijaya','username'=>'@bambang.w','role'=>'Alumni Siswa','class'=>'Lulusan 2025','phone'=>'0819-2233-4455','initial'=>'BW','status'=>'Nonaktif']];
        return compact('admin','stats','students','waste','transactions','accounts');
    }
    public function dashboard(){return view('admin.dashboard',$this->data());}     public function nasabah(){return view('admin.nasabah',$this->data());}
    public function rekapNasabah($number){
        $data = $this->data();
        $student = collect($data['students'])->firstWhere('number', $number)
            ?? ['number'=>$number,'name'=>'Budi Santoso','class'=>'XII RPL B','phone'=>'0812-3456-7890','balance'=>'42.500','count'=>'7','initial'=>'BS','status'=>'Aktif'];
        $transactions = collect($data['transactions'])->filter(fn($t) => $t['number'] === $number)->values()->all();
        if (empty($transactions)) {
            $transactions = $data['transactions'];
        }
        return view('admin.rekap-nasabah', array_merge($data, compact('student', 'transactions')));
    }
    public function jenisSampah(){return view('admin.jenis-sampah',$this->data());}     public function akun(){return view('admin.akun',$this->data());}
    public function riwayat(){return view('admin.riwayat',$this->data());}
}
