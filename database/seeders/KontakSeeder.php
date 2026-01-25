<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run()
    {
        Kontak::create([
            'opening_paragraph' => 'SMK Wisata Indonesia menyambut Anda atas saran dan masukan yang berharga. Jangan ragu untuk menghubungi kami di alamat yang disebutkan di bawah ini.',
            'address' => "JL. Raya Lenteng Agung / Jl. Langgar\nRt. 009/003 No. 1, Kebagusan,\nPs. Minggu, Jakarta Selatan, 12520",
            'phone' => '(021) 78830761',
            'email' => 'smkwisataindonesia01@gmail.com',
            'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6338566938543!2d106.83336617402644!3d-6.31173736176519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69edee70aeb597%3A0x3c33aa85fd86d917!2sSMK%20WISATA%INDONESIA%20%7BSekolah%20Menengah%20Kejuruan%7D!5e0!3m2!1sid!2sid!4v1760179549082!5m2!1sid!2sid',
            'staff1_name' => 'Dewi Lestari, S.Pd.',
            'staff1_position' => 'Wakil Bid. Kesiswaan & Pembina Osis',
            'staff1_phone' => '+62 852-1815-0720',
            'staff1_email' => 'smkwisataindonesia01@gmail.com',
            'staff2_name' => 'Dewi Lestari, S.Pd.',
            'staff2_position' => 'Wakil Bid. Kesiswaan & Pembina Osis',
            'staff2_phone' => '+62 852-1815-0720',
            'staff2_email' => 'smkwisataindonesia01@gmail.com',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'hero_title' => 'Kontak',
        ]);
    }
}