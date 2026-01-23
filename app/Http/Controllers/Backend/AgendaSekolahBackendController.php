<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgendaSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgendaSekolahBackendController extends Controller
{
    public function index(Request $request)
    {
        $query = AgendaSekolah::query();

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } elseif ($request->status == 'draft') {
                $query->where('is_published', false);
            }
            // Hapus filter archived karena tidak ada soft delete
        }

        // Filter tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_selesai') && $request->tanggal_selesai != '') {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        // Statistik - hapus archived count
        $totalAgenda = AgendaSekolah::count();
        $publishedCount = AgendaSekolah::where('is_published', true)->count();
        $draftCount = AgendaSekolah::where('is_published', false)->count();

        $agenda = $query->orderBy('urutan')
                       ->orderBy('tanggal', 'desc')
                       ->paginate(20);

        return view('backend.agenda-sekolah.index', compact(
            'agenda',
            'totalAgenda',
            'publishedCount',
            'draftCount'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|date_format:H:i',
            'lokasi' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:7',
            'urutan' => 'nullable|integer',
            'is_published' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['tanggal'] = date('Y-m-d', strtotime($data['tanggal']));
            $data['bulan'] = date('M Y', strtotime($data['tanggal']));
            $data['hari'] = date('d', strtotime($data['tanggal']));
            
            if ($request->has('is_published') && $request->is_published) {
                $data['published_at'] = now();
            }

            $agenda = AgendaSekolah::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil ditambahkan',
                'data' => $agenda
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $agenda = AgendaSekolah::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $agenda
        ]);
    }

    public function update(Request $request, $id)
    {
        $agenda = AgendaSekolah::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|date_format:H:i',
            'lokasi' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:7',
            'urutan' => 'nullable|integer',
            'is_published' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['tanggal'] = date('Y-m-d', strtotime($data['tanggal']));
            $data['bulan'] = date('M Y', strtotime($data['tanggal']));
            $data['hari'] = date('d', strtotime($data['tanggal']));
            
            if ($request->has('is_published') && $request->is_published && !$agenda->published_at) {
                $data['published_at'] = now();
            } elseif (!$request->has('is_published') || !$request->is_published) {
                $data['published_at'] = null;
            }

            $agenda->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil diperbarui',
                'data' => $agenda
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $agenda = AgendaSekolah::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        try {
            $agenda->delete();

            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus($id, $status)
    {
        $agenda = AgendaSekolah::find($id);

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Agenda tidak ditemukan'
            ], 404);
        }

        try {
            if ($status === 'publish') {
                $agenda->update([
                    'is_published' => true,
                    'published_at' => now()
                ]);
                $message = 'Agenda berhasil dipublikasikan';
            } elseif ($status === 'draft') {
                $agenda->update([
                    'is_published' => false,
                    'published_at' => null
                ]);
                $message = 'Agenda berhasil diubah ke draft';
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $message
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
        $validator = Validator::make($request->all(), [
            'urutan' => 'required|array',
            'urutan.*.id' => 'required|exists:agenda_sekolah,id',
            'urutan.*.urutan' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            foreach ($request->urutan as $item) {
                AgendaSekolah::where('id', $item['id'])
                    ->update(['urutan' => $item['urutan']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan agenda berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}