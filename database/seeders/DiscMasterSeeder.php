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

        // 2. Seed disc_profiles (Tipe / Pattern Kepribadian DISC)
        DB::table('disc_profiles')->truncate();

        $profiles = [
            [
                'pattern_code' => 'D',
                'title' => 'ESTABLISHER / DEVELOPER',
                'general_description' => 'Memiliki rasa ego yang tinggi dan cenderung individualis dengan standar tinggi. Lebih menyukai tantangan baru, mengambil keputusan secara cepat dan independen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I',
                'title' => 'PROMOTER / PERSUADER',
                'general_description' => 'Sangat komunikatif, bersahabat, optimis, dan antusias dalam memotivasi orang lain serta membangun relasi sosial.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S',
                'title' => 'SPECIALIST / RELATER',
                'general_description' => 'Tenang, sabar, konsisten, dan dapat diandalkan. Menyukai stabilitas dan lingkungan kerja yang kooperatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'C',
                'title' => 'LOGICAL THINKER / ANALYST',
                'general_description' => 'Sangat sistematis, teliti, analitis, dan berorientasi pada aturan serta keakuratan data dalam pengambilan keputusan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'D-I',
                'title' => 'PENGAMBIL KEPUTUSAN / RESULT ORIENTED',
                'general_description' => 'Tegas, cepat bertindak, dan pandai mempengaruhi orang lain untuk mencapai sasaran kerja yang tinggi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'I-S',
                'title' => 'COUNSELOR / COACH',
                'general_description' => 'Empatis, suportif, pendengar yang baik, dan mampu menjalin hubungan baik jangka panjang dengan rekan kerja.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'S-C',
                'title' => 'PRACTITIONER / COORDINATOR',
                'general_description' => 'Terstruktur, hati-hati, metodis, dan menyelesaikan tugas-tugas dengan konsisten sesuai prosedur.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pattern_code' => 'D-C',
                'title' => 'CREATIVE / DESIGNER',
                'general_description' => 'Berorientasi pada hasil dan ketelitian. Memiliki standar tinggi, mandiri, dan analitis dalam memecahkan masalah kompleks.',
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
