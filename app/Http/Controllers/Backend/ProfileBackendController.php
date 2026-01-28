<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileBackendController extends Controller
{
    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Custom validation for current password
        $validator->after(function ($validator) use ($request, $user) {
            if ($request->filled('password') && !Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('current_password', 'Password saat ini tidak sesuai.');
            }
        });
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // Update foto profil jika ada file baru
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && \Storage::disk('public')->exists($user->foto_profil)) {
                \Storage::disk('public')->delete($user->foto_profil);
            }
            
            $path = $request->file('foto_profil')->store('users/profiles', 'public');
            $data['foto_profil'] = $path;
        }
        
        $user->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}