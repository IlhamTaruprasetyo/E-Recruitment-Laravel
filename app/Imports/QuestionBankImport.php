<?php

namespace App\Imports;

use App\Models\QuestionBank;
use App\Models\QuestionOption;
use App\Models\TestCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class QuestionBankImport implements ToCollection, WithHeadingRow
{
    public $importedCount = 0;
    public $errors = [];

    public function collection(Collection $rows)
    {
        $categories = TestCategory::all()->keyBy(function ($cat) {
            return strtolower(trim($cat->name));
        });
        $categoryIds = TestCategory::pluck('id')->toArray();

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                // Determine row number for error logging (heading row is row 1)
                $rowNumber = $index + 2;

                $rawCategory = trim($row['kategori'] ?? $row['category'] ?? '');
                $questionText = trim($row['soal'] ?? $row['question'] ?? '');
                $rawType = strtolower(trim($row['tipe_soal'] ?? $row['question_type'] ?? 'multiple_choice'));
                $points = (int) ($row['poin'] ?? $row['points'] ?? 1);
                if ($points <= 0) {
                    $points = 1;
                }

                if (empty($questionText)) {
                    continue; // Skip blank rows
                }

                // Resolve Category ID
                $categoryId = null;
                if (is_numeric($rawCategory) && in_array((int)$rawCategory, $categoryIds)) {
                    $categoryId = (int)$rawCategory;
                } else {
                    $lowerCat = strtolower($rawCategory);
                    if (isset($categories[$lowerCat])) {
                        $categoryId = $categories[$lowerCat]->id;
                    }
                }

                if (!$categoryId) {
                    $firstCategory = TestCategory::first();
                    if ($firstCategory) {
                        $categoryId = $firstCategory->id;
                    } else {
                        throw new \Exception("Category '{$rawCategory}' pada baris {$rowNumber} tidak ditemukan dan tidak ada kategori default.");
                    }
                }

                // Normalize Question Type
                $questionType = 'multiple_choice';
                if (in_array($rawType, ['essay', 'uraian', 'isihan'])) {
                    $questionType = 'essay';
                }

                $questionBank = QuestionBank::create([
                    'category_id' => $categoryId,
                    'question' => $questionText,
                    'question_type' => $questionType,
                    'points' => $points,
                    'image_path' => null,
                ]);

                if ($questionType === 'multiple_choice') {
                    $optA = trim($row['opsi_a'] ?? $row['option_a'] ?? '');
                    $optB = trim($row['opsi_b'] ?? $row['option_b'] ?? '');
                    $optC = trim($row['opsi_c'] ?? $row['option_c'] ?? '');
                    $optD = trim($row['opsi_d'] ?? $row['option_d'] ?? '');
                    $rawCorrect = strtoupper(trim($row['kunci_jawaban'] ?? $row['correct_option'] ?? 'A'));

                    $options = [$optA, $optB, $optC, $optD];

                    $correctIndex = 0;
                    if (in_array($rawCorrect, ['A', '1', '0'])) {
                        $correctIndex = 0;
                    } elseif (in_array($rawCorrect, ['B', '2', '1'])) {
                        $correctIndex = 1;
                    } elseif (in_array($rawCorrect, ['C', '3', '2'])) {
                        $correctIndex = 2;
                    } elseif (in_array($rawCorrect, ['D', '4', '3'])) {
                        $correctIndex = 3;
                    }

                    foreach ($options as $idx => $optText) {
                        QuestionOption::create([
                            'question_id' => $questionBank->id,
                            'option_text' => $optText ?: 'Opsi ' . chr(65 + $idx),
                            'is_correct' => ($idx === $correctIndex),
                        ]);
                    }
                }

                $this->importedCount++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
