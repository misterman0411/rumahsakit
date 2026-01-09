<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\RadiologyOrder;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\InpatientAdmission;
use App\Models\InpatientDailyLog;
use App\Models\VitalSign;
use App\Models\InpatientCharge;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MassDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting mass data generation...');
        $startTime = microtime(true);

        // Disable foreign key checks for faster insertion
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // Generate 5000 additional patients
            $this->generatePatients(5000);

            // Generate appointments (15000 appointments)
            $this->generateAppointments(15000);

            // Generate medical records (8000 records)
            $this->generateMedicalRecords(8000);

            // Generate laboratory orders & results (10000 orders)
            $this->generateLaboratoryData(10000);

            // Generate radiology orders (5000 orders)
            $this->generateRadiologyOrders(5000);

            // Generate prescriptions (12000 prescriptions)
            $this->generatePrescriptions(12000);

            // Generate inpatient admissions (500 admissions)
            $this->generateInpatientAdmissions(500);

            // Generate invoices & payments (10000 invoices)
            $this->generateInvoicesAndPayments(10000);

            // Generate stock movements (3000 movements)
            $this->generateStockMovements(3000);

        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);

        $this->command->info('');
        $this->command->info('==============================================');
        $this->command->info('Mass data generation completed!');
        $this->command->info("Time taken: {$duration} seconds");
        $this->command->info('==============================================');
        $this->command->info('Generated:');
        $this->command->info('- 5000 Patients');
        $this->command->info('- 15000 Appointments');
        $this->command->info('- 8000 Medical Records');
        $this->command->info('- 10000 Laboratory Orders + Results');
        $this->command->info('- 5000 Radiology Orders');
        $this->command->info('- 12000 Prescriptions');
        $this->command->info('- 500 Inpatient Admissions');
        $this->command->info('- 10000 Invoices & Payments');
        $this->command->info('- 3000 Stock Movements');
        $this->command->info('==============================================');
        $this->command->info('Total: ~65,000 records');
        $this->command->info('==============================================');
    }

    private function generatePatients(int $count): void
    {
        $this->command->info("Generating {$count} patients...");
        
        $patients = [];
        $startMRN = Patient::max('id') ?? 10;
        
        for ($i = 1; $i <= $count; $i++) {
            $gender = fake()->randomElement(['laki_laki', 'perempuan']);
            $mrNumber = $startMRN + $i;
            
            $patients[] = [
                'no_rekam_medis' => 'MR-' . str_pad($mrNumber, 6, '0', STR_PAD_LEFT) . '-2026',
                'nik' => '32' . str_pad(fake()->unique()->numberBetween(1, 9999999999), 14, '0', STR_PAD_LEFT),
                'nama' => fake()->name($gender === 'laki_laki' ? 'male' : 'female'),
                'tanggal_lahir' => fake()->dateTimeBetween('-70 years', '-1 year')->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'agama' => fake()->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu']),
                'status_pernikahan' => fake()->randomElement(['menikah', 'belum_menikah', 'cerai', 'janda_duda']),
                'telepon' => '08' . fake()->numerify('##########'),
                'email' => fake()->optional(0.6)->safeEmail(),
                'alamat' => fake()->address(),
                'golongan_darah' => fake()->randomElement(['A', 'B', 'AB', 'O', null]),
                'nama_kontak_darurat' => fake()->name(),
                'telepon_kontak_darurat' => '08' . fake()->numerify('##########'),
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in batches of 500
            if ($i % 500 === 0 || $i === $count) {
                DB::table('pasien')->insert($patients);
                $patients = [];
                $this->command->info("  - {$i}/{$count} patients generated");
            }
        }
    }

    private function generateAppointments(int $count): void
    {
        $this->command->info("Generating {$count} appointments...");
        
        $patientIds = DB::table('pasien')->pluck('id')->toArray();
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $departmentIds = DB::table('departemen')->pluck('id')->toArray();
        
        // Get the highest existing nomor for uniqueness
        $maxExisting = DB::table('janji_temu')->max('id') ?? 0;
        
        $appointments = [];
        $statuses = ['terjadwal', 'dikonfirmasi', 'check_in', 'sedang_dilayani', 'selesai', 'dibatalkan', 'tidak_hadir'];
        $types = ['rawat_jalan', 'darurat', 'rawat_inap', 'kontrol_ulang'];
        
        for ($i = 1; $i <= $count; $i++) {
            $appointmentDate = fake()->dateTimeBetween('-6 months', '+1 month');
            $status = fake()->randomElement($statuses);
            $deptId = fake()->randomElement($departmentIds);
            $deptCode = DB::table('departemen')->where('id', $deptId)->value('kode');
            
            $uniqueNumber = $maxExisting + $i;
            
            $appointments[] = [
                'nomor_janji_temu' => 'JT-' . $appointmentDate->format('Ymd') . '-' . str_pad($uniqueNumber, 7, '0', STR_PAD_LEFT),
                'pasien_id' => fake()->randomElement($patientIds),
                'dokter_id' => fake()->randomElement($doctorIds),
                'departemen_id' => $deptId,
                'tanggal_janji' => $appointmentDate->format('Y-m-d H:i:s'),
                'jenis' => fake()->randomElement($types),
                'status' => $status,
                'alasan' => fake()->randomElement([
                    'Kontrol rutin', 'Sakit kepala', 'Demam', 'Batuk pilek', 'Nyeri perut',
                    'Hipertensi', 'Diabetes', 'Nyeri sendi', 'Alergi', 'Check up'
                ]),
                'catatan' => fake()->optional(0.3)->sentence(),
                'nomor_antrian' => fake()->numberBetween(1, 50),
                'kode_antrian' => $deptCode . str_pad(fake()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
                'waktu_check_in' => $status !== 'terjadwal' ? $appointmentDate : null,
                'waktu_mulai_konsultasi' => in_array($status, ['sedang_dilayani', 'selesai']) ? $appointmentDate : null,
                'created_at' => $appointmentDate,
                'updated_at' => now(),
            ];

            if ($i % 1000 === 0 || $i === $count) {
                DB::table('janji_temu')->insert($appointments);
                $appointments = [];
                $this->command->info("  - {$i}/{$count} appointments generated");
            }
        }
    }

    private function generateMedicalRecords(int $count): void
    {
        $this->command->info("Generating {$count} medical records...");
        
        $completedAppointments = DB::table('janji_temu')
            ->where('status', 'selesai')
            ->pluck('id')
            ->toArray();
        
        if (empty($completedAppointments)) {
            $this->command->warn("  - No completed appointments found, skipping medical records");
            return;
        }
        
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $records = [];
        
        for ($i = 1; $i <= min($count, count($completedAppointments)); $i++) {
            $appointmentId = $completedAppointments[array_rand($completedAppointments)];
            $appointment = DB::table('janji_temu')->where('id', $appointmentId)->first();
            
            $records[] = [
                'pasien_id' => $appointment->pasien_id,
                'dokter_id' => $appointment->dokter_id,
                'janji_temu_id' => $appointmentId,
                'keluhan' => fake()->randomElement([
                    'Sakit kepala', 'Demam tinggi', 'Batuk berdahak', 'Nyeri dada', 'Sesak napas',
                    'Mual muntah', 'Diare', 'Nyeri perut', 'Pusing berputar', 'Lemas'
                ]),
                'tanda_vital' => json_encode([
                    'tekanan_darah' => fake()->numberBetween(100, 140) . '/' . fake()->numberBetween(60, 90),
                    'detak_jantung' => fake()->numberBetween(60, 100),
                    'suhu' => fake()->randomFloat(1, 36.0, 38.0),
                    'laju_pernapasan' => fake()->numberBetween(16, 24)
                ]),
                'diagnosis' => fake()->randomElement([
                    'ISPA (Infeksi Saluran Pernapasan Atas)', 'Gastritis', 'Hipertensi Stage 1',
                    'Diabetes Melitus Tipe 2', 'Vertigo', 'Migrain', 'GERD', 'Anemia',
                    'Bronkitis Akut', 'Dispepsia'
                ]),
                'kode_icd10' => fake()->randomElement([
                    'J06.9', 'K29.7', 'I10', 'E11.9', 'H81.0', 'G43.9', 'K21.9', 'D64.9', 'J20.9', 'K30'
                ]),
                'kode_icd9' => fake()->optional(0.3)->randomElement(['99.21', '99.22', '99.23', '89.03']),
                'rencana_perawatan' => fake()->sentence(6),
                'catatan' => fake()->optional(0.3)->sentence(),
                'created_at' => $appointment->tanggal_janji,
                'updated_at' => now(),
            ];

            if ($i % 500 === 0 || $i === min($count, count($completedAppointments))) {
                DB::table('rekam_medis')->insert($records);
                $records = [];
                $this->command->info("  - {$i}/" . min($count, count($completedAppointments)) . " medical records generated");
            }
        }
    }

    private function generateLaboratoryData(int $count): void
    {
        $this->command->info("Generating {$count} laboratory orders & results...");
        
        $patientIds = DB::table('pasien')->pluck('id')->toArray();
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $labTestIds = DB::table('jenis_tes_laboratorium')->pluck('id')->toArray();
        $labTechIds = DB::table('users')->where('peran_id', 6)->pluck('id')->toArray();
        
        $maxExisting = DB::table('permintaan_laboratorium')->max('id') ?? 0;
        
        $orders = [];
        $results = [];
        $statuses = ['menunggu', 'sampel_diambil', 'sedang_diproses', 'selesai'];
        
        for ($i = 1; $i <= $count; $i++) {
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');
            $status = fake()->randomElement($statuses);
            
            $uniqueNumber = $maxExisting + $i;
            $orderId = DB::table('permintaan_laboratorium')->max('id') + $i;
            
            $orders[] = [
                'nomor_permintaan' => 'LAB-' . $createdAt->format('Ymd') . '-' . str_pad($uniqueNumber, 6, '0', STR_PAD_LEFT),
                'pasien_id' => fake()->randomElement($patientIds),
                'dokter_id' => fake()->randomElement($doctorIds),
                'jenis_tes_id' => fake()->randomElement($labTestIds),
                'status' => $status,
                'catatan' => fake()->optional(0.3)->sentence(),
                'sample_collected_at' => in_array($status, ['sampel_diambil', 'sedang_diproses', 'selesai']) ? $createdAt : null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];
            
            // Generate results for completed orders
            if ($status === 'selesai' && !empty($labTechIds)) {
                $results[] = [
                    'permintaan_id' => $orderId,
                    'hasil' => fake()->randomElement([
                        'Hemoglobin: 14.2 g/dL, Leukosit: 8500/µL, Trombosit: 250000/µL',
                        'Gula Darah Puasa: 110 mg/dL',
                        'Kolesterol Total: 200 mg/dL, HDL: 50 mg/dL, LDL: 130 mg/dL',
                        'SGOT: 28 U/L, SGPT: 32 U/L',
                        'Ureum: 30 mg/dL, Kreatinin: 1.0 mg/dL',
                        'Negatif Typhoid',
                        'HBsAg Non-Reaktif',
                    ]),
                    'nilai' => fake()->randomElement(['14.2', '110', '200', '28', '30', 'Negatif']),
                    'satuan' => fake()->randomElement(['g/dL', 'mg/dL', 'U/L', '/µL', '-']),
                    'nilai_rujukan' => fake()->randomElement(['12-16', '70-100', '<200', '0-40', '10-50']),
                    'status' => fake()->randomElement(['normal', 'tinggi', 'rendah']),
                    'diperiksa_oleh' => fake()->randomElement($labTechIds),
                    'waktu_pemeriksaan' => $createdAt->modify('+1 day')->format('Y-m-d H:i:s'),
                    'catatan' => fake()->optional(0.3)->sentence(),
                    'created_at' => $createdAt->modify('+1 day'),
                    'updated_at' => now(),
                ];
            }

            if ($i % 500 === 0 || $i === $count) {
                DB::table('permintaan_laboratorium')->insert($orders);
                if (!empty($results)) {
                    DB::table('hasil_laboratorium')->insert($results);
                }
                $orders = [];
                $results = [];
                $this->command->info("  - {$i}/{$count} laboratory data generated");
            }
        }
    }

    private function generateRadiologyOrders(int $count): void
    {
        $this->command->info("Generating {$count} radiology orders...");
        
        $patientIds = DB::table('pasien')->pluck('id')->toArray();
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $radTestIds = DB::table('jenis_tes_radiologi')->pluck('id')->toArray();
        $radiologistIds = DB::table('users')->where('peran_id', 7)->pluck('id')->toArray();
        
        $maxExisting = DB::table('permintaan_radiologi')->max('id') ?? 0;
        
        $orders = [];
        $statuses = ['menunggu', 'sedang_diproses', 'selesai'];
        
        for ($i = 1; $i <= $count; $i++) {
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');
            $status = fake()->randomElement($statuses);
            
            $uniqueNumber = $maxExisting + $i;
            
            $orders[] = [
                'nomor_permintaan' => 'RAD-' . $createdAt->format('Ymd') . '-' . str_pad($uniqueNumber, 6, '0', STR_PAD_LEFT),
                'pasien_id' => fake()->randomElement($patientIds),
                'dokter_id' => fake()->randomElement($doctorIds),
                'jenis_tes_id' => fake()->randomElement($radTestIds),
                'status' => $status,
                'catatan_klinis' => fake()->optional(0.5)->sentence(),
                'hasil' => $status === 'selesai' ? fake()->sentence(10) : null,
                'interpretasi' => $status === 'selesai' ? fake()->sentence(6) : null,
                'diperiksa_oleh' => $status === 'selesai' && !empty($radiologistIds) ? fake()->randomElement($radiologistIds) : null,
                'waktu_pemeriksaan' => $status === 'selesai' ? $createdAt->modify('+1 day')->format('Y-m-d H:i:s') : null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];

            if ($i % 500 === 0 || $i === $count) {
                DB::table('permintaan_radiologi')->insert($orders);
                $orders = [];
                $this->command->info("  - {$i}/{$count} radiology orders generated");
            }
        }
    }

    private function generatePrescriptions(int $count): void
    {
        $this->command->info("Generating {$count} prescriptions...");
        
        $patientIds = DB::table('pasien')->pluck('id')->toArray();
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $medicationIds = DB::table('obat')->pluck('id')->toArray();
        $pharmacistIds = DB::table('users')->where('peran_id', 5)->pluck('id')->toArray();
        
        if (empty($pharmacistIds)) {
            $pharmacistIds = [null];
        }
        
        $maxExisting = DB::table('resep')->max('id') ?? 0;
        
        $prescriptions = [];
        $items = [];
        $statuses = ['menunggu', 'diverifikasi', 'diserahkan', 'ditolak'];
        
        for ($i = 1; $i <= $count; $i++) {
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');
            $status = fake()->randomElement($statuses);
            
            $uniqueNumber = $maxExisting + $i;
            $prescriptionId = DB::table('resep')->max('id') + $i;
            
            $prescriptions[] = [
                'nomor_resep' => 'RX-' . $createdAt->format('Ymd') . '-' . str_pad($uniqueNumber, 6, '0', STR_PAD_LEFT),
                'pasien_id' => fake()->randomElement($patientIds),
                'dokter_id' => fake()->randomElement($doctorIds),
                'status' => $status,
                'catatan' => fake()->optional(0.3)->sentence(),
                'waktu_verifikasi' => in_array($status, ['diverifikasi', 'diserahkan']) ? $createdAt : null,
                'diverifikasi_oleh' => in_array($status, ['diverifikasi', 'diserahkan']) ? fake()->randomElement($pharmacistIds) : null,
                'waktu_penyerahan' => $status === 'diserahkan' ? $createdAt->modify('+1 hour') : null,
                'diserahkan_oleh' => $status === 'diserahkan' ? fake()->randomElement($pharmacistIds) : null,
                'alasan_penolakan' => $status === 'ditolak' ? fake()->sentence(5) : null,
                'ditolak_oleh' => $status === 'ditolak' ? fake()->randomElement($pharmacistIds) : null,
                'waktu_penolakan' => $status === 'ditolak' ? $createdAt : null,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];
            
            // Generate 1-5 items per prescription
            $itemCount = fake()->numberBetween(1, 5);
            for ($j = 0; $j < $itemCount; $j++) {
                $items[] = [
                    'resep_id' => $prescriptionId,
                    'obat_id' => fake()->randomElement($medicationIds),
                    'jumlah' => fake()->numberBetween(1, 30),
                    'dosis' => fake()->randomElement(['1x1', '2x1', '3x1', '1x2', '3x2']),
                    'frekuensi' => fake()->randomElement(['Sehari sekali', 'Dua kali sehari', 'Tiga kali sehari']),
                    'durasi' => fake()->randomElement(['3 hari', '5 hari', '7 hari', '10 hari', '14 hari']),
                    'instruksi' => fake()->randomElement(['Sesudah makan', 'Sebelum makan', 'Saat perut kosong']),
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ];
            }

            if ($i % 500 === 0 || $i === $count) {
                DB::table('resep')->insert($prescriptions);
                if (!empty($items)) {
                    // Split items into chunks to avoid too large insert
                    foreach (array_chunk($items, 1000) as $chunk) {
                        DB::table('item_resep')->insert($chunk);
                    }
                }
                $prescriptions = [];
                $items = [];
                $this->command->info("  - {$i}/{$count} prescriptions generated");
            }
        }
    }

    private function generateInpatientAdmissions(int $count): void
    {
        $this->command->info("Generating {$count} inpatient admissions...");
        
        $patientIds = DB::table('pasien')->pluck('id')->toArray();
        $doctorIds = DB::table('dokter')->pluck('id')->toArray();
        $bedIds = DB::table('tempat_tidur')->where('status', 'tersedia')->pluck('id')->toArray();
        
        $maxExisting = DB::table('rawat_inap')->max('id') ?? 0;
        
        $admissions = [];
        $dailyLogs = [];
        $vitalSigns = [];
        
        for ($i = 1; $i <= min($count, count($bedIds)); $i++) {
            $admissionDate = fake()->dateTimeBetween('-3 months', '-1 day');
            $isActive = fake()->boolean(30); // 30% still active
            
            $uniqueNumber = $maxExisting + $i;
            $admissionId = DB::table('rawat_inap')->max('id') + $i;
            $bedId = $bedIds[$i - 1];
            $bed = DB::table('tempat_tidur')->where('id', $bedId)->first();
            
            $admissions[] = [
                'nomor_rawat_inap' => 'RI-' . $admissionDate->format('Ymd') . '-' . str_pad($uniqueNumber, 7, '0', STR_PAD_LEFT),
                'pasien_id' => fake()->randomElement($patientIds),
                'dokter_id' => fake()->randomElement($doctorIds),
                'ruangan_id' => $bed->ruangan_id,
                'tempat_tidur_id' => $bedId,
                'tanggal_masuk' => $admissionDate->format('Y-m-d H:i:s'),
                'tanggal_keluar' => $isActive ? null : $admissionDate->modify('+' . fake()->numberBetween(2, 14) . ' days')->format('Y-m-d H:i:s'),
                'jenis_masuk' => fake()->randomElement(['darurat', 'terjadwal']),
                'alasan_masuk' => fake()->sentence(5),
                'status' => $isActive ? 'dirawat' : 'pulang',
                'resume_keluar' => $isActive ? null : fake()->sentence(10),
                'instruksi_pulang' => $isActive ? null : fake()->sentence(6),
                'tanggal_kontrol' => $isActive ? null : $admissionDate->modify('+7 days')->format('Y-m-d'),
                'status_pulang' => $isActive ? null : fake()->randomElement(['sembuh', 'dirujuk', 'pulang_paksa']),
                'diskon' => 0,
                'pajak' => 0,
                'created_at' => $admissionDate,
                'updated_at' => now(),
            ];
            
            // Generate daily logs
            if (!$isActive) {
                $days = fake()->numberBetween(2, 10);
                for ($d = 0; $d < $days; $d++) {
                    $logDate = clone $admissionDate;
                    $logDate->modify("+{$d} days");
                    
                    $dailyLogs[] = [
                        'rawat_inap_id' => $admissionId,
                        'perawat_id' => null,
                        'dokter_id' => null,
                        'tanggal' => $logDate->format('Y-m-d'),
                        'waktu' => $logDate->format('H:i:s'),
                        'jenis' => fake()->randomElement(['perkembangan', 'tindakan', 'konsultasi']),
                        'catatan' => fake()->sentence(8),
                        'created_at' => $logDate,
                        'updated_at' => $logDate,
                    ];
                    
                    $vitalSigns[] = [
                        'pasien_id' => $admissions[$i - 1]['pasien_id'],
                        'rawat_inap_id' => $admissionId,
                        'perawat_id' => null,
                        'waktu_pengukuran' => $logDate,
                        'tekanan_darah_sistolik' => fake()->numberBetween(100, 140),
                        'tekanan_darah_diastolik' => fake()->numberBetween(60, 90),
                        'detak_jantung' => fake()->numberBetween(60, 100),
                        'suhu' => fake()->randomFloat(1, 36.0, 38.0),
                        'laju_pernapasan' => fake()->numberBetween(16, 24),
                        'saturasi_oksigen' => fake()->numberBetween(95, 100),
                        'created_at' => $logDate,
                        'updated_at' => $logDate,
                    ];
                }
            }

            if ($i % 100 === 0 || $i === min($count, count($bedIds))) {
                DB::table('rawat_inap')->insert($admissions);
                if (!empty($dailyLogs)) {
                    DB::table('catatan_harian_rawat_inap')->insert($dailyLogs);
                }
                if (!empty($vitalSigns)) {
                    DB::table('tanda_vital')->insert($vitalSigns);
                }
                $admissions = [];
                $dailyLogs = [];
                $vitalSigns = [];
                $this->command->info("  - {$i}/" . min($count, count($bedIds)) . " inpatient admissions generated");
            }
        }
    }

    private function generateInvoicesAndPayments(int $count): void
    {
        $this->command->info("Generating {$count} invoices & payments...");
        
        // Get random sample to avoid memory issues with large datasets
        $patientIds = DB::table('pasien')->inRandomOrder()->limit(5000)->pluck('id')->toArray();
        $appointmentIds = DB::table('janji_temu')->inRandomOrder()->limit(5000)->pluck('id')->toArray();
        $serviceCharges = DB::table('biaya_layanan')->get();
        $maxExisting = DB::table('tagihan')->max('id') ?? 0;
        
        $invoices = [];
        $items = [];
        $payments = [];
        
        for ($i = 1; $i <= $count; $i++) {
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');
            $uniqueNumber = $maxExisting + $i;
            $invoiceId = $uniqueNumber;
            
            $itemCount = fake()->numberBetween(1, 5);
            $subtotal = 0;
            
            for ($j = 0; $j < $itemCount; $j++) {
                $service = $serviceCharges->random();
                $qty = fake()->numberBetween(1, 3);
                $itemSubtotal = $service->harga * $qty;
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'tagihan_id' => $invoiceId,
                    'deskripsi' => $service->nama_layanan,
                    'jumlah' => $qty,
                    'harga_satuan' => $service->harga,
                    'total' => $itemSubtotal,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }
            
            $isPaid = fake()->boolean(70); // 70% paid
            $status = $isPaid ? 'lunas' : 'belum_dibayar';
            
            $invoices[] = [
                'pasien_id' => fake()->randomElement($patientIds),
                'nomor_tagihan' => 'INV-' . now()->format('Ymd') . '-' . str_pad($uniqueNumber, 6, '0', STR_PAD_LEFT),
                'tagihan_untuk_tipe' => 'App\\Models\\Appointment',
                'tagihan_untuk_id' => fake()->randomElement($appointmentIds),
                'jatuh_tempo' => $createdAt->modify('+7 days')->format('Y-m-d'),
                'subtotal' => $subtotal,
                'diskon' => 0,
                'pajak' => 0,
                'total' => $subtotal,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];
            
            // Generate payment if paid
            if ($isPaid) {
                $cashierIds = DB::table('users')->where('peran_id', 8)->pluck('id')->toArray();
                if (empty($cashierIds)) {
                    $cashierIds = DB::table('users')->pluck('id')->toArray();
                }
                
                $maxPayment = DB::table('pembayaran')->max('id') ?? 0;
                $paymentNumber = $maxPayment + count($payments) + 1;
                
                $payments[] = [
                    'tagihan_id' => $invoiceId,
                    'nomor_pembayaran' => 'PAY-' . now()->format('Ymd') . '-' . str_pad($paymentNumber, 6, '0', STR_PAD_LEFT),
                    'tanggal_pembayaran' => $createdAt->modify('+' . fake()->numberBetween(0, 5) . ' days')->format('Y-m-d'),
                    'jumlah' => $subtotal,
                    'metode_pembayaran' => fake()->randomElement(['tunai', 'transfer', 'kartu_kredit', 'kartu_debit']),
                    'nomor_referensi' => fake()->optional(0.6)->numerify('REF-########'),
                    'catatan' => fake()->optional(0.3)->sentence(),
                    'diterima_oleh' => fake()->randomElement($cashierIds),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
            }

            if ($i % 500 === 0 || $i === $count) {
                DB::table('tagihan')->insert($invoices);
                if (!empty($items)) {
                    foreach (array_chunk($items, 1000) as $chunk) {
                        DB::table('item_tagihan')->insert($chunk);
                    }
                }
                if (!empty($payments)) {
                    DB::table('pembayaran')->insert($payments);
                }
                $invoices = [];
                $items = [];
                $payments = [];
                $this->command->info("  - {$i}/{$count} invoices & payments generated");
            }
        }
    }

    private function generateStockMovements(int $count): void
    {
        $this->command->info("Generating {$count} stock movements...");
        
        $medicationIds = DB::table('obat')->pluck('id')->toArray();
        $userIds = DB::table('users')->where('peran_id', 5)->pluck('id')->toArray(); // Pharmacist
        
        if (empty($userIds)) {
            $userIds = DB::table('users')->pluck('id')->toArray();
        }
        
        $movements = [];
        $types = ['masuk', 'keluar', 'penyesuaian'];
        
        for ($i = 1; $i <= $count; $i++) {
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');
            $jumlah = fake()->numberBetween(1, 100);
            $stokSebelum = fake()->numberBetween(0, 500);
            $jenis = fake()->randomElement($types);
            
            // Calculate stok_sesudah based on jenis_mutasi
            $stokSesudah = match($jenis) {
                'masuk' => $stokSebelum + $jumlah,
                'keluar' => max(0, $stokSebelum - $jumlah),
                'penyesuaian' => $jumlah,
            };
            
            $movements[] = [
                'obat_id' => fake()->randomElement($medicationIds),
                'jenis_mutasi' => $jenis,
                'jumlah' => $jumlah,
                'stok_sebelum' => $stokSebelum,
                'stok_sesudah' => $stokSesudah,
                'referensi' => fake()->optional(0.4)->bothify('REF-########'),
                'keterangan' => fake()->optional(0.5)->sentence(5),
                'user_id' => fake()->randomElement($userIds),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if ($i % 500 === 0 || $i === $count) {
                DB::table('mutasi_stok')->insert($movements);
                $movements = [];
                $this->command->info("  - {$i}/{$count} stock movements generated");
            }
        }
    }
}
