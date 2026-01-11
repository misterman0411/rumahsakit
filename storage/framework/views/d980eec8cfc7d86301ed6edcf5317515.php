<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Radiologi - <?php echo e($radiology->nomor_permintaan); ?></title>
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
            border-bottom: 3px solid #7C3AED;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #7C3AED;
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
            background-color: #7C3AED;
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
            border-left: 3px solid #7C3AED;
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
            background-color: #faf5ff;
            border: 2px solid #9333ea;
            padding: 20px;
            margin-bottom: 20px;
        }
        .result-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .result-content {
            font-size: 14px;
            color: #111;
            line-height: 1.8;
            white-space: pre-line;
            margin-bottom: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-draft { 
            background-color: #fef9c3; 
            color: #854d0e; 
        }
        .status-final { 
            background-color: #dcfce7; 
            color: #166534; 
        }
        .signature-box {
            background: linear-gradient(135deg, #dcfce7 0%, #dbeafe 100%);
            border: 2px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .signature-title {
            font-size: 16px;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 10px;
        }
        .signature-info {
            font-size: 14px;
            color: #111;
            margin-bottom: 5px;
        }
        .signature-timestamp {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
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
        .audit-icon-orange { background-color: #fed7aa; color: #9a3412; }
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
            color: #7C3AED;
        }
        .audit-role {
            font-size: 11px;
            color: #999;
            font-style: italic;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            font-size: 12px;
            color: #666;
        }
        .version-badge {
            background-color: #fef3c7;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-left: 10px;
        }
        .image-info {
            background-color: #eff6ff;
            border: 1px solid #93c5fd;
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
        }
        .image-info p {
            font-size: 13px;
            color: #1e40af;
            margin: 5px 0;
        }
        @media print {
            body {
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🏥 RUMAH SAKIT</h1>
        <p>Laporan Hasil Pemeriksaan Radiologi</p>
        <p style="font-size: 12px; margin-top: 5px;"><?php echo e($radiology->nomor_permintaan); ?>

            <?php if($radiology->version > 1): ?>
            <span class="version-badge">VERSI <?php echo e($radiology->version); ?></span>
            <?php endif; ?>
        </p>
    </div>

    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">Informasi Pasien</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">No. Rekam Medis</div>
                <div class="info-value"><?php echo e($radiology->pasien->no_rekam_medis); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Nama Lengkap</div>
                <div class="info-value"><?php echo e($radiology->pasien->nama); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Jenis Kelamin</div>
                <div class="info-value"><?php echo e($radiology->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value"><?php echo e(\Carbon\Carbon::parse($radiology->pasien->tanggal_lahir)->format('d/m/Y')); ?> (<?php echo e(\Carbon\Carbon::parse($radiology->pasien->tanggal_lahir)->age); ?> tahun)</div>
            </div>
        </div>
    </div>

    <!-- Order Information -->
    <div class="section">
        <div class="section-title">Informasi Pemeriksaan</div>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Jenis Pemeriksaan</div>
                <div class="info-value"><?php echo e($radiology->jenisTes->nama); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Dokter Pengirim</div>
                <div class="info-value"><?php echo e($radiology->dokter->user->nama); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Tanggal Order</div>
                <div class="info-value"><?php echo e($radiology->created_at->format('d/m/Y H:i')); ?></div>
            </div>
            <div class="info-item">
                <div class="info-label">Status Laporan</div>
                <div class="info-value">
                    <?php if($radiology->report_status === 'final'): ?>
                        <span class="status-badge status-final">FINAL</span>
                    <?php else: ?>
                        <span class="status-badge status-draft">DRAFT</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if($radiology->catatan_klinis): ?>
        <div class="info-item" style="margin-top: 15px;">
            <div class="info-label">Catatan Klinis</div>
            <div class="info-value" style="font-weight: normal;"><?php echo e($radiology->catatan_klinis); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Image Information -->
    <?php if($radiology->image_path): ?>
    <div class="section">
        <div class="image-info">
            <p><strong>📸 Gambar Radiologi:</strong> Tersimpan dalam sistem</p>
            <p><strong>Path:</strong> <?php echo e($radiology->image_path); ?></p>
            <p style="font-size: 11px; color: #64748b; margin-top: 10px;">
                <em>* Gambar dapat diakses melalui sistem elektronik untuk analisis lebih lanjut</em>
            </p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Results -->
    <?php if($radiology->hasil): ?>
    <div class="section">
        <div class="section-title">Hasil Pemeriksaan</div>
        <div class="result-box">
            <div class="result-content"><?php echo e($radiology->hasil); ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Interpretation -->
    <?php if($radiology->interpretasi): ?>
    <div class="section">
        <div class="section-title">Interpretasi</div>
        <div class="result-box">
            <div class="result-content"><?php echo e($radiology->interpretasi); ?></div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Digital Signature -->
    <?php if($radiology->signed_by && $radiology->signed_at): ?>
    <div class="signature-box">
        <div class="signature-title">✅ Laporan Telah Ditandatangani Secara Digital</div>
        <div class="signature-info">
            <strong>Radiolog:</strong> <?php echo e($radiology->signedBy->nama); ?>

            <?php if($radiology->signedBy->peran): ?>
            (<?php echo e(ucfirst(str_replace('_', ' ', $radiology->signedBy->peran->nama))); ?>)
            <?php endif; ?>
        </div>
        <div class="signature-timestamp">
            Ditandatangani pada: <?php echo e($radiology->signed_at->format('d/m/Y H:i:s')); ?> WIB
        </div>
        <div style="font-size: 11px; color: #065f46; margin-top: 10px;">
            <em>Dokumen ini sah secara hukum dan dilindungi dari perubahan setelah ditandatangani.</em>
        </div>
    </div>
    <?php endif; ?>

    <!-- Audit Trail -->
    <div class="section">
        <div class="section-title">Riwayat Pemeriksaan (Audit Trail)</div>
        <div class="audit-trail">
            <!-- Order Created -->
            <div class="audit-item">
                <div class="audit-icon audit-icon-gray">📋</div>
                <div class="audit-content">
                    <div class="audit-title">Order Dibuat</div>
                    <div class="audit-time"><?php echo e($radiology->created_at->format('d/m/Y H:i:s')); ?></div>
                    <div class="audit-user">Oleh: <?php echo e($radiology->dokter->user->nama); ?></div>
                </div>
            </div>

            <!-- Hasil Diinput -->
            <?php if($radiology->hasil_diinput_oleh): ?>
            <div class="audit-item">
                <div class="audit-icon audit-icon-purple">✍️</div>
                <div class="audit-content">
                    <div class="audit-title">Hasil Diinput</div>
                    <?php if($radiology->waktu_input_hasil): ?>
                    <div class="audit-time"><?php echo e($radiology->waktu_input_hasil->format('d/m/Y H:i:s')); ?></div>
                    <?php endif; ?>
                    <div class="audit-user">Oleh: <?php echo e($radiology->hasilDiinputOleh->nama); ?></div>
                    <?php if($radiology->hasilDiinputOleh->peran): ?>
                    <div class="audit-role"><?php echo e(ucfirst(str_replace('_', ' ', $radiology->hasilDiinputOleh->peran->nama))); ?></div>
                    <?php endif; ?>
                    <?php if($radiology->report_status === 'draft' && !$radiology->signed_by): ?>
                    <div style="margin-top: 5px;">
                        <span class="status-badge status-draft">DRAFT</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Ditandatangani -->
            <?php if($radiology->signed_by): ?>
            <div class="audit-item">
                <div class="audit-icon audit-icon-green">✅</div>
                <div class="audit-content">
                    <div class="audit-title">Laporan Ditandatangani</div>
                    <?php if($radiology->signed_at): ?>
                    <div class="audit-time"><?php echo e($radiology->signed_at->format('d/m/Y H:i:s')); ?></div>
                    <?php endif; ?>
                    <div class="audit-user">Oleh: <?php echo e($radiology->signedBy->nama); ?></div>
                    <?php if($radiology->signedBy->peran): ?>
                    <div class="audit-role"><?php echo e(ucfirst(str_replace('_', ' ', $radiology->signedBy->peran->nama))); ?></div>
                    <?php endif; ?>
                    <div style="margin-top: 5px;">
                        <span class="status-badge status-final">FINAL</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Revisi Information -->
            <?php if($radiology->parentRevision): ?>
            <div class="audit-item">
                <div class="audit-icon audit-icon-orange">🔄</div>
                <div class="audit-content">
                    <div class="audit-title">Revisi dari Versi <?php echo e($radiology->parentRevision->version); ?></div>
                    <div class="audit-time"><?php echo e($radiology->created_at->format('d/m/Y H:i:s')); ?></div>
                    <div style="font-size: 12px; color: #9a3412; margin-top: 5px;">
                        <em>Laporan ini merupakan revisi dari laporan sebelumnya</em>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Rumah Sakit</strong></p>
        <p>Dokumen ini dicetak pada: <?php echo e(now()->format('d/m/Y H:i:s')); ?> WIB</p>
        <p style="margin-top: 10px; font-size: 11px;">
            Untuk pertanyaan atau informasi lebih lanjut, silakan hubungi bagian radiologi.
        </p>
        <?php if($radiology->report_status === 'final'): ?>
        <p style="margin-top: 15px; font-size: 11px; color: #10b981; font-weight: bold;">
            ✓ Dokumen ini telah diverifikasi dan ditandatangani secara digital
        </p>
        <?php else: ?>
        <p style="margin-top: 15px; font-size: 11px; color: #f59e0b; font-weight: bold;">
            ⚠ Dokumen ini masih berstatus DRAFT dan belum final
        </p>
        <?php endif; ?>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\radiology\print.blade.php ENDPATH**/ ?>