<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',    
            'province' => 'nullable|string|max:255',
        ]);

        $path = $request->file('logo')->store('logo', 'public');

        $data = Company::create([
            'role_id' => $request ->role_id,
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
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg|max:4096',
            'website' => 'sometimes|nullable|url|max:255',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:255',
            'province' => 'sometimes|nullable|string|max:255',
        ]);
        if ($request->hasFile('logo')) {
            if ($data->logo && Storage::disk('public')->exists($data->logo)) {
                Storage::disk('public')->delete($data->logo);
            }
            $path = $request->file('logo')->store('logo', 'public');
        } else {
            $path = $data->logo;
        }
        // $data->update([
        //     'role_id' => $request->role_id,
        //     'name' => $request->name,
        //     'logo' => $path,
        //     'website' => $request->website,
        //     'address' => $request->address, 
        //     'city' => $request->city,
        //     'province' => $request->province,
        // ]);
        $data->update([
            'role_id' => $request->input('role_id', $data->role_id),
            'name' => $request->input('name', $data->name),
            'logo' => $path,
            'website' => $request->input('website', $data->website),
            'address' => $request->input('address', $data->address),
            'city' => $request->input('city', $data->city),
            'province' => $request->input('province', $data->province),
        ]);

        
    }

    public function destroy(string $id)
    {
        $data = Company::findOrFail($id);
        if ($data->logo && Storage::disk('public')->exists($data->logo)) {
            Storage::disk('public')->delete($data->logo);
        }
        // $data->delete();
        if (!$data->delete()){
            return redirect()->route('admin.company')->with('error', 'Company gagal dihapus');
        }
        return redirect()->route('admin.company')->with('delete', 'Company berhasil dihapus');
    }
}
