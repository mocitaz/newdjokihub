<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BAST - {{ $project->order_id }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; line-height: 1.6; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { font-family: 'Arial', sans-serif; font-size: 18pt; font-weight: bold; text-decoration: underline; margin: 0; text-transform: uppercase; }
        .header p { font-size: 11pt; margin: 5px 0 0; }
        
        .c-both { clear: both; }
        
        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 10px; text-transform: uppercase; font-size: 11pt; }
        
        table.meta { width: 100%; margin-bottom: 20px; }
        table.meta td { vertical-align: top; padding: 2px 0; }
        table.meta td.label { width: 150px; font-weight: bold; }
        
        .content { margin-bottom: 30px; text-align: justify; }
        
        table.bordered { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        table.bordered th, table.bordered td { border: 1px solid #000; padding: 8px; font-size: 11pt; }
        table.bordered th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        
        .signatures { margin-top: 60px; width: 100%; }
        .sig-block { float: left; width: 40%; text-align: center; }
        .sig-block.right { float: right; }
        .sig-space { height: 80px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 8pt; border-top: 1px solid #ccc; padding-top: 5px; font-family: 'Arial', sans-serif; color: #666; }
        
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 100px; color: rgba(0,0,0,0.05); font-weight: bold; z-index: -1; white-space: nowrap; font-family: 'Arial', sans-serif; }
    </style>
</head>
<body>
    <div class="watermark">OFFICIAL DOCUMENT</div>

    <div class="header">
        <h1>Berita Acara Serah Terima Pekerjaan</h1>
        <p>Nomor: {{ $project->order_id }}/BAST/{{ now()->format('Y') }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ now()->locale('id')->translatedFormat('l') }}</strong> tanggal <strong>{{ now()->format('d') }}</strong> bulan <strong>{{ now()->locale('id')->translatedFormat('F') }}</strong> tahun <strong>{{ now()->format('Y') }}</strong> ({{ now()->format('d-m-Y') }}), kami yang bertanda tangan di bawah ini:</p>
        
        <table class="meta">
            <tr>
                <td class="label" style="width: 30px;">1.</td>
                <td class="label">Nama</td>
                <td>: <strong>Djoki Coding Management</strong></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Jabatan</td>
                <td>: Developer Team</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Dalam hal ini bertindak untuk dan atas nama <strong>Djoki Coding</strong>, selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.</td>
            </tr>
        </table>

        <table class="meta">
            <tr>
                <td class="label" style="width: 30px;">2.</td>
                <td class="label">Nama</td>
                <td>: <strong>{{ $project->client_name ?? 'Klien Yang Terhormat' }}</strong></td>
            </tr>
            <tr>
                <td></td>
                <td class="label">Proyek</td>
                <td>: {{ $project->name }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">Dalam hal ini bertindak sebagai Pemilik Pekerjaan, selanjutnya disebut sebagai <strong>PIHAK KEDUA</strong>.</td>
            </tr>
        </table>
        
        <p>Kedua belah pihak sepakat untuk melakukan serah terima pekerjaan dengan ketentuan sebagai berikut:</p>

        <div class="section-title">PASAL 1: LINGKUP PEKERJAAN</div>
        <p>PIHAK PERTAMA telah menyelesaikan pekerjaan <strong>{{ $project->name }}</strong> sesuai dengan spesifikasi yang telah disepakati sebelumnya. Rincian deliverable adalah sebagai berikut:</p>
        
        @if($project->deliverables->count() > 0)
        <table class="bordered">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Item Pekerjaan</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($project->deliverables as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        {{ $item->name }}
                        @if($item->description)
                        <br><span style="font-size: 10pt; font-style: italic; color: #555;">{{ $item->description }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->is_completed ? 'Selesai / Diterima' : 'Pending' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p><em>(Tidak ada daftar deliverable spesifik yang tercatat dalam sistem)</em></p>
        @endif

        <div class="section-title">PASAL 2: SERAH TERIMA</div>
        <p>PIHAK PERTAMA menyerahkan hasil pekerjaan kepada PIHAK KEDUA, dan PIHAK KEDUA menyatakan telah menerima hasil pekerjaan tersebut dengan baik dan lengkap.</p>

        <div class="section-title">PASAL 3: GARANSI DAN PEMELIHARAAN</div>
        <p>PIHAK PERTAMA memberikan masa garansi selama <strong>30 (tiga puluh) hari kalender</strong> terhitung sejak tanggal Berita Acara ini ditandatangani. Garansi meliputi perbaikan <em>bug</em> atau <em>error</em> yang disebabkan oleh kesalahan kode (<em>script error</em>). Garansi tidak termasuk penambahan fitur baru atau perubahan alur sistem di luar kesepakatan awal.</p>

        <div class="section-title">PASAL 4: PENUTUP</div>
        <p>Demikian Berita Acara Serah Terima ini dibuat rangkap 2 (dua) bermaterai cukup dan memiliki kekuatan hukum yang sama untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signatures">
        <div class="sig-block">
            <p><strong>PIHAK KEDUA</strong><br>(Klien)</p>
            <div class="sig-space"></div>
            <p class="sig-name">{{ $project->client_name ?? 'Nama Klien' }}</p>
        </div>
        <div class="sig-block right">
            <p><strong>PIHAK PERTAMA</strong><br>(Developer)</p>
            <div class="sig-space"></div>
            <p class="sig-name">Djoki Coding</p>
        </div>
        <div class="c-both"></div>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem DjokiHub. Validitas dokumen ini dijamin oleh Djoki Coding.
    </div>
</body>
</html>
