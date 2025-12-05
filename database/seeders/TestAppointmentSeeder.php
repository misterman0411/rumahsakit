<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class TestAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $doctor = Doctor::first();

        if (!$patient || !$doctor) {
            $this->command->error('Tidak ada patient atau doctor. Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // Create appointments for today with various statuses
        $appointments = [
            [
                'pasien_id' => $patient->id,
                'dokter_id' => $doctor->id,
                'departemen_id' => $doctor->departemen_id,
                'tanggal_janji' => Carbon::today()->setHour(9)->setMinute(0),
                'jenis' => 'rawat_jalan',
                'status' => 'check_in',
                'alasan' => 'Pemeriksaan rutin',
                'waktu_check_in' => Carbon::today()->setHour(8)->setMinute(30),
                'nomor_antrian' => 1,
                'kode_antrian' => 'P001',
            ],
            [
                'pasien_id' => Patient::skip(1)->first()->id ?? $patient->id,
                'dokter_id' => $doctor->id,
                'departemen_id' => $doctor->departemen_id,
                'tanggal_janji' => Carbon::today()->setHour(10)->setMinute(0),
                'jenis' => 'rawat_jalan',
                'status' => 'sedang_dilayani',
                'alasan' => 'Konsultasi lanjutan',
                'waktu_check_in' => Carbon::today()->setHour(9)->setMinute(45),
                'nomor_antrian' => 2,
                'kode_antrian' => 'P002',
                'waktu_mulai_konsultasi' => Carbon::today()->setHour(10)->setMinute(0),
            ],
            [
                'pasien_id' => Patient::skip(2)->first()->id ?? $patient->id,
                'dokter_id' => $doctor->id,
                'departemen_id' => $doctor->departemen_id,
                'tanggal_janji' => Carbon::today()->setHour(11)->setMinute(0),
                'jenis' => 'kontrol_ulang',
                'status' => 'terjadwal',
                'alasan' => 'Kontrol diabetes',
            ],
            [
                'pasien_id' => Patient::skip(3)->first()->id ?? $patient->id,
                'dokter_id' => $doctor->id,
                'departemen_id' => $doctor->departemen_id,
                'tanggal_janji' => Carbon::today()->setHour(8)->setMinute(0),
                'jenis' => 'rawat_jalan',
                'status' => 'selesai',
                'alasan' => 'Medical checkup',
                'waktu_check_in' => Carbon::today()->setHour(7)->setMinute(30),
                'nomor_antrian' => 3,
                'kode_antrian' => 'P003',
            ],
        ];

        foreach ($appointments as $data) {
            Appointment::create($data);
        }

        $this->command->info('Test appointments created successfully!');
    }
}
