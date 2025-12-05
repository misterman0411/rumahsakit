<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    MedicalRecord, LaboratoryOrder, LaboratoryResult, RadiologyOrder,
    Prescription, PrescriptionItem, InpatientAdmission, InpatientDailyLog,
    InpatientCharge, VitalSign, Invoice, InvoiceItem, Payment
};

class ComprehensiveDataSeeder extends Seeder
{
    public function run(): void
    {
        // Medical Records
        $medicalRecords = [
            ['janji_temu_id' => 1, 'pasien_id' => 1, 'dokter_id' => 1, 'diagnosis' => 'Diabetes Mellitus Tipe 2', 'kode_icd10' => 'E11.9', 'keluhan' => 'Sering haus, mudah lelah, berat badan turun', 'tanda_vital' => json_encode(['tekanan_darah' => '130/80', 'nadi' => 88, 'berat_badan' => 65]), 'rencana_perawatan' => 'Kontrol gula darah rutin, diet rendah gula', 'catatan' => 'Pasien kooperatif'],
            ['janji_temu_id' => 5, 'pasien_id' => 5, 'dokter_id' => 6, 'diagnosis' => 'ISPA (Infeksi Saluran Pernapasan Atas)', 'kode_icd10' => 'J06.9', 'keluhan' => 'Demam 3 hari, batuk, pilek', 'tanda_vital' => json_encode(['suhu' => 38.5, 'tenggorokan' => 'merah']), 'rencana_perawatan' => 'Antibiotik, istirahat cukup', 'catatan' => 'Follow up 3 hari'],
            ['janji_temu_id' => 6, 'pasien_id' => 6, 'dokter_id' => 1, 'diagnosis' => 'Gastritis Akut', 'kode_icd10' => 'K29.0', 'keluhan' => 'Nyeri ulu hati, mual, muntah', 'tanda_vital' => json_encode(['pemeriksaan_abdomen' => 'nyeri tekan epigastrium']), 'rencana_perawatan' => 'PPI, diet lunak', 'catatan' => 'Hindari makanan pedas'],
            ['janji_temu_id' => 10, 'pasien_id' => 1, 'dokter_id' => 2, 'diagnosis' => 'Post Operasi Apendektomi', 'kode_icd9' => '47.09', 'keluhan' => 'Kontrol luka operasi', 'tanda_vital' => json_encode(['luka' => 'kering, tidak ada tanda infeksi']), 'rencana_perawatan' => 'Ganti verband', 'catatan' => 'Luka sembuh baik'],
            ['janji_temu_id' => 13, 'pasien_id' => 4, 'dokter_id' => 3, 'diagnosis' => 'Febris (Demam pada Anak)', 'kode_icd10' => 'R50.9', 'keluhan' => 'Demam tinggi 39°C sejak 1 hari', 'tanda_vital' => json_encode(['suhu' => 39.0, 'tenggorokan' => 'merah']), 'rencana_perawatan' => 'Antipiretik, observasi', 'catatan' => 'Pantau suhu tiap 4 jam'],
        ];
        foreach ($medicalRecords as $record) {
            MedicalRecord::create($record);
        }

        // Laboratory Orders
        $labOrders = [
            ['nomor_permintaan' => 'LAB-20251204-0001', 'pasien_id' => 1, 'dokter_id' => 1, 'jenis_tes_id' => 1, 'status' => 'selesai', 'catatan' => 'Cek gula darah puasa - Follow up diabetes'],
            ['nomor_permintaan' => 'LAB-20251204-0002', 'pasien_id' => 1, 'dokter_id' => 1, 'jenis_tes_id' => 2, 'status' => 'selesai', 'catatan' => 'Profil lipid lengkap - Kontrol kolesterol'],
            ['nomor_permintaan' => 'LAB-20251204-0003', 'pasien_id' => 5, 'dokter_id' => 6, 'jenis_tes_id' => 3, 'status' => 'selesai', 'catatan' => 'Hitung darah lengkap - ISPA dengan demam'],
            ['nomor_permintaan' => 'LAB-20251204-0004', 'pasien_id' => 3, 'dokter_id' => 5, 'jenis_tes_id' => 5, 'status' => 'menunggu', 'catatan' => 'Troponin I - Evaluasi nyeri dada'],
            ['nomor_permintaan' => 'LAB-20251204-0005', 'pasien_id' => 6, 'dokter_id' => 1, 'jenis_tes_id' => 7, 'status' => 'sedang_diproses', 'catatan' => 'Fungsi hati - Evaluasi gastritis'],
        ];
        foreach ($labOrders as $order) {
            LaboratoryOrder::create($order);
        }

        // Laboratory Results
        $labResults = [
            ['permintaan_id' => 1, 'hasil' => 'Glukosa Puasa', 'nilai' => '145', 'nilai_rujukan' => '70-100', 'satuan' => 'mg/dL', 'status' => 'tinggi', 'catatan' => 'Kontrol diabetes diperlukan'],
            ['permintaan_id' => 2, 'hasil' => 'Kolesterol Total', 'nilai' => '220', 'nilai_rujukan' => '<200', 'satuan' => 'mg/dL', 'status' => 'tinggi', 'catatan' => 'Perlu diet rendah lemak'],
            ['permintaan_id' => 2, 'hasil' => 'HDL', 'nilai' => '40', 'nilai_rujukan' => '>40', 'satuan' => 'mg/dL', 'status' => 'normal'],
            ['permintaan_id' => 2, 'hasil' => 'LDL', 'nilai' => '150', 'nilai_rujukan' => '<130', 'satuan' => 'mg/dL', 'status' => 'tinggi'],
            ['permintaan_id' => 3, 'hasil' => 'Hemoglobin', 'nilai' => '12.5', 'nilai_rujukan' => '12-16', 'satuan' => 'g/dL', 'status' => 'normal'],
            ['permintaan_id' => 3, 'hasil' => 'Leukosit', 'nilai' => '11500', 'nilai_rujukan' => '4000-10000', 'satuan' => '/uL', 'status' => 'tinggi', 'catatan' => 'Indikasi infeksi'],
        ];
        foreach ($labResults as $result) {
            LaboratoryResult::create($result);
        }

        // Radiology Orders
        $radioOrders = [
            ['nomor_permintaan' => 'RAD-20251204-0001', 'pasien_id' => 3, 'dokter_id' => 5, 'jenis_tes_id' => 3, 'status' => 'menunggu', 'catatan_klinis' => 'Nyeri dada, curiga MI'],
            ['nomor_permintaan' => 'RAD-20251204-0002', 'pasien_id' => 2, 'dokter_id' => 4, 'jenis_tes_id' => 5, 'status' => 'selesai', 'catatan_klinis' => 'ANC - USG kehamilan 12 minggu', 'hasil' => 'Janin tunggal hidup intrauterin, usia gestasi 12 minggu', 'interpretasi' => 'Kehamilan normal', 'waktu_pemeriksaan' => now()->subHours(10)],
            ['nomor_permintaan' => 'RAD-20251204-0003', 'pasien_id' => 5, 'dokter_id' => 6, 'jenis_tes_id' => 1, 'status' => 'selesai', 'catatan_klinis' => 'Batuk lama, curiga pneumonia', 'hasil' => 'Infiltrat di lobus bawah paru kanan', 'interpretasi' => 'Pneumonia lobus bawah paru kanan', 'waktu_pemeriksaan' => now()->subHours(12)],
            ['nomor_permintaan' => 'RAD-20251204-0004', 'pasien_id' => 9, 'dokter_id' => 2, 'jenis_tes_id' => 7, 'status' => 'sedang_diproses', 'catatan_klinis' => 'Post operasi hemoroidektomi'],
        ];
        foreach ($radioOrders as $order) {
            RadiologyOrder::create($order);
        }

        // Prescriptions
        $prescriptions = [
            ['nomor_resep' => 'RX-20251204-0001', 'pasien_id' => 1, 'dokter_id' => 1, 'status' => 'diserahkan', 'catatan' => 'Konsumsi obat teratur', 'waktu_verifikasi' => now()->subDays(1), 'waktu_penyerahan' => now()->subDays(1)],
            ['nomor_resep' => 'RX-20251204-0002', 'pasien_id' => 5, 'dokter_id' => 6, 'status' => 'diserahkan', 'catatan' => 'Habiskan antibiotik', 'waktu_verifikasi' => now()->subHours(20), 'waktu_penyerahan' => now()->subHours(19)],
            ['nomor_resep' => 'RX-20251204-0003', 'pasien_id' => 6, 'dokter_id' => 1, 'status' => 'diverifikasi', 'catatan' => 'Minum sebelum makan', 'waktu_verifikasi' => now()->subHours(18)],
            ['nomor_resep' => 'RX-20251204-0004', 'pasien_id' => 4, 'dokter_id' => 3, 'status' => 'menunggu', 'catatan' => 'Untuk 3 hari'],
        ];
        foreach ($prescriptions as $prescription) {
            Prescription::create($prescription);
        }

        // Prescription Items
        $prescriptionItems = [
            // Resep 1 - Diabetes
            ['resep_id' => 1, 'obat_id' => 1, 'jumlah' => 30, 'dosis' => '500mg', 'frekuensi' => '2x sehari', 'durasi' => '30 hari', 'instruksi' => 'Sesudah makan pagi dan malam'],
            ['resep_id' => 1, 'obat_id' => 15, 'jumlah' => 60, 'dosis' => '1 tablet', 'frekuensi' => '2x sehari', 'durasi' => '30 hari', 'instruksi' => 'Pagi dan malam'],
            // Resep 2 - ISPA
            ['resep_id' => 2, 'obat_id' => 2, 'jumlah' => 10, 'dosis' => '500mg', 'frekuensi' => '3x sehari', 'durasi' => '5 hari', 'instruksi' => 'Sesudah makan, habiskan'],
            ['resep_id' => 2, 'obat_id' => 3, 'jumlah' => 10, 'dosis' => '500mg', 'frekuensi' => '3x sehari', 'durasi' => '3 hari', 'instruksi' => 'Saat demam/nyeri'],
            ['resep_id' => 2, 'obat_id' => 10, 'jumlah' => 1, 'dosis' => '1 botol', 'frekuensi' => '3x sehari', 'durasi' => '5 hari', 'instruksi' => '1 sendok makan'],
            // Resep 3 - Gastritis
            ['resep_id' => 3, 'obat_id' => 5, 'jumlah' => 14, 'dosis' => '20mg', 'frekuensi' => '2x sehari', 'durasi' => '7 hari', 'instruksi' => 'Sebelum makan pagi dan malam'],
            ['resep_id' => 3, 'obat_id' => 18, 'jumlah' => 10, 'dosis' => '1 tablet', 'frekuensi' => '3x sehari', 'durasi' => '3 hari', 'instruksi' => 'Saat mual'],
            // Resep 4 - Demam Anak
            ['resep_id' => 4, 'obat_id' => 4, 'jumlah' => 1, 'dosis' => '1 botol', 'frekuensi' => '3x sehari', 'durasi' => '3 hari', 'instruksi' => '1 sendok teh (5ml) saat demam'],
        ];
        foreach ($prescriptionItems as $item) {
            PrescriptionItem::create($item);
        }

        // Inpatient Admissions
        $inpatients = [
            ['nomor_rawat_inap' => 'RI-20251204-0001', 'pasien_id' => 2, 'dokter_id' => 4, 'ruangan_id' => 1, 'tempat_tidur_id' => 1, 'jenis_masuk' => 'darurat', 'tanggal_masuk' => now()->subDays(2), 'alasan_masuk' => 'Preeklampsia - Hamil 32 minggu, TD 160/100', 'status' => 'dirawat'],
            ['nomor_rawat_inap' => 'RI-20251203-0001', 'pasien_id' => 9, 'dokter_id' => 2, 'ruangan_id' => 2, 'tempat_tidur_id' => 6, 'jenis_masuk' => 'terjadwal', 'tanggal_masuk' => now()->subDays(3), 'tanggal_keluar' => now()->subDays(1), 'alasan_masuk' => 'Hemoroid Grade 3 - Perdarahan berulang', 'resume_keluar' => 'Post Hemoroidektomi, luka operasi baik', 'instruksi_pulang' => 'Kontrol 1 minggu, jaga kebersihan luka', 'tanggal_kontrol' => now()->addDays(6), 'status_pulang' => 'sembuh', 'status' => 'pulang'],
            ['nomor_rawat_inap' => 'RI-20251202-0001', 'pasien_id' => 3, 'dokter_id' => 5, 'ruangan_id' => 4, 'tempat_tidur_id' => 8, 'jenis_masuk' => 'darurat', 'tanggal_masuk' => now()->subDays(4), 'tanggal_keluar' => now()->subDays(2), 'alasan_masuk' => 'Unstable Angina - Nyeri dada menjalar ke lengan kiri', 'resume_keluar' => 'Coronary Artery Disease, kondisi stabil', 'instruksi_pulang' => 'Kontrol rutin, diet rendah lemak, olahraga ringan', 'tanggal_kontrol' => now()->addWeeks(1), 'status_pulang' => 'sembuh', 'status' => 'pulang'],
        ];
        foreach ($inpatients as $inpatient) {
            InpatientAdmission::create($inpatient);
        }

        // Inpatient Daily Logs
        $dailyLogs = [
            ['rawat_inap_id' => 1, 'tanggal' => now()->subDays(2), 'waktu' => now()->subDays(2)->setHour(8), 'catatan' => 'Pasien masuk, kondisi stabil. TD: 150/95 mmHg', 'perawat_id' => 1],
            ['rawat_inap_id' => 1, 'tanggal' => now()->subDays(2), 'waktu' => now()->subDays(2)->setHour(20), 'catatan' => 'TD: 140/90 mmHg. Pasien istirahat cukup', 'perawat_id' => 2],
            ['rawat_inap_id' => 1, 'tanggal' => now()->subDays(1), 'waktu' => now()->subDays(1)->setHour(8), 'catatan' => 'Kondisi membaik. TD: 135/85 mmHg. Janin baik', 'perawat_id' => 1],
            ['rawat_inap_id' => 1, 'tanggal' => now()->subDays(1), 'waktu' => now()->subDays(1)->setHour(20), 'catatan' => 'TD: 130/85 mmHg. Tidak ada keluhan', 'perawat_id' => 3],
            ['rawat_inap_id' => 1, 'tanggal' => now(), 'waktu' => now()->setHour(8), 'catatan' => 'TD: 130/80 mmHg. Rencana observasi 1 hari lagi', 'perawat_id' => 1],
        ];
        foreach ($dailyLogs as $log) {
            InpatientDailyLog::create($log);
        }

        // Vital Signs
        $vitalSigns = [
            ['pasien_id' => 2, 'rawat_inap_id' => 1, 'perawat_id' => 1, 'tekanan_darah_sistolik' => 150, 'tekanan_darah_diastolik' => 95, 'detak_jantung' => 88, 'suhu' => 36.8, 'laju_pernapasan' => 20, 'saturasi_oksigen' => 98, 'waktu_pengukuran' => now()->subDays(2)->setHour(8)],
            ['pasien_id' => 2, 'rawat_inap_id' => 1, 'perawat_id' => 2, 'tekanan_darah_sistolik' => 140, 'tekanan_darah_diastolik' => 90, 'detak_jantung' => 82, 'suhu' => 36.7, 'laju_pernapasan' => 18, 'saturasi_oksigen' => 99, 'waktu_pengukuran' => now()->subDays(2)->setHour(20)],
            ['pasien_id' => 2, 'rawat_inap_id' => 1, 'perawat_id' => 1, 'tekanan_darah_sistolik' => 135, 'tekanan_darah_diastolik' => 85, 'detak_jantung' => 80, 'suhu' => 36.6, 'laju_pernapasan' => 18, 'saturasi_oksigen' => 99, 'waktu_pengukuran' => now()->subDays(1)->setHour(8)],
            ['pasien_id' => 2, 'rawat_inap_id' => 1, 'perawat_id' => 3, 'tekanan_darah_sistolik' => 130, 'tekanan_darah_diastolik' => 85, 'detak_jantung' => 78, 'suhu' => 36.7, 'laju_pernapasan' => 18, 'saturasi_oksigen' => 98, 'waktu_pengukuran' => now()->subDays(1)->setHour(20)],
            ['pasien_id' => 2, 'rawat_inap_id' => 1, 'perawat_id' => 1, 'tekanan_darah_sistolik' => 130, 'tekanan_darah_diastolik' => 80, 'detak_jantung' => 76, 'suhu' => 36.8, 'laju_pernapasan' => 18, 'saturasi_oksigen' => 99, 'waktu_pengukuran' => now()->setHour(8)],
        ];
        foreach ($vitalSigns as $vital) {
            VitalSign::create($vital);
        }

        // Inpatient Charges
        $inpatientCharges = [
            ['rawat_inap_id' => 1, 'jenis_biaya' => 'Kamar', 'deskripsi' => 'Kamar VIP - 2 hari', 'jumlah' => 2, 'harga_satuan' => 500000, 'total' => 1000000, 'tanggal' => now()->subDays(2)],
            ['rawat_inap_id' => 1, 'jenis_biaya' => 'Visite Dokter', 'deskripsi' => 'Visite dokter spesialis kandungan', 'jumlah' => 1, 'harga_satuan' => 150000, 'total' => 150000, 'tanggal' => now()->subDays(2)],
            ['rawat_inap_id' => 2, 'jenis_biaya' => 'Kamar', 'deskripsi' => 'Kamar Kelas 1 - 2 hari', 'jumlah' => 2, 'harga_satuan' => 300000, 'total' => 600000, 'tanggal' => now()->subDays(3)],
            ['rawat_inap_id' => 2, 'jenis_biaya' => 'Tindakan Operasi', 'deskripsi' => 'Operasi hemoroidektomi', 'jumlah' => 1, 'harga_satuan' => 5000000, 'total' => 5000000, 'tanggal' => now()->subDays(3)],
        ];
        foreach ($inpatientCharges as $charge) {
            InpatientCharge::create($charge);
        }

        // Invoices
        $invoices = [
            ['nomor_tagihan' => 'INV-20251204-0001', 'pasien_id' => 1, 'tagihan_untuk_id' => 1, 'tagihan_untuk_tipe' => 'App\Models\Prescription', 'subtotal' => 285000, 'diskon' => 0, 'pajak' => 0, 'total' => 285000, 'status' => 'lunas', 'jatuh_tempo' => now()->addDays(7)],
            ['nomor_tagihan' => 'INV-20251204-0002', 'pasien_id' => 5, 'tagihan_untuk_id' => 2, 'tagihan_untuk_tipe' => 'App\Models\Prescription', 'subtotal' => 165000, 'diskon' => 0, 'pajak' => 0, 'total' => 165000, 'status' => 'lunas', 'jatuh_tempo' => now()->addDays(7)],
            ['nomor_tagihan' => 'INV-20251204-0003', 'pasien_id' => 6, 'tagihan_untuk_id' => 3, 'tagihan_untuk_tipe' => 'App\Models\Prescription', 'subtotal' => 125000, 'diskon' => 0, 'pajak' => 0, 'total' => 125000, 'status' => 'belum_dibayar', 'jatuh_tempo' => now()->addDays(7)],
            ['nomor_tagihan' => 'INV-20251203-0001', 'pasien_id' => 9, 'tagihan_untuk_id' => 2, 'tagihan_untuk_tipe' => 'App\Models\InpatientAdmission', 'subtotal' => 5600000, 'diskon' => 280000, 'pajak' => 0, 'total' => 5320000, 'status' => 'dibayar_sebagian', 'jatuh_tempo' => now()->addDays(14)],
            ['nomor_tagihan' => 'INV-20251202-0001', 'pasien_id' => 3, 'tagihan_untuk_id' => 3, 'tagihan_untuk_tipe' => 'App\Models\InpatientAdmission', 'subtotal' => 8500000, 'diskon' => 0, 'pajak' => 0, 'total' => 8500000, 'status' => 'lunas', 'jatuh_tempo' => now()->addDays(14)],
        ];
        foreach ($invoices as $invoice) {
            Invoice::create($invoice);
        }

        // Invoice Items
        $invoiceItems = [
            ['tagihan_id' => 1, 'deskripsi' => 'Metformin 500mg x30', 'jumlah' => 30, 'harga_satuan' => 5000, 'total' => 150000],
            ['tagihan_id' => 1, 'deskripsi' => 'Vitamin B Complex x60', 'jumlah' => 60, 'harga_satuan' => 2000, 'total' => 120000],
            ['tagihan_id' => 1, 'deskripsi' => 'Biaya administrasi', 'jumlah' => 1, 'harga_satuan' => 15000, 'total' => 15000],
            ['tagihan_id' => 2, 'deskripsi' => 'Amoxicillin 500mg x10', 'jumlah' => 10, 'harga_satuan' => 8000, 'total' => 80000],
            ['tagihan_id' => 2, 'deskripsi' => 'Paracetamol 500mg x10', 'jumlah' => 10, 'harga_satuan' => 3000, 'total' => 30000],
            ['tagihan_id' => 2, 'deskripsi' => 'Obat Batuk Sirup 100ml x1', 'jumlah' => 1, 'harga_satuan' => 35000, 'total' => 35000],
            ['tagihan_id' => 2, 'deskripsi' => 'Biaya administrasi', 'jumlah' => 1, 'harga_satuan' => 20000, 'total' => 20000],
            ['tagihan_id' => 4, 'deskripsi' => 'Kamar Kelas 1 (2 hari)', 'jumlah' => 2, 'harga_satuan' => 300000, 'total' => 600000],
            ['tagihan_id' => 4, 'deskripsi' => 'Operasi Hemoroidektomi', 'jumlah' => 1, 'harga_satuan' => 5000000, 'total' => 5000000],
        ];
        foreach ($invoiceItems as $item) {
            InvoiceItem::create($item);
        }

        // Payments
        $payments = [
            ['tagihan_id' => 1, 'nomor_pembayaran' => 'PAY-20251204-0001', 'jumlah' => 285000, 'metode_pembayaran' => 'tunai', 'tanggal_pembayaran' => now()->subDays(1), 'diterima_oleh' => 4, 'catatan' => 'Lunas'],
            ['tagihan_id' => 2, 'nomor_pembayaran' => 'PAY-20251204-0002', 'jumlah' => 165000, 'metode_pembayaran' => 'transfer', 'tanggal_pembayaran' => now()->subHours(15), 'diterima_oleh' => 4, 'nomor_referensi' => 'TRF20251204001', 'catatan' => 'Transfer BCA'],
            ['tagihan_id' => 4, 'nomor_pembayaran' => 'PAY-20251203-0001', 'jumlah' => 3000000, 'metode_pembayaran' => 'transfer', 'tanggal_pembayaran' => now()->subDays(2), 'diterima_oleh' => 4, 'nomor_referensi' => 'TRF20251203001', 'catatan' => 'DP operasi'],
            ['tagihan_id' => 5, 'nomor_pembayaran' => 'PAY-20251202-0001', 'jumlah' => 8500000, 'metode_pembayaran' => 'kartu_debit', 'tanggal_pembayaran' => now()->subDays(3), 'diterima_oleh' => 4, 'catatan' => 'Lunas via debit'],
        ];
        foreach ($payments as $payment) {
            Payment::create($payment);
        }

        $this->command->info('✅ Comprehensive data seeded:');
        $this->command->info('   - 5 Medical Records');
        $this->command->info('   - 5 Laboratory Orders + 6 Results');
        $this->command->info('   - 4 Radiology Orders');
        $this->command->info('   - 4 Prescriptions + 8 Items');
        $this->command->info('   - 3 Inpatient Admissions');
        $this->command->info('   - 5 Daily Logs + 5 Vital Signs + 4 Charges');
        $this->command->info('   - 5 Invoices + 9 Items + 4 Payments');
    }
}
