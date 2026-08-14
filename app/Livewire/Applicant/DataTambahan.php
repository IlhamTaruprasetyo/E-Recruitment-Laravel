<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use App\Models\Certification;
use App\Models\Language;
use App\Models\Skill;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataTambahan extends Component
{
    use WithFileUploads;

    // --- FORM MODAL STATE ---
    public $showModal = false;
    public $modalType = 'skill'; // 'skill', 'certification', 'training', 'language'
    public $isEdit = false;
    public $itemId = null;
    public $name;
    public $certificate;
    public $existing_certificate;

    // --- DELETE MODAL STATE ---
    public $showDeleteModal = false;
    public $deleteId = null;
    public $deleteType = null; // 'skill', 'certification', 'training', 'language'

    public function openModal($type)
    {
        $this->resetForm();
        $this->modalType = $type;
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'itemId',
            'name',
            'certificate',
            'existing_certificate',
        ]);
        $this->resetErrorBag();
    }

    public function edit($type, $id)
    {
        $user = Auth::user();
        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        if (!$profile) return;

        $model = $this->getModelInstance($type, $profile->id, $id);
        if (!$model) return;

        $this->modalType = $type;
        $this->itemId = $model->id;
        $this->name = $model->name;
        $this->existing_certificate = $model->certificate_path;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $typeLabel = $this->getTypeLabel($this->modalType);

        $this->validate([
            'name' => 'required|string|max:255',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'name.required' => "Nama {$typeLabel} wajib diisi.",
            'certificate.mimes' => 'Format file sertifikat/bukti harus PDF, JPG, JPEG, atau PNG.',
            'certificate.max' => 'Ukuran file tidak boleh melebihi 2MB.',
        ]);

        $user = Auth::user();
        $profile = ApplicantProfile::firstOrCreate(['user_id' => $user->id]);

        $certPath = $this->existing_certificate;
        if ($this->certificate) {
            if ($certPath && Storage::disk('public')->exists($certPath)) {
                Storage::disk('public')->delete($certPath);
            }
            $folder = "certificates/{$this->modalType}s";
            $certPath = $this->certificate->store($folder, 'public');
        }

        if ($this->isEdit && $this->itemId) {
            $model = $this->getModelInstance($this->modalType, $profile->id, $this->itemId);
            if ($model) {
                $model->update([
                    'name' => $this->name,
                    'certificate_path' => $certPath,
                ]);
                session()->flash('message', "{$typeLabel} berhasil diperbarui.");
            }
        } else {
            $class = $this->getModelClass($this->modalType);
            $class::create([
                'profile_id' => $profile->id,
                'name' => $this->name,
                'certificate_path' => $certPath,
            ]);
            session()->flash('message', "{$typeLabel} berhasil ditambahkan.");
        }

        $this->closeModal();
        $this->dispatch('profile-updated');
    }

    public function confirmDelete($type, $id)
    {
        $this->deleteId = $id;
        $this->deleteType = $type;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteType = null;
    }

    public function delete()
    {
        if ($this->deleteId && $this->deleteType) {
            $user = Auth::user();
            $profile = ApplicantProfile::where('user_id', $user->id)->first();
            if ($profile) {
                $model = $this->getModelInstance($this->deleteType, $profile->id, $this->deleteId);
                if ($model) {
                    if ($model->certificate_path && Storage::disk('public')->exists($model->certificate_path)) {
                        Storage::disk('public')->delete($model->certificate_path);
                    }
                    $model->delete();
                    $typeLabel = $this->getTypeLabel($this->deleteType);
                    session()->flash('message', "{$typeLabel} berhasil dihapus.");
                }
            }
        }

        $this->cancelDelete();
        $this->dispatch('profile-updated');
    }

    protected function getModelClass($type)
    {
        return match ($type) {
            'certification' => Certification::class,
            'training' => Training::class,
            'language' => Language::class,
            default => Skill::class,
        };
    }

    protected function getModelInstance($type, $profileId, $id)
    {
        $class = $this->getModelClass($type);
        return $class::where('profile_id', $profileId)->where('id', $id)->first();
    }

    public function getTypeLabel($type)
    {
        return match ($type) {
            'certification' => 'Sertifikasi',
            'training' => 'Pelatihan',
            'language' => 'Bahasa',
            default => 'Keahlian',
        };
    }

    public function render()
    {
        $user = Auth::user();
        $profile = ApplicantProfile::where('user_id', $user->id)->first();

        $skills = $profile ? Skill::where('profile_id', $profile->id)->get() : collect();
        $certifications = $profile ? Certification::where('profile_id', $profile->id)->get() : collect();
        $trainings = $profile ? Training::where('profile_id', $profile->id)->get() : collect();
        $languages = $profile ? Language::where('profile_id', $profile->id)->get() : collect();

        return view('livewire.applicant.data_tambahan', [
            'skills' => $skills,
            'certifications' => $certifications,
            'trainings' => $trainings,
            'languages' => $languages,
        ]);
    }
}
