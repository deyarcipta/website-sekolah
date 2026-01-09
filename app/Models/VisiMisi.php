<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi';
    
    protected $fillable = [
        'hero_title',
        'hero_background',
        'opening_paragraph',
        'card1_image',
        'card1_label',
        'card2_image',
        'card2_label',
        'card3_image',
        'card3_label',
        'visi_image',
        'visi_title',
        'visi_description',
        'visi_items',
        'misi_image',
        'misi_title',
        'misi_description',
        'misi_items',
    ];
    
    protected $casts = [
        'visi_items' => 'array',
        'misi_items' => 'array',
    ];
    
    /**
     * Accessor untuk visi_items
     */
    public function getVisiItemsAttribute($value)
    {
        // Jika sudah array, langsung return
        if (is_array($value)) {
            return $value;
        }
        
        // Jika null, return array kosong
        if (is_null($value)) {
            return [];
        }
        
        // Decode JSON
        $decoded = json_decode($value, true);
        
        // Jika decode berhasil, return hasil decode
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // Jika gagal decode, return array kosong
        return [];
    }
    
    /**
     * Accessor untuk misi_items
     */
    public function getMisiItemsAttribute($value)
    {
        // Jika sudah array, langsung return
        if (is_array($value)) {
            return $value;
        }
        
        // Jika null, return array kosong
        if (is_null($value)) {
            return [];
        }
        
        // Decode JSON
        $decoded = json_decode($value, true);
        
        // Jika decode berhasil, return hasil decode
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // Jika gagal decode, return array kosong
        return [];
    }
    
    /**
     * Get the default data if no record exists
     */
    public static function getData()
    {
        $data = self::first();
        
        if (!$data) {
            $data = self::createDefault();
        }
        
        return $data;
    }
    
    /**
     * Create default data
     */
    public static function createDefault()
    {
        return self::create([
            'hero_title' => 'Visi & Misi',
            'opening_paragraph' => 'Pendidikan di SMK Wisata Indonesia adalah tentang meningkatkan kemampuan keterampilan siswa yang dilandaskan dengan ide kreatif, unggul dan berakhlak mulia untuk mampu bersaing di dunia industri.',
            'card1_label' => 'Kreatif',
            'card2_label' => 'Unggul',
            'card3_label' => 'Berakhlak Mulia',
            'visi_title' => 'Visi Kami',
            'visi_description' => 'SMK Wisata Indonesia diharapkan menjadi lembaga pendidikan dan pelatihan yang berwawasan global dan menghasilkan tamatan yang unggul di bidangnya dengan dilandasi akhlak mulia.',
            'visi_items' => json_encode([
                'Menghasilkan lulusan yang terampil, profesional, dan siap kerja.',
                'Membekali siswa dengan wawasan internasional dan kemampuan bahasa asing.',
                'Menanamkan karakter positif agar menjadi pribadi berintegritas.',
                'Menjadi sekolah rujukan di bidang pariwisata dan perhotelan berstandar global.',
                'Menjalin kemitraan luas dengan dunia usaha dan dunia industri (DUDI).'
            ]),
            'misi_title' => 'Misi Kami',
            'misi_description' => 'SMK Wisata Indonesia memiliki misi untuk mendukung pengembangan potensi peserta didik agar menjadi tenaga kerja profesional dan berdaya saing global.',
            'misi_items' => json_encode([
                'Meningkatkan kompetensi peserta didik di bidang pariwisata dan perhotelan.',
                'Mengintegrasikan kurikulum dengan kebutuhan dunia industri (DUDI).',
                'Meningkatkan penguasaan bahasa asing dan teknologi informasi.',
                'Membangun karakter, etos kerja, dan tanggung jawab sosial.'
            ]),
        ]);
    }
    
    /**
     * Get hero background URL
     */
    public function getHeroBackgroundUrl()
    {
        return $this->hero_background ? asset('storage/' . $this->hero_background) : asset('assets/img/foto-gedung.png');
    }
    
    /**
     * Get card image URL
     */
    public function getCardImageUrl($cardNumber)
    {
        $imageField = "card{$cardNumber}_image";
        $defaultImage = "assets/img/card{$cardNumber}.png";
        
        return $this->$imageField ? asset('storage/' . $this->$imageField) : asset($defaultImage);
    }
    
    /**
     * Get visi image URL
     */
    public function getVisiImageUrl()
    {
        return $this->visi_image ? asset('storage/' . $this->visi_image) : asset('assets/img/visi&misi.png');
    }
    
    /**
     * Get misi image URL
     */
    public function getMisiImageUrl()
    {
        return $this->misi_image ? asset('storage/' . $this->misi_image) : asset('assets/img/visi&misi.png');
    }
}