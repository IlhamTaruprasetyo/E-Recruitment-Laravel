<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $table = 'applicant_profile';

    // Fillable disesuaikan dengan kolom di database
    protected $fillable = [
        'user_id', 'nik', 'full_name', 'gender', 'birth_place',
        'birth_date', 'phone', 'address', 'city', 'province',
        'photo', 'npwp', 'child_sequence', 'total_siblings', 'marital_status',
        'about_me', 'generated_cv_url', 'cv_file_path',
    ];

    protected $appends = ['cv_url', 'cv_file_url'];

    public function getCvFileUrlAttribute(): ?string
    {
        return $this->cv_file_path ? asset('storage/' . $this->cv_file_path) : null;
    }

    public function getCvUrlAttribute(): ?string
    {
        if ($this->cv_file_path) {
            return asset('storage/' . $this->cv_file_path);
        }
        if ($this->generated_cv_url) {
            return $this->generated_cv_url;
        }
        return route('profile.cv.preview');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'profile_id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class, 'profile_id');
    }

    public function educations()
    {
        return $this->hasMany(Education::class, 'profile_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'profile_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'profile_id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'profile_id');
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'profile_id');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'profile_id');
    }

    public function socialMedias()
    {
        return $this->hasMany(SocialMedia::class, 'profile_id');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'profile_id');
    }

    public function jobPreference()
    {
        return $this->hasOne(ApplicantJobPreference::class, 'applicant_profile_id');
    }

    public function family()
    {
        return $this->hasOne(ApplicantFamily::class, 'applicant_profile_id');
    }

    /**
     * Get section completion status map
     */
    public function getSectionStatusesAttribute(): array
    {
        return [
            'pribadi' => ! empty($this->nik) && ! empty($this->full_name) && ! empty($this->phone) && ! empty($this->address) && (! empty($this->cv_file_path) || ! empty($this->generated_cv_url)),
            'keluarga' => $this->family()->exists() || (! empty($this->child_sequence) && ! empty($this->marital_status)),
            'pendidikan' => $this->educations()->exists(),
            'skill' => $this->skills()->exists(),
            'pengalaman' => $this->workExperiences()->exists(),
            'organisasi' => $this->organizations()->exists(),
            'prestasi' => $this->achievements()->exists(),
            'social_media' => $this->socialMedias()->exists(),
            'data_tambahan' => $this->certifications()->exists() || $this->trainings()->exists() || $this->languages()->exists(),
        ];
    }

    /**
     * Check whether all mandatory profile data are complete
     */
    public function getIsMandatoryCompleteAttribute(): bool
    {
        $statuses = $this->section_statuses;
        return ! empty($statuses['pribadi'])
            && ! empty($statuses['keluarga'])
            && ! empty($statuses['pendidikan'])
            && ! empty($statuses['skill'])
            && ! empty($statuses['pengalaman']);
    }

    /**
     * Calculate mandatory profile completion percentage (0 - 100%)
     */
    public function getMandatoryCompletionPercentageAttribute(): int
    {
        $statuses = $this->section_statuses;
        $mandatoryKeys = ['pribadi', 'keluarga', 'pendidikan', 'skill', 'pengalaman'];
        
        $completedCount = 0;
        foreach ($mandatoryKeys as $key) {
            if (! empty($statuses[$key])) {
                $completedCount++;
            }
        }

        return (int) round(($completedCount / count($mandatoryKeys)) * 100);
    }

    /**
     * Get list of uncompleted mandatory profile section labels
     */
    public function getMissingMandatorySectionsAttribute(): array
    {
        $statuses = $this->section_statuses;
        $labels = [
            'pribadi' => 'Data Pribadi & Dokumen CV',
            'keluarga' => 'Data Keluarga',
            'pendidikan' => 'Pendidikan',
            'skill' => 'Skill / Keahlian',
            'pengalaman' => 'Pengalaman Kerja',
        ];

        $missing = [];
        foreach ($labels as $key => $label) {
            if (empty($statuses[$key])) {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    /**
     * Calculate total profile completion percentage (0 - 100%)
     */
    public function getCompletionPercentageAttribute(): int
    {
        $statuses = $this->section_statuses;
        $weights = [
            // Data Wajib (80% total)
            'pribadi' => 16,
            'keluarga' => 16,
            'pendidikan' => 16,
            'skill' => 16,
            'pengalaman' => 16,
            // Data Pelengkap (20% total)
            'organisasi' => 5,
            'prestasi' => 5,
            'social_media' => 5,
            'data_tambahan' => 5,
        ];

        $totalPercentage = 0;
        foreach ($weights as $key => $weight) {
            if (! empty($statuses[$key])) {
                $totalPercentage += $weight;
            }
        }

        return min(100, $totalPercentage);
    }
}
