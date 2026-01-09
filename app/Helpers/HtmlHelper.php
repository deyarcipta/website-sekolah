<?php

namespace App\Helpers;

class HtmlHelper
{
    /**
     * Membersihkan HTML dengan menjaga tag tertentu
     *
     * @param string $html
     * @return string
     */
    public static function cleanHtml($html)
    {
        // Daftar tag yang diizinkan (bisa disesuaikan)
        $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><table><thead><tbody><tr><th><td><blockquote><pre><code><a><img><span><div><hr><sup><sub><small><font><b><i>';
        
        // Bersihkan HTML
        $cleaned = strip_tags($html, $allowedTags);
        
        return $cleaned;
    }
    
    /**
     * Membersihkan HTML dengan validasi tambahan untuk link dan gambar
     *
     * @param string $html
     * @return string
     */
    public static function sanitizeHtml($html)
    {
        // Bersihkan tag dasar
        $allowedTags = '<p><br><strong><em><u><ul><ol><li><h1><h2><h3><h4><h5><h6><table><thead><tbody><tr><th><td><blockquote><pre><code><a><img>';
        $cleaned = strip_tags($html, $allowedTags);
        
        // Validasi dan sanitasi link
        $cleaned = preg_replace_callback('/<a[^>]*>/i', function($matches) {
            $tag = $matches[0];
            
            // Ekstrak href
            if (preg_match('/href\s*=\s*["\']([^"\']+)["\']/i', $tag, $hrefMatch)) {
                $href = trim($hrefMatch[1]);
                
                // Validasi URL
                if (filter_var($href, FILTER_VALIDATE_URL)) {
                    // Hanya izinkan http/https
                    if (strpos($href, 'http://') === 0 || strpos($href, 'https://') === 0) {
                        // Escape href dan tambahkan atribut keamanan
                        $href = e($href);
                        return '<a href="' . $href . '" target="_blank" rel="noopener noreferrer">';
                    }
                }
            }
            
            // Hapus tag jika tidak valid
            return '';
        }, $cleaned);
        
        // Tutup tag <a> yang tidak ditutup
        $cleaned = preg_replace('/<a[^>]*>(.*?)<\/a>/i', '<a href="#" target="_blank" rel="noopener noreferrer">$1</a>', $cleaned);
        
        return $cleaned;
    }
}