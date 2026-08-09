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
}
