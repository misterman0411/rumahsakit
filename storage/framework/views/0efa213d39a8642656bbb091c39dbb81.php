<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Queue Ticket - <?php echo e($appointment->queue_code); ?></title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10mm;
            background: white;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 5mm;
            margin-bottom: 5mm;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 2mm;
        }

        .hospital-name {
            font-size: 16px;
            font-weight: bold;
        }

        .hospital-address {
            font-size: 10px;
            margin-top: 1mm;
        }

        .queue-number {
            text-align: center;
            margin: 8mm 0;
            padding: 5mm;
            border: 3px solid #000;
            background: #f0f0f0;
        }

        .queue-label {
            font-size: 14px;
            margin-bottom: 2mm;
        }

        .queue-code {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 3px;
        }

        .info-section {
            margin: 5mm 0;
            font-size: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 2mm 0;
            padding: 2mm 0;
            border-bottom: 1px dotted #ccc;
        }

        .info-label {
            font-weight: bold;
        }

        .info-value {
            text-align: right;
            max-width: 50%;
        }

        .footer {
            text-align: center;
            margin-top: 8mm;
            padding-top: 5mm;
            border-top: 2px dashed #000;
            font-size: 10px;
        }

        .barcode {
            text-align: center;
            margin: 5mm 0;
        }

        .barcode-value {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Libre Barcode 39', monospace;
        }

        .important-note {
            background: #000;
            color: #fff;
            padding: 3mm;
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            margin: 5mm 0;
        }

        @media print {
            .no-print {
                display: none;
            }
        }

        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Ticket</button>

    <div class="header">
        <div class="logo">🏥</div>
        <div class="hospital-name">RUMAH SAKIT UMUM</div>
        <div class="hospital-address">Jl. Kesehatan No. 123, Jakarta<br>Telp: (021) 12345678</div>
    </div>

    <div class="important-note">
        NOMOR ANTRIAN ANDA
    </div>

    <div class="queue-number">
        <div class="queue-label">ANTRIAN</div>
        <div class="queue-code"><?php echo e($appointment->queue_code); ?></div>
    </div>

    <div class="barcode">
        <div class="barcode-value">*<?php echo e($appointment->queue_code); ?>*</div>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Pasien:</span>
            <span class="info-value"><?php echo e(Str::limit($appointment->pasien->nama, 20)); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">No. RM:</span>
            <span class="info-value"><?php echo e($appointment->pasien->no_rekam_medis); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Poliklinik:</span>
            <span class="info-value"><?php echo e($appointment->departemen->nama); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Dokter:</span>
            <span class="info-value">Dr. <?php echo e(Str::limit($appointment->dokter->user->nama, 18)); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span class="info-value"><?php echo e($appointment->janjiTemu_date->format('d/m/Y')); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Waktu:</span>
            <span class="info-value"><?php echo e($appointment->janjiTemu_time); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Check-in:</span>
            <span class="info-value"><?php echo e($appointment->checked_in_at->format('H:i')); ?></span>
        </div>
    </div>

    <div class="important-note">
        HARAP MENUNGGU HINGGA NOMOR ANDA DIPANGGIL
    </div>

    <div class="footer">
        <div style="margin-bottom: 3mm;">
            <strong>INFORMASI PENTING:</strong>
        </div>
        <div style="text-align: left; font-size: 9px; line-height: 1.4;">
            • Harap datang 15 menit sebelum jadwal<br>
            • Pantau layar antrian di ruang tunggu<br>
            • Bawa kartu identitas & kartu BPJS (jika ada)<br>
            • Simpan tiket ini dengan baik<br>
        </div>
        <div style="margin-top: 5mm; font-size: 8px;">
            Dicetak: <?php echo e(now()->format('d/m/Y H:i:s')); ?>

        </div>
        <div style="margin-top: 3mm;">
            ═══════════════════════════════
        </div>
        <div style="margin-top: 2mm; font-weight: bold;">
            TERIMA KASIH
        </div>
    </div>

    <script>
        // Auto print when page loads (for thermal printers)
        window.onload = function() {
            // Give a small delay to ensure page is fully loaded
            setTimeout(function() {
                // Uncomment the line below to enable auto-print
                // window.print();
            }, 500);
        };
    </script>
</body>
</html>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/queue/ticket.blade.php ENDPATH**/ ?>