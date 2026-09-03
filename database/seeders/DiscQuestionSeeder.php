<?php

namespace Database\Seeders;

use App\Models\QuestionBank;
use App\Models\QuestionOption;
use App\Models\TestCategory;
use Illuminate\Database\Seeder;

class DiscQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dapatkan atau buat Kategori Tes DISC
        $discCategory = TestCategory::firstOrCreate(
            ['name' => 'Tes Kepribadian (DISC)'],
            ['description' => 'Tes profil kepribadian DISC (Dominance, Influence, Steadiness, Compliance) 24 Nomor.']
        );

        // Hapus soal DISC yang ada terlebih dahulu agar tidak duplikat jika seeder dijalankan ulang
        QuestionBank::where('category_id', $discCategory->id)->delete();

        // 24 Nomor Soal DISC standar dengan 4 Opsi (disesuaikan 100% presisi dengan DISC TEST SOFTWARE 2018 - Copy.xlsx)
        $questionsData = [
            1 => [
                ['text' => 'Gampangan, Mudah setuju', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Percaya, Mudah percaya pada orang', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Petualang, Mengambil resiko', 'most_tag' => '*', 'least_tag' => 'D', 'tag' => '*'],
                ['text' => 'Toleran, Menghormati', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
            ],
            2 => [
                ['text' => 'Lembut suara, Pendiam', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
                ['text' => 'Optimistik, Visioner', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Pusat Perhatian, Suka gaul', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Pendamai, Membawa Harmoni', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
            ],
            3 => [
                ['text' => 'Menyemangati orang', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Berusaha sempurna', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
                ['text' => 'Bagian dari kelompok', 'most_tag' => '*', 'least_tag' => 'S', 'tag' => '*'],
                ['text' => 'Ingin membuat tujuan', 'most_tag' => 'D', 'least_tag' => '*', 'tag' => 'D'],
            ],
            4 => [
                ['text' => 'Menjadi frustrasi', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
                ['text' => 'Menyimpan perasaan saya', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Menceritakan sisi saya', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Siap beroposisi', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
            ],
            5 => [
                ['text' => 'Hidup, Suka bicara', 'most_tag' => 'I', 'least_tag' => '*', 'tag' => 'I'],
                ['text' => 'Gerak cepat, Tekun', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Usaha menjaga keseimbangan', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Usaha mengikuti aturan', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
            ],
            6 => [
                ['text' => 'Kelola waktu secara efisien', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
                ['text' => 'Sering terburu-buru, Merasa tertekan', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Masalah sosial itu penting', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Suka selesaikan apa yang saya mulai', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
            ],
            7 => [
                ['text' => 'Tolak perubahan mendadak', 'most_tag' => 'S', 'least_tag' => '*', 'tag' => 'S'],
                ['text' => 'Cenderung janji berlebihan', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Tarik diri di tengah tekanan', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
                ['text' => 'Tidak takut bertempur', 'most_tag' => '*', 'least_tag' => 'D', 'tag' => '*'],
            ],
            8 => [
                ['text' => 'Penyemangat yang baik', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Pendengar yang baik', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Penganalisa yang baik', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
                ['text' => 'Delegator yang baik', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
            ],
            9 => [
                ['text' => 'Hasil adalah penting', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Lakukan dengan benar, Akurasi penting', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
                ['text' => 'Dibuat menyenangkan', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Mari kerjakan bersama', 'most_tag' => '*', 'least_tag' => 'S', 'tag' => '*'],
            ],
            10 => [
                ['text' => 'Akan berjalan terus tanpa kontrol diri', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
                ['text' => 'Akan membeli sesuai dorongan hati', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Akan menunggu, Tanpa tekanan', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Akan mengusahakan  yang kuinginkan', 'most_tag' => 'I', 'least_tag' => '*', 'tag' => 'I'],
            ],
            11 => [
                ['text' => 'Ramah, Mudah bergabung', 'most_tag' => 'S', 'least_tag' => '*', 'tag' => 'S'],
                ['text' => 'Unik, Bosan rutinitas', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Aktif mengubah sesuatu', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Ingin hal-hal yang pasti', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
            ],
            12 => [
                ['text' => 'Non-konfrontasi, Menyerah', 'most_tag' => '*', 'least_tag' => 'S', 'tag' => '*'],
                ['text' => 'Dipenuhi hal detail', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
                ['text' => 'Perubahan pada menit terakhir', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Menuntut, Kasar', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
            ],
            13 => [
                ['text' => 'Ingin kemajuan', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Puas dengan segalanya', 'most_tag' => 'S', 'least_tag' => '*', 'tag' => 'S'],
                ['text' => 'Terbuka memperlihatkan perasaan', 'most_tag' => 'I', 'least_tag' => '*', 'tag' => 'I'],
                ['text' => 'Rendah hati, Sederhana', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
            ],
            14 => [
                ['text' => 'Tenang, Pendiam', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
                ['text' => 'Bahagia, Tanpa beban', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Menyenangkan, Baik hati', 'most_tag' => 'S', 'least_tag' => '*', 'tag' => 'S'],
                ['text' => 'Tak gentar, Berani', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
            ],
            15 => [
                ['text' => 'Menggunakan waktu berkualitas dgn teman', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Rencanakan masa depan, Bersiap', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
                ['text' => 'Bepergian demi petualangan baru', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Menerima ganjaran atas tujuan yg dicapai', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
            ],
            16 => [
                ['text' => 'Aturan perlu dipertanyakan', 'most_tag' => '*', 'least_tag' => 'D', 'tag' => '*'],
                ['text' => 'Aturan membuat adil', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
                ['text' => 'Aturan membuat bosan', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Aturan membuat aman', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
            ],
            17 => [
                ['text' => 'Pendidikan, Kebudayaan', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
                ['text' => 'Prestasi, Ganjaran', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Keselamatan, keamanan', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Sosial, Perkumpulan kelompok', 'most_tag' => 'I', 'least_tag' => '*', 'tag' => 'I'],
            ],
            18 => [
                ['text' => 'Memimpin, Pendekatan langsung', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Suka bergaul, Antusias', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Dapat diramal, Konsisten', 'most_tag' => '*', 'least_tag' => 'S', 'tag' => '*'],
                ['text' => 'Waspada, Hati-hati', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
            ],
            19 => [
                ['text' => 'Tidak mudah dikalahkan', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Kerjakan sesuai perintah, Ikut pimpinan', 'most_tag' => 'S', 'least_tag' => '*', 'tag' => 'S'],
                ['text' => 'Mudah terangsang, Riang', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Ingin segalanya teratur, Rapi', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
            ],
            20 => [
                ['text' => 'Saya akan pimpin mereka', 'most_tag' => 'D', 'least_tag' => '*', 'tag' => 'D'],
                ['text' => 'Saya akan melaksanakan', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Saya akan meyakinkan mereka', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Saya dapatkan fakta', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
            ],
            21 => [
                ['text' => 'Memikirkan orang dahulu', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Kompetitif, Suka tantangan', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Optimis, Positif', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Pemikir logis, Sistematik', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
            ],
            22 => [
                ['text' => 'Menyenangkan orang, Mudah setuju', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Tertawa lepas, Hidup', 'most_tag' => '*', 'least_tag' => 'I', 'tag' => '*'],
                ['text' => 'Berani, Tak gentar', 'most_tag' => 'D', 'least_tag' => 'D', 'tag' => 'D'],
                ['text' => 'Tenang, Pendiam', 'most_tag' => 'C', 'least_tag' => 'C', 'tag' => 'C'],
            ],
            23 => [
                ['text' => 'Ingin otoritas lebih', 'most_tag' => '*', 'least_tag' => 'D', 'tag' => '*'],
                ['text' => 'Ingin kesempatan baru', 'most_tag' => 'I', 'least_tag' => '*', 'tag' => 'I'],
                ['text' => 'Menghindari konflik', 'most_tag' => 'S', 'least_tag' => 'S', 'tag' => 'S'],
                ['text' => 'Ingin petunjuk yang jelas', 'most_tag' => '*', 'least_tag' => 'C', 'tag' => '*'],
            ],
            24 => [
                ['text' => 'Dapat diandalkan, Dapata dipercaya', 'most_tag' => '*', 'least_tag' => 'S', 'tag' => '*'],
                ['text' => 'Kreatif, Unik', 'most_tag' => 'I', 'least_tag' => 'I', 'tag' => 'I'],
                ['text' => 'Garis dasar, Orientasi hasil', 'most_tag' => 'D', 'least_tag' => '*', 'tag' => 'D'],
                ['text' => 'Jalankan standar yang tinggi, Akurat', 'most_tag' => 'C', 'least_tag' => '*', 'tag' => 'C'],
            ],
        ];

        foreach ($questionsData as $number => $options) {
            $question = QuestionBank::create([
                'category_id' => $discCategory->id,
                'question' => "Pilihlah satu pernyataan yang Paling Menggambarkan (Most) dan Satu yang Paling Tidak Menggambarkan (Least) diri Anda. (Soal Nomor {$number})",
                'question_type' => 'disc',
                'metadata' => [
                    'number' => $number,
                    'instruction' => 'Pilih 1 Most (P) dan 1 Least (K)',
                ],
                'points' => 1,
            ]);

            foreach ($options as $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'attribute_tag' => $opt['tag'],
                    'most_tag' => $opt['most_tag'],
                    'least_tag' => $opt['least_tag'],
                    'is_correct' => false,
                ]);
            }
        }
    }
}
