<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscMasterSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed disc_norms (Konversi Skor Line 1, Line 2, Line 3 untuk D, I, S, C)
        DB::table('disc_norms')->truncate();

        $norms = [];

        // Sample / Standard DISC Norm Table mapping raw_score to converted_score (-8 to +8)
        // Line 1: MOST
        // Line 2: LEAST
        // Line 3: DIFFERENCE

        // Raw scores range 0..24 for Most/Least, and -24..24 for Difference
        // Line 1 & Line 2 Norms
        for ($raw = 0; $raw <= 24; $raw++) {
            // Line 1 (Most)
            $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => $raw, 'converted_score' => round(($raw - 7) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => $raw, 'converted_score' => round(($raw - 6) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => $raw, 'converted_score' => round(($raw - 8) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => $raw, 'converted_score' => round(($raw - 6) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];

            // Line 2 (Least)
            $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => $raw, 'converted_score' => round((7 - $raw) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => $raw, 'converted_score' => round((6 - $raw) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => $raw, 'converted_score' => round((8 - $raw) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => $raw, 'converted_score' => round((6 - $raw) * 0.7, 1), 'created_at' => now(), 'updated_at' => now()];
        }

        // Line 3 (Difference -24 to +24)
        for ($diff = -24; $diff <= 24; $diff++) {
            $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => $diff, 'converted_score' => round($diff * 0.4, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => $diff, 'converted_score' => round($diff * 0.4, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => $diff, 'converted_score' => round($diff * 0.4, 1), 'created_at' => now(), 'updated_at' => now()];
            $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => $diff, 'converted_score' => round($diff * 0.4, 1), 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('disc_norms')->insert($norms);

        // 2. Seed disc_profiles (Tipe / Pattern Kepribadian DISC Standar Internasional)
        DB::table('disc_profiles')->truncate();

        $profiles = [
            [
                'pattern_code' => 'D',
                'title' => 'ESTABLISHER / DEVELOPER (D)',
                'general_description' => 'Memiliki rasa ego yang tinggi dan cenderung individualis dengan standar tinggi. Lebih menyukai tantangan baru, mengambil keputusan secara cepat, tegas, dan independen.',
                'suitable_jobs' => 'Executive Director, General Manager, Entrepreneur, Project Director, Operations Director, Military Officer, Corporate Strategist, Production Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I',
                'title' => 'PROMOTER / PERSUADER (I)',
                'general_description' => 'Sangat komunikatif, bersahabat, optimis, dan antusias dalam memotivasi orang lain serta membangun relasi sosial yang luas.',
                'suitable_jobs' => 'Marketing Specialist, Public Relations (PR), Sales Executive, Brand Ambassador, Event Manager, Recruiter / HR Talent Acquisition, Creative Director, Media Broadcaster.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S',
                'title' => 'SPECIALIST / RELATER (S)',
                'general_description' => 'Tenang, sabar, konsisten, dan dapat diandalkan. Menyukai stabilitas, hubungan kerja yang harmonis, dan lingkungan yang kooperatif.',
                'suitable_jobs' => 'Human Resources Specialist, Customer Service Specialist, Counselor / Psychologist, Healthcare Administrator, Social Worker, Administrative Specialist, Teacher / Educator.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'C',
                'title' => 'LOGICAL THINKER / ANALYST (C)',
                'general_description' => 'Sangat sistematis, teliti, analitis, dan berorientasi pada aturan serta keakuratan data dalam pengambilan keputusan.',
                'suitable_jobs' => 'Quality Controller (QA/QC), Data Analyst, Financial Auditor, Accountant, Research Scientist, Statistician, Compliance Officer, Software Engineer, Chemist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'D-I',
                'title' => 'RESULT ORIENTED / DRIVER (D-I)',
                'general_description' => 'Tegas, dinamis, cepat bertindak, dan pandai mempengaruhi orang lain untuk mencapai sasaran dan target kerja yang tinggi.',
                'suitable_jobs' => 'Business Development Manager, Sales Director, Venture Capitalist, Field Operations Leader, Commercial Manager, Real Estate Developer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I-D',
                'title' => 'INFLUENTIAL DRIVER (I-D)',
                'general_description' => 'Energik, antusias, berani mengambil inisiatif, dan mampu memimpin perubahan dengan gaya komunikasi yang karismatik.',
                'suitable_jobs' => 'Creative Campaign Lead, Public Figure Manager, Startup Founder, Agency Director, Business Negotiator.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'D-S',
                'title' => 'ACHIEVER / INVESTIGATOR (D-S)',
                'general_description' => 'Gigih, fokus pada tujuan jangka panjang, mandiri, dan memiliki daya tahan kerja yang tinggi dalam menyelesaikan target sulit.',
                'suitable_jobs' => 'Production Supervisor, Project Coordinator, Operations Supervisor, Logistics Manager, Security Operations Director.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S-D',
                'title' => 'TENACIOUS IMPLEMENTER (S-D)',
                'general_description' => 'Konsisten, pantang menyerah, stabil dalam bekerja di bawah tekanan, dan mampu mengawal proses hingga tuntas.',
                'suitable_jobs' => 'Plant Manager, Facilities Director, Distribution Manager, Operations Specialist, Branch Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'D-C',
                'title' => 'CREATIVE / DESIGNER (D-C)',
                'general_description' => 'Berorientasi pada hasil dan ketelitian tinggi. Mandiri, kritis, dan memiliki standar kualitas yang sangat terukur dalam memecahkan masalah kompleks.',
                'suitable_jobs' => 'Systems Architect, R&D Engineer, Industrial Designer, Technical Consultant, Corporate Planner, Operations Research Analyst.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'C-D',
                'title' => 'PRODUCER / PERFECTIONIST (C-D)',
                'general_description' => 'Kritis, teliti, berani menantang inkonsistensi data, dan memastikan produk atau sistem berjalan tanpa celah cacat.',
                'suitable_jobs' => 'Manufacturing Engineer, Financial Controller, Risk Manager, Forensic Investigator, Supply Chain Architect.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I-S',
                'title' => 'COUNSELOR / COACH (I-S)',
                'general_description' => 'Empatis, suportif, pendengar yang baik, penuh perhatian, dan mampu menjalin hubungan kerja sama jangka panjang yang solid.',
                'suitable_jobs' => 'Corporate Trainer, Career Counselor, Customer Relationship Manager, HR Generalist, Community Manager, Social Welfare Officer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S-I',
                'title' => 'HARMONIZER / ADVISOR (S-I)',
                'general_description' => 'Hangat, sabar, ramah, dan piawai menciptakan atmosfer kerja yang positif serta menyenangkan bagi seluruh anggota tim.',
                'suitable_jobs' => 'Internal Communications Specialist, Employee Relations Officer, Guest Relations Manager, School Counselor, Mediator.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I-C',
                'title' => 'ASSESSOR / COMMUNICATOR (I-C)',
                'general_description' => 'Mampu menggabungkan kecakapan komunikasi persuasif dengan analisa data yang akurat, sistematis, dan terperinci.',
                'suitable_jobs' => 'Technical Sales Specialist, Marketing Research Analyst, Public Policy Analyst, Technical Trainer, Product Evangelist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'C-I',
                'title' => 'EVALUATOR / CRITIC (C-I)',
                'general_description' => 'Objektif, diplomatis, detail dalam menganalisa fakta, dan mampu menyajikan temuan teknis secara jelas kepada publik.',
                'suitable_jobs' => 'Technical Writer, Legal Compliance Officer, Product Reviewer, Market Intelligence Specialist, Content Auditor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S-C',
                'title' => 'PRACTITIONER / COORDINATOR (S-C)',
                'general_description' => 'Terstruktur, hati-hati, metodis, disiplin, dan konsisten menyelesaikan tugas-tugas teknis sesuai prosedur dan standar mutu.',
                'suitable_jobs' => 'Planner (any function), Engineer (Installation, Technical), Technical/Research (Chemist Technician), Academic, Statistician, Government Worker, IT Management, Prison Officer, Quality Controller.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'C-S',
                'title' => 'PRECISION SPECIALIST (C-S)',
                'general_description' => 'Sangat berhati-hati, taat aturan baku, tenang, dan memiliki tingkat akurasi serta reliabilitas data yang sangat tinggi.',
                'suitable_jobs' => 'Database Administrator, Quality Assurance Engineer, Regulatory Affairs Officer, Laboratory Technician, Archivist, Medical Records Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('disc_profiles')->insert($profiles);

        // 3. Seed disc_traits (Dimensi Kepribadian D, I, S, C)
        DB::table('disc_traits')->truncate();

        $traits = [
            [
                'dimension_code' => 'D',
                'potret_diri' => json_encode([
                    'Independen dan percaya diri',
                    'Berorientasi pada target dan hasil',
                    'Suka tantangan dan wewenang',
                    'Cepat dalam mengambil keputusan'
                ]),
                'kelebihan' => json_encode([
                    'Kepemimpinan yang kuat dalam situasi krisis',
                    'Berani mengambil risiko',
                    'Fokus pada pencapaian hasil',
                    'Mengatasi hambatan dengan cepat'
                ]),
                'kekurangan' => json_encode([
                    'Terkadang kurang sabar dengan orang lain',
                    'Tampak terlalu mendominasi atau keras',
                    'Kurang memperhatikan detail administratif',
                    'Cenderung abaikan perasaan orang lain'
                ]),
                'deskripsi_tipe' => 'Dimensi Dominance menekankan pada membentuk lingkungan dengan mengatasi hambatan untuk mencapai hasil.',
                'kecenderungan' => json_encode([
                    'Mendapatkan hasil secepatnya',
                    'Menantang status quo',
                    'Mengambil alih kendali'
                ]),
                'lingkungan_cocok' => json_encode([
                    'Lingkungan yang dinamis dan kompetitif',
                    'Memiliki otonomi dan kebebasan bertindak',
                    'Peluang untuk kemajuan karir yang cepat'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dimension_code' => 'I',
                'potret_diri' => json_encode([
                    'Antusias, ramah, dan optimis',
                    'Pandai membangun komunikasi',
                    'Menyukai popularitas dan interaksi',
                    'Kreatif dan penuh energi'
                ]),
                'kelebihan' => json_encode([
                    'Memotivasi dan menginspirasi orang lain',
                    'Kreatif dalam mencari ide baru',
                    'Membangun jejaring sosial yang luas',
                    'Memiliki rasa humor yang positif'
                ]),
                'kekurangan' => json_encode([
                    'Cenderung terburu-buru dan kurang detail',
                    'Terlalu banyak berjanji namun kurang eksekusi',
                    'Bosan dengan rutinitas administratif',
                    'Sangat tergantung pada pengakuan sosial'
                ]),
                'deskripsi_tipe' => 'Dimensi Influence menekankan pada membentuk lingkungan dengan mempengaruhi atau membujuk orang lain.',
                'kecenderungan' => json_encode([
                    'Menghubungi orang secara spontan',
                    'Membuat kesan menguntungkan',
                    'Gaya bicara yang persuasif'
                ]),
                'lingkungan_cocok' => json_encode([
                    'Lingkungan kerja sosial dan kolaboratif',
                    'Bebas dari kontrol ketat atau rincian rutin',
                    'Pengakuan dan penghargaan publik'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dimension_code' => 'S',
                'potret_diri' => json_encode([
                    'Tenang, sabar, dan setia',
                    'Pendengar yang sangat baik',
                    'Pekerja keras yang konsisten',
                    'Menyukai iklim kerja harmonis'
                ]),
                'kelebihan' => json_encode([
                    'Dapat diandalkan dan konsisten',
                    'Sabar dan mampu mendamaikan konflik',
                    'Membangun hubungan jangka panjang',
                    'Anggota tim yang kooperatif'
                ]),
                'kekurangan' => json_encode([
                    'Resisten terhadap perubahan mendadak',
                    'Lambat dalam mengambil keputusan',
                    'Terkadang menahan ketidakpuasan',
                    'Meninggalkan inisiatif pribadi'
                ]),
                'deskripsi_tipe' => 'Dimensi Steadiness menekankan pada bekerja sama dengan orang lain dalam kondisi yang ada untuk melaksanakan tugas.',
                'kecenderungan' => json_encode([
                    'Menjaga konsistensi dan stabilitas',
                    'Mengembangkan kebiasaan kerja yang baik',
                    'Menunjukkan rasa empati'
                ]),
                'lingkungan_cocok' => json_encode([
                    'Lingkungan kerja yang stabil dan dapat diprediksi',
                    'Suasana kerja yang harmonis tanpa konflik tajam',
                    'Prosedur kerja yang jelas'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dimension_code' => 'C',
                'potret_diri' => json_encode([
                    'Analitis, teliti, dan sistematis',
                    'Menjaga standar kualitas tinggi',
                    'Berhati-hati dalam mengambil keputusan',
                    'Berorientasi pada data dan fakta'
                ]),
                'kelebihan' => json_encode([
                    'Akurasi dan ketelitian tinggi',
                    'Pemikiran logis dan objektif',
                    'Menjaga standar dan ketaatan prosedur',
                    'Perencanaan terstruktur'
                ]),
                'kekurangan' => json_encode([
                    'Terlalu perfeksionis dan kritis',
                    'Cenderung lambat karena perbanyak analisa',
                    'Kaku terhadap aturan',
                    'Tertutup secara emosional'
                ]),
                'deskripsi_tipe' => 'Dimensi Compliance menekankan pada bekerja secara tekun dalam kondisi yang ada untuk memastikan kualitas dan ketelitian.',
                'kecenderungan' => json_encode([
                    'Menganalisis data secara mendalam',
                    'Menjaga standar akurasi yang tinggi',
                    'Mengikuti instruksi dan prosedur'
                ]),
                'lingkungan_cocok' => json_encode([
                    'Lingkungan yang memerlukan ketelitian dan analisis',
                    'Standard Operational Procedure (SOP) yang jelas',
                    'Fokus pada kualitas produk/layanan'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('disc_traits')->insert($traits);
    }
}
