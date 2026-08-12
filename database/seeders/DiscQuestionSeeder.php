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

        // 24 Nomor Soal DISC standar dengan 4 Opsi (D, I, S, C) disesuaikan dengan DISC TEST SOFTWARE 2018 - Copy.xlsx
        $questionsData = [
            1 => [
                ['text' => 'Gampang gaul, Mudah setuju', 'tag' => 'S'],
                ['text' => 'Percaya, Mudah percaya pada orang', 'tag' => 'I'],
                ['text' => 'Petualang, Mengambil resiko', 'tag' => 'D'],
                ['text' => 'Toleran, Menghormati', 'tag' => 'C'],
            ],
            2 => [
                ['text' => 'Lembut suara, Pendiam', 'tag' => 'C'],
                ['text' => 'Optimistik, Visioner', 'tag' => 'D'],
                ['text' => 'Pusat Perhatian, Suka gaul', 'tag' => 'I'],
                ['text' => 'Pendamai, Membawa Harmoni', 'tag' => 'S'],
            ],
            3 => [
                ['text' => 'Menyemangati orang', 'tag' => 'I'],
                ['text' => 'Berusaha sempurna', 'tag' => 'C'],
                ['text' => 'Bagian dari kelompok', 'tag' => 'S'],
                ['text' => 'Ingin membuat tujuan', 'tag' => 'D'],
            ],
            4 => [
                ['text' => 'Menjadi frustrasi', 'tag' => 'C'],
                ['text' => 'Menyimpan perasaan saya', 'tag' => 'S'],
                ['text' => 'Menceritakan sisi saya', 'tag' => 'I'],
                ['text' => 'Siap beroposisi', 'tag' => 'D'],
            ],
            5 => [
                ['text' => 'Hidup, Suka bicara', 'tag' => 'I'],
                ['text' => 'Gerak cepat, Tekun', 'tag' => 'D'],
                ['text' => 'Usaha menjaga keseimbangan', 'tag' => 'S'],
                ['text' => 'Usaha mengikuti aturan', 'tag' => 'C'],
            ],
            6 => [
                ['text' => 'Kelola waktu secara efisien', 'tag' => 'C'],
                ['text' => 'Sering terburu-buru, Merasa tertekan', 'tag' => 'D'],
                ['text' => 'Masalah sosial itu penting', 'tag' => 'I'],
                ['text' => 'Suka selesaikan apa yang saya mulai', 'tag' => 'S'],
            ],
            7 => [
                ['text' => 'Tolak perubahan mendadak', 'tag' => 'S'],
                ['text' => 'Cenderung janji berlebihan', 'tag' => 'I'],
                ['text' => 'Tarik diri di tengah tekanan', 'tag' => 'C'],
                ['text' => 'Tidak takut bertempur', 'tag' => 'D'],
            ],
            8 => [
                ['text' => 'Penyemangat yang baik', 'tag' => 'I'],
                ['text' => 'Pendengar yang baik', 'tag' => 'S'],
                ['text' => 'Penganalisa yang baik', 'tag' => 'C'],
                ['text' => 'Delegator yang baik', 'tag' => 'D'],
            ],
            9 => [
                ['text' => 'Hasil adalah penting', 'tag' => 'D'],
                ['text' => 'Lakukan dengan benar, Akurasi penting', 'tag' => 'C'],
                ['text' => 'Dibuat menyenangkan', 'tag' => 'I'],
                ['text' => 'Mari kerjakan bersama', 'tag' => 'S'],
            ],
            10 => [
                ['text' => 'Akan berjalan terus tanpa kontrol diri', 'tag' => 'C'],
                ['text' => 'Akan membeli sesuai dorongan hati', 'tag' => 'D'],
                ['text' => 'Akan menunggu, Tanpa tekanan', 'tag' => 'S'],
                ['text' => 'Akan mengusahakan  yang kuinginkan', 'tag' => 'I'],
            ],
            11 => [
                ['text' => 'Ramah, Mudah bergabung', 'tag' => 'S'],
                ['text' => 'Unik, Bosan rutinitas', 'tag' => 'I'],
                ['text' => 'Aktif mengubah sesuatu', 'tag' => 'D'],
                ['text' => 'Ingin hal-hal yang pasti', 'tag' => 'C'],
            ],
            12 => [
                ['text' => 'Non-konfrontasi, Menyerah', 'tag' => 'S'],
                ['text' => 'Dipenuhi hal detail', 'tag' => 'C'],
                ['text' => 'Perubahan pada menit terakhir', 'tag' => 'I'],
                ['text' => 'Menuntut, Kasar', 'tag' => 'D'],
            ],
            13 => [
                ['text' => 'Ingin kemajuan', 'tag' => 'D'],
                ['text' => 'Puas dengan segalanya', 'tag' => 'S'],
                ['text' => 'Terbuka memperlihatkan perasaan', 'tag' => 'I'],
                ['text' => 'Rendah hati, Sederhana', 'tag' => 'C'],
            ],
            14 => [
                ['text' => 'Tenang, Pendiam', 'tag' => 'C'],
                ['text' => 'Bahagia, Tanpa beban', 'tag' => 'I'],
                ['text' => 'Menyenangkan, Baik hati', 'tag' => 'S'],
                ['text' => 'Tak gentar, Berani', 'tag' => 'D'],
            ],
            15 => [
                ['text' => 'Menggunakan waktu berkualitas dgn teman', 'tag' => 'S'],
                ['text' => 'Rencanakan masa depan, Bersiap', 'tag' => 'C'],
                ['text' => 'Bepergian demi petualangan baru', 'tag' => 'I'],
                ['text' => 'Menerima ganjaran atas tujuan yg dicapai', 'tag' => 'D'],
            ],
            16 => [
                ['text' => 'Aturan perlu dipertanyakan', 'tag' => 'D'],
                ['text' => 'Aturan membuat adil', 'tag' => 'C'],
                ['text' => 'Aturan membuat bosan', 'tag' => 'I'],
                ['text' => 'Aturan membuat aman', 'tag' => 'S'],
            ],
            17 => [
                ['text' => 'Pendidikan, Kebudayaan', 'tag' => 'C'],
                ['text' => 'Prestasi, Ganjaran', 'tag' => 'D'],
                ['text' => 'Keselamatan, keamanan', 'tag' => 'S'],
                ['text' => 'Sosial, Perkumpulan kelompok', 'tag' => 'I'],
            ],
            18 => [
                ['text' => 'Memimpin, Pendekatan langsung', 'tag' => 'D'],
                ['text' => 'Suka bergaul, Antusias', 'tag' => 'I'],
                ['text' => 'Dapat diramal, Konsisten', 'tag' => 'S'],
                ['text' => 'Waspada, Hati-hati', 'tag' => 'C'],
            ],
            19 => [
                ['text' => 'Tidak mudah dikalahkan', 'tag' => 'D'],
                ['text' => 'Kerjakan sesuai perintah, Ikut pimpinan', 'tag' => 'S'],
                ['text' => 'Mudah terangsang, Riang', 'tag' => 'I'],
                ['text' => 'Ingin segalanya teratur, Rapi', 'tag' => 'C'],
            ],
            20 => [
                ['text' => 'Saya akan pimpin mereka', 'tag' => 'D'],
                ['text' => 'Saya akan melaksanakan', 'tag' => 'S'],
                ['text' => 'Saya akan meyakinkan mereka', 'tag' => 'I'],
                ['text' => 'Saya dapatkan fakta', 'tag' => 'C'],
            ],
            21 => [
                ['text' => 'Memikirkan orang dahulu', 'tag' => 'S'],
                ['text' => 'Kompetitif, Suka tantangan', 'tag' => 'D'],
                ['text' => 'Optimis, Positif', 'tag' => 'I'],
                ['text' => 'Pemikir logis, Sistematik', 'tag' => 'C'],
            ],
            22 => [
                ['text' => 'Menyenangkan orang, Mudah setuju', 'tag' => 'S'],
                ['text' => 'Tertawa lepas, Hidup', 'tag' => 'I'],
                ['text' => 'Berani, Tak gentar', 'tag' => 'D'],
                ['text' => 'Tenang, Pendiam', 'tag' => 'C'],
            ],
            23 => [
                ['text' => 'Ingin otoritas lebih', 'tag' => 'D'],
                ['text' => 'Ingin kesempatan baru', 'tag' => 'I'],
                ['text' => 'Menghindari konflik', 'tag' => 'S'],
                ['text' => 'Ingin petunjuk yang jelas', 'tag' => 'C'],
            ],
            24 => [
                ['text' => 'Dapat diandalkan, Dapat dipercaya', 'tag' => 'S'],
                ['text' => 'Kreatif, Unik', 'tag' => 'I'],
                ['text' => 'Garis dasar, Orientasi hasil', 'tag' => 'D'],
                ['text' => 'Jalankan standar yang tinggi, Akurat', 'tag' => 'C'],
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
                    'is_correct' => false,
                ]);
            }
        }
    }
}
