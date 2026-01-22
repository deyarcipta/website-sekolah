<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementBackendController extends Controller
{
    // Tampilkan daftar pengumuman
    public function index()
    {
        $announcements = Announcement::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $types = [
            'info' => 'Info',
            'warning' => 'Peringatan',
            'danger' => 'Bahaya',
            'success' => 'Sukses',
            'primary' => 'Utama',
        ];

        $statuses = [
            'draft' => 'Draft',
            'active' => 'Aktif',
            'inactive' => 'Non-Aktif',
        ];

        $modalPositions = [
            'center' => 'Tengah',
            'top' => 'Atas',
            'top-right' => 'Atas Kanan',
            'top-left' => 'Atas Kiri',
            'bottom' => 'Bawah',
            'bottom-right' => 'Bawah Kanan',
            'bottom-left' => 'Bawah Kiri',
        ];

        $animations = [
            'fade' => 'Fade',
            'slide' => 'Slide',
            'zoom' => 'Zoom',
            'bounce' => 'Bounce',
        ];

        return view('backend.announcements.index', compact(
            'announcements',
            'types',
            'statuses',
            'modalPositions',
            'animations'
        ));
    }

    // Simpan pengumuman baru
    // Simpan pengumuman baru
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'type' => 'required|in:info,warning,danger,success,primary',
        'status' => 'required|in:draft,active,inactive',
        'show_on_frontend' => 'boolean',
        'show_as_modal' => 'boolean',
        'modal_show_once' => 'boolean',
        'modal_width' => 'nullable|integer|min:100|max:1200',
        'sort_order' => 'nullable|integer',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        DB::beginTransaction();

        $data = $request->only([
            'title', 'content', 'type', 'status',
            'show_on_frontend', 'show_as_modal', 'modal_show_once',
            'modal_width', 'sort_order', 'start_date', 'end_date'
        ]);

        // Konversi checkbox values
        $data['show_on_frontend'] = $request->boolean('show_on_frontend');
        $data['show_as_modal'] = $request->boolean('show_as_modal');
        $data['modal_show_once'] = $request->boolean('modal_show_once');

        // Modal settings - sebagai array
        $modalSettings = [
            'position' => $request->input('modal_position', 'center'),
            'animation' => $request->input('modal_animation', 'fade'),
            'backdrop' => $request->boolean('modal_backdrop'),
            'keyboard' => $request->boolean('modal_keyboard'),
            'close_button' => $request->boolean('modal_close_button'),
        ];
        $data['modal_settings'] = $modalSettings; // Langsung array, akan dicast otomatis

        $announcement = Announcement::create($data);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil ditambahkan!',
            'data' => $announcement->fresh() // Ambil data fresh dengan accessor
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

// Update pengumuman
public function update(Request $request, $id)
{
    $announcement = Announcement::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'type' => 'required|in:info,warning,danger,success,primary',
        'status' => 'required|in:draft,active,inactive',
        'show_on_frontend' => 'boolean',
        'show_as_modal' => 'boolean',
        'modal_show_once' => 'boolean',
        'modal_width' => 'nullable|integer|min:100|max:1200',
        'sort_order' => 'nullable|integer',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        DB::beginTransaction();

        $data = $request->only([
            'title', 'content', 'type', 'status',
            'show_on_frontend', 'show_as_modal', 'modal_show_once',
            'modal_width', 'sort_order', 'start_date', 'end_date'
        ]);

        // Konversi checkbox values
        $data['show_on_frontend'] = $request->boolean('show_on_frontend');
        $data['show_as_modal'] = $request->boolean('show_as_modal');
        $data['modal_show_once'] = $request->boolean('modal_show_once');

        // Modal settings - sebagai array
        $modalSettings = [
            'position' => $request->input('modal_position', 'center'),
            'animation' => $request->input('modal_animation', 'fade'),
            'backdrop' => $request->boolean('modal_backdrop'),
            'keyboard' => $request->boolean('modal_keyboard'),
            'close_button' => $request->boolean('modal_close_button'),
        ];
        $data['modal_settings'] = $modalSettings; // Langsung array, akan dicast otomatis

        $announcement->update($data);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diperbarui!',
            'data' => $announcement->fresh() // Ambil data fresh dengan accessor
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

    // Ambil data untuk edit
    public function editData($id)
    {
        try {
            $announcement = Announcement::find($id);
            
            if (!$announcement) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $announcement
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Hapus pengumuman
    public function destroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);
            $announcement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update urutan
    public function updateUrutan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'urutan' => 'required|array',
            'urutan.*.id' => 'required|exists:announcements,id',
            'urutan.*.urutan' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        }

        try {
            DB::beginTransaction();

            foreach ($request->urutan as $item) {
                Announcement::where('id', $item['id'])
                    ->update(['sort_order' => $item['urutan']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan pengumuman berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = 'announcement_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Simpan file di storage/app/public/announcements
                $path = $file->storeAs('public/announcements', $fileName);
                
                // Generate URL untuk akses file
                $url = Storage::url($path);
                
                // Format response sesuai yang diharapkan TinyMCE
                return response()->json([
                    'location' => asset($url) // Menggunakan asset() untuk URL lengkap
                ]);
            }
            
            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}