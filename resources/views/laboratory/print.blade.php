<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Laboratorium - {{ $laboratory->nomor_permintaan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4F46E5;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #4F46E5;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 10px;
            background-color: #f9fafb;
            border-left: 3px solid #4F46E5;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }
        .result-box {
            background-color: #f0f9ff;
            border: 2px solid #3b82f6;
            padding: 20px;
            margin-bottom: 20px;
        }
        .result-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        .result-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .result-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }
        .result-value {
            font-size: 16px;
            font-weight: bold;
            color: #111;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-normal { background-color: #dcfce7; color: #166534; }
        .status-tinggi { background-color: #fed7aa; color: #9a3412; }
        .status-rendah { background-color: #fef9c3; color: #854d0e; }
        .status-kritis { background-color: #fee2e2; color: #991b1b; }
        .audit-trail {
            background-color: #fafafa;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }
        .audit-item {
            display: flex;
            align-items: start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #ddd;
        }
        .audit-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .audit-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            font-size: 18px;
        }
        .audit-icon-gray { background-color: #e5e7eb; color: #6b7280; }
        .audit-icon-blue { background-color: #dbeafe; color: #1e40af; }
        .audit-icon-green { background-color: #d1fae5; color: #065f46; }
        .audit-icon-purple { background-color: #e9d5ff; color: #6b21a8; }
        .audit-content {
            flex: 1;
        }
        .audit-title {
            font-weight: bold;
            font-size: 14px;
            color: #111;
            margin-bottom: 3px;
        }
        .audit-time {
            font-size: 12px;
            color: #666;
            margin-bottom: 3px;
        }
        .audit-user {
            font-size: 12px;
            color: #4F46E5;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body {
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }
        .print-button {
            background-color: #4F46E5;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .print-button:hover {
            background-color: #4338ca;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="print-button">🖨️ Cetak Halaman</button>
    </div>

    <div class="header">
        <h1>HASIL PEMERIKSAAN LABORATORIUM</h1>
        <p>MediCare Hospital System</p>
        <p style="margin-top: 10px; font-weight: bold; color: #111;">{{ $laboratory->nomor_permintaan }}</p>
    </div>

    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">INFORMASI PASIEN</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">No. Rekam Medis</div>
                <div class="info-value">{{ $laboratory->pasien->no_rekam_medis }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Nama Pasien</div>
                <div class="info-value">{{ $laboratory->pasien->nama }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value">{{ $laboratory->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($laboratory->pasien->tanggal_lahir)->format('d/m/Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ $laboratory->pasien->alamat }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">No. Telepon</div>
                <div class="info-value">{{ $laboratory->pasien->telepon }}</div>
            </div>
        </div>
    </div>

    <!-- Order Information -->
    <div class="section">
        <div class="section-title">INFORMASI PEMERIKSAAN</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Jenis Pemeriksaan</div>
                <div class="info-value">{{ $laboratory->jenisTes->nama }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Order</div>
                <div class="info-value">{{ $laboratory->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Dokter Pengirim</div>
                <div class="info-value">{{ $laboratory->dokter->user->nama }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Spesialisasi</div>
                <div class="info-value">{{ $laboratory->dokter->spesialisasi }}</div>
            </div>
        </div>
        @if($laboratory->catatan)
        <div class="info-item" style="margin-top: 15px;">
            <div class="info-label">Catatan Klinis</div>
            <div class="info-value">{{ $laboratory->catatan }}</div>
        </div>
        @endif
    </div>

    <!-- Laboratory Results -->
    @if($laboratory->hasilLaboratorium)
    <div class="section">
        <div class="section-title">HASIL LABORATORIUM</div>
        <div class="result-box">
            <div class="result-item">
                <div class="result-label">Hasil Pemeriksaan</div>
                <div class="result-value">{{ $laboratory->hasilLaboratorium->hasil }}</div>
            </div>
            
            @if($laboratory->hasilLaboratorium->nilai)
            <div class="result-item">
                <div class="result-label">Nilai</div>
                <div class="result-value">
                    {{ $laboratory->hasilLaboratorium->nilai }}
                    @if($laboratory->hasilLaboratorium->satuan)
                        {{ $laboratory->hasilLaboratorium->satuan }}
                    @endif
                </div>
            </div>
            @endif

            @if($laboratory->hasilLaboratorium->nilai_rujukan)
            <div class="result-item">
                <div class="result-label">Nilai Rujukan</div>
                <div class="result-value">{{ $laboratory->hasilLaboratorium->nilai_rujukan }}</div>
            </div>
            @endif

            @if($laboratory->hasilLaboratorium->status)
            <div class="result-item">
                <div class="result-label">Status</div>
                <div class="result-value">
                    <span class="status-badge status-{{ $laboratory->hasilLaboratorium->status }}">
                        {{ strtoupper($laboratory->hasilLaboratorium->status) }}
                    </span>
                </div>
            </div>
            @endif

            @if($laboratory->hasilLaboratorium->catatan)
            <div class="result-item">
                <div class="result-label">Catatan</div>
                <div class="result-value">{{ $laboratory->hasilLaboratorium->catatan }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Audit Trail -->
    <div class="section">
        <div class="section-title">RIWAYAT PEMERIKSAAN</div>
        <div class="audit-trail">
            <!-- Order Created -->
            <div class="audit-item">
                <div class="audit-icon audit-icon-gray">📋</div>
                <div class="audit-content">
                    <div class="audit-title">Order Dibuat</div>
                    <div class="audit-time">{{ $laboratory->created_at->format('d/m/Y H:i:s') }}</div>
                    <div class="audit-user">oleh Dr. {{ $laboratory->dokter->user->nama }}</div>
                </div>
            </div>

            <!-- Sample Collected -->
            @if($laboratory->sample_collected_at)
            <div class="audit-item">
                <div class="audit-icon audit-icon-blue">✓</div>
                <div class="audit-content">
                    <div class="audit-title">Sampel Diambil</div>
                    <div class="audit-time">{{ \Carbon\Carbon::parse($laboratory->sample_collected_at)->format('d/m/Y H:i:s') }}</div>
                    @if($laboratory->sampelDiambilOleh)
                    <div class="audit-user">oleh {{ $laboratory->sampelDiambilOleh->nama }}</div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Results Entered -->
            @if($laboratory->waktu_input_hasil)
            <div class="audit-item">
                <div class="audit-icon audit-icon-green">📝</div>
                <div class="audit-content">
                    <div class="audit-title">Hasil Diinput</div>
                    <div class="audit-time">{{ \Carbon\Carbon::parse($laboratory->waktu_input_hasil)->format('d/m/Y H:i:s') }}</div>
                    @if($laboratory->hasilDiinputOleh)
                    <div class="audit-user">oleh {{ $laboratory->hasilDiinputOleh->nama }}</div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Verified -->
            @if($laboratory->waktu_verifikasi)
            <div class="audit-item">
                <div class="audit-icon audit-icon-purple">✔</div>
                <div class="audit-content">
                    <div class="audit-title">Hasil Diverifikasi</div>
                    <div class="audit-time">{{ \Carbon\Carbon::parse($laboratory->waktu_verifikasi)->format('d/m/Y H:i:s') }}</div>
                    @if($laboratory->diverifikasiOleh)
                    <div class="audit-user">oleh Dr. {{ $laboratory->diverifikasiOleh->nama }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p><strong>MediCare Hospital System</strong></p>
        <p>Dokumen ini dicetak pada {{ now()->format('d/m/Y H:i:s') }}</p>
        <p style="margin-top: 10px; font-style: italic;">Dokumen ini sah dan dihasilkan secara elektronik</p>
    </div>
</body>
</html>
