<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Data Kuliner Masyarakat - KUMAR</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body {
            background: #e5e7eb;
            color: #1f2937;
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            margin: 10mm auto;
            padding: 18mm;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        }

        .print-btn-wrapper {
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            z-index: 50;
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 22px;
            border: none;
            border-radius: 999px;
            background: #960913;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(150, 9, 19, 0.25);
        }

        /* Header */
        .report-header {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 3px solid #960913;
        }

        .logo-image {
            width: 80px;
            height: auto;
            object-fit: contain;
            flex-shrink: 0;
            transform: translateX(45px);
        }

        .header-text {
            flex: 1;
        }

        .report-title {
            font-size: 22px;
            font-weight: 900;
            text-align: center;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            line-height: 1.35;
        }

        .report-info h3,
        .section-title {
            margin: 0 0 12px;
            font-size: 15px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 8px 12px;
            font-size: 12px;
        }

        .info-grid strong {
            color: #111827;
            font-weight: 700;
        }

        .section {
            margin-top: 20px;
        }

        .section-title {
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Ringkasan Utama */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .summary-table th {
            background: #960913;
            color: #ffffff;
            font-weight: 600;
            padding: 10px;
            border: 1px solid #960913;
        }

        .summary-table td {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            color: #374151;
            vertical-align: top;
        }

        .summary-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .summary-number {
            width: 140px;
            text-align: center;
            font-weight: 800;
            color: #960913;
            white-space: nowrap;
        }

        .summary-description {
            color: #6b7280;
        }

        /* Rekap Data */
        .recap-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead th {
            background: #960913;
            color: #ffffff;
            font-weight: 600;
            padding: 10px;
            border: 1px solid #960913;
        }

        tbody td {
            padding: 9px 10px;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .font-semibold {
            font-weight: 700;
        }

        .empty-row {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
        }

        /* Catatan & TTD */
        .note-signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            break-inside: avoid;
        }

        .report-note {
            width: 55%;
            font-size: 12px;
            color: #4b5563;
            line-height: 1.7;
        }

        .report-note h4 {
            margin: 0 0 8px;
            color: #111827;
            font-size: 13px;
            font-weight: 800;
        }

        .report-note p {
            margin: 0 0 8px;
        }

        .signature-box {
            width: 220px;
            text-align: center;
            font-size: 12px;
            color: #374151;
        }

        .signature-box p {
            margin: 0 0 6px;
        }

        .signature-space {
            height: 40px;
        }

        .signature-line {
            border-bottom: 1px solid #374151;
            margin-bottom: 8px;
        }

        .footer-print {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }

        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                background: #ffffff;
            }

            .no-print {
                display: none !important;
            }

            .page-container {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                /* Optional minor scaling if still overflowing slightly */
                zoom: 0.96;
            }

            .section,
            .summary-table,
            table,
            .report-info {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="print-btn-wrapper no-print">
        <button onclick="window.print()" class="print-btn">
            Cetak Laporan
        </button>
    </div>

    <main class="page-container">

        {{-- Header --}}
        <header class="report-header">
            <img src="{{ asset('assets/img/icon-kumar-logo.png') }}" alt="Logo KUMAR" class="logo-image">

            <div class="header-text">
                <h1 class="report-title">
                    Laporan Rekap Data Kuliner Masyarakat
                </h1>
            </div>
        </header>

        {{-- Informasi Laporan --}}
        <section class="report-info">
            <br>
            <h3>Informasi Laporan</h3>

            <div class="info-grid">
                <span>Tanggal Cetak</span>
                : {{ now()->translatedFormat('d F Y') }}

                <span>Dicetak Oleh</span>
                : {{ auth()->user()?->name ?? 'Admin' }} (Admin)

                <span>Periode</span>
                : Semua Waktu
            </div>
        </section>

        {{-- Ringkasan Utama --}}
        <section class="section">
            <h3 class="section-title">Ringkasan Utama</h3>

            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Indikator</th>
                        <th class="text-center">Jumlah / Nilai</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Restoran Aktif</td>
                        <td class="summary-number">{{ number_format($totalRestaurants ?? 0) }}</td>
                        <td class="summary-description">
                            Restoran yang tercatat aktif pada sistem KUMAR.
                        </td>
                    </tr>

                    <tr>
                        <td>Usulan Disetujui</td>
                        <td class="summary-number">{{ number_format($totalApproved ?? 0) }}</td>
                        <td class="summary-description">
                            Usulan tempat kuliner yang telah diterima oleh admin.
                        </td>
                    </tr>

                    <tr>
                        <td>Usulan Tertunda</td>
                        <td class="summary-number">{{ number_format($totalPending ?? 0) }}</td>
                        <td class="summary-description">
                            Usulan tempat kuliner yang masih menunggu proses validasi.
                        </td>
                    </tr>

                    <tr>
                        <td>Usulan Ditolak</td>
                        <td class="summary-number">{{ number_format($totalRejected ?? 0) }}</td>
                        <td class="summary-description">
                            Usulan tempat kuliner yang tidak diterima berdasarkan hasil validasi.
                        </td>
                    </tr>

                    <tr>
                        <td>Total Ulasan</td>
                        <td class="summary-number">{{ number_format($totalReviews ?? 0) }}</td>
                        <td class="summary-description">
                            Jumlah seluruh ulasan yang diberikan oleh pengguna.
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        {{-- Rekap Data --}}
        <section class="section">
            <h3 class="section-title">Rekap Data Restoran</h3>

            <div class="recap-grid">
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Kampus</th>
                                <th class="text-center" width="90">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($campusRecap as $recap)
                                <tr>
                                    <td>{{ $recap->campus->name ?? 'Tidak diketahui' }}</td>
                                    <td class="text-center font-semibold">
                                        {{ number_format($recap->total ?? 0) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-row">
                                        Belum ada data kampus
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Kategori Restoran</th>
                                <th class="text-center" width="90">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryRecap as $recap)
                                <tr>
                                    <td>{{ $recap->category ?? 'Lainnya' }}</td>
                                    <td class="text-center font-semibold">
                                        {{ number_format($recap->total ?? 0) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-row">
                                        Belum ada data kategori
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Catatan dan Tanda Tangan --}}
        <section class="note-signature">
            <div class="signature-box">
                <br>
                <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-semibold">Admin KUMAR</p>

                <div class="signature-space"></div>

                <div class="signature-line"></div>
                <p class="font-semibold">{{ auth()->user()?->name ?? 'Admin' }}</p>
            </div>
        </section>

        <footer class="footer-print">
            Dokumen ini dicetak secara otomatis melalui sistem KUMAR.
        </footer>
    </main>
</body>
</html>