<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Medication;
use App\Models\LabTestType;
use App\Models\RadiologyTestType;
use App\Models\ServiceCharge;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $roles = [
            ['nama' => 'admin', 'deskripsi' => 'Administrator sistem'],
            ['nama' => 'doctor', 'deskripsi' => 'Dokter'],
            ['nama' => 'nurse', 'deskripsi' => 'Perawat'],
            ['nama' => 'front_office', 'deskripsi' => 'Staf front office'],
            ['nama' => 'pharmacist', 'deskripsi' => 'Staf farmasi'],
            ['nama' => 'lab_technician', 'deskripsi' => 'Staf laboratorium'],
            ['nama' => 'radiologist', 'deskripsi' => 'Staf radiologi'],
            ['nama' => 'cashier', 'deskripsi' => 'Kasir'],
            ['nama' => 'management', 'deskripsi' => 'Manajemen'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create Admin User
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 1,
        ]);

        // Create Departments
        $departments = [
            ['kode' => 'PD', 'nama' => 'Penyakit Dalam', 'deskripsi' => 'Departemen Penyakit Dalam'],
            ['kode' => 'BED', 'nama' => 'Bedah', 'deskripsi' => 'Departemen Bedah'],
            ['kode' => 'ANK', 'nama' => 'Anak', 'deskripsi' => 'Departemen Anak'],
            ['kode' => 'KDG', 'nama' => 'Kandungan', 'deskripsi' => 'Departemen Kandungan'],
            ['kode' => 'JTG', 'nama' => 'Jantung', 'deskripsi' => 'Departemen Jantung'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create Doctor User and Doctor
        $doctorUser = User::create([
            'nama' => 'Dr. Ahmad Santoso, Sp.PD',
            'email' => 'ahmad@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 2,
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'departemen_id' => 1,
            'spesialisasi' => 'Penyakit Dalam',
            'nomor_izin_praktik' => 'STR-001-2024',
            'telepon' => '081234567890',
            'biaya_konsultasi' => 150000,
        ]);

        // Create Nurse User and Nurse
        $nurseUser = User::create([
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 3,
        ]);

        Nurse::create([
            'user_id' => $nurseUser->id,
            'departemen_id' => 1,
            'nomor_izin_praktik' => 'STR-N-001-2024',
            'telepon' => '081234567891',
        ]);

        // Create Front Office User
        User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 4,
        ]);

        // Create Pharmacist User
        User::create([
            'nama' => 'Dewi Lestari',
            'email' => 'dewi@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 5,
        ]);

        // Create Lab Technician User
        User::create([
            'nama' => 'Rudi Hartono',
            'email' => 'rudi@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 6,
        ]);

        // Create Radiologist User
        User::create([
            'nama' => 'Andi Wijaya',
            'email' => 'andi@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 7,
        ]);

        // Create Cashier User
        User::create([
            'nama' => 'Fitriani Kusuma',
            'email' => 'fitri@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 8,
        ]);

        // Create Management User
        User::create([
            'nama' => 'Hendra Gunawan',
            'email' => 'hendra@hospital.com',
            'password' => Hash::make('password'),
            'peran_id' => 9,
        ]);

        // Create More Doctors
        $additionalDoctors = [
            ['nama' => 'Dr. Budi Hartono, Sp.B', 'email' => 'budi.h@hospital.com', 'departemen_id' => 2, 'spesialisasi' => 'Bedah Umum', 'nomor_izin_praktik' => 'STR-002-2024', 'telepon' => '081234567912', 'biaya_konsultasi' => 200000],
            ['nama' => 'Dr. Citra Dewi, Sp.A', 'email' => 'citra.d@hospital.com', 'departemen_id' => 3, 'spesialisasi' => 'Anak', 'nomor_izin_praktik' => 'STR-003-2024', 'telepon' => '081234567913', 'biaya_konsultasi' => 175000],
            ['nama' => 'Dr. Doni Prabowo, Sp.OG', 'email' => 'doni.p@hospital.com', 'departemen_id' => 4, 'spesialisasi' => 'Kandungan', 'nomor_izin_praktik' => 'STR-004-2024', 'telepon' => '081234567914', 'biaya_konsultasi' => 250000],
            ['nama' => 'Dr. Eka Wijaya, Sp.JP', 'email' => 'eka.w@hospital.com', 'departemen_id' => 5, 'spesialisasi' => 'Jantung dan Pembuluh Darah', 'nomor_izin_praktik' => 'STR-005-2024', 'telepon' => '081234567915', 'biaya_konsultasi' => 300000],
            ['nama' => 'Dr. Farah Amalia, Sp.PD', 'email' => 'farah.a@hospital.com', 'departemen_id' => 1, 'spesialisasi' => 'Penyakit Dalam', 'nomor_izin_praktik' => 'STR-006-2024', 'telepon' => '081234567916', 'biaya_konsultasi' => 180000],
        ];

        foreach ($additionalDoctors as $doc) {
            $doctorUser = User::create([
                'nama' => $doc['nama'],
                'email' => $doc['email'],
                'password' => Hash::make('password'),
                'peran_id' => 2,
            ]);

            Doctor::create([
                'user_id' => $doctorUser->id,
                'departemen_id' => $doc['departemen_id'],
                'spesialisasi' => $doc['spesialisasi'],
                'nomor_izin_praktik' => $doc['nomor_izin_praktik'],
                'telepon' => $doc['telepon'],
                'biaya_konsultasi' => $doc['biaya_konsultasi'],
            ]);
        }

        // Create More Nurses
        $additionalNurses = [
            ['nama' => 'Ana Wijaya', 'email' => 'ana.w@hospital.com', 'departemen_id' => 2, 'nomor_izin_praktik' => 'STR-N-002-2024', 'telepon' => '081234567917'],
            ['nama' => 'Bela Kusuma', 'email' => 'bela.k@hospital.com', 'departemen_id' => 3, 'nomor_izin_praktik' => 'STR-N-003-2024', 'telepon' => '081234567918'],
            ['nama' => 'Cinta Lestari', 'email' => 'cinta.l@hospital.com', 'departemen_id' => 4, 'nomor_izin_praktik' => 'STR-N-004-2024', 'telepon' => '081234567919'],
            ['nama' => 'Diana Putri', 'email' => 'diana.p@hospital.com', 'departemen_id' => 5, 'nomor_izin_praktik' => 'STR-N-005-2024', 'telepon' => '081234567920'],
        ];

        foreach ($additionalNurses as $nurse) {
            $nurseUser = User::create([
                'nama' => $nurse['nama'],
                'email' => $nurse['email'],
                'password' => Hash::make('password'),
                'peran_id' => 3,
            ]);

            Nurse::create([
                'user_id' => $nurseUser->id,
                'departemen_id' => $nurse['departemen_id'],
                'nomor_izin_praktik' => $nurse['nomor_izin_praktik'],
                'telepon' => $nurse['telepon'],
            ]);
        }

        // Create Rooms
        for ($i = 1; $i <= 5; $i++) {
            $room = Room::create([
                'nomor_ruangan' => 'R-10' . $i,
                'nama' => 'Ruangan Kelas ' . ($i <= 3 ? 'VIP' : 'Reguler'),
                'departemen_id' => 1,
                'jenis' => $i <= 3 ? 'vip' : 'kelas_3',
                'tarif_per_hari' => $i <= 3 ? 500000 : 200000,
                'kapasitas' => $i <= 3 ? 1 : 4,
                'status' => 'tersedia',
            ]);

            // Create Beds for each room
            $bedCount = $room->kapasitas;
            for ($j = 1; $j <= $bedCount; $j++) {
                Bed::create([
                    'ruangan_id' => $room->id,
                    'nomor_tempat_tidur' => 'R-10' . $i . '-' . $j,
                    'status' => 'tersedia',
                ]);
            }
        }

        // Create Sample Patients
        $patients = [
            ['no_rekam_medis' => 'MR-001-2024', 'nik' => '3201010101010001', 'nama' => 'Budi Santoso', 'tanggal_lahir' => '1990-01-01', 'jenis_kelamin' => 'laki_laki', 'agama' => 'islam', 'status_pernikahan' => 'menikah', 'telepon' => '081234567892', 'email' => 'budi@email.com', 'alamat' => 'Jl. Merdeka No. 123, Jakarta', 'golongan_darah' => 'A', 'nama_kontak_darurat' => 'Siti Santoso', 'telepon_kontak_darurat' => '081234567893', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-002-2024', 'nik' => '3201010202020002', 'nama' => 'Sari Wulandari', 'tanggal_lahir' => '1985-05-15', 'jenis_kelamin' => 'perempuan', 'agama' => 'kristen', 'status_pernikahan' => 'menikah', 'telepon' => '081234567894', 'email' => 'sari@email.com', 'alamat' => 'Jl. Sudirman No. 456, Jakarta', 'golongan_darah' => 'B', 'nama_kontak_darurat' => 'Andi Wulandari', 'telepon_kontak_darurat' => '081234567895', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-003-2024', 'nik' => '3201010303030003', 'nama' => 'Andi Wijaya', 'tanggal_lahir' => '1992-03-20', 'jenis_kelamin' => 'laki_laki', 'agama' => 'islam', 'status_pernikahan' => 'belum_menikah', 'telepon' => '081234567896', 'email' => 'andi.w@email.com', 'alamat' => 'Jl. Gatot Subroto No. 789, Jakarta', 'golongan_darah' => 'O', 'nama_kontak_darurat' => 'Budi Wijaya', 'telepon_kontak_darurat' => '081234567897', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-004-2024', 'nik' => '3201010404040004', 'nama' => 'Dewi Anggraini', 'tanggal_lahir' => '1988-07-12', 'jenis_kelamin' => 'perempuan', 'agama' => 'katolik', 'status_pernikahan' => 'menikah', 'telepon' => '081234567898', 'email' => 'dewi.a@email.com', 'alamat' => 'Jl. Thamrin No. 234, Jakarta', 'golongan_darah' => 'AB', 'nama_kontak_darurat' => 'Rudi Anggraini', 'telepon_kontak_darurat' => '081234567899', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-005-2024', 'nik' => '3201010505050005', 'nama' => 'Eko Prasetyo', 'tanggal_lahir' => '1995-11-08', 'jenis_kelamin' => 'laki_laki', 'agama' => 'islam', 'status_pernikahan' => 'belum_menikah', 'telepon' => '081234567900', 'email' => 'eko.p@email.com', 'alamat' => 'Jl. Kuningan No. 567, Jakarta', 'golongan_darah' => 'A', 'nama_kontak_darurat' => 'Sri Prasetyo', 'telepon_kontak_darurat' => '081234567901', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-006-2024', 'nik' => '3201010606060006', 'nama' => 'Fitri Handayani', 'tanggal_lahir' => '1991-04-25', 'jenis_kelamin' => 'perempuan', 'agama' => 'islam', 'status_pernikahan' => 'menikah', 'telepon' => '081234567902', 'email' => 'fitri.h@email.com', 'alamat' => 'Jl. Rasuna Said No. 890, Jakarta', 'golongan_darah' => 'B', 'nama_kontak_darurat' => 'Ahmad Handayani', 'telepon_kontak_darurat' => '081234567903', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-007-2024', 'nik' => '3201010707070007', 'nama' => 'Gunawan Setiawan', 'tanggal_lahir' => '1987-09-14', 'jenis_kelamin' => 'laki_laki', 'agama' => 'buddha', 'status_pernikahan' => 'menikah', 'telepon' => '081234567904', 'email' => 'gun.s@email.com', 'alamat' => 'Jl. Senopati No. 123, Jakarta', 'golongan_darah' => 'O', 'nama_kontak_darurat' => 'Linda Setiawan', 'telepon_kontak_darurat' => '081234567905', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-008-2024', 'nik' => '3201010808080008', 'nama' => 'Hendra Kusuma', 'tanggal_lahir' => '1993-12-30', 'jenis_kelamin' => 'laki_laki', 'agama' => 'islam', 'status_pernikahan' => 'belum_menikah', 'telepon' => '081234567906', 'email' => 'hendra.k@email.com', 'alamat' => 'Jl. Menteng No. 456, Jakarta', 'golongan_darah' => 'A', 'nama_kontak_darurat' => 'Yanti Kusuma', 'telepon_kontak_darurat' => '081234567907', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-009-2024', 'nik' => '3201010909090009', 'nama' => 'Indah Permata', 'tanggal_lahir' => '1989-06-18', 'jenis_kelamin' => 'perempuan', 'agama' => 'hindu', 'status_pernikahan' => 'menikah', 'telepon' => '081234567908', 'email' => 'indah.p@email.com', 'alamat' => 'Jl. Cikini No. 789, Jakarta', 'golongan_darah' => 'B', 'nama_kontak_darurat' => 'Made Permata', 'telepon_kontak_darurat' => '081234567909', 'status' => 'aktif'],
            ['no_rekam_medis' => 'MR-010-2024', 'nik' => '3201011010100010', 'nama' => 'Joko Widodo', 'tanggal_lahir' => '1994-02-28', 'jenis_kelamin' => 'laki_laki', 'agama' => 'islam', 'status_pernikahan' => 'belum_menikah', 'telepon' => '081234567910', 'email' => 'joko.w@email.com', 'alamat' => 'Jl. Salemba No. 321, Jakarta', 'golongan_darah' => 'AB', 'nama_kontak_darurat' => 'Susi Widodo', 'telepon_kontak_darurat' => '081234567911', 'status' => 'aktif'],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }

        // Create Medications (30 obat dengan harga lengkap)
        $medications = [
            ['kode' => 'MED-001', 'nama' => 'Paracetamol 500mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 1000, 'stok_minimum' => 100, 'harga' => 500, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Analgesik'],
            ['kode' => 'MED-002', 'nama' => 'Ibuprofen 400mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '400mg', 'satuan' => 'tablet', 'stok' => 800, 'stok_minimum' => 80, 'harga' => 1500, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Analgesik'],
            ['kode' => 'MED-003', 'nama' => 'Asam Mefenamat 500mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 600, 'stok_minimum' => 60, 'harga' => 2000, 'tanggal_kadaluarsa' => '2026-10-31', 'kategori' => 'Analgesik'],
            ['kode' => 'MED-004', 'nama' => 'Amoxicillin 500mg', 'bentuk_sediaan' => 'kapsul', 'kekuatan' => '500mg', 'satuan' => 'kapsul', 'stok' => 500, 'stok_minimum' => 50, 'harga' => 2000, 'tanggal_kadaluarsa' => '2026-08-31', 'kategori' => 'Antibiotik'],
            ['kode' => 'MED-005', 'nama' => 'Ciprofloxacin 500mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 400, 'stok_minimum' => 40, 'harga' => 5000, 'tanggal_kadaluarsa' => '2026-09-30', 'kategori' => 'Antibiotik'],
            ['kode' => 'MED-006', 'nama' => 'Cefadroxil 500mg', 'bentuk_sediaan' => 'kapsul', 'kekuatan' => '500mg', 'satuan' => 'kapsul', 'stok' => 350, 'stok_minimum' => 35, 'harga' => 3500, 'tanggal_kadaluarsa' => '2026-11-30', 'kategori' => 'Antibiotik'],
            ['kode' => 'MED-007', 'nama' => 'Azithromycin 500mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 300, 'stok_minimum' => 30, 'harga' => 8000, 'tanggal_kadaluarsa' => '2026-07-31', 'kategori' => 'Antibiotik'],
            ['kode' => 'MED-008', 'nama' => 'Vitamin C 1000mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '1000mg', 'satuan' => 'tablet', 'stok' => 800, 'stok_minimum' => 80, 'harga' => 1000, 'tanggal_kadaluarsa' => '2027-03-31', 'kategori' => 'Vitamin'],
            ['kode' => 'MED-009', 'nama' => 'Vitamin B Complex', 'bentuk_sediaan' => 'tablet', 'kekuatan' => 'multi', 'satuan' => 'tablet', 'stok' => 700, 'stok_minimum' => 70, 'harga' => 1200, 'tanggal_kadaluarsa' => '2027-02-28', 'kategori' => 'Vitamin'],
            ['kode' => 'MED-010', 'nama' => 'Multivitamin', 'bentuk_sediaan' => 'kapsul', 'kekuatan' => 'multi', 'satuan' => 'kapsul', 'stok' => 900, 'stok_minimum' => 90, 'harga' => 2500, 'tanggal_kadaluarsa' => '2027-04-30', 'kategori' => 'Vitamin'],
            ['kode' => 'MED-011', 'nama' => 'Omeprazole 20mg', 'bentuk_sediaan' => 'kapsul', 'kekuatan' => '20mg', 'satuan' => 'kapsul', 'stok' => 450, 'stok_minimum' => 45, 'harga' => 3000, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Pencernaan'],
            ['kode' => 'MED-012', 'nama' => 'Antasida Tablet', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 600, 'stok_minimum' => 60, 'harga' => 800, 'tanggal_kadaluarsa' => '2026-11-30', 'kategori' => 'Pencernaan'],
            ['kode' => 'MED-013', 'nama' => 'Domperidone 10mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '10mg', 'satuan' => 'tablet', 'stok' => 500, 'stok_minimum' => 50, 'harga' => 1500, 'tanggal_kadaluarsa' => '2026-10-31', 'kategori' => 'Pencernaan'],
            ['kode' => 'MED-014', 'nama' => 'Metformin 500mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '500mg', 'satuan' => 'tablet', 'stok' => 1000, 'stok_minimum' => 100, 'harga' => 1000, 'tanggal_kadaluarsa' => '2027-01-31', 'kategori' => 'Antidiabetes'],
            ['kode' => 'MED-015', 'nama' => 'Glimepiride 2mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '2mg', 'satuan' => 'tablet', 'stok' => 400, 'stok_minimum' => 40, 'harga' => 3500, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Antidiabetes'],
            ['kode' => 'MED-016', 'nama' => 'Amlodipine 5mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '5mg', 'satuan' => 'tablet', 'stok' => 800, 'stok_minimum' => 80, 'harga' => 2000, 'tanggal_kadaluarsa' => '2027-02-28', 'kategori' => 'Antihipertensi'],
            ['kode' => 'MED-017', 'nama' => 'Captopril 25mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '25mg', 'satuan' => 'tablet', 'stok' => 700, 'stok_minimum' => 70, 'harga' => 1500, 'tanggal_kadaluarsa' => '2026-11-30', 'kategori' => 'Antihipertensi'],
            ['kode' => 'MED-018', 'nama' => 'Valsartan 80mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '80mg', 'satuan' => 'tablet', 'stok' => 500, 'stok_minimum' => 50, 'harga' => 4000, 'tanggal_kadaluarsa' => '2027-01-31', 'kategori' => 'Antihipertensi'],
            ['kode' => 'MED-019', 'nama' => 'Cetirizine 10mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '10mg', 'satuan' => 'tablet', 'stok' => 600, 'stok_minimum' => 60, 'harga' => 1200, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Antihistamin'],
            ['kode' => 'MED-020', 'nama' => 'Loratadine 10mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '10mg', 'satuan' => 'tablet', 'stok' => 550, 'stok_minimum' => 55, 'harga' => 1000, 'tanggal_kadaluarsa' => '2026-11-30', 'kategori' => 'Antihistamin'],
            ['kode' => 'MED-021', 'nama' => 'OBH Sirup', 'bentuk_sediaan' => 'sirup', 'kekuatan' => '100ml', 'satuan' => 'botol', 'stok' => 200, 'stok_minimum' => 20, 'harga' => 15000, 'tanggal_kadaluarsa' => '2026-09-30', 'kategori' => 'Batuk & Flu'],
            ['kode' => 'MED-022', 'nama' => 'Dextromethorphan 15mg', 'bentuk_sediaan' => 'tablet', 'kekuatan' => '15mg', 'satuan' => 'tablet', 'stok' => 400, 'stok_minimum' => 40, 'harga' => 2000, 'tanggal_kadaluarsa' => '2026-10-31', 'kategori' => 'Batuk & Flu'],
            ['kode' => 'MED-023', 'nama' => 'Ceftriaxone 1g Injection', 'bentuk_sediaan' => 'injeksi', 'kekuatan' => '1g', 'satuan' => 'vial', 'stok' => 150, 'stok_minimum' => 15, 'harga' => 25000, 'tanggal_kadaluarsa' => '2026-08-31', 'kategori' => 'Antibiotik Injeksi'],
            ['kode' => 'MED-024', 'nama' => 'Dexamethasone 4mg/ml Injection', 'bentuk_sediaan' => 'injeksi', 'kekuatan' => '4mg/ml', 'satuan' => 'ampul', 'stok' => 200, 'stok_minimum' => 20, 'harga' => 15000, 'tanggal_kadaluarsa' => '2026-12-31', 'kategori' => 'Anti-inflamasi Injeksi'],
            ['kode' => 'MED-025', 'nama' => 'Ranitidin Injection', 'bentuk_sediaan' => 'injeksi', 'kekuatan' => '25mg/ml', 'satuan' => 'ampul', 'stok' => 180, 'stok_minimum' => 18, 'harga' => 12000, 'tanggal_kadaluarsa' => '2026-11-30', 'kategori' => 'Pencernaan Injeksi'],
            ['kode' => 'MED-026', 'nama' => 'Hydrocortisone Cream 1%', 'bentuk_sediaan' => 'krim', 'kekuatan' => '1%', 'satuan' => 'tube', 'stok' => 100, 'stok_minimum' => 10, 'harga' => 18000, 'tanggal_kadaluarsa' => '2026-10-31', 'kategori' => 'Topikal'],
            ['kode' => 'MED-027', 'nama' => 'Gentamicin Salep', 'bentuk_sediaan' => 'salep', 'kekuatan' => '0.1%', 'satuan' => 'tube', 'stok' => 120, 'stok_minimum' => 12, 'harga' => 22000, 'tanggal_kadaluarsa' => '2026-09-30', 'kategori' => 'Topikal'],
            ['kode' => 'MED-028', 'nama' => 'Cendo Xitrol Tetes Mata', 'bentuk_sediaan' => 'tetes mata', 'kekuatan' => '5ml', 'satuan' => 'botol', 'stok' => 80, 'stok_minimum' => 8, 'harga' => 35000, 'tanggal_kadaluarsa' => '2026-07-31', 'kategori' => 'Oftalmik'],
            ['kode' => 'MED-029', 'nama' => 'NaCl 0.9% 500ml', 'bentuk_sediaan' => 'infus', 'kekuatan' => '500ml', 'satuan' => 'botol', 'stok' => 300, 'stok_minimum' => 30, 'harga' => 20000, 'tanggal_kadaluarsa' => '2027-06-30', 'kategori' => 'Cairan Infus'],
            ['kode' => 'MED-030', 'nama' => 'Dextrose 5% 500ml', 'bentuk_sediaan' => 'infus', 'kekuatan' => '500ml', 'satuan' => 'botol', 'stok' => 280, 'stok_minimum' => 28, 'harga' => 22000, 'tanggal_kadaluarsa' => '2027-06-30', 'kategori' => 'Cairan Infus'],
        ];

        foreach ($medications as $med) {
            Medication::create($med);
        }

        // Create Lab Test Types (15 tes dengan harga)
        $labTests = [
            ['nama' => 'Hematologi - Darah Lengkap', 'kode' => 'LAB-001', 'harga' => 150000, 'kategori' => 'Hematologi', 'deskripsi' => 'Pemeriksaan komponen darah lengkap (Hb, Leukosit, Eritrosit, Trombosit, dll)'],
            ['nama' => 'Kimia Klinik - Gula Darah Puasa', 'kode' => 'LAB-002', 'harga' => 50000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan kadar gula darah puasa'],
            ['nama' => 'Kimia Klinik - Gula Darah 2 Jam PP', 'kode' => 'LAB-003', 'harga' => 50000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan kadar gula darah 2 jam setelah makan'],
            ['nama' => 'Kimia Klinik - HbA1c', 'kode' => 'LAB-004', 'harga' => 200000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan rata-rata gula darah 3 bulan terakhir'],
            ['nama' => 'Kimia Klinik - Kolesterol Total', 'kode' => 'LAB-005', 'harga' => 75000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan kadar kolesterol total'],
            ['nama' => 'Kimia Klinik - Profil Lipid', 'kode' => 'LAB-006', 'harga' => 250000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan kolesterol total, HDL, LDL, Trigliserida'],
            ['nama' => 'Kimia Klinik - Fungsi Hati (SGOT/SGPT)', 'kode' => 'LAB-007', 'harga' => 150000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan fungsi hati'],
            ['nama' => 'Kimia Klinik - Fungsi Ginjal (Ureum/Kreatinin)', 'kode' => 'LAB-008', 'harga' => 120000, 'kategori' => 'Kimia Klinik', 'deskripsi' => 'Pemeriksaan fungsi ginjal'],
            ['nama' => 'Urinalisis - Urine Lengkap', 'kode' => 'LAB-009', 'harga' => 100000, 'kategori' => 'Urinalisis', 'deskripsi' => 'Pemeriksaan urine lengkap'],
            ['nama' => 'Serologi - Widal Test', 'kode' => 'LAB-010', 'harga' => 80000, 'kategori' => 'Serologi', 'deskripsi' => 'Pemeriksaan tifus (typhoid)'],
            ['nama' => 'Serologi - HBsAg', 'kode' => 'LAB-011', 'harga' => 120000, 'kategori' => 'Serologi', 'deskripsi' => 'Pemeriksaan Hepatitis B'],
            ['nama' => 'Serologi - Anti HCV', 'kode' => 'LAB-012', 'harga' => 150000, 'kategori' => 'Serologi', 'deskripsi' => 'Pemeriksaan Hepatitis C'],
            ['nama' => 'Serologi - HIV Test', 'kode' => 'LAB-013', 'harga' => 200000, 'kategori' => 'Serologi', 'deskripsi' => 'Pemeriksaan HIV'],
            ['nama' => 'Mikrobiologi - Kultur Darah', 'kode' => 'LAB-014', 'harga' => 300000, 'kategori' => 'Mikrobiologi', 'deskripsi' => 'Kultur dan sensitivitas darah'],
            ['nama' => 'Mikrobiologi - Kultur Urine', 'kode' => 'LAB-015', 'harga' => 250000, 'kategori' => 'Mikrobiologi', 'deskripsi' => 'Kultur dan sensitivitas urine'],
        ];

        foreach ($labTests as $test) {
            LabTestType::create($test);
        }

        // Create Radiology Test Types (15 tes dengan harga)
        $radioTests = [
            ['nama' => 'Rontgen Thorax AP/PA', 'kode' => 'RAD-001', 'harga' => 200000, 'kategori' => 'Radiologi Konvensional', 'deskripsi' => 'Foto rontgen dada posisi AP/PA'],
            ['nama' => 'Rontgen Abdomen', 'kode' => 'RAD-002', 'harga' => 250000, 'kategori' => 'Radiologi Konvensional', 'deskripsi' => 'Foto rontgen perut'],
            ['nama' => 'Rontgen Cervical', 'kode' => 'RAD-003', 'harga' => 220000, 'kategori' => 'Radiologi Konvensional', 'deskripsi' => 'Foto rontgen leher'],
            ['nama' => 'Rontgen Lumbosakral', 'kode' => 'RAD-004', 'harga' => 250000, 'kategori' => 'Radiologi Konvensional', 'deskripsi' => 'Foto rontgen pinggang'],
            ['nama' => 'Rontgen Ekstremitas', 'kode' => 'RAD-005', 'harga' => 180000, 'kategori' => 'Radiologi Konvensional', 'deskripsi' => 'Foto rontgen tangan/kaki'],
            ['nama' => 'USG Abdomen', 'kode' => 'RAD-006', 'harga' => 350000, 'kategori' => 'USG', 'deskripsi' => 'USG perut'],
            ['nama' => 'USG Obstetri', 'kode' => 'RAD-007', 'harga' => 300000, 'kategori' => 'USG', 'deskripsi' => 'USG kehamilan'],
            ['nama' => 'USG Mammae', 'kode' => 'RAD-008', 'harga' => 400000, 'kategori' => 'USG', 'deskripsi' => 'USG payudara'],
            ['nama' => 'CT Scan Kepala', 'kode' => 'RAD-009', 'harga' => 1500000, 'kategori' => 'CT Scan', 'deskripsi' => 'CT Scan otak'],
            ['nama' => 'CT Scan Thorax', 'kode' => 'RAD-010', 'harga' => 1800000, 'kategori' => 'CT Scan', 'deskripsi' => 'CT Scan dada'],
            ['nama' => 'CT Scan Abdomen', 'kode' => 'RAD-011', 'harga' => 2000000, 'kategori' => 'CT Scan', 'deskripsi' => 'CT Scan perut'],
            ['nama' => 'MRI Kepala', 'kode' => 'RAD-012', 'harga' => 3000000, 'kategori' => 'MRI', 'deskripsi' => 'MRI otak'],
            ['nama' => 'MRI Lumbal', 'kode' => 'RAD-013', 'harga' => 3500000, 'kategori' => 'MRI', 'deskripsi' => 'MRI tulang belakang'],
            ['nama' => 'Mammografi', 'kode' => 'RAD-014', 'harga' => 800000, 'kategori' => 'Radiologi Khusus', 'deskripsi' => 'Pemeriksaan payudara dengan sinar-X'],
            ['nama' => 'BNO-IVP', 'kode' => 'RAD-015', 'harga' => 1200000, 'kategori' => 'Radiologi Khusus', 'deskripsi' => 'Pemeriksaan ginjal dan saluran kemih dengan kontras'],
        ];

        foreach ($radioTests as $test) {
            RadiologyTestType::create($test);
        }

        // Create Service Charges (10 layanan dengan harga)
        $serviceCharges = [
            ['kode' => 'SVC-001', 'nama_layanan' => 'Konsultasi Dokter Umum', 'kategori' => 'konsultasi', 'harga' => 100000, 'deskripsi' => 'Konsultasi dengan dokter umum'],
            ['kode' => 'SVC-002', 'nama_layanan' => 'Konsultasi Dokter Spesialis', 'kategori' => 'konsultasi', 'harga' => 150000, 'deskripsi' => 'Konsultasi dengan dokter spesialis'],
            ['kode' => 'SVC-003', 'nama_layanan' => 'Tindakan Medis Ringan', 'kategori' => 'tindakan', 'harga' => 200000, 'deskripsi' => 'Tindakan medis ringan seperti jahit luka kecil'],
            ['kode' => 'SVC-004', 'nama_layanan' => 'Tindakan Medis Sedang', 'kategori' => 'tindakan', 'harga' => 500000, 'deskripsi' => 'Tindakan medis sedang'],
            ['kode' => 'SVC-005', 'nama_layanan' => 'Operasi Kecil', 'kategori' => 'operasi', 'harga' => 2000000, 'deskripsi' => 'Operasi kecil dengan bius lokal'],
            ['kode' => 'SVC-006', 'nama_layanan' => 'Operasi Sedang', 'kategori' => 'operasi', 'harga' => 5000000, 'deskripsi' => 'Operasi sedang dengan bius umum'],
            ['kode' => 'SVC-007', 'nama_layanan' => 'Operasi Besar', 'kategori' => 'operasi', 'harga' => 10000000, 'deskripsi' => 'Operasi besar dengan persiapan khusus'],
            ['kode' => 'SVC-008', 'nama_layanan' => 'Perawatan Luka', 'kategori' => 'tindakan', 'harga' => 50000, 'deskripsi' => 'Perawatan dan pembersihan luka'],
            ['kode' => 'SVC-009', 'nama_layanan' => 'Infus', 'kategori' => 'tindakan', 'harga' => 75000, 'deskripsi' => 'Pemasangan infus'],
            ['kode' => 'SVC-010', 'nama_layanan' => 'Injeksi', 'kategori' => 'tindakan', 'harga' => 30000, 'deskripsi' => 'Suntikan injeksi'],
        ];

        foreach ($serviceCharges as $charge) {
            ServiceCharge::create($charge);
        }

        // Create Sample Appointments for Queue System
        $appointments = [
            // Department 1 - Penyakit Dalam (Dr. Ahmad & Dr. Farah)
            // Morning - Check-in & In Consultation
            ['pasien_id' => 1, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(8)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'sedang_dilayani', 'alasan' => 'Kontrol diabetes', 'catatan' => 'Pasien rutin kontrol', 'nomor_antrian' => 1, 'kode_antrian' => 'PD001', 'waktu_check_in' => now()->subHours(2), 'waktu_mulai_konsultasi' => now()->subMinutes(30)],
            ['pasien_id' => 2, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(8)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Sakit maag', 'catatan' => 'Nyeri ulu hati', 'nomor_antrian' => 2, 'kode_antrian' => 'PD002', 'waktu_check_in' => now()->subHours(1)],
            ['pasien_id' => 3, 'dokter_id' => 6, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(9)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Hipertensi', 'catatan' => 'Tekanan darah tinggi', 'nomor_antrian' => 3, 'kode_antrian' => 'PD003', 'waktu_check_in' => now()->subMinutes(45)],
            ['pasien_id' => 4, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(9)->setMinute(30), 'jenis' => 'kontrol_ulang', 'status' => 'check_in', 'alasan' => 'Kontrol kolesterol', 'catatan' => 'Hasil lab bulan lalu tinggi', 'nomor_antrian' => 4, 'kode_antrian' => 'PD004', 'waktu_check_in' => now()->subMinutes(30)],
            // Morning - Completed
            ['pasien_id' => 5, 'dokter_id' => 6, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(7)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'Demam', 'catatan' => 'Sudah 3 hari demam', 'nomor_antrian' => 5, 'kode_antrian' => 'PD005', 'waktu_check_in' => now()->subHours(3), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(45)],
            ['pasien_id' => 6, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(7)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'Batuk pilek', 'catatan' => 'Batuk berdahak', 'nomor_antrian' => 6, 'kode_antrian' => 'PD006', 'waktu_check_in' => now()->subHours(3)->subMinutes(30), 'waktu_mulai_konsultasi' => now()->subHours(3)->subMinutes(15)],
            // Afternoon - Scheduled
            ['pasien_id' => 7, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(13)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'dikonfirmasi', 'alasan' => 'Cek kesehatan rutin', 'catatan' => null],
            ['pasien_id' => 8, 'dokter_id' => 6, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(14)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'terjadwal', 'alasan' => 'Kontrol gula darah', 'catatan' => null],

            // Department 2 - Bedah (Dr. Budi Hartono)
            ['pasien_id' => 1, 'dokter_id' => 2, 'departemen_id' => 2, 'tanggal_janji' => now()->setHour(8)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'sedang_dilayani', 'alasan' => 'Luka bekas operasi', 'catatan' => 'Kontrol luka pasca operasi', 'nomor_antrian' => 1, 'kode_antrian' => 'BED001', 'waktu_check_in' => now()->subHours(2), 'waktu_mulai_konsultasi' => now()->subMinutes(15)],
            ['pasien_id' => 2, 'dokter_id' => 2, 'departemen_id' => 2, 'tanggal_janji' => now()->setHour(8)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Benjolan di leher', 'catatan' => 'Benjolan sebesar kelereng', 'nomor_antrian' => 2, 'kode_antrian' => 'BED002', 'waktu_check_in' => now()->subHours(1)->subMinutes(30)],
            ['pasien_id' => 9, 'dokter_id' => 2, 'departemen_id' => 2, 'tanggal_janji' => now()->setHour(9)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Wasir', 'catatan' => 'Nyeri saat BAB', 'nomor_antrian' => 3, 'kode_antrian' => 'BED003', 'waktu_check_in' => now()->subMinutes(40)],
            ['pasien_id' => 3, 'dokter_id' => 2, 'departemen_id' => 2, 'tanggal_janji' => now()->setHour(7)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'Abses', 'catatan' => 'Bisul di punggung', 'nomor_antrian' => 4, 'kode_antrian' => 'BED004', 'waktu_check_in' => now()->subHours(3), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(50)],
            ['pasien_id' => 10, 'dokter_id' => 2, 'departemen_id' => 2, 'tanggal_janji' => now()->setHour(14)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'terjadwal', 'alasan' => 'Kontrol luka jahitan', 'catatan' => null],

            // Department 3 - Anak (Dr. Citra Dewi)
            ['pasien_id' => 4, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(8)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'sedang_dilayani', 'alasan' => 'Demam tinggi anak', 'catatan' => 'Anak demam 39°C', 'nomor_antrian' => 1, 'kode_antrian' => 'ANK001', 'waktu_check_in' => now()->subHours(2), 'waktu_mulai_konsultasi' => now()->subMinutes(20)],
            ['pasien_id' => 5, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(8)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Imunisasi', 'catatan' => 'Imunisasi campak', 'nomor_antrian' => 2, 'kode_antrian' => 'ANK002', 'waktu_check_in' => now()->subHours(1)->subMinutes(20)],
            ['pasien_id' => 6, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(9)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Diare anak', 'catatan' => 'BAB cair 5x/hari', 'nomor_antrian' => 3, 'kode_antrian' => 'ANK003', 'waktu_check_in' => now()->subMinutes(50)],
            ['pasien_id' => 7, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(7)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'Batuk pilek', 'catatan' => 'Pilek 4 hari', 'nomor_antrian' => 4, 'kode_antrian' => 'ANK004', 'waktu_check_in' => now()->subHours(3), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(45)],
            ['pasien_id' => 8, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(7)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'Alergi kulit', 'catatan' => 'Ruam merah gatal', 'nomor_antrian' => 5, 'kode_antrian' => 'ANK005', 'waktu_check_in' => now()->subHours(2)->subMinutes(45), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(30)],
            ['pasien_id' => 9, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(13)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'dikonfirmasi', 'alasan' => 'Kontrol tumbuh kembang', 'catatan' => null],
            ['pasien_id' => 10, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->setHour(15)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'terjadwal', 'alasan' => 'Konsultasi gizi anak', 'catatan' => null],

            // Department 4 - Kandungan (Dr. Doni Prabowo)
            ['pasien_id' => 2, 'dokter_id' => 4, 'departemen_id' => 4, 'tanggal_janji' => now()->setHour(8)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'sedang_dilayani', 'alasan' => 'ANC (Antenatal Care)', 'catatan' => 'Kehamilan 20 minggu', 'nomor_antrian' => 1, 'kode_antrian' => 'KDG001', 'waktu_check_in' => now()->subHours(2), 'waktu_mulai_konsultasi' => now()->subMinutes(25)],
            ['pasien_id' => 4, 'dokter_id' => 4, 'departemen_id' => 4, 'tanggal_janji' => now()->setHour(8)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'USG kehamilan', 'catatan' => 'Kehamilan 12 minggu', 'nomor_antrian' => 2, 'kode_antrian' => 'KDG002', 'waktu_check_in' => now()->subHours(1)->subMinutes(15)],
            ['pasien_id' => 6, 'dokter_id' => 4, 'departemen_id' => 4, 'tanggal_janji' => now()->setHour(9)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Nyeri haid', 'catatan' => 'Nyeri hebat saat menstruasi', 'nomor_antrian' => 3, 'kode_antrian' => 'KDG003', 'waktu_check_in' => now()->subMinutes(35)],
            ['pasien_id' => 9, 'dokter_id' => 4, 'departemen_id' => 4, 'tanggal_janji' => now()->setHour(7)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'selesai', 'alasan' => 'Kontrol pasca melahirkan', 'catatan' => 'Post partum 2 minggu', 'nomor_antrian' => 4, 'kode_antrian' => 'KDG004', 'waktu_check_in' => now()->subHours(3), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(40)],
            ['pasien_id' => 1, 'dokter_id' => 4, 'departemen_id' => 4, 'tanggal_janji' => now()->setHour(14)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'dikonfirmasi', 'alasan' => 'Konsultasi program hamil', 'catatan' => null],

            // Department 5 - Jantung (Dr. Eka Wijaya)
            ['pasien_id' => 3, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(8)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'sedang_dilayani', 'alasan' => 'Nyeri dada', 'catatan' => 'Nyeri dada kiri', 'nomor_antrian' => 1, 'kode_antrian' => 'JTG001', 'waktu_check_in' => now()->subHours(2), 'waktu_mulai_konsultasi' => now()->subMinutes(10)],
            ['pasien_id' => 5, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(8)->setMinute(30), 'jenis' => 'rawat_jalan', 'status' => 'check_in', 'alasan' => 'Jantung berdebar', 'catatan' => 'Sering jantung berdebar kencang', 'nomor_antrian' => 2, 'kode_antrian' => 'JTG002', 'waktu_check_in' => now()->subHours(1)->subMinutes(10)],
            ['pasien_id' => 7, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(9)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'check_in', 'alasan' => 'Kontrol jantung koroner', 'catatan' => 'Pasien pasca pemasangan ring', 'nomor_antrian' => 3, 'kode_antrian' => 'JTG003', 'waktu_check_in' => now()->subMinutes(25)],
            ['pasien_id' => 10, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(7)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'selesai', 'alasan' => 'EKG rutin', 'catatan' => 'Pemeriksaan rutin', 'nomor_antrian' => 4, 'kode_antrian' => 'JTG004', 'waktu_check_in' => now()->subHours(3), 'waktu_mulai_konsultasi' => now()->subHours(2)->subMinutes(35)],
            ['pasien_id' => 8, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(13)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'dikonfirmasi', 'alasan' => 'Ekokardiografi', 'catatan' => null],
            ['pasien_id' => 1, 'dokter_id' => 5, 'departemen_id' => 5, 'tanggal_janji' => now()->setHour(15)->setMinute(0), 'jenis' => 'kontrol_ulang', 'status' => 'terjadwal', 'alasan' => 'Kontrol hipertensi', 'catatan' => null],

            // Cancelled appointment example
            ['pasien_id' => 2, 'dokter_id' => 1, 'departemen_id' => 1, 'tanggal_janji' => now()->setHour(10)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'dibatalkan', 'alasan' => 'Sakit kepala', 'catatan' => 'Pasien tidak bisa datang'],
            ['pasien_id' => 6, 'dokter_id' => 3, 'departemen_id' => 3, 'tanggal_janji' => now()->subDays(1)->setHour(9)->setMinute(0), 'jenis' => 'rawat_jalan', 'status' => 'tidak_hadir', 'alasan' => 'Vaksinasi booster', 'catatan' => 'Pasien tidak hadir tanpa kabar'],
        ];

        foreach ($appointments as $appointment) {
            \App\Models\Appointment::create($appointment);
        }

        // Call comprehensive data seeder
        $this->call(ComprehensiveDataSeeder::class);

        $this->command->info('==============================================');
        $this->command->info('Database seeded successfully!');
        $this->command->info('==============================================');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@hospital.com / password');
        $this->command->info('Doctor: ahmad@hospital.com / password');
        $this->command->info('Nurse: siti@hospital.com / password');
        $this->command->info('Front Office: budi@hospital.com / password');
        $this->command->info('Pharmacist: dewi@hospital.com / password');
        $this->command->info('Lab Technician: rudi@hospital.com / password');
        $this->command->info('Radiologist: andi@hospital.com / password');
        $this->command->info('Cashier: fitri@hospital.com / password');
        $this->command->info('Management: hendra@hospital.com / password');
        $this->command->info('==============================================');
        $this->command->info('Total Data:');
        $this->command->info('- 17 Users (9 roles)');
        $this->command->info('- 10 Patients');
        $this->command->info('- 6 Doctors');
        $this->command->info('- 5 Nurses');
        $this->command->info('- 5 Departments');
        $this->command->info('- 5 Rooms with 11 Beds');
        $this->command->info('- 30 Medications with prices');
        $this->command->info('- 15 Lab Test Types');
        $this->command->info('- 15 Radiology Test Types');
        $this->command->info('- 10 Service Charges');
        $this->command->info('- 38 Appointments (Queue System)');
        $this->command->info('- 5 Medical Records with ICD codes');
        $this->command->info('- 5 Laboratory Orders + 6 Results');
        $this->command->info('- 4 Radiology Orders (2 completed)');
        $this->command->info('- 4 Prescriptions + 8 Medication Items');
        $this->command->info('- 3 Inpatient Admissions (1 active)');
        $this->command->info('- 5 Daily Nursing Notes + 5 Vital Signs');
        $this->command->info('- 5 Invoices + 9 Items + 4 Payments');
        $this->command->info('==============================================');
        $this->command->info('Queue Status Summary:');
        $this->command->info('- Sedang Dilayani: 5 appointments');
        $this->command->info('- Check-in (Menunggu): 15 appointments');
        $this->command->info('- Selesai: 11 appointments');
        $this->command->info('- Dikonfirmasi: 5 appointments');
        $this->command->info('- Terjadwal: 4 appointments');
        $this->command->info('- Dibatalkan: 1 appointment');
        $this->command->info('- Tidak Hadir: 1 appointment');
        $this->command->info('==============================================');
    }
}
