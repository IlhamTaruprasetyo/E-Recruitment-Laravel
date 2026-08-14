<?php

namespace App\Console\Commands;

use App\Mail\JobRecommendationMail;
use App\Models\ApplicantJobPreference;
use App\Models\Job;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendJobRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-job-recommendations {period=Harian : Periode notifikasi (Harian, Mingguan, Bulanan)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email rekomendasi lowongan kerja otomatis kepada pelamar berdasarkan minat kerja dan periode notifikasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $period = ucfirst(strtolower($this->argument('period')));

        if (!in_array($period, ['Harian', 'Mingguan', 'Bulanan'])) {
            $this->error('Periode tidak valid. Gunakan: Harian, Mingguan, atau Bulanan.');
            return 1;
        }

        $this->info("Memulai pengiriman notifikasi lowongan kerja periode: [{$period}]...");

        // Ambil preference pelamar yang statusnya Aktif atau Pasif dan match periodenya
        $preferences = ApplicantJobPreference::with(['applicantProfile.user'])
            ->whereIn('job_search_status', ['Aktif', 'Pasif'])
            ->where('notification_period', $period)
            ->get();

        if ($preferences->isEmpty()) {
            $this->info("Tidak ada pelamar aktif/pasif dengan periode [{$period}].");
            return 0;
        }

        $activeJobs = Job::with(['company', 'department'])
            ->where('status', 'open')
            ->get();

        if ($activeJobs->isEmpty()) {
            $this->info("Tidak ada lowongan pekerjaan aktif (open).");
            return 0;
        }

        $sentCount = 0;

        foreach ($preferences as $pref) {
            $user = $pref->applicantProfile?->user;
            if (!$user || !$user->email) {
                continue;
            }

            // Ambil bidang minat pelamar
            $fields = array_filter([
                $pref->interested_field_1,
                $pref->interested_field_2,
                $pref->interested_field_3,
            ]);

            // Filter lowongan yang cocok dengan bidang minat pelamar
            $matchedJobs = $activeJobs->filter(function ($job) use ($fields) {
                if (empty($fields)) {
                    return true; // Jika belum isi bidang minat, kirimkan lowongan terbaru
                }

                $deptName = $job->department?->name;
                if (!$deptName) return false;

                foreach ($fields as $field) {
                    if (strcasecmp(trim($deptName), trim($field)) === 0 || stripos($deptName, $field) !== false) {
                        return true;
                    }
                }
                return false;
            })->take(5);

            if ($matchedJobs->isNotEmpty()) {
                try {
                    Mail::to($user->email)->send(new JobRecommendationMail($user, $matchedJobs, $period));
                    $sentCount++;
                    $this->line("-> Email berhasil dikirim ke: {$user->email}");
                } catch (\Exception $e) {
                    $this->error("-> Gagal mengirim email ke {$user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("Selesai. Total {$sentCount} email rekomendasi lowongan telah terkirim.");
        return 0;
    }
}
