<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\MajorTeacher;
use App\Models\MajorAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MajorBackendController extends Controller
{
    // Index - List all majors
    public function index()
    {
        $majors = Major::orderBy('order')->get();
        return view('backend.majors.index', compact('majors'));
    }

    // Create form
    public function create()
    {
        return view('backend.majors.create');
    }

    // Store new major
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:majors',
            'short_name' => 'nullable|string|max:100',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only([
                'name', 'short_name', 'description', 'hero_title', 
                'hero_subtitle', 'is_active', 'order'
            ]);

            // Generate slug
            $data['slug'] = Major::generateSlug($request->name);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('majors/logos', 'public');
                $data['logo'] = $logoPath;
            }

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                $heroPath = $request->file('hero_image')->store('majors/heroes', 'public');
                $data['hero_image'] = $heroPath;
            }

            $major = Major::create($data);

            return redirect()->route('backend.majors.edit', $major->id)
                ->with('success', 'Jurusan berhasil dibuat! Sekarang Anda bisa melengkapi detail lainnya.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Edit form
    public function edit($id)
    {
        $major = Major::with(['teachers', 'achievements'])->findOrFail($id);
        return view('backend.majors.edit', compact('major'));
    }

    // Update major
public function update(Request $request, $id)
{
    $major = Major::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:majors,name,' . $id,
        'short_name' => 'nullable|string|max:100',
        'description' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'hero_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        'hero_title' => 'nullable|string|max:255',
        'hero_subtitle' => 'nullable|string',
        'overview_title' => 'nullable|string|max:255',
        'overview_content' => 'nullable|string',
        'overview_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'vision' => 'nullable|string',
        'mission' => 'nullable|string',
        'vision_mission_title' => 'nullable|string|max:255',
        'vision_mission_content' => 'nullable|string',
        'vision_mission_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'quote' => 'nullable|string',
        'quote_author' => 'nullable|string|max:255',
        'quote_position' => 'nullable|string|max:255',
        'learning_title' => 'nullable|string|max:255',
        'learning_content' => 'nullable|string',
        'learning_items' => 'nullable|array',
        'learning_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'teachers_title' => 'nullable|string|max:255',
        'teachers_content' => 'nullable|string',
        'achievements_title' => 'nullable|string|max:255',
        'achievements_content' => 'nullable|string',
        'achievement_items' => 'nullable|array',
        'accordion_items' => 'nullable|array',
        'accordion_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // TAMBAHKAN VALIDASI INI
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'is_active' => 'boolean',
        'order' => 'integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Validasi gagal!'
        ], 422);
    }

    try {
        $data = $request->except([
            'logo', 
            'hero_image', 
            'overview_image', 
            'vision_mission_image', 
            'learning_image',
            'accordion_image' // TAMBAHKAN INI DI EXCEPT
        ]);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($major->logo) {
                Storage::disk('public')->delete($major->logo);
            }
            $logoPath = $request->file('logo')->store('majors/logos', 'public');
            $data['logo'] = $logoPath;
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            if ($major->hero_image) {
                Storage::disk('public')->delete($major->hero_image);
            }
            $heroPath = $request->file('hero_image')->store('majors/heroes', 'public');
            $data['hero_image'] = $heroPath;
        }

        // Handle overview image upload
        if ($request->hasFile('overview_image')) {
            if ($major->overview_image) {
                Storage::disk('public')->delete($major->overview_image);
            }
            $overviewPath = $request->file('overview_image')->store('majors/overviews', 'public');
            $data['overview_image'] = $overviewPath;
        }

        // Handle vision mission image upload
        if ($request->hasFile('vision_mission_image')) {
            if ($major->vision_mission_image) {
                Storage::disk('public')->delete($major->vision_mission_image);
            }
            $vmPath = $request->file('vision_mission_image')->store('majors/vision-mission', 'public');
            $data['vision_mission_image'] = $vmPath;
        }

        // Handle learning image upload
        if ($request->hasFile('learning_image')) {
            if ($major->learning_image) {
                Storage::disk('public')->delete($major->learning_image);
            }
            $learningPath = $request->file('learning_image')->store('majors/learning', 'public');
            $data['learning_image'] = $learningPath;
        }

        // ========== TAMBAHKAN KODE INI UNTUK accordion_image ==========
        // Handle accordion image upload
        if ($request->hasFile('accordion_image')) {
            // Hapus gambar accordion lama jika ada
            if ($major->accordion_image) {
                Storage::disk('public')->delete($major->accordion_image);
            }
            $accordionPath = $request->file('accordion_image')->store('majors/accordion', 'public');
            $data['accordion_image'] = $accordionPath;
        }
        // ===============================================================

        // Process JSON arrays
        $data['learning_items'] = $request->learning_items ?: [];
        $data['achievement_items'] = $request->achievement_items ?: [];
        $data['accordion_items'] = $request->accordion_items ?: [];

        $major->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data jurusan berhasil diperbarui!',
            'redirect' => route('backend.majors.index')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

    // Delete major
    public function destroy($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            // Delete associated files
            if ($major->logo) Storage::disk('public')->delete($major->logo);
            if ($major->hero_image) Storage::disk('public')->delete($major->hero_image);
            if ($major->overview_image) Storage::disk('public')->delete($major->overview_image);
            if ($major->vision_mission_image) Storage::disk('public')->delete($major->vision_mission_image);
            if ($major->learning_image) Storage::disk('public')->delete($major->learning_image);
            
            // Delete associated teachers and achievements
            $major->teachers()->delete();
            $major->achievements()->delete();
            
            $major->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jurusan berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Manage Teachers
    public function manageTeachers($id)
    {
        $major = Major::findOrFail($id);
        $teachers = $major->teachers;
        return view('backend.majors.teachers', compact('major', 'teachers'));
    }

    public function storeTeacher(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('majors/teachers', 'public');
                $data['image'] = $imagePath;
            }

            $data['major_id'] = $id;
            $teacher = MajorTeacher::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Pengajar berhasil ditambahkan!',
                'teacher' => $teacher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateTeacher(Request $request, $teacherId)
    {
        $teacher = MajorTeacher::findOrFail($teacherId);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                // Delete old image
                if ($teacher->image) {
                    Storage::disk('public')->delete($teacher->image);
                }
                $imagePath = $request->file('image')->store('majors/teachers', 'public');
                $data['image'] = $imagePath;
            }

            $teacher->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Pengajar berhasil diperbarui!',
                'teacher' => $teacher
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyTeacher($teacherId)
    {
        try {
            $teacher = MajorTeacher::findOrFail($teacherId);
            
            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }
            
            $teacher->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengajar berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorderTeachers(Request $request, $id)
    {
        try {
            $major = Major::findOrFail($id);
            
            foreach ($request->orders as $order) {
                $teacher = MajorTeacher::find($order['id']);
                if ($teacher && $teacher->major_id == $id) {
                    $teacher->order = $order['order'];
                    $teacher->save();
                }
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Manage Achievements
    public function manageAchievements($id)
    {
        $major = Major::findOrFail($id);
        $achievements = $major->achievements;
        return view('backend.majors.achievements', compact('major', 'achievements'));
    }

    public function storeAchievement(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'level' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('majors/achievements', 'public');
                $data['image'] = $imagePath;
            }

            $data['major_id'] = $id;
            $achievement = MajorAchievement::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil ditambahkan!',
                'achievement' => $achievement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAchievement(Request $request, $achievementId)
    {
        $achievement = MajorAchievement::findOrFail($achievementId);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
            'level' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                // Delete old image
                if ($achievement->image) {
                    Storage::disk('public')->delete($achievement->image);
                }
                $imagePath = $request->file('image')->store('majors/achievements', 'public');
                $data['image'] = $imagePath;
            }

            $achievement->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil diperbarui!',
                'achievement' => $achievement
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyAchievement($achievementId)
    {
        try {
            $achievement = MajorAchievement::findOrFail($achievementId);
            
            if ($achievement->image) {
                Storage::disk('public')->delete($achievement->image);
            }
            
            $achievement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prestasi berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Achievements Management
    public function reorderAchievements(Request $request, $id)
    {
        try {
            $major = Major::findOrFail($id);
            
            foreach ($request->orders as $order) {
                $achievement = MajorAchievement::find($order['id']);
                if ($achievement && $achievement->major_id == $id) {
                    $achievement->order = $order['order'];
                    $achievement->save();
                }
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Remove Image Functions
    public function removeLogo($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            if ($major->logo) {
                Storage::disk('public')->delete($major->logo);
                $major->logo = null;
                $major->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logo berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeHeroImage($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            if ($major->hero_image) {
                Storage::disk('public')->delete($major->hero_image);
                $major->hero_image = null;
                $major->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar hero berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeOverviewImage($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            if ($major->overview_image) {
                Storage::disk('public')->delete($major->overview_image);
                $major->overview_image = null;
                $major->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar overview berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeVisionMissionImage($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            if ($major->vision_mission_image) {
                Storage::disk('public')->delete($major->vision_mission_image);
                $major->vision_mission_image = null;
                $major->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar visi misi berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeLearningImage($id)
    {
        try {
            $major = Major::findOrFail($id);
            
            if ($major->learning_image) {
                Storage::disk('public')->delete($major->learning_image);
                $major->learning_image = null;
                $major->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar pembelajaran berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}