<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GuruStaff;
use App\Models\GuruStaffDeskripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruStaffBackendController extends Controller
{
    // Data untuk dropdown
    private function getTipeOptions()
    {
        return [
            'kepala_sekolah' => 'Kepala Sekolah',
            'wakil_kepala_sekolah' => 'Wakil Kepala Sekolah',
            'kepala_jurusan' => 'Kepala Jurusan',
            'guru' => 'Guru',
            'staff' => 'Staff'
        ];
    }

    public function index()
    {
        $guruStaff = GuruStaff::orderBy('urutan')->get();
        $tipeOptions = $this->getTipeOptions();
        $guruStaffDescription = GuruStaffDeskripsi::getDeskripsi();
        
        return view('backend.guru-staff.index', compact('guruStaff', 'tipeOptions', 'guruStaffDescription'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe' => 'required|in:kepala_sekolah,wakil_kepala_sekolah,kepala_jurusan,guru,staff',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y'),
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('foto');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/guru-staff', $filename);
            $data['foto'] = $filename;
        }

        $guruStaff = GuruStaff::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil ditambahkan.',
            'data' => $guruStaff
        ]);
    }

    public function editData($id)
    {
        $guruStaff = GuruStaff::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $guruStaff
        ]);
    }

    public function update(Request $request, $id)
    {
        $guruStaff = GuruStaff::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tipe' => 'required|in:kepala_sekolah,wakil_kepala_sekolah,kepala_jurusan,guru,staff',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y'),
            'urutan' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('foto');
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($guruStaff->foto && Storage::exists('public/guru-staff/' . $guruStaff->foto)) {
                Storage::delete('public/guru-staff/' . $guruStaff->foto);
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/guru-staff', $filename);
            $data['foto'] = $filename;
        }

        $guruStaff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil diperbarui.',
            'data' => $guruStaff
        ]);
    }

    public function destroy($id)
    {
        $guruStaff = GuruStaff::findOrFail($id);
        
        // Delete foto if exists
        if ($guruStaff->foto && Storage::exists('public/guru-staff/' . $guruStaff->foto)) {
            Storage::delete('public/guru-staff/' . $guruStaff->foto);
        }
        
        $guruStaff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil dihapus.'
        ]);
    }

    public function updateUrutan(Request $request)
    {
        $urutan = $request->input('urutan', []);
        
        foreach ($urutan as $item) {
            GuruStaff::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan berhasil diperbarui.'
        ]);
    }

     /**
     * Get deskripsi halaman
     */
    public function getDeskripsi()
    {
        $deskripsi = GuruStaffDeskripsi::first();
        
        return response()->json([
            'success' => true,
            'data' => $deskripsi ? $deskripsi->deskripsi : ''
        ]);
    }
    
    /**
     * Store/update deskripsi
     */
    public function storeDeskripsi(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        $deskripsi = GuruStaffDeskripsi::first();
        
        if (!$deskripsi) {
            $deskripsi = new GuruStaffDeskripsi();
        }
        
        $deskripsi->deskripsi = $request->deskripsi;
        $deskripsi->save();

        return response()->json([
            'success' => true,
            'message' => 'Deskripsi berhasil diperbarui.',
            'data' => $deskripsi
        ]);
    }

    // Untuk pengaturan teks di atas
    public function getSettings()
    {
        $settings = [
            'guru_staff_description' => 'Sebuah tim pendidik yang berdedikasi untuk membentuk masa depan cerdas dan berkarakter.'
        ];
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function updateSettings(Request $request)
    {
        // Simpan ke database atau file config
        // Ini contoh sederhana, sesuaikan dengan kebutuhan
        $description = $request->input('description');
        
        // Simpan ke database jika ada model Settings
        // Atau ke file config
        
        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil diperbarui.'
        ]);
    }

}