<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::where('name', 'like', '%Mitra Karya Analitika%')->first();

        if (!$company) {
            $company = Company::first() ?? new Company();
        }

        $missions = [
            'Menyediakan instrumen laboratorium, alat pelindung keselamatan kerja (HSE), dan sistem monitoring lingkungan berkualitas tinggi berstandar internasional.',
            'Memberikan layanan purna jual, kalibrasi, konsultasi teknis terpadu, dan dukungan profesional yang responsif demi kepuasan mitra bisnis.',
            'Membangun ekosistem kemitraan strategis yang berkelanjutan bersama industri manufaktur, institusi riset, akademisi, dan instansi pemerintah di seluruh Indonesia.',
        ];

        $coreValues = [
            [
                'code' => 'M',
                'title' => 'Menghargai',
                'subtitle' => 'Respect',
                'description' => 'Menjunjung tinggi rasa hormat, menghargai keberagaman pandangan, serta membina komunikasi kerja yang inklusif dan harmonis bagi seluruh insan perusahaan dan mitra.',
                'icon' => 'hand-shake',
            ],
            [
                'code' => 'I',
                'title' => 'Integritas',
                'subtitle' => 'Integrity',
                'description' => 'Berpikir, berkata, dan bertindak secara jujur, adil, transparan, serta berpegang teguh pada prinsip moral dan kode etik bisnis profesional tanpa kompromi.',
                'icon' => 'shield-check',
            ],
            [
                'code' => 'K',
                'title' => 'Komitmen',
                'subtitle' => 'Commitment',
                'description' => 'Berdedikasi tinggi untuk memberikan pelayanan berkualitas terbaik, menepati janji kesepakatan, dan terus berinovasi menjawab kebutuhan industri secara berkesinambungan.',
                'icon' => 'sparkles',
            ],
            [
                'code' => 'A',
                'title' => 'Akuntabel',
                'subtitle' => 'Accountable',
                'description' => 'Bertanggung jawab penuh atas setiap keputusan, tindakan, dan hasil kerja demi menjaga kepercayaan mitra serta pemangku kepentingan secara transparan.',
                'icon' => 'check-badge',
            ],
        ];

        $company->name = 'PT Mitra Karya Analitika';
        $company->tagline = 'The Best Choice for Your Business Partner';
        $company->about = 'PT Mitra Karya Analitika (MIKA) adalah perusahaan terkemuka yang bergerak di bidang distribusi dan penyediaan instrumen laboratorium presisi, peralatan keselamatan dan kesehatan kerja (Health, Safety & Environment / HSE), serta instrumen pemantauan lingkungan (Environmental Monitoring). Berdiri sejak tahun 2014 dan berpusat di Semarang, Jawa Tengah, MIKA telah dipercaya oleh ratusan industri manufaktur, instansi riset, universitas, dan laboratorium pengujian di seluruh penjuru Indonesia sebagai mitra andalan.';
        $company->vision = 'Menjadi mitra bisnis terdepan, terpercaya, dan menjadi pilihan utama di Indonesia dalam penyediaan solusi komprehensif peralatan laboratorium, perlindungan keselamatan kerja, dan teknologi pemantauan lingkungan.';
        $missionsEncoded = $missions;
        $coreValuesEncoded = $coreValues;
        $company->missions = $missionsEncoded;
        $company->core_values = $coreValuesEncoded;
        $company->address = 'Jl. Klipang Ruko Amsterdam No.9D, Sendangmulyo, Kec. Tembalang';
        $company->city = 'Semarang';
        $company->province = 'Jawa Tengah';
        $company->postal_code = '50272';
        $company->phone = '081225588888';
        $company->email = 'info@mikacares.co.id';
        if (empty($company->website)) {
            $company->website = 'https://mikacares.co.id/';
        }

        $company->save();

        // 2. Seed PT Autentik Karya Analitika (AKA)
        $aka = Company::where('name', 'like', '%Autentik%')->first();
        if ($aka) {
            $aka->name = 'PT Autentik Karya Analitika';
            $aka->tagline = 'Hardware Manufacturing & IoT Devices';
            $aka->about = 'Spesialis riset, pengembangan, dan perancangan manufaktur perangkat keras elektronik serta instrumentasi cerdas berbasis Internet of Things (IoT) untuk otomasi industri.';
            if (empty($aka->website)) {
                $aka->website = 'https://www.autentik.co.id/';
            }
            $aka->save();
        }

        // 3. Seed PT Sapujagat Nirmana Tekna (Tekna.id)
        $tekna = Company::where('name', 'like', '%Tekna%')->first();
        if ($tekna) {
            $tekna->name = 'PT Sapujagat Nirmana Tekna';
            $tekna->tagline = 'Cloud Platform & IoT Software Solutions';
            $tekna->about = 'Penyedia ekosistem platform cloud terpadu (Tekna.id), dashboard analitik data sensor real-time, dan solusi perangkat lunak pemantauan industri terhubung.';
            if (empty($tekna->website)) {
                $tekna->website = 'https://www.tekna.id/';
            }
            $tekna->save();
        }

        // 4. Seed CV Agra Prima Indonesia
        $agra = Company::where('name', 'like', '%Agra Prima%')->first();
        if ($agra) {
            $agra->name = 'CV Agra Prima Indonesia';
            $agra->tagline = 'Academic & Agricultural Distribution';
            $agra->about = 'Fokus pada penyediaan dan distribusi perlengkapan laboratorium untuk segmen institusi pendidikan, riset akademik, serta instrumentasi sektor agrikultur dan perkebunan.';
            $agra->save();
        }
    }
}
