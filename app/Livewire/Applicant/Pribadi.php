<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Pribadi extends Component
{
    use WithFileUploads;

    public $nik;
    public $full_name;
    public $gender;
    public $birth_place;
    public $birth_date;
    public $phone;
    public $address;
    public $city;
    public $province;
    public $npwp;
    public $about_me;

    public $photo;
    public $cropped_photo_base64;
    public $current_photo_url;

    public function mount()
    {
        $user = Auth::user();
        $profile = ApplicantProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => $user->name,
                'phone' => $user->phone ?? null,
            ]
        );

        $this->nik = $profile->nik;
        $this->full_name = $profile->full_name ?? $user->name;
        $this->gender = $profile->gender;
        $this->birth_place = $profile->birth_place;
        $this->birth_date = $profile->birth_date;
        $this->phone = $profile->phone;
        $this->address = $profile->address;
        $this->city = $profile->city;
        $this->province = $profile->province;
        $this->npwp = $profile->npwp;
        $this->about_me = $profile->about_me;
        $this->current_photo_url = $profile->photo ? (asset('storage/' . $profile->photo) . '?v=' . time()) : null;
    }

    protected function rules()
    {
        return [
            'nik' => 'nullable|string|max:20',
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'npwp' => 'nullable|string|max:30',
            'about_me' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:5120',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $user = Auth::user();
        $profile = ApplicantProfile::firstOrCreate(['user_id' => $user->id]);

        if ($this->cropped_photo_base64) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            // Decode base64 image from Cropper.js
            $imageParts = explode(";base64,", $this->cropped_photo_base64);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = isset($imageTypeAux[1]) ? strtolower($imageTypeAux[1]) : 'jpeg';
            if ($imageType === 'jpeg') { $imageType = 'jpg'; }
            $imageBase64 = base64_decode($imageParts[1]);

            $fileName = 'applicant-photos/' . uniqid() . '.' . $imageType;
            Storage::disk('public')->put($fileName, $imageBase64);

            $validatedData['photo'] = $fileName;
            $this->current_photo_url = asset('storage/' . $fileName) . '?v=' . time();
            $this->photo = null;
            $this->cropped_photo_base64 = null;
        } elseif ($this->photo) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
            $photoPath = $this->photo->store('applicant-photos', 'public');
            $validatedData['photo'] = $photoPath;
            $this->current_photo_url = asset('storage/' . $photoPath) . '?v=' . time();
            $this->photo = null;
        } else {
            unset($validatedData['photo']);
        }

        $profile->update($validatedData);

        if ($user->name !== $this->full_name) {
            $user->update(['name' => $this->full_name]);
        }

        session()->flash('message', 'Data pribadi berhasil diperbarui.');
        $this->dispatch('profile-updated', name: $this->full_name);
    }

    public function render()
    {
        return view('livewire.applicant.pribadi');
    }
}
