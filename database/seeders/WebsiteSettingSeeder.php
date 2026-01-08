<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            'site_name' => 'SMK Wisata Indonesia',
            'site_tagline' => 'Membentuk Generasi Pariwisata Berkompeten',
            'site_description' => 'SMK Wisata Indonesia merupakan sekolah menengah kejuruan yang berfokus pada pengembangan kompetensi di bidang pariwisata, perhotelan, dan kuliner untuk menyiapkan generasi muda yang siap bersaing di era global.',
            'site_logo' => 'assets/img/logo-wistek.png',
            'site_email' => 'info@smkwisataindonesia.sch.id',
            'site_phone' => '(021) 1234-5678',
            'site_whatsapp' => '6281234567890',
            'site_address' => 'Jl. Pendidikan No. 123, Jakarta Pusat 10110',
            
            'facebook' => 'https://facebook.com/smkwisataindonesia',
            'instagram' => 'https://instagram.com/smkwisataindonesia',
            'youtube' => 'https://youtube.com/c/smkwisataindonesia',
            'tiktok' => 'https://tiktok.com/@smkwisataindonesia',
            
            'meta_title' => 'SMK Wisata Indonesia - Sekolah Unggulan Pariwisata',
            'meta_description' => 'SMK Wisata Indonesia adalah sekolah kejuruan bidang pariwisata terbaik dengan jurusan Perhotelan, Kuliner, dan Tata Boga yang telah terakreditasi A.',
            'meta_keywords' => 'smk wisata indonesia, sekolah pariwisata, perhotelan, kuliner, tata boga, jakarta, smk terbaik',
            
            'timezone' => 'Asia/Jakarta',
            'date_format' => 'd/m/Y',
            'time_format' => 'H:i',
            
            'headmaster_name' => 'Dr. Surya Adi, M.Pd',
            'headmaster_nip' => '196512151987031002',
            'headmaster_message' => 'Selamat datang di SMK Wisata Indonesia. Kami berkomitmen untuk menghasilkan lulusan yang kompeten, berkarakter, dan siap bersaing di industri pariwisata nasional maupun internasional.',
            
            'school_npsn' => '20236123',
            'school_nss' => '32121601001',
            'school_akreditation' => 'A (Unggul)',
            'school_operator_name' => 'Budi Santoso',
            'school_operator_email' => 'operator@smkwisataindonesia.sch.id',
        ];
        
        // Cek apakah data sudah ada
        if (!WebsiteSetting::count()) {
            WebsiteSetting::create($settings);
            $this->command->info('Website settings seeded successfully!');
        } else {
            $this->command->info('Website settings already exist. Skipping...');
        }
    }
}