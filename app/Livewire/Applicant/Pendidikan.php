<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use App\Models\Degree;
use App\Models\Education;
use App\Models\Major;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pendidikan extends Component
{
    public $showModal = false;
    public $isEdit = false;
    public $education_id;

    public $degree_id;
    public $degree;
    public $major_id;
    public $major;
    public $school_name;
    public $study_program;
    public $start_year;
    public $end_year;
    public $is_ongoing = false;
    public $gpa;
    public $description;

    public function updatedIsOngoing($value)
    {
        if ($value) {
            $this->end_year = null;
        }
    }

    public function isSchoolDegree()
    {
        if ($this->degree_id) {
            $deg = Degree::find($this->degree_id);
            if ($deg) {
                $name = strtoupper($deg->name);
                return str_contains($name, 'SMA') || str_contains($name, 'SMK') || str_contains($name, 'SLTA') || str_contains($name, 'SMP') || str_contains($name, 'SD');
            }
        }
        if ($this->degree) {
            $name = strtoupper($this->degree);
            return str_contains($name, 'SMA') || str_contains($name, 'SMK') || str_contains($name, 'SLTA') || str_contains($name, 'SMP') || str_contains($name, 'SD');
        }
        return false;
    }

    protected function rules()
    {
        $isSchool = $this->isSchoolDegree();
        $gpaRule = $isSchool ? 'nullable|numeric|between:0,100.00' : 'nullable|numeric|between:0,4.00';

        return [
            'school_name' => 'required|string|max:255',
            'degree_id' => 'nullable|exists:degrees,id',
            'degree' => 'nullable|string|max:100',
            'major_id' => 'nullable|exists:majors,id',
            'major' => 'nullable|string|max:100',
            'study_program' => 'nullable|string|max:255',
            'start_year' => 'required|integer|digits:4|min:1950|max:' . (date('Y') + 5),
            'end_year' => $this->is_ongoing ? 'nullable' : 'nullable|integer|digits:4|gte:start_year|max:' . (date('Y') + 10),
            'gpa' => $gpaRule,
            'description' => 'nullable|string|max:1000',
        ];
    }

    protected function messages()
    {
        $isSchool = $this->isSchoolDegree();
        return [
            'school_name.required' => 'Nama sekolah / perguruan tinggi wajib diisi.',
            'start_year.required' => 'Tahun mulai wajib diisi.',
            'start_year.digits' => 'Tahun mulai harus 4 digit angka.',
            'end_year.gte' => 'Tahun selesai harus lebih besar atau sama dengan tahun mulai.',
            'gpa.between' => $isSchool 
                ? 'Nilai Rata-rata harus di antara 0 sampai 100.' 
                : 'IPK harus di antara 0.00 sampai 4.00.',
        ];
    }

    public function openModal()
    {
        $this->resetForm();
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
            'education_id',
            'degree_id',
            'degree',
            'major_id',
            'major',
            'school_name',
            'study_program',
            'start_year',
            'end_year',
            'is_ongoing',
            'gpa',
            'description',
        ]);
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $user = Auth::user();
        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        if (!$profile) return;

        $education = Education::where('profile_id', $profile->id)->where('id', $id)->firstOrFail();

        $this->education_id = $education->id;
        $this->degree_id = $education->degree_id;
        $this->degree = $education->degree;
        $this->major_id = $education->major_id;
        $this->major = $education->major;
        $this->school_name = $education->school_name;
        $this->study_program = $education->study_program;
        $this->start_year = $education->start_year;
        $this->end_year = $education->end_year;
        $this->is_ongoing = empty($education->end_year);
        $this->gpa = $education->gpa;
        $this->description = $education->description;

        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->is_ongoing) {
            $validatedData['end_year'] = null;
        }

        $user = Auth::user();
        $profile = ApplicantProfile::firstOrCreate(['user_id' => $user->id]);

        if (!empty($this->degree_id)) {
            $degreeObj = Degree::find($this->degree_id);
            $validatedData['degree'] = $degreeObj ? $degreeObj->name : ($this->degree ?? '-');
        } else {
            $validatedData['degree'] = !empty($this->degree) ? $this->degree : '-';
        }

        if ($this->isSchoolDegree()) {
            $validatedData['major'] = '-';
            $validatedData['major_id'] = null;
        } else {
            if (!empty($this->major_id)) {
                $majorObj = Major::find($this->major_id);
                $validatedData['major'] = $majorObj ? $majorObj->name : ($this->major ?? '-');
            } else {
                $validatedData['major'] = !empty($this->major) ? $this->major : '-';
            }
        }

        if ($this->isEdit && $this->education_id) {
            $education = Education::where('profile_id', $profile->id)->where('id', $this->education_id)->firstOrFail();
            $education->update($validatedData);
            session()->flash('message', 'Riwayat pendidikan berhasil diperbarui.');
        } else {
            $validatedData['profile_id'] = $profile->id;
            Education::create($validatedData);
            session()->flash('message', 'Riwayat pendidikan berhasil ditambahkan.');
        }

        $this->closeModal();
        return redirect(route('profile', ['tab' => 'pendidikan']));
    }

    public function delete($id)
    {
        $user = Auth::user();
        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        if ($profile) {
            Education::where('profile_id', $profile->id)->where('id', $id)->delete();
            session()->flash('message', 'Riwayat pendidikan berhasil dihapus.');
        }

        return redirect(route('profile', ['tab' => 'pendidikan']));
    }

    public function render()
    {
        $user = Auth::user();
        $profile = ApplicantProfile::where('user_id', $user->id)->first();
        $educations = $profile ? Education::where('profile_id', $profile->id)->orderBy('start_year', 'desc')->get() : collect();

        $degrees = Degree::orderBy('rank', 'asc')->get();
        $majors = Major::orderBy('name', 'asc')->get();

        return view('livewire.applicant.pendidikan', [
            'educations' => $educations,
            'degrees' => $degrees,
            'majors' => $majors,
        ]);
    }
}
