Struktur Organisasi & Deskripsi Pekerjaan (Job Description)
Dokumen ini menjelaskan struktur organisasi dan tanggung jawab (jobdesk) untuk setiap peran yang ada dalam sistem manajemen Rumah Sakit yang telah dibangun.

Struktur Organisasi
Struktur organisasi dikelompokkan berdasarkan fungsi dan hak akses yang telah diimplementasikan dalam sistem.

## 1. Manajemen (Management)
Fokus: Pengawasan operasional dan pengambilan keputusan strategis.

Tanggung Jawab:
Melihat laporan kinerja rumah sakit secara keseluruhan (ManagementReportController).
Memantau statistik kunjungan pasien, pendapatan, dan penggunaan layanan.
Melihat dashboard eksekutif untuk evaluasi operasional.

## 2. Administrator (Admin)
Fokus: Pengelolaan sistem, data master, dan manajemen pengguna.

Tanggung Jawab:
Mengelola akun pengguna (User Management) untuk semua staf.
Mengelola data master: Departemen, Ruangan, Tempat Tidur, Jadwal Dokter.
Mengonfigurasi pengaturan sistem global.
Memiliki akses penuh ke seluruh fitur untuk tujuan pemeliharaan (DashboardController, DepartmentController).

## 3. Dokter (Doctor)
Fokus: Pelayanan medis diagnostik dan kuratif kepada pasien.

Tanggung Jawab:
Mengelola jadwal konsultasi dan antrian pasien (AppointmentController, QueueDisplayController).
Melakukan pemeriksaan pasien dan mencatat Rekam Medis (MedicalRecordController).
Membuat resep obat digital untuk pasien (PrescriptionController).
Meminta pemeriksaan penunjang (Lab dan Radiologi) jika diperlukan.
Melihat riwayat medis pasien.

## 4. Perawat (Nurse)
Fokus: Asuhan keperawatan dan perawatan pasien rawat inap/jalan.

Tanggung Jawab:
Mencatat Tanda Vital (Tensi, Suhu, Nadi, drr) pasien (VitalSignController).
Mengelola administrasi pasien Rawat Inap (InpatientController).
Mencatat catatan harian perkembangan pasien (Daily Logs) (InpatientDailyLogController).
Memasukkan tindakan keperawatan atau biaya ruangan (InpatientChargeController).
Membantu dokter dalam manajemen antrian poliklinik.

## 5. Staf Farmasi (Pharmacist)
Fokus: Pengelolaan obat dan pelayanan resep.

Tanggung Jawab:
Melayani resep obat dari dokter (PrescriptionController).
Mengelola stok obat dan inventaris farmasi (MedicationController, StockMovementController).
Mengelola pembelian obat bebas (E-Pharmacy/Shop) (ShopController, CartController, CheckoutController).
Memproses pesanan obat dan memantau pergerakan stok masuk/keluar.

## 6. Staf Front Office (Front Office)
Fokus: Pendaftaran dan pelayanan informasi awal pasien.

Tanggung Jawab:
Mendaftarkan pasien baru (PatientController).
Mengelola pendaftaran rawat jalan dan booking jadwal konsultasi (AppointmentController).
Mengelola alokasi kamar untuk rawat inap (RoomController, Bed).
Memberikan informasi ketersediaan tempat tidur dan jadwal dokter.

## 7. Kasir (Cashier)
Fokus: Administrasi keuangan dan pembayaran.

Tanggung Jawab:
Membuat dan mengelola tagihan (Invoice) pasien (BillingController).
Memproses pembayaran tunai maupun non-tunai (Payment, MidtransController).
Mencetak kuitansi pembayaran.
Memverifikasi status pembayaran untuk layanan medis, obat, dan penunjang.

## 8. Staf Laboratorium (Lab Technician)
Fokus: Pelayanan pemeriksaan laboratorium.

Tanggung Jawab:
Menerima permintaan pemeriksaan lab dari dokter (LaboratoryController).
Menginput hasil pemeriksaan laboratorium.
Mengelola jenis-jenis tes lab yang tersedia.

## 9. Staf Radiologi (Radiologist)
Fokus: Pelayanan pemeriksaan radiologi (pencitraan medis).

Tanggung Jawab:
Menerima permintaan pemeriksaan radiologi dari dokter (RadiologyController).
Menginput hasil ekspertise/bacaan rontgen/USG/CT-Scan.
Mengelola jenis-jenis pemeriksaan radiologi yang tersedia.