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
        'photo', 'npwp', 'about_me', 'generated_cv_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'profile_id');
    }

    public function organizations() { return $this->hasMany(Organization::class, 'profile_id'); }
    public function educations() { return $this->hasMany(Education::class, 'profile_id'); }
    public function workExperiences() { return $this->hasMany(WorkExperience::class, 'profile_id'); }
    public function achievements() { return $this->hasMany(Achievement::class, 'profile_id'); }
    public function certifications() { return $this->hasMany(Certification::class, 'profile_id'); }
    public function trainings() { return $this->hasMany(Training::class, 'profile_id'); }
    public function skills() { return $this->hasMany(Skill::class, 'profile_id'); }
    public function socialMedias() { return $this->hasMany(SocialMedia::class, 'profile_id'); }
    public function languages() { return $this->hasMany(Language::class, 'profile_id'); }

    /**
     * Get section completion status map
     */
    public function getSectionStatusesAttribute(): array
    {
        return [
            'pribadi' => !empty($this->nik) && !empty($this->full_name) && !empty($this->phone) && !empty($this->address),
            'pendidikan' => $this->educations()->exists(),
            'pengalaman' => $this->workExperiences()->exists(),
            'organisasi' => $this->organizations()->exists(),
            'prestasi' => $this->achievements()->exists(),
            'social_media' => $this->socialMedias()->exists(),
            'data_tambahan' => $this->skills()->exists() || $this->certifications()->exists() || $this->trainings()->exists() || $this->languages()->exists(),
        ];
    }

    /**
     * Calculate profile completion percentage (0 - 100%)
     */
    public function getCompletionPercentageAttribute(): int
    {
        $statuses = $this->section_statuses;
        $weights = [
            'pribadi' => 20,
            'pendidikan' => 20,
            'pengalaman' => 15,
            'organisasi' => 10,
            'prestasi' => 10,
            'social_media' => 10,
            'data_tambahan' => 15,
        ];

        $totalPercentage = 0;
        foreach ($weights as $key => $weight) {
            if (!empty($statuses[$key])) {
                $totalPercentage += $weight;
            }
        }

        return min(100, $totalPercentage);
    }
}
