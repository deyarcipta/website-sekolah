<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TestimoniAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniAlumniBackendController extends Controller
{
    public function index()
    {
        $testimoni = TestimoniAlumni::orderBy('urutan')->get();
        return view('backend.testimoni-alumni.index', compact('testimoni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:50',
            'testimoni' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            $data = $request->except('foto');
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('testimoni-alumni', 'public');
            }

            TestimoniAlumni::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni alumni berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $testimoni = TestimoniAlumni::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $testimoni
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:50',
            'testimoni' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            $testimoni = TestimoniAlumni::findOrFail($id);
            $data = $request->except('foto');
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($testimoni->foto && Storage::disk('public')->exists($testimoni->foto)) {
                    Storage::disk('public')->delete($testimoni->foto);
                }
                $data['foto'] = $request->file('foto')->store('testimoni-alumni', 'public');
            }

            $testimoni->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni alumni berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $testimoni = TestimoniAlumni::findOrFail($id);
            
            // Delete photo if exists
            if ($testimoni->foto && Storage::disk('public')->exists($testimoni->foto)) {
                Storage::disk('public')->delete($testimoni->foto);
            }
            
            $testimoni->delete();

            return response()->json([
                'success' => true,
                'message' => 'Testimoni alumni berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateUrutan(Request $request)
    {
        try {
            $urutan = $request->input('urutan');
            
            foreach ($urutan as $item) {
                TestimoniAlumni::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan testimoni berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}