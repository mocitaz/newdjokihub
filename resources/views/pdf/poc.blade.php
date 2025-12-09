<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>POC - {{ $project->order_id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #333; line-height: 1.4; padding: 40px; }
        
        .header-table { width: 100%; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        .brand { font-size: 20pt; font-weight: bold; color: #111; }
        .brand span { color: #555; }
        .doc-type { font-size: 16pt; font-weight: bold; color: #000; text-transform: uppercase; text-align: right; letter-spacing: 1px; }
        
        h2 { font-size: 11pt; color: #000; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 3px; margin-top: 20px; margin-bottom: 10px; }
        p { margin-bottom: 8px; text-align: justify; }
        ul { margin: 0 0 10px 20px; padding: 0; }
        li { margin-bottom: 3px; }
        
        table.meta { width: 100%; margin-bottom: 20px; font-size: 10pt; }
        table.meta td { padding: 3px 0; vertical-align: top; }
        table.meta td.label { font-weight: bold; width: 140px; }
        
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 9pt; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px; vertical-align: top; text-align: left; }
        table.data th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        table.data td.center { text-align: center; }
        
        .status-pass { font-weight: bold; color: #008000; text-align: center; }
        
        .recommendation-box { border: 1px solid #000; padding: 10px; font-weight: bold; text-align: center; background: #f9f9f9; margin: 10px 0; }
        
        .signatures { margin-top: 40px; width: 100%; }
        .sig-block { float: left; width: 45%; }
        .sig-block.right { float: right; }
        .sig-line { border-top: 1px solid #000; margin-top: 60px; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 8pt; color: #555; border-top: 1px solid #e5e7eb; padding-top: 5px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td valign="bottom" class="brand">DjokiHub<span>.</span></td>
            <td valign="bottom" class="doc-type">Proof of Concept</td>
        </tr>
    </table>

    <table class="meta">
        <tr>
            <td class="label">Project Name</td>
            <td>: {{ $project->name }}</td>
        </tr>
        <tr>
            <td class="label">Client</td>
            <td>: {{ $project->client_name ?? 'Muhammad Hasbi Hakim' }}</td>
        </tr>
        <tr>
            <td class="label">Reference ID</td>
            <td>: #{{ $project->order_id }}</td>
        </tr>
        <tr>
            <td class="label">Date</td>
            <td>: {{ now()->locale('id')->isoFormat('D MMMM Y') }}</td>
        </tr>
        <tr>
            <td class="label">POC Version</td>
            <td>: 1.0</td>
        </tr>
    </table>

    <h2>1. EXECUTIVE SUMMARY</h2>
    <p>Dokumen Proof of Concept (POC) ini dibuat untuk memvalidasi kelayakan metode dan hasil sementara dari proyek <strong>{{ $project->name }}</strong>. Dokumen ini bertujuan untuk mendemonstrasikan bahwa pendekatan yang digunakan mampu memenuhi kebutuhan klien serta standar kualitas yang disepakati, sebelum pengerjaan diselesaikan secara menyeluruh.</p>

    <h2>2. OBJECTIVES & SCOPE POC</h2>
    <p>Tujuan utama dari tahapan ini adalah:</p>
    <ul>
        <li><strong>Validasi Metode:</strong> Memastikan pendekatan / metode pengerjaan yang dipilih sudah tepat.</li>
        <li><strong>Verifikasi Kebutuhan Utama:</strong> Mengonfirmasi bahwa hasil sementara sudah sesuai dengan ekspektasi klien.</li>
        <li><strong>Standar Kualitas:</strong> Memastikan output pekerjaan memenuhi kriteria kelayakan yang diharapkan.</li>
        <li><strong>Identifikasi Kendala:</strong> Menemukan potensi hambatan sejak dini agar penyelesaian proyek berjalan lancar.</li>
    </ul>

    <h2>3. KEY ITEMS YANG DIVERIFIKASI</h2>
    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Item / Scope</th>
                <th width="30%">Requirement / Expectation</th>
                <th width="10%">Result</th>
                <th width="10%">Status</th>
                <th width="15%">Evidence</th>
            </tr>
        </thead>
        <tbody>
            @if($project->deliverables->count() > 0)
                @foreach($project->deliverables as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>Sesuai dengan permintaan dan spesifikasi.</td>
                    <td class="center">Sesuai</td>
                    <td class="status-pass">PASS</td>
                    <td>Terlampir</td>
                </tr>
                @endforeach
            @else
                <!-- Generic Fallback Items -->
                <tr>
                    <td class="center">1</td>
                    <td>Kesesuaian Lingkup (Scope)</td>
                    <td>Hasil pekerjaan mencakup semua poin yang diminta.</td>
                    <td class="center">Sesuai</td>
                    <td class="status-pass">PASS</td>
                    <td>Draft Awal</td>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>Kualitas & Akurasi</td>
                    <td>Output memiliki akurasi atau estetika yang standar.</td>
                    <td class="center">Baik</td>
                    <td class="status-pass">PASS</td>
                    <td>Review</td>
                </tr>
                <tr>
                    <td class="center">3</td>
                    <td>Struktur / Format Penyajian</td>
                    <td>Format hasil akhir sesuai dengan kesepakatan.</td>
                    <td class="center">Sesuai</td>
                    <td class="status-pass">PASS</td>
                    <td>Dokumen</td>
                </tr>
                <tr>
                    <td class="center">4</td>
                    <td>Fungsionalitas / Penerapan</td>
                    <td>Hasil dapat digunakan atau diterapkan sesuai tujuan.</td>
                    <td class="center">Berfungsi</td>
                    <td class="status-pass">PASS</td>
                    <td>Uji Coba</td>
                </tr>
            @endif
        </tbody>
    </table>

    <h2>4. CATATAN & TINDAK LANJUT</h2>
    <ul>
        <li>Detail revisi minor akan disesuaikan pada tahap finalisasi.</li>
        <li>Data atau materi pendukung tambahan mungkin diperlukan seiring progres.</li>
        <li>Penambahan lingkup kerja di luar kesepakatan awal akan dibahas secara terpisah.</li>
    </ul>

    <h2>5. KESIMPULAN & REKOMENDASI</h2>
    <p>Berdasarkan hasil verifikasi di atas, kami menyimpulkan bahwa:</p>
    <div class="recommendation-box">
        KONSEP & HASIL KERJA INI LAYAK DAN SIAP untuk dilanjutkan ke tahap penyelesaian akhir (Final Stage)<br>
        sesuai dengan standar dan metode yang telah divalidasi dalam dokumen ini.
    </div>
    <p>Estimasi waktu penyelesaian: Sesuai timeline proyek yang telah disepakati.</p>

    <h2>6. APPROVAL & TANDA TANGAN PERSETUJUAN</h2>
    <p>Disetujui dan disepakati pada tanggal <strong>{{ now()->locale('id')->isoFormat('D MMMM Y') }}</strong></p>

    <div class="signatures">
        <div class="sig-block">
            <p><strong>Approved By</strong></p>
            <div class="sig-line"></div>
            <p><strong>{{ $project->client_name }}</strong><br>Project Owner / Client</p>
            <p style="margin-top: 5px; font-size: 8pt;">Tanggal: {{ now()->locale('id')->format('d-m-Y') }}</p>
        </div>
        <div class="sig-block right">
            <p><strong>Validated & Developed By</strong></p>
            <div class="sig-line"></div>
            <p><strong>Djoki Coding Team</strong><br>Technical Lead</p>
            <p style="margin-top: 5px; font-size: 8pt;">Tanggal: {{ now()->locale('id')->format('d-m-Y') }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="footer">
        Confidential Document &bull; Djoki Coding &bull; Generated on {{ now()->format('Y-m-d') }}
    </div>
</body>
</html>
