<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscMasterSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed disc_norms based on Official DISC Standard Software 2018 (Sheet3 Norms)
        DB::table('disc_norms')->truncate();

        $norms = [];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 0, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 0, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 0, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 0, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 1, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 1, 'converted_score' => -4.6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 1, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 1, 'converted_score' => -4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 2, 'converted_score' => -4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 2, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 2, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 2, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 3, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 3, 'converted_score' => -1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 3, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 3, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 4, 'converted_score' => -1.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 4, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 4, 'converted_score' => -0.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 4, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 5, 'converted_score' => -1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 5, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 5, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 5, 'converted_score' => 2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 6, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 6, 'converted_score' => 3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 6, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 6, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 7, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 7, 'converted_score' => 5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 7, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 7, 'converted_score' => 5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 8, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 8, 'converted_score' => 5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 8, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 8, 'converted_score' => 5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 9, 'converted_score' => 2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 9, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 9, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 9, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 10, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 10, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 10, 'converted_score' => 4.6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 10, 'converted_score' => 6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 11, 'converted_score' => 3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 11, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 11, 'converted_score' => 5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 11, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 12, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 12, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 12, 'converted_score' => 5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 12, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 13, 'converted_score' => 4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 13, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 13, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 13, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 14, 'converted_score' => 5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 14, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 14, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 14, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 15, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 15, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 15, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 15, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 16, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 16, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 16, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 16, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 17, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 17, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 17, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 17, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 18, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 18, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 18, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 18, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 19, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 19, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 19, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 19, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 20, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 20, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 20, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 20, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 21, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 21, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 21, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 21, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 22, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 22, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 23, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 23, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'D', 'raw_score' => 24, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'I', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'S', 'raw_score' => 24, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 1, 'attribute' => 'C', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 0, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 0, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 0, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 0, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 1, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 1, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 1, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 1, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 2, 'converted_score' => 4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 2, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 2, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 2, 'converted_score' => 5.6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 3, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 3, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 3, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 3, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 4, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 4, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 4, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 4, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 5, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 5, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 5, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 5, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 6, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 6, 'converted_score' => -2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 6, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 6, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 7, 'converted_score' => -1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 7, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 7, 'converted_score' => -1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 7, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 8, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 8, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 8, 'converted_score' => -2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 8, 'converted_score' => -1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 9, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 9, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 9, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 9, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 10, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 10, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 10, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 10, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 11, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 11, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 11, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 11, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 12, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 12, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 12, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 12, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 13, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 13, 'converted_score' => -7.2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 13, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 13, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 14, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 14, 'converted_score' => -7.2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 14, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 14, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 15, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 15, 'converted_score' => -7.2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 15, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 15, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 16, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 16, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 16, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 16, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 17, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 17, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 17, 'converted_score' => -7.2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 17, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 18, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 18, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 18, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 18, 'converted_score' => -7.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 19, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 19, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 19, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 19, 'converted_score' => -7.9, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 20, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 20, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 20, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 20, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 21, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 21, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 21, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 21, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 22, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 23, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'D', 'raw_score' => 24, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'I', 'raw_score' => 24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'S', 'raw_score' => 24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 2, 'attribute' => 'C', 'raw_score' => 24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -24, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -24, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -23, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -23, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -22, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -22, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -21, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -21, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -21, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -21, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -20, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -20, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -20, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -20, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -19, 'converted_score' => -6.8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -19, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -19, 'converted_score' => -8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -19, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -18, 'converted_score' => -6.75, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -18, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -18, 'converted_score' => -7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -18, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -17, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -17, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -17, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -17, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -16, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -16, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -16, 'converted_score' => -7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -16, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -15, 'converted_score' => -6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -15, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -15, 'converted_score' => -7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -15, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -14, 'converted_score' => -6.1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -14, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -14, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -14, 'converted_score' => -6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -13, 'converted_score' => -5.9, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -13, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -13, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -13, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -12, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -12, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -12, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -12, 'converted_score' => -5.85, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -11, 'converted_score' => -5.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -11, 'converted_score' => -6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -11, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -11, 'converted_score' => -5.85, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -10, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -10, 'converted_score' => -6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -10, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -10, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -9, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -9, 'converted_score' => -6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -9, 'converted_score' => -4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -9, 'converted_score' => -4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -8, 'converted_score' => -3.25, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -8, 'converted_score' => -5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -8, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -8, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -7, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -7, 'converted_score' => -4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -7, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -7, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -6, 'converted_score' => -2.75, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -6, 'converted_score' => -4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -6, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -6, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -5, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -5, 'converted_score' => -3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -5, 'converted_score' => -2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -5, 'converted_score' => -2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -4, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -4, 'converted_score' => -3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -4, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -4, 'converted_score' => -0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -3, 'converted_score' => -1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -3, 'converted_score' => -2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -3, 'converted_score' => -1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -3, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -2, 'converted_score' => -0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -2, 'converted_score' => -1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -2, 'converted_score' => -0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -2, 'converted_score' => 0.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => -1, 'converted_score' => -0.25, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => -1, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => -1, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => -1, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 0, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 0, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 0, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 0, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 1, 'converted_score' => 0.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 1, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 1, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 1, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 2, 'converted_score' => 0.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 2, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 2, 'converted_score' => 2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 2, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 3, 'converted_score' => 1, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 3, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 3, 'converted_score' => 3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 3, 'converted_score' => 4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 4, 'converted_score' => 1.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 4, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 4, 'converted_score' => 3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 4, 'converted_score' => 5.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 5, 'converted_score' => 1.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 5, 'converted_score' => 4.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 5, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 5, 'converted_score' => 5.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 6, 'converted_score' => 2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 6, 'converted_score' => 5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 6, 'converted_score' => 0, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 6, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 7, 'converted_score' => 2.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 7, 'converted_score' => 5.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 7, 'converted_score' => 4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 7, 'converted_score' => 6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 8, 'converted_score' => 3.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 8, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 8, 'converted_score' => 5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 8, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 9, 'converted_score' => 4, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 9, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 9, 'converted_score' => 5.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 9, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 10, 'converted_score' => 4.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 10, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 10, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 10, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 11, 'converted_score' => 4.85, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 11, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 11, 'converted_score' => 6.2, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 11, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 12, 'converted_score' => 5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 12, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 12, 'converted_score' => 6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 12, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 13, 'converted_score' => 5.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 13, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 13, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 13, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 14, 'converted_score' => 6, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 14, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 14, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 14, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 15, 'converted_score' => 6.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 15, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 15, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 15, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 16, 'converted_score' => 6.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 16, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 16, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 16, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 17, 'converted_score' => 6.7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 17, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 17, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 17, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 18, 'converted_score' => 7, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 18, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 18, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 18, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 19, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 19, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 19, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 19, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 20, 'converted_score' => 7.3, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 20, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 20, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 20, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 21, 'converted_score' => 7.5, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 21, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 21, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 21, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 22, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 23, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'D', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'I', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'S', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];
        $norms[] = ['line_type' => 3, 'attribute' => 'C', 'raw_score' => 24, 'converted_score' => 8, 'created_at' => now(), 'updated_at' => now()];

        foreach (array_chunk($norms, 100) as $chunk) {
            DB::table('disc_norms')->insert($chunk);
        }

        // 2. Seed 40 Standard DISC Profiles from Official Software 2018 (Def Sheet)
        DB::table('disc_profiles')->truncate();

        $profiles = [
            [
                'id' => 1,
                'pattern_code' => 'C',
                'title' => 'LOGICAL THINKER',
                'general_description' => 'Seorang yang praktis, cakap dan unik. Ia orang yang mampu menilai diri sendiri dan kritis terhadap dirinya dan orang lain. Ia menyukai hal yang detil dan logis; secara alamiah ia sangat analitis. Karena menyimpan informasi, ia meneliti isu berulang-ulang kali. Ia cenderung malu dan tertutup; ia hati-hati dalam membuat keputusan yang berdasarkan pada logika, bukan emosi, selalu menggunakan pertanyaan \"bagaimana dan mengapa\". Ia mengerjakan sesuatu dengan sistematis dan akurat. Ia rapi dan terorganisir sebab ia merasa bahwa keadaan berantakan sama dengan mutu yang rendah; demikian juga, rapi dan teratur merupakan mutu yang tinggi. Sangat teliti dalam segala sesuatu seperti halnya dalam pekerjaan dan penggunaan waktunya. Ia merencanakan dan mengorganisir semua sisi kehidupannya. Kelambanan sangat mengganggunya dan tak dapat ditolerir.',
                'suitable_jobs' => 'Planner (any function), Engineer (Installation, Technical), Technical/Research (Chemist Technician), Academic, Statistician, Government Worker, IT Management, Prison Officer, Quality Controller.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'pattern_code' => 'D',
                'title' => 'ESTABLISHER',
                'general_description' => 'Memiliki rasa ego yang tinggi dan cenderung invidualis dengan standard yang sangat tinggi. Ia lebih suka menganalisa masalah sendirian daripada bersama orang lain. Rasa egoisnya yang kuat membuatnya tidak nyaman di bawah kendali orang lain; ia lebih suka menjadi \"boss\" dan menetapkan standard tinggi baik untuk dirinya maupun orang lain. Ia menghindari sesuatu yang biasa-biasa dan cenderung mencari tantangan yang baru. Ia menyukai petualangan dan kadang-kadang beralih ke dalam petualangan baru sebelum mempertimbangkannya secara menyeluruh. Mampu memimpin situasi dan orang lain dalam rangka mencapai sasarannya; ia ingin selalu unggul dalam persaingan dengan taruhan apapun.',
                'suitable_jobs' => 'Attorney, Researcher, Sales Representative, Planning Consultant, Transport Personnel, Production (Director, Manager, Supervisor), Technologist, Strategic Planning, Trouble Shooting, Marketing Services, Consultant, Engineering (Director, Manager, Supervisor) and Self-Employment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'pattern_code' => 'D / C-D',
                'title' => 'DESIGNER',
                'general_description' => 'Seorang yang sangat berorientasi pada tugas dan sensitif pada permasalahan. Ia lebih mempedulikan tugas yang ada dibanding orang-orang di sekitarnya, termasuk perasaan mereka. Sangat kukuh/keras dan mempunyai pendekatan yang efektif dalam pemecahan masalah. Oleh karena sifat alamiah dan keinginannya akan hasil yang terukur, Akan tampak dingin, tidak berperasaan dan menjaga jarak. Ia membuat keputusan berdasar pada fakta, bukan emosi. Cenderung pendiam dan tidak mudah percaya.',
                'suitable_jobs' => 'Engineering (Management, Research, Design), Research (R&D), Planning, Chemist, Accountancy, Specialist, Finance, Technician, Quality Control, Production Planning/Management, Design Engineer, Bookkeeper, Chemist Technician, Safety Officer, Librarian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'pattern_code' => 'D / I-D',
                'title' => 'NEGOTIATOR',
                'general_description' => 'Merupakan seorang pemimpin integratif yang bekerja dengan dan melalui orang lain.  Ia ramah, memiliki perhatian yang tinggi akan orang dan juga mempunyai kemampuan untuk memperoleh hormat dan penghargaan dari berbagai tipe orang.  Melakukan pekerjaannya dengan cara yang bersahabat, baik dalam mencapai sasarannya maupun meyakinkan pandangannya kepada orang lain.  Ia tidak begitu memperhatikan hal-hal kecil.  Kadang bertindak sesuai dengan kata hati/impulsif, terlalu antusias dan sangat banyak bicara.  Ia terlalu berlebihan menilai kemampuannya dalam memotivasi atau mengubah perilaku orang lain.  Mencari kebebasan dari rutinitas, menginginkan otoritas/wewenang dan juga prestise.  Ia menginginkan aktivitas yang bervariasi dan bekerja lebih efisien jika data-data analitis disediakan oleh orang lain.  Menginginkan penugasan yang mengutamakan mobilitas dan tantangan.',
                'suitable_jobs' => 'Sales and Marketing (Directing, Manager, Person), Public Relations, Recruitment Consultant, Politician, Director, Self-Employed, Hotelier, Travel Agent, Trainer, Hospitality, Lawyer, Solicitor, Motivators, Team Leader, Politician, Trainer, Lecturer, Theatrical Agent, General Management and Leading People, Attorney.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'pattern_code' => 'D / I-D-C',
                'title' => 'CONFIDENT & DETERMINED',
                'general_description' => 'Sangat berorientasi terhadap tugas dan juga menyukai orang.  Ia sangat baik dalam menarik orang/recruiting.  Seorang yang bersahabat, tetapi menyukai keadaan di mana tugas-tugas harus dilakukan dengan benar.  Ia kadang-kadang tampak dingin dan mendominasi.  Ia juga bisa sangat fokus pada tugas dan melupakan orang-orang di sekitarnya.  Sangat mengharapkan orang-orang terlibat dalam proyeknya, tetapi tidak memperdulikan apa yang diinginkan oleh orang-orang itu.  Ia perlu mendengar dan memikirkan  apa yang menjadi keinginan orang di sekitarnya, khususnya kesempatan untuk mencoba.  Ia sangat membutuhkan persetujuan sosial seperti halnya ia sangat mempercayai orang lain.  Karena itu, ia kadang-kadang berlebihan dalam menilai orang dan kemampuannya.  Ia tampak tidak konsisten dan tidak karuan karena ketidakmampuannya berkonsentrasi dan fokus dalam waktu yang lama.  Perlu belajar untuk secara sungguh-sungguh mendengarkan orang-orang di sekitarnya dari pada selalu berpikir apa yang ingin dikatakan.  Ia mempunyai kemampuan logika yang tinggi ketika ia mau menggunakannya.',
                'suitable_jobs' => 'Specialist/Technical Selling (Computer, Finance, Engineer and others, Chef, Technical/Capital Equipment Selling), Financial (Manager, Specialist), Computer Hardware Sales, Engineering (Manager, Designer, Buyer, Draughtsman), Project Engineer, Sales Engineer, Consultant, Trainer, Lecturer, Hotelier, Insurance, Mortgage and Finance Sales, Teacher, Travel Agent, Personnel and Marketing Services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'pattern_code' => 'D / I-D-S',
                'title' => 'REFORMER',
                'general_description' => 'Seorang yang bersahabat dan sosial; ia juga suka mengendalikan situasi dan menjadi pemimpin.  Ia menyelesaikan tugasnya melalui keterampilan sosialnya; ia peduli dan menerima orang lain.  Ia berkonsentrasi pada tugas yang ada di tangannya sampai selesai dan akan minta bantuan orang lain jika perlu.  Ia menyadari keterbatasannya dan meminta bantuan jika memerlukannya.  Ia disukai dan orang ingin menolongnya.  Senang membagi kebanggaannya dengan kelompok; ia seorang team player tetapi juga team leader.  Menginginkan popularitas dan pengakuan.',
                'suitable_jobs' => 'Hotelier, Customer Service, Complaints Manager, Recruiting Agent, Sales (Manager/Person), Marketing Services, Public Relations, Politician, Computer Software Sales, Lecturer, Engineering and Production (Manager/Supervisor).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'pattern_code' => 'D / I-S-D',
                'title' => 'MOTIVATOR',
                'general_description' => 'Seorang yang menampilkan gaya bersemangat ketika termotivasi pada sasaran.  Ia lebih suka memimpin atau melibatkan diri, walaupun ia juga mau melayani sebagai pembantu.  Ia membutuhkan pengakuan dan penghargaan serta senang pada peran pendukung.  Ia peduli kepada orang-orang di sekitarnya dan akan mempertimbangkan perasaan orang lain dalam proses pengambilan keputusan.  Menampilkan keterampilan berhubungan dan berkomunikasi dengan sangat baik.  Ia akan berusaha keras menyelesaikan tugas dengan cepat dan efisien.',
                'suitable_jobs' => 'Hotelier, Community Counseling, Customer Service, Complaints Manager, Community Work, Recruitment Consultant, Hospitality, Teacher, Telemarketing, Production Manager, Complaints Manager, Recruiting Agent, Sales (Manager/Person), Marketing Services, Public Relations, Politician, Call Centre Manager, Lecturer, Engineering and Production (Manager/Supervisor).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'pattern_code' => 'D / S-D-C / S-C-D',
                'title' => 'INQUIRER',
                'general_description' => 'Seorang yang sabar, terkontrol dan suka menggali fakta dan jalan keluar.  Ia tenang dan ramah.  Ia merencanakan pekerjaan dengan hati-hati, tetapi agresif, menanyakan sesuatu serta mengumpulkan data pendukung.  Kemudian ia bekerja dengan konsisten dengan arahan yang benar.  Menjadi individu yang penuh perhatian, rendah hati, dan ia berhubungan baik dengan hampir semua orang.  Seorang yang konsisten dan suka menolong. People skill darinya melebihi orientasi tugasnya.',
                'suitable_jobs' => 'Directing, Managing or Supervising (in Engineering, Accountancy, Research and Development and Computing disciplines), Research Manager, Scientific Work, Accountant, Administration, Project Engineer, Draughtsman, Designer, Analyst, Finance, Chemist, Technical Service Support, Flight Attendant, Technician, Service Engineer, Service Manager, Security Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'pattern_code' => 'D-I',
                'title' => 'PENGAMBIL KEPUTUSAN',
                'general_description' => 'Tidak basa-basi dan tegas, ia cenderung merupakan seorang invidualis yang kuat. Ia berpandangan jauh ke depan, progresif dan mau berkompetisi untuk mencapai sasaran. DI seorang yang selalu ingin tahu dan mempunyai minat dengan cakupan yang luas. Ia seorang yang logis, kritis dan tajam dalam memecahkan masalah. Sering kali ia tampak imajinatif. Ia mempunyai kemampuan memimpinan yang baik. Ia kadang tampak keras kepala atau dingin karena orientasi dan prioritasnya pada tugas cenderung melebihi orientasi terhadap sesama. Ia mencanangkan standard tinggi pada dirinya dan akan sangat kritis ketika standard ini tidak dicapai. Ia juga menempatkan standard tinggi pada orang-orang di sekitarnya, serta mengutamakan kesempurnaan. Ia menginginkan otoritas yang jelas dan menyukai tugas-tugas baru.',
                'suitable_jobs' => 'General Management (Directing/Managing/Supervising, Public Relations, Business Management, Conflict Resolution, Industrial Relations, Business Consultant, Trouble Shooting, Sales and Sales Management, Marketing, Promoting, Production (Director, Manager, Supervisor), Consultancy, Publishing, Sales Executive, Promotional Work, Brokers, Self-Employment, Advertising, Lecturing, Dealing/Broking.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'pattern_code' => 'D-I-S',
                'title' => 'DIRECTOR',
                'general_description' => 'Fokus pada penyelesaian pekerjaan dan menunjukkan penghargaan yang tinggi kepada orang lain.  Ia memiliki kemampuan untuk menggerakkan orang dan pekerjaan dikarenakan keterampilannya berpikir ke depan dan hubungan antar manusia.  Tidak berorientasi detil, ia fokus pada target secara keseluruhan dengan menyerahkan hal detil kepada orang lain.  Enerjik dan sosial, ia mampu memotivasi orang lain sambil menyelesaikan pekerjaannya.  Ia menampilkan rasa percaya diri dan mampu meyakinkan orang lain.  Sekali ia memutuskan sesuatu, ia akan terus mengerjakannya dan bertahan sampai selesai.',
                'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Office Management, Account Manager, Customer Service, Retail Manager, IT, Lecturer, Logistics, Manager-General, National Accounts Manager, Teacher, Projects Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'pattern_code' => 'D-S',
                'title' => 'SELF-MOTIVATED',
                'general_description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
                'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Project Management, Researcher, Chemist (R&D), Planner, Engineering (R&D), Systems Analyst, Commercial Planner, Computer Engineer, Programmer, IT, Other computer-related disciplines, Technical Trouble Shooting and Directing, Lawyer, Solicitor, Development Engineer, Work Study, Barrister, Attorney.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'pattern_code' => 'I / C-I-S',
                'title' => 'MEDIATOR',
                'general_description' => 'Merupakan individu yang berorientasi pada orang, ia mampu menggabungkan ketepatan dan loyalitas.  Ia cenderung peka dan mempunyai standard yang tinggi.  Ia menginginkan stabilitas dan berorientasi terhadap sasaran.  Ia menginginkan pengakuan sosial dan perhatian pribadi.  Ia bersahabat, antusias, informal, banyak bicara, dan mungkin sangat mencemaskan apa yang dipikirkan oleh orang lain.  Ia menolak agresi, dan mengharapkan suasana harmonis.  Ia cenderung cukup cerdas dalam berbagai hal. Ia merupakan pencari fakta yang sangat baik dan akan membuat keputusan yang baik setelah mengumpulkan fakta dan data pendukung.',
                'suitable_jobs' => 'Engineering and Production (Supervisor, Installer, Technician, Service and Design), Research (Supervisor, Chemist, Lab. Technician), Trainer, Finance (Supervisor, Accountant, Advisor), Public Relations, Administration, Office Administrator, Market Analyst, System Analyst, Programmer, Selling (Technical/Service).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'pattern_code' => 'I / C-S-I',
                'title' => 'PRACTITIONER',
                'general_description' => 'Merupakan individu yang berorientasi pada orang, ia mampu menggabungkan ketepatan dan loyalitas.  Ia cenderung peka dan mempunyai standard yang tinggi.  Ia menginginkan stabilitas dan berorientasi terhadap sasaran.  Ia menginginkan pengakuan sosial dan perhatian pribadi.  Bersahabat, antusias, informal, banyak bicara, dan mungkin sangat mencemaskan apa yang dipikirkan oleh orang lain.  Ia menolak agresi dan mengharapkan suasana harmonis.  Ia cenderung cukup cerdas dalam berbagai hal. Ia merupakan pencari fakta yang sangat baik dan akan membuat keputusan yang baik setelah mengumpulkan fakta dan data pendukung.',
                'suitable_jobs' => 'Engineering and Production (Supervisor, Installer, Technician, Service and Design), Research (Supervisor, Chemist), Trainer, Finance (Manager, Supervisor, Accountant, Advisor), Public Relations-Administration, Purchasing, Chemist Research, Office Administrator, Computer Programmer, Market Analyst, System Analyst, Programmer, Research and Development Supervisor, Laboratory Technician, Legal, Selling (Technical/Service).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'pattern_code' => 'I-S-C / I-C-S',
                'title' => 'RESPONSIVE & THOUGHTFUL',
                'general_description' => 'Merupakan individu yang berorientasi pada orang dan lancar berkomunikasi serta loyal.  Ia cenderung sensitif dan mempunyai standard yang tinggi.  Keputusannya dibuat berdasarkan fakta dan data pendukung.  Ia sepertinya tidak bisa diam.  Ia perlu untuk lebih terus terang dan jangan terlalu subyektif.  Ia butuh pengakuan sosial dan perhatian pribadi; ia dapat cepat akrab dengan orang lain.  Ia bersahabat, antusias, informal, banyak bicara dan terlalu khawatir terhadap apa yang dipikirkan orang.  Ia menguasai banyak hal.  Ia ingin diterima sebagai anggota kelompok dan ingin mengetahui secara pasti apa yang diharapkan darinya sebelum ia memulai proyek baru.',
                'suitable_jobs' => 'Actors, Chef, Personnel, Welfare, Broadcasting, Training, Attorney, Teaching, Accounting, Technical Instructor, Accounting-General, Accounts Supervisor, Customer Services, Public Relations, Artist, Hotelier, Demonstrator, Florist/Floral Designer, Engineering (Sales, Service, Project, Draughtsman, Designer), Graphic Designer, Specialist (Soft/Services), Selling, Purchasing, Singers, Technical Instructor, Personnel Management, Politician, Supervising (Engineering, Production, Accounts), Administration Work, Sales Engineer, Secretarial, Industrial Relations Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'pattern_code' => 'S',
                'title' => 'SPECIALIST',
                'general_description' => 'Merupakan individu konsisten yang berusaha menjaga lingkungan/suasana yang tidak berubah.  Ia bekerja dengan baik bersama orang-orang dengan berbagai kepribadian karena perilakunya yang terkendali dan rendah hati.  Sabar, loyal dan suka menolong.  Persahabatan dikembangkannya dengan lambat dan selektif.  Ia tidak bosan dengan rutinitas dan sangat baik bekerja dengan petunjuk dan peraturan yang jelas. Ia mengharapkan bantuan dan supervisi pada saat mengawali proyek baru.  Ia butuh waktu untuk menyesuaikan diri dengan perubahan dan sungkan menjalankan \"cara-cara lama mengerjakan sesuatu\".  Ia akan menghindari konfrontasi dan berusaha sekuat tenaga memendam perasaannya.',
                'suitable_jobs' => 'Administrative Work, Engineering and Production areas (Sales, Services, Project, Painter, Plumber, Draughtsman, Designer, Operative), Chef, Accounting, Telemarketing/Tele-Sales, Research and Development, Administrator, Florist/Floral Designer, Retail-General, Sales-General, Accounting-General, Service-General, Landscape Gardener.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 16,
                'pattern_code' => 'S / C-S',
                'title' => 'PERFECTIONIST',
                'general_description' => 'Berpikir sistematis dan cenderung mengikuti prosedur dalam kehidupan pribadi dan pekerjaannya.  Teratur dan memiliki perencanaan yang baik, ia teliti dan fokus pada detil.  Bertindak dengan penuh kebijaksanaan, diplomatis dan jarang menentang rekan kerjanya dengan sengaja.  Ia sangat berhati-hati, sungguh-sungguh mengharapkan akurasi dan standard tinggi dalam pekerjaannya.  Ia cenderung terjebak dalam hal detil, khususnya jika harus memutuskan.  Menginginkan adanya petunjuk standard pelaksanaan kerja dan tanpa perubahan mendadak.',
                'suitable_jobs' => 'Researcher (Technician, Chemist, Quality Control), Engineer (Project, Draughtsman, Armed Forces, Designer), Statistician, Surveyor, Optician, Medical Specialist, Health Care, IT Management, Planner, Technical Writing, Production, Dentist, Quality Control, Planning, Dental Technician, Accounting, Computer Programmer, Psychologist, Surgeon, Architect, Medical Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 17,
                'pattern_code' => 'S-C',
                'title' => 'PEACEMAKER, RESPECTFULL & ACCURATE',
                'general_description' => 'Ia adalah orang yang baik secara alamiah dan sangat berorientasi detil.  Ia peduli dengan orang-orang di sekitarnya dan mempunyai kualitas yang membuatnya sangat teliti dalam penyelesaian tugas.  Ia mempertimbangkan sekelilingnya dengan hati-hati sebelum membuat keputusan untuk melihat pengaruhnya pada mereka; saat tertentu ia terlalu hati-hati.  Jika ia merasa seseorang memanfaatkan situasi, ia akan memperlambat kerjanya sehingga dapat mengamati apa yang sedang berlangsung di sekitarnya.',
                'suitable_jobs' => 'Office (Manager, Supervisor, Person), Chief Clerk, General Administrator, Production Supervisor, Planner, Accountant, Research and Development, Flight Attendant, Engineering (Project Manager, Supervisor, Technician), Computer Programmer, Draughtsman, Soft/Service Selling, Doctor, Cashier, Receptionist, Data Entry, Planner, Word Processing, Property Manager, Database Administrator, Health Care, Statistician, Nursing-Administration, Company Secretary, System Analyst, Programmer, Statistician, Accounting-General, Security Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 18,
                'pattern_code' => 'D-C',
                'title' => 'CHALLENGER',
                'general_description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
                'suitable_jobs' => 'Engineering (Management, Research, Design), Actuaries, Research (R&D), Planning, Chemist, Hospital Supervisor, Industrial Marketing, Investment Banking, Medical Administrator, Mortgage Brokers, Accountancy, Fund Management, Specialist Finance, Quality Control and Specialist work in any area where knowledge and experience is available, Production, Financial Services, Technical Management, Project Leader, Matron, Strategic Planning, Industrial Marketing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 19,
                'pattern_code' => 'D-I-C',
                'title' => 'CHANCELLOR',
                'general_description' => 'Ia menggabungkan antara kesenangan dengan pekerjaan/bisnis ketika melakukan sesuatu. Ia kelihatan menyukai hubungan dengan sesama tetapi juga dapat mengerjakan hal-hal detil. Ia ingin melakukan segala sesuatu dengan tepat, dan ia akan menyelesaikan tugasnya untuk meyakinkan ketepatan dan kelengkapannya. Seorang yang ramah secara alami dan menikmati interaksi dengan sesama, akan tetapi ia akan juga menilai orang dan tugas secara hati-hati; persahabatannya akan bergeser sesuai dengan dorongan hatinya pada orang lain di sekitarnya. Ia sering melalaikan perencanaan yang seksama dan akan beralih ke pada proyek-proyek baru tanpa pertimbangan yang menyeluruh.',
                'suitable_jobs' => 'Technical/Scientific (Directing, Management, Supervision), Engineering, Finance, Production Planning, Personnel Disciplines, Self-Employment, Credit Manager, Planner, Fund Management, Computer Hardware/Software Sales, IT, Business Consultant, Banking, Logistics, Lecturing, Work Study, Film Director, Transport, Consultancy, Industrial Relations and Computers (Selling, Software, Systems Analyst) and General Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'pattern_code' => 'D-S-I',
                'title' => 'DIRECTOR',
                'general_description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
                'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Creative Designer, Office Management, Chief Engineer, Business Consultant, Chief Financial Officer, Customer Service, National Accounts Manager, Chief Accountant, Lecturer, Projects Manager, Research Planning, Human Resources, Scientific Work, Security Specialist, Solicitor, Planner, Production Administrator.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 21,
                'pattern_code' => 'D-S-C',
                'title' => 'Director',
                'general_description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
                'suitable_jobs' => 'Engineering and Production (Directing, Managing, Supervising), Sales, Sales Management, Service Manager, Distribution, Public Relations, Creative Designer, Office Management, Chief Engineer, Business Consultant, Chief Financial Officer, Customer Service, National Accounts Manager, Chief Accountant, Lecturer, Projects Manager, Research Planning, Human Resources, Scientific Work, Security Specialist, Solicitor, Planner, Production Administrator.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 22,
                'pattern_code' => 'D-C-I',
                'title' => 'CHALLENGER',
                'general_description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
                'suitable_jobs' => 'Technical/Scientific (Directing, Management, Supervision), Engineering, Finance, Production Planning, Personnel Disciplines, Self-Employment, Credit Manager, Planner, Lecturing, Work Study, Transport, Consultancy, Industrial Relations and Computers (Selling, Software, Systems Analyst) and General Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 23,
                'pattern_code' => 'D-C-S',
                'title' => 'CHALLENGER',
                'general_description' => 'Seorang yang sensitif terhadap permasalahan, dan memiliki kreativitas yang baik dalam memecahkan masalah. Ia dapat menyelesaikan tugas-tugas penting dalam waktu singkat karena mempunyai keputusan yang kuat. Seorang yang tekun dan memiliki reaksi yang cepat.  Ia akan meneliti dan mengejar semua kemungkinan yang ada dalam mencari solusi permasalahan.  Ia banyak memberikan ide-ide dengan berfokus pada pekerjaan. Usaha yang keras pada ketepatan akan mengimbangi keinginannya pada hasil yang terukur.  Ia cenderung perfeksionis dan dapat juga memperlambat pengambilan keputusan karena keinginannya untuk menentukan pilihan yang terbaik.',
                'suitable_jobs' => 'Engineering, Production and Finance (Directing, Administrating, Managing and Managing Specialist Work), Scientific, Research Planning, Personnel, Trouble Shooting, Credit Control, Chief Accountant, Accountant, Chief Engineer, Work Study, Consultancy, Designer, Draughtsman, Project Work, Security Specialist, Doctor, Attorney.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 24,
                'pattern_code' => 'I',
                'title' => 'COMMUNICATOR',
                'general_description' => 'Merupakan seorang yang antusias dan optimistik, ia lebih suka mencapai sasarannya melalui orang lain. Ia suka berhubungan dengan sesamanya - ia bahkan suka mengadakan “pesta” atau kegiatan untuk berkumpul, dan ini menunjukkan kepribadiannya yang ramah. Ia tidak suka bekerja sendirian dan cenderung bersama dengan orang lain dalam menyelesaikan proyek.  Perhatian dan fokusnya tidak sebaik apa yang dia inginkan -  maka ia membutuhkan energi yang besar untuk mampu bergerak cepat dari satu hal ke hal berikutnya tanpa penundaan.  Ia sangat menonjol dalam keterampilan berkomunikasi, dan ini merupakan salah satu kekuatan yang paling sering digunakan.  Ia memiliki kemampuan untuk memotivasi dan memberi semangat dengan kata-katanya, dan ia dikenal sebagai individu yang inspirasional. Ketika ia harus memusatkan perhatiannya pada tugas, Ia akan menjadi tidak akurat dan bahkan tidak terorganisir.  Tetapi ia akan memusatkan perhatian kepada yang harus ia senangkan, karena ia enggan sekali untuk menolak.  Ia menginginkan pengakuan sosial dan takut akan penolakan.  Ia mudah menemukan teman dan berusaha menciptakan suasana yang menyenangkan.  Ia membutuhkan seorang manajer atau supervisor untuk menentukan batas waktu yang jelas dalam pekerjaannya, ia lebih suka menggunakan gaya manajemen partisipatif yang dibangun berdasarkan hubungan yang kuat.',
                'suitable_jobs' => 'Promoting, Demonstrating, Canvassing, Marketing Services, Public Relations, Lecturing, Advertising, Publican, Publishing, Hospitality, Retail-General, Human Resources, Journalist, Singers, Technical Writing, Tour Guide, Promotional Work, Hotelier, Dancers, Host, Actors, Travel Agent, Politician, and very soft selling.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 25,
                'pattern_code' => 'I-S',
                'title' => 'ADVISOR',
                'general_description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan \"penjaga damai\" dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
                'suitable_jobs' => 'Personnel, Welfare, Training, Hotelier, Promoting, Travel Agent, Lecturing, Upmarket/Speciality Sales, Soft/Service Selling, Beauty Therapist, Psychologist, Nursing, Human Resources, Retail-Specialist, Veterinarian, Social Work, Personal Assistant, Personnel-HR, Coach, Mentor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 26,
                'pattern_code' => 'I-C',
                'title' => 'ASSESSOR',
                'general_description' => 'Merupakan seorang yang ramah dan suka berteman; ia merasa nyaman walaupun dengan orang asing. Ia dapat mengembangkan hubungan baru dengan mudah, dan pada umumnya dapat mengendalikan diri sampai pada tingkat dimana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia seorang yang sangat sosial, menunjukkan kepedulian dan persahabatan ketika sedang melakukan tugas-tugas di tangannya. Ia cenderung perfeksionis secara alamiah, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan.  Ia berkeinginan mempromosikan tugas-tugas orang lain, juga kepunyaannya.  Kadang-kadang ia salah menilai kemampuan orang lain dikarenakan pandangan-pandangannya yang optimis.',
                'suitable_jobs' => 'Teaching, Training, Inventing, Specialist Selling (Engineering, Finance or any area involving capital equipment), Project Engineer, Finance, Service Engineer or Supervising within a Technical/Specialist Area, Public Relations, Environmentalist, Marketing, Conference Organiser, Estate Agent.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 27,
                'pattern_code' => 'I-C-D',
                'title' => 'ASSESSOR',
                'general_description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
                'suitable_jobs' => 'Specialist/Technical Selling (Computer, Finance, Engineer and others, Technical/Capital Equipment Selling), Financial (Manager, Specialist), Engineering (Manager, Designer, Buyer, Draughtsman), Project Engineer, Sales Engineer, Consultant, Trainer, Lecturer, Hotelier, Travel Agent, Personnel and Marketing Services.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 28,
                'pattern_code' => 'I-C-S',
                'title' => 'RESPONSIVE & THOUGHTFUL',
                'general_description' => 'Merupakan individu yang berorientasi pada orang dan lancar berkomunikasi serta loyal.  Ia cenderung sensitif dan mempunyai standard yang tinggi.  Keputusannya dibuat berdasarkan fakta dan data pendukung.  Ia sepertinya tidak bisa diam.  Ia perlu untuk lebih terus terang dan jangan terlalu subyektif.  Ia butuh pengakuan sosial dan perhatian pribadi; ia dapat cepat akrab dengan orang lain.  Ia bersahabat, antusias, informal, banyak bicara dan terlalu khawatir terhadap apa yang dipikirkan orang.  Ia menguasai banyak hal.  Ia ingin diterima sebagai anggota kelompok dan ingin mengetahui secara pasti apa yang diharapkan darinya sebelum ia memulai proyek baru.',
                'suitable_jobs' => 'Personnel, Welfare, Training, Attorney, Teaching, Accounting, Technical Instructor, Customer Services, Public Relations, Artist, Hotelier, Demonstrator, Engineering (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Services), Selling, Purchasing, Supervising (Engineering, Production, Accounts), Administration Work, Secretarial, Industrial Relations Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 29,
                'pattern_code' => 'S-D',
                'title' => 'SELF-MOTIVATED',
                'general_description' => 'Merupakan seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan juga ingin memberikan bantuan dan dukungan.  Secara internal termotivasi oleh target pribadi, Ia menyukai orang-orang, tetapi juga mempunyai kemampuan untuk berorientasi pada pekerjaannya pada saat dibutuhkan.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya memiliki kontribusi akan keberhasilannya.  Keuletannya setelah memulai pekerjaan, ia akan berusaha keras untuk mendapatkan sasarannya.  Seorang yang bebas, ia orang yang cermat dan memiliki tindak lanjut yang baik.  Ia bisa menjadi tidak ramah walaupun ia pada dasarnya ia yang berorientasi pada orang; dan pada situasi yang tidak membuatnya nyaman, ia lebih suka mendukung pemimpinnya dari pada keterlibatannya dengan situasi.',
                'suitable_jobs' => 'Investigator, Researcher, Accountant, Engineering, Production/Engineering Supervisor, Computer Specialist, Architect, Transport/Warehouse Supervisor, Credit Controller, DP Supervisor, Computer Specialist, Research and Development, Private Investigator, Quality Controller, Engineering (Designer, Draughtsman, Project Engineer), Sales and Service Engineer, Property Manager, Attorney, Administration Manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 30,
                'pattern_code' => 'S-I',
                'title' => 'ADVISOR',
                'general_description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan \"penjaga damai\" yang sebenarnya dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
                'suitable_jobs' => 'Personnel Welfare, Training, Hotelier, Promoting, Travel Agent, Lecturing, Child Care, Charitable Organizations, Soft or Service Selling, Psychologist, Therapist, Nurse, Personal Assistant, Hospitality Manager, Social Work, Student Services, Upmarket/Speciality Sales.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 31,
                'pattern_code' => 'S-D-I',
                'title' => 'DIRECTOR',
                'general_description' => 'Seorang yang obyektif dan analitis.  Ia ingin terlibat dalam situasi, dan ia juga ingin memberikan bantuan dan dukungan kepada orang yang ia hormati.  Secara internal termotivasi oleh target pribadi, ia berorientasi terhadap pekerjaannya tapi juga menyukai hubungan dengan sesama.  Karena determinasinya yang kuat, ia sering berhasil dalam berbagai hal; karakternya yang tenang, stabil dan daya tahannya yang tinggi memiliki kontribusi dalam keberhasilannya.  Ulet dalam memulai pekerjaan. Ia akan berusaha keras untuk mencapai sasarannya.  Seorang yang mandiri dan cermat serta memiliki tindak lanjut yang baik.',
                'suitable_jobs' => 'Engineering and Production (Supervision), Service Selling, Distribution and Warehouse Supervision/Manager, Office Management, Customer Service, System Analyst, Radio Announcer, Technical Writing, Telemarketing, TV Presenter, Project Engineer, Film Producer, Programmer, Sales/Service Engineer, Accounting, Draughtsman, Project Engineer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 32,
                'pattern_code' => 'S-I-D',
                'title' => 'ADVISOR',
                'general_description' => 'Seorang yang mengesankan orang akan kehangatan, simpati dan pengertiannya.  Ia memiliki ketenangan dalam sebagian besar situasi sosial dan jarang tidak menyenangkan orang lain.  Faktanya, banyak orang datang padanya karena ia kelihatan sebagai pendengar yang baik.  Ia cenderung sangat demonstratif dan emosinya biasanya tampak jelas bagi orang di sekitarnya.  Ia tidak akan memaksakan idenya pada orang lain; ia tidak tegas dalam mengekspresikan atau memberi perintah.  Jika ia sangat kuat merasakan sesuatu, Ia akan bicara secara terbuka dan terus terang tentang pendiriannya.  Ia cenderung menerima kritik atas pekerjaannya sebagai serangan pribadi.  Ia dapat menjadi sangat toleran dan sabar kepada mereka yang tidak produktif di pekerjaan.  Ia merupakan \"penjaga damai\" yang sebenarnya dan akan bekerja untuk menjaga kedamaian dalam setiap keadaan.',
                'suitable_jobs' => 'Engineering and Production (Supervision), Service Selling, Distribution and Warehouse Supervision, Office Management, Customer Service, System Analyst, Programmer, Sales/Service Engineer, Accounting, Draughtsman, Project Engineer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 33,
                'pattern_code' => 'S-I-C',
                'title' => 'ADVOCATE',
                'general_description' => 'Merupakan orang yang stabil, individu yang ramah yang berusaha keras membangun hubungan yang positif di tempat kerja dan di rumah.  Ia dapat menjadi sangat berorientasi detil ketika situasi membutuhkan; tetapi secara keseluruhan ia cenderung individualis, independen dan sedikit perhatian terhadap detil.  Sekali dia membuat keputusan, sangat sulit mengubah pendiriannya.  Ia menyukai hubungan dengan orang dan cenderung mendukung pihak yang lemah.  Ia akan mengambil posisi berlawanan dengan ketidaksepakatan dan merasa frustrasi jika sesuatu tidak sejalan dengannya.  Ia ingin diterima sebagai anggota tim, dan ia menginginkan orang lain menyukainya.  Ia cukup sulit membuat keputusan sampai parameter wewenang secara jelas ditentukan, dan ia mungkin cenderung tidak sungguh-sungguh jika dipaksa membuat keputusan ketika ia tidak ingin melakukannya.  Ia menginginkan orang lain yang membuat keputusan, khususnya jika ada orang yang sangat ia hargai dan hormati.  Ia cenderung moderat, cermat dan dapat diandalkan.',
                'suitable_jobs' => 'Personnel Welfare, Training, Teaching, Attorney, Accounting, Technical Instructor, Customer Service, Public Relations, Artist, Hotelier, Demonstrator, Engineer (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Service), Selling, Purchasing, Supervising (Engineering, Production, Accounts) Administrative Work, Secretarial.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 34,
                'pattern_code' => 'S-C-D',
                'title' => 'INQUIRER',
                'general_description' => 'Seorang yang baik secara alamiah dan sangat berorientasi detil.  Ia peduli dengan orang-orang di sekitarnya dan mempunyai kualitas yang membuatnya sangat teliti dalam penyelesaian tugas.  Ia mempertimbangkan sekelilingnya dengan hati-hati sebelum membuat keputusan untuk melihat pengaruhnya pada mereka; saat tertentu ia terlalu hati-hati.  Jika ia merasa seseorang memanfaatkan situasi, ia akan memperlambat kerjanya sehingga dapat mengamati apa yang sedang berlangsung di sekitarnya.',
                'suitable_jobs' => 'Directing, Managing or Supervising (in Engineering, Accountancy, Research and Development and Computing disciplines), Accountant, Project Engineer, Draughtsman, Designer, Analyst, Chemist, Technician, Service Engineer, Manager, Security Specialist.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 35,
                'pattern_code' => 'S-C-I',
                'title' => 'ADVOCATE',
                'general_description' => 'Merupakan orang yang stabil, individu yang ramah yang berusaha keras membangun hubungan yang positif di tempat kerja dan di rumah.  Ia dapat menjadi sangat berorientasi detil ketika situasi membutuhkan; tetapi secara keseluruhan ia cenderung individualis, independen dan sedikit perhatian terhadap detil.  Sekali dia membuat keputusan, sangat sulit mengubah pendiriannya.  Ia menyukai hubungan dengan orang dan cenderung mendukung pihak yang lemah.  Ia akan mengambil posisi berlawanan dengan ketidaksepakatan dan merasa frustrasi jika sesuatu tidak sejalan dengannya.  Ia ingin diterima sebagai anggota tim, dan ia menginginkan orang lain menyukainya.  Ia cukup sulit membuat keputusan sampai parameter wewenang secara jelas ditentukan, dan ia mungkin cenderung tidak sungguh-sungguh jika dipaksa membuat keputusan ketika ia tidak ingin melakukannya.  Ia menginginkan orang lain yang membuat keputusan, khususnya jika ada orang yang sangat ia hargai dan hormati.  Ia cenderung moderat, cermat dan dapat diandalkan.',
                'suitable_jobs' => 'Personnel Welfare, Administrator, Advisers, Training, Teaching, Attorney, Accounting, Counseling, Technical Instructor, Customer Service, Accounting-General, Public Relations, Accounts Supervisor, Artist, Hotelier, Demonstrator, Engineer (Sales, Service, Project, Draughtsman, Designer), Specialist (Soft/Service), Selling, Purchasing, Sales Engineer, Legal, Negotiator, Student Service, Photographer, Physiotherapist, Project Engineer, Vocational Education, Supervising (Engineering, Production, Accounts) Administrative Work, Demonstrator, Secretarial, Hospitality Manager.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 36,
                'pattern_code' => 'C-I',
                'title' => 'ASSESSOR',
                'general_description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
                'suitable_jobs' => 'Sales (Technical/Specialist), Public Relations, Lecturer, Academic, Personnel Administration, Purchasing, Travel Agent, Training, Teaching, Real Estate Agent, Hospitality Administration, Sales-Technical, Hotelier, Project Engineer, Service Engineer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 37,
                'pattern_code' => 'C-D-I',
                'title' => 'CHALLENGER',
                'general_description' => 'Seorang yang sangat berorientasi pada tugas dan sensitif pada permasalahan. Ia lebih mempedulikan tugas yang ada dibanding orang-orang di sekitarnya, termasuk perasaan mereka. Ia sangat kukuh/keras dan mempunyai pendekatan yang efektif dalam pemecahan masalah. Oleh karena sifat alamiah dan keinginannya akan hasil yang terukur, ia akan tampak dingin, tidak berperasaan dan menjaga jarak. Ia membuat keputusan berdasar pada fakta, bukan emosi. ia cenderung pendiam dan tidak mudah percaya.',
                'suitable_jobs' => 'Directing, Managing or Supervising (Engineering, Research, Finance, Planning), Designer, Work Study, Sales (Technical/ Specialist), Logistic Support, Systems Analyst, Lecturer, Company Secretary, Negotiator and Purchasing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 38,
                'pattern_code' => 'C-D-S',
                'title' => 'CONTEMPLATOR',
                'general_description' => 'Berorientasi pada hal detil dan mempunyai standard tinggi untuk dirinya. Ia logis dan analitis. Ia ingin berbuat yang terbaik, dan ia selalu berpikir ada ruang untuk peningkatan/kemajuan. Ia cenderung kompetitif dan ingin menghasilkan pekerjaan dengan mutu yang terbaik. Ia sebenarnya sensitif terhadap orang-orang, tetapi karena sifat logisnya, orientasinya terhadap tugas dapat menutupinya dengan mudah. Ia suka dihargai untuk pekerjaannya yang berkualitas. Ia mampu mengerjakan tugas-tugas; dan mencapai sasarannya. Ia sangat memusatkan perhatian pada tugas yang ada, mantap dan dapat diandalkan.',
                'suitable_jobs' => 'Engineering, Research, Production and Finance (Director, Manager atau Supervisor), Work Study, Accountant, Administrator, Quality Controller, Safety Officer, Market Analyst, Planner and Personnel (Director, Manager, Administrator), MIS Manager, Security Manager, Loss Control.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 39,
                'pattern_code' => 'C-I-D',
                'title' => 'ASSESSOR',
                'general_description' => 'Merupakan seseorang yang analitis, berwatak hati-hati dan ramah pada saat merasa nyaman. Ia sangat biasa dengan orang asing, karena ia dapat menilai dan menyesuaikan diri dalam hubungan mereka. Ia dapat mengembangkan hubungan baru dengan mudah ketika ia ingin melakukannya, dan pada umumnya dapat mengendalikan diri sampai pada tingkat di mana ia jarang menimbulkan rasa benci pada orang lain dengan sengaja. Ia menampilkan sikap peduli dan ramah, namun mampu memusatkan perhatian pada penyelesaian tugas yang ada. Ia cenderung perfeksionis secara alami, dan akan mengisolasi dirinya jika diperlukan untuk melaksanakan pekerjaan. Ia suka berada pada situasi yang dapat diramalkan dan tidak ada kejutan. Ia sangat berorientasi pada kualitas dan akan bekerja dengan keras untuk menyelesaikan pekerjakan dengan benar. Ia ingin orang-orang berkenan akan pekerjaan yang sudah ia selesaikan dengan baik.',
                'suitable_jobs' => 'Directing, Managing or Supervising (Engineering, Research, Finance, Planning), Designer, Work Study, Sales (Technical/Specialist), Lecturer, Company Secretary, Negotiator and Purchasing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 40,
                'pattern_code' => 'C-S-D',
                'title' => 'PRECISIONIST',
                'general_description' => 'Berpikir sistematis dan cenderung mengikuti prosedur dalam kehidupan pribadi dan pekerjaannya.  Teratur dan memiliki perencanaan yang baik, ia teliti dan fokus pada detil.  Ia bertindak dengan penuh kebijaksanaan, diplomatis dan jarang menentang rekan kerjanya dengan sengaja.  Ia sangat berhati-hati, ia sungguh-sungguh mengharapkan akurasi dan standard tinggi dalam pekerjaannya.  Ia cenderung terjebak dalam hal detil, khususnya jika harus memutuskan.  ia menginginkan adanya petunjuk standard pelaksanaan kerja dan tanpa perubahan mendadak.',
                'suitable_jobs' => 'Engineering, Research Director, Production and Finance (Director, Manager, Supervisor), Work Study, Accountant, Administrator, Quality Controller, Financial Services Manager, Safety Officer, Market Analyst, Planner and Personnel (Director, Manager, Administrator), MIS Manager, Electrician, Security Manager, Financial Researcher, Planner, Printer, Production Controller, Production Manager, Personnel Management, Loss Control.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('disc_profiles')->insert($profiles);
    }
}
