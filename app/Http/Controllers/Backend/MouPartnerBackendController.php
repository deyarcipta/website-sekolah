<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MouPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MouPartnerBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = MouPartner::orderBy('sort_order')->get();
        
        // Untuk dropdown options
        $partnerTypes = $this->getPartnerTypes();
        $statuses = $this->getStatuses();
        
        return view('backend.mou-partners.index', compact('partners', 'partnerTypes', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255|unique:mou_partners',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'contact_person' => 'nullable|string|max:100',
            'contact_position' => 'nullable|string|max:100',
            'partner_type' => 'required|in:corporate,government,education,community,other',
            'status' => 'required|in:active,inactive,draft',
            'mou_date' => 'nullable|date',
            'mou_expired_date' => 'nullable|date|after_or_equal:mou_date',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('logo');
            $data['slug'] = Str::slug($request->company_name);
            
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('mou-logos', 'public');
                $data['logo'] = $logoPath;
            }
            
            $partner = MouPartner::create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Mitra kerjasama berhasil ditambahkan.',
                'data' => [
                    'id' => $partner->id,
                    'company_name' => $partner->company_name,
                    'logo_url' => $partner->logo_url,
                    'partner_type' => $partner->partner_type,
                    'status' => $partner->status,
                    'mou_date' => $partner->mou_date ? $partner->mou_date->format('d/m/Y') : null,
                    'mou_expired_date' => $partner->mou_expired_date ? $partner->mou_expired_date->format('d/m/Y') : null,
                    'mou_status' => $partner->mou_status,
                    'sort_order' => $partner->sort_order,
                    'website' => $partner->website
                ]
            ]);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for editing.
     */
    public function editData($id)
{
    try {
        \Log::info('editData called for ID: ' . $id);
        
        $partner = MouPartner::find($id);
        
        if (!$partner) {
            \Log::warning('Partner not found for ID: ' . $id);
            
            return response()->json([
                'success' => false,
                'message' => 'Mitra tidak ditemukan dengan ID: ' . $id
            ], 404);
        }
        
        \Log::info('Partner found: ' . $partner->company_name);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $partner->id,
                'company_name' => $partner->company_name,
                'description' => $partner->description,
                'website' => $partner->website,
                'email' => $partner->email,
                'phone' => $partner->phone,
                'address' => $partner->address,
                'contact_person' => $partner->contact_person,
                'contact_position' => $partner->contact_position,
                'partner_type' => $partner->partner_type,
                'status' => $partner->status,
                'mou_date' => $partner->mou_date ? $partner->mou_date->format('Y-m-d') : null,
                'mou_expired_date' => $partner->mou_expired_date ? $partner->mou_expired_date->format('Y-m-d') : null,
                'sort_order' => $partner->sort_order,
                'logo_url' => $partner->logo_url
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error in editData: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $partner = MouPartner::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255|unique:mou_partners,company_name,' . $id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'contact_person' => 'nullable|string|max:100',
            'contact_position' => 'nullable|string|max:100',
            'partner_type' => 'required|in:corporate,government,education,community,other',
            'status' => 'required|in:active,inactive,draft',
            'mou_date' => 'nullable|date',
            'mou_expired_date' => 'nullable|date|after_or_equal:mou_date',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('logo');
            
            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                    Storage::disk('public')->delete($partner->logo);
                }
                
                $logoPath = $request->file('logo')->store('mou-logos', 'public');
                $data['logo'] = $logoPath;
            }
            
            $partner->update($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Mitra kerjasama berhasil diperbarui.',
                'data' => [
                    'id' => $partner->id,
                    'company_name' => $partner->company_name,
                    'logo_url' => $partner->logo_url,
                    'partner_type' => $partner->partner_type,
                    'status' => $partner->status,
                    'mou_date' => $partner->mou_date ? $partner->mou_date->format('d/m/Y') : null,
                    'mou_expired_date' => $partner->mou_expired_date ? $partner->mou_expired_date->format('d/m/Y') : null,
                    'mou_status' => $partner->mou_status,
                    'sort_order' => $partner->sort_order,
                    'website' => $partner->website
                ]
            ]);
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $partner = MouPartner::findOrFail($id);
            
            // Delete logo if exists
            if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            
            $partner->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Mitra kerjasama berhasil dihapus.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update urutan mitra.
     */
    public function updateUrutan(Request $request)
    {
        try {
            foreach ($request->urutan as $urutanData) {
                MouPartner::where('id', $urutanData['id'])->update(['sort_order' => $urutanData['urutan']]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan mitra berhasil diperbarui.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get partner types for dropdown.
     */
    private function getPartnerTypes()
    {
        return [
            'corporate' => 'Perusahaan',
            'government' => 'Pemerintah',
            'education' => 'Pendidikan',
            'community' => 'Komunitas',
            'other' => 'Lainnya'
        ];
    }

    /**
     * Get statuses for dropdown.
     */
    private function getStatuses()
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Non-Aktif',
            'draft' => 'Draft'
        ];
    }
}