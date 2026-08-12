<?php

namespace App\Exports;

use App\Models\TestCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionBankTemplateExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function title(): string
    {
        return 'Template Soal';
    }

    public function headings(): array
    {
        return [
            'kategori',
            'soal',
            'tipe_soal',
            'poin',
            'opsi_a',
            'opsi_b',
            'opsi_c',
            'opsi_d',
            'kunci_jawaban',
        ];
    }

    public function collection()
    {
        $category = TestCategory::first();
        $catName = $category ? $category->name : 'Umum';

        return collect([
            [
                'kategori' => $catName,
                'soal' => 'Apa kepanjangan dari PHP?',
                'tipe_soal' => 'multiple_choice',
                'poin' => 1,
                'opsi_a' => 'PHP: Hypertext Preprocessor',
                'opsi_b' => 'Personal Home Page',
                'opsi_c' => 'Public Hosting Process',
                'opsi_d' => 'Program High Performance',
                'kunci_jawaban' => 'A',
            ],
            [
                'kategori' => $catName,
                'soal' => 'Jelaskan perbedaan antara REST API dan GraphQL!',
                'tipe_soal' => 'essay',
                'poin' => 5,
                'opsi_a' => '',
                'opsi_b' => '',
                'opsi_c' => '',
                'opsi_d' => '',
                'kunci_jawaban' => '',
            ],
            [
                'kategori' => 'Tes Kepribadian (DISC)',
                'soal' => 'Pilihlah satu yang Paling Menggambarkan (Most) dan Satu yang Paling Tidak Menggambarkan (Least) diri Anda. (Soal Nomor 1)',
                'tipe_soal' => 'disc',
                'poin' => 1,
                'opsi_a' => 'Petualang, Mengambil resiko (Tag: D)',
                'opsi_b' => 'Percaya, Mudah percaya pada orang (Tag: I)',
                'opsi_c' => 'Gampang gaul, Mudah setuju (Tag: S)',
                'opsi_d' => 'Toleran, Menghormati (Tag: C)',
                'kunci_jawaban' => '',
            ],
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
