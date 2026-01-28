<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter status aktif
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Urutkan
        $query->orderBy('created_at', 'desc');

        // Role options untuk filter
        $roleOptions = [
            'admin' => 'Administrator',
            'superadmin' => 'Super Administrator',
        ];

        $users = $query->paginate(20)->withQueryString();

        // Tambahkan computed properties ke setiap user
        $users->getCollection()->transform(function ($user) use ($roleOptions) {
            $user->initials = substr($user->name, 0, 2);
            $user->role_color = $user->role === 'superadmin' ? 'danger' : 'primary';
            $user->foto_profil_url = $user->foto_profil ? 
                Storage::disk('public')->url($user->foto_profil) : null;
            return $user;
        });

        return view('backend.users.index', compact('users', 'roleOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'success' => true,
            'roleOptions' => $this->getRoleOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,superadmin',
            'is_active' => 'sometimes|boolean',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->boolean('is_active'),
            ];

            // Upload foto profil jika ada
            if ($request->hasFile('foto_profil')) {
                $path = $request->file('foto_profil')->store('users/profiles', 'public');
                $data['foto_profil'] = $path;
            }

            $user = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Tambahkan URL foto jika ada
            if ($user->foto_profil) {
                $user->foto_profil_url = Storage::disk('public')->url($user->foto_profil);
            }
            
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        try {
            $user = User::findOrFail($id);
            
            // Validasi untuk update
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required|in:admin,superadmin',
                'is_active' => 'sometimes|boolean',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'email.unique' => 'Email sudah digunakan oleh user lain.',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Update data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->is_active = $request->boolean('is_active');
            
            // Update password HANYA jika diisi
            if ($request->filled('password') && trim($request->password) !== '') {
                $user->password = Hash::make($request->password);
            }
            
            // Handle foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
                
                // Simpan foto baru
                $path = $request->file('foto_profil')->store('users/profiles', 'public');
                $user->foto_profil = $path;
            } elseif ($request->has('remove_foto') && $request->remove_foto == '1') {
                // Hapus foto jika ada tombol hapus
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                    $user->foto_profil = null;
                }
            }
            
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui!',
                'data' => $user
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Cegah penghapusan user sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus akun sendiri'
                ], 422);
            }
            
            // Hapus foto profil jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status aktif user
     */
    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Cegah nonaktifkan diri sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menonaktifkan akun sendiri'
                ], 422);
            }
            
            $user->update([
                'is_active' => $user->is_active ? 0 : 1
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'data' => $user
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah status'
            ], 500);
        }
    }

    /**
     * Check email availability
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'user_id' => 'nullable|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'available' => false
            ]);
        }

        $query = User::where('email', $request->email);
        
        // Jika ada user_id (untuk edit), exclude user tersebut
        if ($request->filled('user_id')) {
            $query->where('id', '!=', $request->user_id);
        }
        
        $exists = $query->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }

    /**
     * Get role options with labels
     */
    private function getRoleOptions()
    {
        return [
            'admin' => [
                'label' => 'Administrator',
                'color' => 'primary',
                'description' => 'Akses administrasi sistem'
            ],
            'superadmin' => [
                'label' => 'Super Administrator',
                'color' => 'danger',
                'description' => 'Akses penuh ke semua fitur sistem'
            ],
        ];
    }
}