<?php
// database/seeders/WebsiteStatisticsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteStatistic;

class WebsiteStatisticsSeeder extends Seeder
{
    public function run()
    {
        $statistics = [
            [
                'name' => 'pageview_hari_ini',
                'display_name' => 'Pageview Hari Ini',
                'category' => 'daily',
                'value' => 0,
                'unit' => 'views',
                'icon' => 'fas fa-eye',
                'color' => 'primary',
                'sort_order' => 1,
                'is_editable' => false,
                'is_auto_increment' => true,
                'description' => 'Jumlah halaman yang dilihat hari ini'
            ],
            [
                'name' => 'visitor_hari_ini',
                'display_name' => 'Visitor Hari Ini',
                'category' => 'daily',
                'value' => 0,
                'unit' => 'visitors',
                'icon' => 'fas fa-users',
                'color' => 'success',
                'sort_order' => 2,
                'is_editable' => false,
                'is_auto_increment' => true,
                'description' => 'Jumlah pengunjung unik hari ini'
            ],
            [
                'name' => 'visitor_bulan_ini',
                'display_name' => 'Visitor Bulan Ini',
                'category' => 'monthly',
                'value' => 0,
                'unit' => 'visitors',
                'icon' => 'fas fa-calendar-alt',
                'color' => 'info',
                'sort_order' => 3,
                'is_editable' => false,
                'is_auto_increment' => true,
                'description' => 'Jumlah pengunjung bulan ini'
            ],
            [
                'name' => 'total_visitor',
                'display_name' => 'Total Visitor',
                'category' => 'total',
                'value' => 0,
                'unit' => 'visitors',
                'icon' => 'fas fa-chart-line',
                'color' => 'warning',
                'sort_order' => 4,
                'is_editable' => false,
                'is_auto_increment' => true,
                'description' => 'Total pengunjung sejak awal'
            ],
            [
                'name' => 'avg_session_duration',
                'display_name' => 'Rata-rata Durasi Sesi',
                'category' => 'analytics',
                'value' => 0,
                'unit' => 'detik',
                'icon' => 'fas fa-clock',
                'color' => 'purple',
                'sort_order' => 5,
                'description' => 'Rata-rata durasi kunjungan'
            ],
            [
                'name' => 'bounce_rate',
                'display_name' => 'Bounce Rate',
                'category' => 'analytics',
                'value' => 0,
                'unit' => '%',
                'icon' => 'fas fa-chart-pie',
                'color' => 'danger',
                'sort_order' => 6,
                'description' => 'Persentase pengunjung yang langsung keluar'
            ]
        ];

        foreach ($statistics as $stat) {
            WebsiteStatistic::updateOrCreate(
                ['name' => $stat['name']],
                $stat
            );
        }
    }
}