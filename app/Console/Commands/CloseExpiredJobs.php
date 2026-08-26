<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class CloseExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-jobs {--dry-run : Jalankan simulasi tanpa mengubah data di database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis menutup lowongan kerja yang statusnya Open tetapi telah melewati batas tanggal pendaftaran (deadline)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $isDryRun = (bool) $this->option('dry-run');

        $this->info("Memeriksa lowongan kadaluarsa per tanggal hari ini: [{$today}]...");

        // Ambil lowongan yang masih 'Open' tapi deadlinenya sudah lewat
        $expiredJobs = Job::where('status', 'Open')
            ->whereNotNull('deadline')
            ->where('deadline', '<', $today)
            ->with(['company', 'department'])
            ->get();

        $count = $expiredJobs->count();

        if ($count === 0) {
            $this->info("Tidak ada lowongan berstatus 'Open' yang telah melewati batas deadline.");
            return 0;
        }

        $this->warn("Ditemukan {$count} lowongan kadaluarsa yang perlu ditutup:");

        foreach ($expiredJobs as $job) {
            $companyName = $job->company?->name ?? 'Perusahaan #' . $job->company_id;
            $this->line(" - [ID: {$job->id}] {$job->title} ({$companyName}) - Deadline: {$job->deadline}");
        }

        if ($isDryRun) {
            $this->info("[DRY RUN] Tidak ada perubahan data yang disimpan ke database.");
            return 0;
        }

        $updatedCount = Job::where('status', 'Open')
            ->whereNotNull('deadline')
            ->where('deadline', '<', $today)
            ->update(['status' => 'Closed']);

        $this->info("Berhasil menutup {$updatedCount} lowongan kerja otomatis.");
        return 0;
    }
}
