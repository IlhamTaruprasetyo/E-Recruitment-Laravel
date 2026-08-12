<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Cloudinary\Cloudinary;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::all());
    }

    private function uploadLogo($file)
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        // Jika kredensial Cloudinary diatur di .env, unggah ke Cloudinary
        if (!empty($cloudName) && !empty($apiKey) && !empty($apiSecret)) {
            try {
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => $cloudName,
                        'api_key'    => $apiKey,
                        'api_secret' => $apiSecret,
                    ]
                ]);

                $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'e-recruitment/logos',
                    'transformation' => [
                        'quality' => 'auto',
                        'fetch_format' => 'auto',
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'limit'
                    ]
                ]);

                return $result['secure_url'] ?? null;
            } catch (\Exception $e) {
                // Fallback ke penyimpanan lokal jika gagal koneksi
            }
        }

        // Fallback simpan ke penyimpanan lokal
        return $file->store('logo', 'public');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',    
            'province' => 'nullable|string|max:255',
        ]);

        $path = $this->uploadLogo($request->file('logo'));

        $data = Company::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'logo' => $path,
            'website' => $request->website,
            'address' => $request->address, 
            'city' => $request->city,
            'province' => $request->province,
        ]);

        if (!$data) {
            return redirect()->route('admin.company')->with('error', 'Company gagal dibuat');
        }
        return redirect()->route('admin.company')->with('create', 'Company berhasil dibuat');
    }

    public function show(string $id)
    {
        $data = Company::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $data = Company::findOrFail($id);

        $request->validate([
            'role_id' => 'sometimes|required|exists:roles,id',
            'name' => 'sometimes|required|string|max:255',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4096',
            'website' => 'sometimes|nullable|url|max:255',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:255',
            'province' => 'sometimes|nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus file lama jika lokal
            if ($data->logo && !str_starts_with($data->logo, 'http') && Storage::disk('public')->exists($data->logo)) {
                Storage::disk('public')->delete($data->logo);
            }
            $path = $this->uploadLogo($request->file('logo'));
        } else {
            $path = $data->logo;
        }

        $data->update([
            'role_id' => $request->input('role_id', $data->role_id),
            'name' => $request->input('name', $data->name),
            'logo' => $path,
            'website' => $request->input('website', $data->website),
            'address' => $request->input('address', $data->address),
            'city' => $request->input('city', $data->city),
            'province' => $request->input('province', $data->province),
        ]);

        return response()->json(['message' => 'Company berhasil diperbarui', 'data' => $data]);
    }

    public function destroy(string $id)
    {
        $data = Company::findOrFail($id);
        if ($data->logo && !str_starts_with($data->logo, 'http') && Storage::disk('public')->exists($data->logo)) {
            Storage::disk('public')->delete($data->logo);
        }
        
        if (!$data->delete()){
            return redirect()->route('admin.company')->with('error', 'Company gagal dihapus');
        }
        return redirect()->route('admin.company')->with('delete', 'Company berhasil dihapus');
    }
}
