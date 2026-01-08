<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KeunggulanSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KeunggulanSekolahController extends Controller
{
    public function index()
    {
        $keunggulan = KeunggulanSekolah::orderBy('urutan')->get();
        return view('backend.keunggulan-sekolah.index', compact('keunggulan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:7', // Validasi warna hex
            'urutan' => 'nullable|integer'
        ]);

        try {
            // Set default warna jika kosong
            $data = $request->all();
            if (empty($data['warna'])) {
                $data['warna'] = '#007bff';
            }
            
            KeunggulanSekolah::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Keunggulan sekolah berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'warna' => 'nullable|string|max:7',
            'urutan' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        try {
            $keunggulan = KeunggulanSekolah::findOrFail($id);
            $keunggulan->update($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Keunggulan sekolah berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $keunggulan = KeunggulanSekolah::findOrFail($id);
            $keunggulan->delete();
            
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }

    public function updateUrutan(Request $request)
    {
        $request->validate([
            'urutan' => 'required|array'
        ]);

        try {
            DB::beginTransaction();
            
            foreach ($request->urutan as $index => $id) {
                KeunggulanSekolah::where('id', $id)->update(['urutan' => $index + 1]);
            }
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 500);
        }
    }
}