<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Hasil Tes DISC - {{ (($attempt->attempt_type === 'employee') || empty($attempt->job_application_id)) ? ($attempt->user?->employeeProfile?->full_name ?? ($attempt->user?->name ?? 'Karyawan')) : ($attempt->jobApplication?->applicantProfile?->full_name ?? 'Pelamar') }}</title>
    <style>
        @page {
            margin: 7mm 10mm 7mm 10mm;
            size: a4 portrait;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10.5px;
            line-height: 1.4;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Utility Table Layout */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .w-third {
            width: 33.333%;
        }

        .align-top {
            vertical-align: top;
        }

        .align-middle {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-extrabold {
            font-weight: 800;
        }

        .uppercase {
            text-transform: uppercase;
        }

        /* Document Header */
        .doc-header {
            border-bottom: 2px solid #1e293b;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .system-badge {
            font-size: 9px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .doc-title {
            font-size: 15.5px;
            font-weight: 900;
            color: #0f172a;
            margin: 1px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .doc-subtitle {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 1px;
        }

        .confidential-tag {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 2.5px 7px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        /* Candidate Bio Card */
        .bio-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 6px 9px;
            margin-bottom: 9px;
        }

        .bio-label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .bio-value {
            font-size: 11px;
            color: #0f172a;
            font-weight: bold;
        }

        /* Profile Banner */
        .profile-banner {
            background-color: #1e293b;
            color: #ffffff;
            border-radius: 3px;
            padding: 6px 10px;
            margin-bottom: 10px;
        }

        .pattern-badge {
            background-color: #ffffff;
            color: #0f172a;
            font-size: 10.5px;
            font-weight: 900;
            padding: 2.5px 7px;
            border-radius: 2px;
            display: inline-block;
            letter-spacing: 0.4px;
        }

        .pattern-title {
            font-size: 12.5px;
            font-weight: 800;
            color: #ffffff;
            margin-left: 7px;
            vertical-align: middle;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Section Block */
        .section-title {
            font-size: 10px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 3px;
            margin-top: 8px;
            margin-bottom: 6px;
        }

        /* Table Styling */
        .score-table {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            font-size: 9.5px;
            margin-bottom: 9px;
        }

        .score-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: bold;
            padding: 3.5px 5px;
            border: 1px solid #334155;
            text-align: center;
        }

        .score-table td {
            padding: 3px 5px;
            border: 1px solid #e2e8f0;
            text-align: center;
            color: #1e293b;
        }

        .score-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .score-table .row-title {
            text-align: left;
            font-weight: bold;
            color: #0f172a;
            padding-left: 8px;
        }

        .score-table .row-highlight {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #0f172a;
        }

        /* Charts Container */
        .charts-table {
            width: 100%;
            margin-bottom: 9px;
        }

        .chart-card {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 4px 5px;
            text-align: center;
        }

        .chart-header {
            font-size: 8.5px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            padding-bottom: 3px;
            margin-bottom: 3px;
            border-bottom: 1px solid #e2e8f0;
            letter-spacing: 0.3px;
        }

        /* Standard DISC Personality Cards */
        .personality-card {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-top: 2.5px solid #1e293b;
            border-radius: 3px;
            padding: 5px 8px;
            margin-bottom: 5px;
        }

        .personality-section-title {
            font-size: 9.5px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 2px;
        }

        .personality-pattern-title {
            font-size: 11.5px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }

        .personality-trait-list {
            margin: 0;
            padding-left: 14px;
            font-size: 9.5px;
            line-height: 1.35;
            color: #334155;
        }

        .personality-trait-list li {
            margin-bottom: 1px;
        }

        /* Analysis Box */
        .desc-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3.5px solid #1e293b;
            padding: 5px 8px;
            border-radius: 0 3px 3px 0;
            font-size: 10px;
            line-height: 1.4;
            color: #1e293b;
            margin-bottom: 6px;
            text-align: justify;
        }

        .job-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3.5px solid #475569;
            border-radius: 0 3px 3px 0;
            padding: 5px 8px;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
            margin-bottom: 6px;
        }

        /* Footer Signature */
        .footer-table {
            margin-top: 6px;
            padding-top: 4px;
            border-top: 1px solid #cbd5e1;
            font-size: 9.5px;
            color: #64748b;
        }

        .sig-box {
            width: 170px;
            text-align: center;
            float: right;
        }

        .sig-space {
            height: 24px;
        }
    </style>
</head>

<body>

    <!-- Header Section with Mika Logo -->
    <div class="doc-header">
        <table class="w-full">
            <tr>
                @php
                    $logoPath = public_path('images/mikaaaa.png');
                    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
                @endphp
                @if ($logoBase64)
                    <td class="align-middle text-left" style="width: 48px; padding-right: 8px;">
                        <img src="{{ $logoBase64 }}" style="height: 38px; width: auto; display: block;" alt="Mika Logo">
                    </td>
                @endif
                <td class="align-middle text-left">
                    <span class="system-badge">Mika Career & Assessment System</span>
                    <h1 class="doc-title">Laporan Hasil Tes Kepribadian DISC</h1>
                    <div class="doc-subtitle">Self-Inventory Personality Profile & Behavioral Style Report</div>
                </td>
                <td class="align-middle text-right" style="width: 160px;">
                    <span class="confidential-tag">Rahasia / Confidential</span>
                    <div style="font-size: 8px; color: #64748b; margin-top: 3px;">
                        No. Dokumen: #EV-{{ str_pad($attempt->id, 5, '0', STR_PAD_LEFT) }}<br>
                        Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Candidate / Employee Bio Box -->
    @php
        $isEmployeeAttempt = ($attempt->attempt_type === 'employee') || empty($attempt->job_application_id);
        $applicant = $attempt->jobApplication?->applicantProfile;
        $employee = $attempt->user?->employeeProfile;
        $user = $attempt->user ?? $applicant?->user;
        $job = $attempt->jobApplication?->job;
        $company = $job?->company ?? $employee?->company ?? $employee?->department?->company;
        $dept = $job?->department ?? $employee?->department ?? $attempt->test?->department;

        // Prioritaskan snapshot form biodata yang diinput peserta sebelum mulai ujian
        $participantName = !empty($attempt->participant_name)
            ? $attempt->participant_name
            : ($isEmployeeAttempt 
                ? ($employee?->full_name ?? ($user?->name ?? 'Karyawan')) 
                : ($applicant?->full_name ?? ($user?->name ?? 'Pelamar')));

        $participantTitle = $isEmployeeAttempt 
            ? ($employee?->position_title ?? ($dept?->name ?? 'Karyawan Internal')) 
            : ($job?->title ?? '-');

        $participantNik = $isEmployeeAttempt ? ($employee?->nik ?? ($user?->nik ?? '-')) : ($applicant?->nik ?? '-');

        $rawGender = $attempt->participant_gender ?? ($isEmployeeAttempt ? $employee?->gender : $applicant?->gender);
        $genderLabel = match(strtolower($rawGender ?? '')) {
            'male', 'laki-laki', 'pria' => 'Laki-laki',
            'female', 'perempuan', 'wanita' => 'Perempuan',
            default => '-',
        };

        $participantAge = $attempt->participant_age 
            ?? ($employee?->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->age : ($applicant?->birth_date ? \Carbon\Carbon::parse($applicant->birth_date)->age : null));

        $testDateFormatted = $attempt->test_date 
            ? \Carbon\Carbon::parse($attempt->test_date)->translatedFormat('d F Y')
            : \Carbon\Carbon::parse($attempt->finished_at ?? $attempt->started_at ?? now())->translatedFormat('d F Y');
    @endphp

    <div class="bio-box">
        <table class="w-full">
            <tr>
                <td class="align-top" style="width: 28%;">
                    <div class="bio-label">{{ $isEmployeeAttempt ? 'Nama Karyawan' : 'Nama Pelamar' }}</div>
                    <div class="bio-value">{{ $participantName }}</div>
                </td>
                <td class="align-top" style="width: 25%;">
                    <div class="bio-label">{{ $isEmployeeAttempt ? 'Jabatan / Departemen' : 'Posisi Lowongan' }}</div>
                    <div class="bio-value">{{ $participantTitle }}</div>
                </td>
                <td class="align-top" style="width: 23%;">
                    <div class="bio-label">Unit / Perusahaan</div>
                    <div class="bio-value">{{ $company?->name ?? ($dept?->name ?? 'Mitra Karya Analitika') }}</div>
                </td>
                <td class="align-top" style="width: 24%;">
                    <div class="bio-label">Tanggal Pelaksanaan Tes</div>
                    <div class="bio-value">
                        {{ $testDateFormatted }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-top" style="padding-top: 5px;">
                    <div class="bio-label">NIK / Identitas</div>
                    <div class="bio-value" style="font-size: 10px;">{{ $participantNik }}</div>
                </td>
                <td class="align-top" style="padding-top: 5px;">
                    <div class="bio-label">Email</div>
                    <div class="bio-value" style="font-size: 10px;">{{ $user?->email ?? '-' }}</div>
                </td>
                <td class="align-top" style="padding-top: 5px;">
                    <div class="bio-label">Jenis Kelamin / Usia</div>
                    <div class="bio-value" style="font-size: 10px;">
                        {{ $genderLabel }}
                        @if ($participantAge)
                            ({{ $participantAge }} Thn)
                        @endif
                    </div>
                </td>
                <td class="align-top" style="padding-top: 5px;">
                    <div class="bio-label">Tipe Peserta</div>
                    <div class="bio-value" style="font-size: 10px; color: #334155;">
                        {{ $isEmployeeAttempt ? 'Karyawan Internal' : 'Kandidat Pelamar' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- DISC Profile Pattern Banner -->
    <div class="profile-banner">
        <table class="w-full">
            <tr>
                <td class="align-middle text-left">
                    <span class="pattern-badge">{{ $profile?->pattern_code ?? 'DISC' }}</span>
                    <span class="pattern-title">{{ $profile?->title ?? 'Tipe Profil Kepribadian DISC' }}</span>
                </td>
                <td class="align-middle text-right">
                    <span style="font-size: 9px; font-weight: bold; color: #cbd5e1; text-transform: uppercase;">
                        Tipe Dominan: <strong>Dimensi {{ $primaryCode }}</strong>
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Table of Scores -->
    <div class="section-title">1. Ringkasan Skor DISC (Raw & Converted Scores)</div>
    <table class="score-table">
        <thead>
            <tr>
                <th style="width: 34%; text-align: left; padding-left: 8px;">Line / Dimensi Perilaku</th>
                <th style="width: 11%;">D (Dominance)</th>
                <th style="width: 11%;">I (Influence)</th>
                <th style="width: 11%;">S (Steadiness)</th>
                <th style="width: 11%;">C (Compliance)</th>
                <th style="width: 8%;">*</th>
                <th style="width: 14%;">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="row-title">
                    Line 1: MOST (Public Self / Mask)
                    <div style="font-size: 8px; font-weight: normal; color: #64748b;">Perilaku yang ditampilkan di
                        tempat kerja / publik</div>
                </td>
                <td class="font-bold">{{ $line1Raw['D'] ?? 0 }}</td>
                <td class="font-bold">{{ $line1Raw['I'] ?? 0 }}</td>
                <td class="font-bold">{{ $line1Raw['S'] ?? 0 }}</td>
                <td class="font-bold">{{ $line1Raw['C'] ?? 0 }}</td>
                <td style="color: #94a3b8;">{{ $line1Raw['*'] ?? 0 }}</td>
                <td class="font-bold">{{ array_sum($line1Raw) }}</td>
            </tr>
            <tr>
                <td class="row-title">
                    Line 2: LEAST (Core Self / Private)
                    <div style="font-size: 8px; font-weight: normal; color: #64748b;">Karakter asli ketika di bawah
                        tekanan / stres</div>
                </td>
                <td class="font-bold">{{ $line2Raw['D'] ?? 0 }}</td>
                <td class="font-bold">{{ $line2Raw['I'] ?? 0 }}</td>
                <td class="font-bold">{{ $line2Raw['S'] ?? 0 }}</td>
                <td class="font-bold">{{ $line2Raw['C'] ?? 0 }}</td>
                <td style="color: #94a3b8;">{{ $line2Raw['*'] ?? 0 }}</td>
                <td class="font-bold">{{ array_sum($line2Raw) }}</td>
            </tr>
            <tr class="row-highlight">
                <td class="row-title">
                    Line 3: CHANGE (Perceived Self / Shift)
                    <div style="font-size: 8px; font-weight: normal; color: #475569;">Kombinasi persepsi dan
                        penyesuaian diri</div>
                </td>
                <td class="font-bold">{{ $line3Raw['D'] ?? 0 }}</td>
                <td class="font-bold">{{ $line3Raw['I'] ?? 0 }}</td>
                <td class="font-bold">{{ $line3Raw['S'] ?? 0 }}</td>
                <td class="font-bold">{{ $line3Raw['C'] ?? 0 }}</td>
                <td style="color: #94a3b8;">-</td>
                <td style="color: #475569; font-size: 8.5px;">(Line 1 - Line 2)</td>
            </tr>
        </tbody>
    </table>

    <!-- 3 Graph Visualizations -->
    <div class="section-title">2. Visualisasi Grafik DISC (3 Dimensi Pola)</div>
    <table class="charts-table">
        <tr>
            <!-- Graph 1: MOST -->
            <td class="w-third align-top" style="padding-right: 4px;">
                <div class="chart-card">
                    <div class="chart-header">Graph 1 (MOST) - Mask / Public</div>
                    @if (!empty($chartMost))
                        <img src="{{ $chartMost }}"
                            style="width: 100%; height: auto; display: block; margin: 0 auto; border-radius: 2px;"
                            alt="Graph 1 MOST">
                    @endif
                </div>
            </td>

            <!-- Graph 2: LEAST -->
            <td class="w-third align-top" style="padding-left: 2px; padding-right: 2px;">
                <div class="chart-card">
                    <div class="chart-header">Graph 2 (LEAST) - Core / Private</div>
                    @if (!empty($chartLeast))
                        <img src="{{ $chartLeast }}"
                            style="width: 100%; height: auto; display: block; margin: 0 auto; border-radius: 2px;"
                            alt="Graph 2 LEAST">
                    @endif
                </div>
            </td>

            <!-- Graph 3: CHANGE -->
            <td class="w-third align-top" style="padding-left: 4px;">
                <div class="chart-card">
                    <div class="chart-header">Graph 3 (CHANGE) - Mirror / Shift</div>
                    @if (!empty($chartChange))
                        <img src="{{ $chartChange }}"
                            style="width: 100%; height: auto; display: block; margin: 0 auto; border-radius: 2px;"
                            alt="Graph 3 CHANGE">
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Gambaran Kepribadian -->
    <div class="section-title">3. Gambaran Kepribadian</div>
    @php
        $mostEval = $discEval['most'] ?? null;
        $leastEval = $discEval['least'] ?? null;
        $changeEval = $discEval['change'] ?? null;
    @endphp

    <table class="w-full" style="margin-bottom: 6px;">
        <tr>
            <!-- Kepribadian yang biasa ditunjukan (Line 1 / MOST) -->
            <td class="w-half align-top" style="padding-right: 4px;">
                <div class="personality-card">
                    <div class="personality-section-title">
                        Kepribadian yang biasa ditunjukan
                    </div>
                    <div class="personality-pattern-title">
                        {{ $mostEval['title'] ?? 'LOGICAL THINKER' }}
                    </div>
                    <ul class="personality-trait-list">
                        @foreach ($mostEval['traits'] ?? [] as $trait)
                            <li>{{ $trait }}</li>
                        @endforeach
                    </ul>
                </div>
            </td>

            <!-- Kepribadian ketika dibawah tekanan (Line 2 / LEAST) -->
            <td class="w-half align-top" style="padding-left: 4px;">
                <div class="personality-card">
                    <div class="personality-section-title">
                        Kepribadian ketika dibawah tekanan
                    </div>
                    <div class="personality-pattern-title">
                        {{ $leastEval['title'] ?? 'PERFECTIONIST' }}
                    </div>
                    <ul class="personality-trait-list">
                        @foreach ($leastEval['traits'] ?? [] as $trait)
                            <li>{{ $trait }}</li>
                        @endforeach
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <!-- Kepribadian asli yang tersembunyi (Line 3 / CHANGE) -->
            <td colspan="2" class="align-top" style="padding-top: 4px;">
                <div class="personality-card">
                    <div class="personality-section-title">
                        Kepribadian asli yang tersembunyi
                    </div>
                    <div class="personality-pattern-title">
                        {{ $changeEval['title'] ?? 'LOGICAL THINKER' }}
                    </div>
                    <table class="w-full">
                        <tr>
                            @php
                                $cTraits = $changeEval['traits'] ?? [];
                                $halfCount = ceil(count($cTraits) / 2);
                                $col1 = array_slice($cTraits, 0, $halfCount);
                                $col2 = array_slice($cTraits, $halfCount);
                            @endphp
                            <td class="w-half align-top">
                                <ul class="personality-trait-list">
                                    @foreach ($col1 as $trait)
                                        <li>{{ $trait }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="w-half align-top">
                                <ul class="personality-trait-list">
                                    @foreach ($col2 as $trait)
                                        <li>{{ $trait }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- Deskripsi Kepribadian Naratif -->
    <div class="section-title" style="margin-top: 6px;">4. Deskripsi & Interpretasi Kepribadian</div>
    <div class="desc-box">
        {{ $changeEval['description'] ?? ($profile?->general_description ?? 'Analisis profil kepribadian pelamar berhasil dibentuk berdasarkan pola respons inventori DISC.') }}
    </div>

    <!-- Suitable Jobs Recommendation -->
    @php
        $suitableJobs = $changeEval['suitable_jobs'] ?? ($profile?->suitable_jobs ?? '');
    @endphp
    @if (!empty($suitableJobs))
        <div class="section-title" style="margin-top: 6px;">5. Rekomendasi Profesi yang Cocok</div>
        <div class="job-box">
            <strong>Kesesuaian Peran / Karir:</strong><br>
            {{ $suitableJobs }}
        </div>
    @endif

    <!-- HR Decision / Signature Area -->
    <table class="w-full footer-table">
        <tr>
            <td class="align-top text-right" style="width: 100%;">
                <div class="sig-box">
                    <div>Dicetak oleh Tim Rekrutmen,</div>
                    <div class="sig-space"></div>
                    <div style="font-weight: bold; text-decoration: underline; color: #0f172a;">
                        {{ auth()->user()->name ?? 'HR Recruitment Officer' }}
                    </div>
                    <div style="font-size: 8.5px; color: #64748b;">
                        {{ auth()->user()->role?->name ?? 'Recruiter / Administrator' }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
