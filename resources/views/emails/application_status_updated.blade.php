<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemberitahuan Status Lamaran Pekerjaan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: #1e293b;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding: 40px 16px;
        }
        .main-card {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }
        .header {
            padding: 28px 32px 20px 32px;
            border-bottom: 1px solid #f1f5f9;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo {
            max-height: 40px;
            max-width: 160px;
            height: auto;
            display: block;
        }
        .header-category {
            text-align: right;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
        }
        .content {
            padding: 32px;
        }
        .salutation {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .paragraph {
            font-size: 14px;
            color: #334155;
            line-height: 1.65;
            margin: 0 0 16px 0;
        }
        .notice-card {
            margin: 24px 0;
            padding: 18px 20px;
            border-radius: 8px;
            border-left: 4px solid #0f172a;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .notice-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px 0;
        }
        .notice-desc {
            font-size: 13px;
            color: #475569;
            line-height: 1.6;
            margin: 0;
        }
        .memo-box {
            margin: 20px 0;
            padding: 16px 20px;
            background-color: #f1f5f9;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .memo-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #475569;
            margin-bottom: 6px;
        }
        .memo-text {
            font-size: 13px;
            color: #1e293b;
            font-style: italic;
            line-height: 1.6;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 13px;
        }
        .details-table td {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .details-label {
            width: 38%;
            color: #64748b;
            font-weight: 500;
        }
        .details-val {
            width: 62%;
            color: #0f172a;
            font-weight: 600;
        }
        .btn-wrapper {
            margin: 28px 0 20px 0;
            text-align: left;
        }
        .btn-primary {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 6px;
            text-align: center;
        }
        .footnote {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed #e2e8f0;
        }
        .sign-off {
            margin-top: 28px;
            font-size: 13px;
            color: #334155;
            line-height: 1.6;
        }
        .sign-off strong {
            color: #0f172a;
        }
        .footer {
            padding: 24px 32px;
            background-color: #fafbfc;
            border-top: 1px solid #f1f5f9;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    @php
        $job = $application->job;
        $company = $job?->company;
        $applicantProfile = $application->applicantProfile;
        $candidateName = $applicantProfile?->full_name ?? ($applicantProfile?->user?->name ?? 'Pelamar');
        $jobTitle = $job?->title ?? 'Posisi Pekerjaan';
        $companyName = $company?->name ?? config('app.name', 'MIKA CAREER');

        // Embed logo resmi secara inline agar selalu tampil di semua aplikasi email
        $logoPath = public_path('images/mikaaaa.png');
        $hasLogo = file_exists($logoPath);
        $logoSrc = (isset($message) && method_exists($message, 'embed') && $hasLogo) 
            ? $message->embed($logoPath) 
            : ($hasLogo ? asset('images/mikaaaa.png') : null);

        // Teks dan instruksi profesional sesuai status
        $statusInfo = match($status) {
            'Reviewed' => [
                'badge'       => 'Lolos Seleksi Berkas',
                'border_color'=> '#0f172a',
                'title'       => 'Pemberitahuan: Lolos Seleksi Berkas & Undangan Ujian Online',
                'desc'        => 'Berdasarkan hasil penelaahan kualifikasi terhadap berkas lamaran yang Anda ajukan, kami menyampaikan bahwa berkas Anda memenuhi kriteria awal posisi ini. Anda kami undang untuk melanjutkan ke tahapan Ujian Seleksi Online.',
                'btn_text'    => 'Masuk ke Portal & Mulai Ujian',
                'btn_url'     => route('profile', ['tab' => 'riwayat']),
                'has_exam'    => true,
            ],
            'Shortlisted' => [
                'badge'       => 'Kandidat Terpilih',
                'border_color'=> '#0f172a',
                'title'       => 'Pemberitahuan: Lolos Tahap Evaluasi (Shortlisted)',
                'desc'        => 'Hasil evaluasi dan penilaian tes Anda telah kami tinjau. Profil Anda dinyatakan memenuhi standar kompetensi dan telah kami masukkan ke dalam daftar kandidat terpilih (Shortlisted) untuk proses seleksi lebih lanjut.',
                'btn_text'    => 'Buka Riwayat Lamaran',
                'btn_url'     => route('profile', ['tab' => 'riwayat']),
                'has_exam'    => false,
            ],
            'Interview' => [
                'badge'       => 'Jadwal Wawancara',
                'border_color'=> '#0f172a',
                'title'       => 'Undangan Tahap Wawancara Kerja',
                'desc'        => 'Kami mengundang Anda untuk mengikuti tahapan wawancara bersama tim rekruter. Detail mengenai waktu pelaksanaan dan media pertemuan telah kami sematkan pada akun Anda.',
                'btn_text'    => 'Lihat Jadwal Wawancara',
                'btn_url'     => route('profile', ['tab' => 'riwayat']),
                'has_exam'    => false,
            ],
            'Accepted' => [
                'badge'       => 'Pemberitahuan Penerimaan',
                'border_color'=> '#0f172a',
                'title'       => 'Pemberitahuan Penerimaan Kerja',
                'desc'        => 'Dengan senang hati kami sampaikan bahwa Anda dinyatakan Diterima untuk bergabung bersama ' . $companyName . '. Tim Human Resources akan segera menghubungi Anda untuk koordinasi penawaran resmi (offering) serta administrasi onboarding.',
                'btn_text'    => 'Akses Akun Pelamar',
                'btn_url'     => route('profile', ['tab' => 'riwayat']),
                'has_exam'    => false,
            ],
            'Rejected' => [
                'badge'       => 'Perkembangan Lamaran',
                'border_color'=> '#64748b',
                'title'       => 'Informasi Perkembangan Seleksi Lamaran',
                'desc'        => 'Setelah melalui proses pertimbangan yang mendalam terhadap seluruh berkas kandidat yang masuk, saat ini kualifikasi Anda belum sesuai dengan kebutuhan posisi ini. Kami sangat mengapresiasi waktu dan minat yang telah Anda berikan, serta akan tetap menyimpan profil Anda untuk peluang yang sesuai di masa mendatang.',
                'btn_text'    => 'Lihat Lowongan Lainnya',
                'btn_url'     => route('jobs.index'),
                'has_exam'    => false,
            ],
            default => [
                'badge'       => 'Status Lamaran',
                'border_color'=> '#0f172a',
                'title'       => 'Pembaruan Perkembangan Lamaran Pekerjaan',
                'desc'        => 'Terdapat pembaruan informasi pada status lamaran pekerjaan yang Anda ajukan. Silakan masuk ke akun Anda untuk meninjau detail perkembangan seleksi.',
                'btn_text'    => 'Buka Riwayat Lamaran',
                'btn_url'     => route('profile', ['tab' => 'riwayat']),
                'has_exam'    => false,
            ]
        };
    @endphp

    <div class="wrapper">
        <div class="main-card">
            <!-- Header with Company Logo -->
            <div class="header">
                <table class="header-table">
                    <tr>
                        <td align="left" style="vertical-align: middle;">
                            @if ($logoSrc)
                                <img src="{{ $logoSrc }}" alt="{{ $companyName }}" class="header-logo">
                            @else
                                <span style="font-size: 16px; font-weight: 700; color: #0f172a; letter-spacing: -0.5px;">{{ $companyName }}</span>
                            @endif
                        </td>
                        <td align="right" class="header-category" style="vertical-align: middle;">
                            Rekrutmen Resmi
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Content -->
            <div class="content">
                <div class="salutation">Yth. Sdr/i. {{ $candidateName }},</div>

                <p class="paragraph">
                    Terima kasih atas minat dan partisipasi Anda dalam proses seleksi penerimaan karyawan di <strong>{{ $companyName }}</strong> untuk posisi <strong>{{ $jobTitle }}</strong>.
                </p>

                <!-- Official Notice Callout -->
                <div class="notice-card" style="border-left-color: {{ $statusInfo['border_color'] }};">
                    <h3 class="notice-title">{{ $statusInfo['title'] }}</h3>
                    <p class="notice-desc">{{ $statusInfo['desc'] }}</p>
                </div>

                <!-- Catatan Khusus Rekruter jika diisi -->
                @if (!empty(trim($notes ?? '')))
                    <div class="memo-box">
                        <div class="memo-label">Catatan Tim Rekrutmen:</div>
                        <div class="memo-text">"{{ $notes }}"</div>
                    </div>
                @endif

                <!-- Ringkasan Lamaran -->
                <table class="details-table">
                    <tr>
                        <td class="details-label">Posisi yang Dilamar</td>
                        <td class="details-val">: {{ $jobTitle }}</td>
                    </tr>
                    <tr>
                        <td class="details-label">Perusahaan</td>
                        <td class="details-val">: {{ $companyName }}</td>
                    </tr>
                    @if ($job?->department)
                        <tr>
                            <td class="details-label">Departemen</td>
                            <td class="details-val">: {{ $job->department->name }}</td>
                        </tr>
                    @endif
                    @if ($application->applied_at)
                        <tr>
                            <td class="details-label">Tanggal Lamaran</td>
                            <td class="details-val">: {{ \Carbon\Carbon::parse($application->applied_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                        </tr>
                    @endif
                </table>

                <!-- Action Button -->
                <div class="btn-wrapper">
                    <a href="{{ $statusInfo['btn_url'] }}" class="btn-primary">
                        {{ $statusInfo['btn_text'] }}
                    </a>
                </div>

                @if ($statusInfo['has_exam'])
                    <div class="footnote">
                        <strong>Panduan Teknis:</strong> Untuk kenyamanan dan kelancaran pengerjaan ujian online, disarankan menggunakan perangkat komputer atau laptop dengan koneksi internet yang stabil serta peramban web versi terbaru.
                    </div>
                @endif

                <div class="sign-off">
                    Hormat kami,<br>
                    <strong>Tim Rekrutmen & Pengembangan Talenta</strong><br>
                    {{ $companyName }}
                </div>
            </div>

            <!-- Professional Corporate Footer -->
            <div class="footer">
                Email ini dikirimkan secara otomatis melalui Sistem E-Recruitment {{ $companyName }}.<br>
                Mohon untuk tidak membalas email ini secara langsung.<br>
                &copy; {{ date('Y') }} {{ $companyName }}. Hak cipta dilindungi undang-undang.
            </div>
        </div>
    </div>
</body>
</html>
