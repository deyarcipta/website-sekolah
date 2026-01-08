<!-- Footer -->
<footer class="footer-section text-center py-3">
  <div class="container">
    <span>
      &copy; {{ date('Y') }} <strong>{{ $settings->site_name }}</strong> |
      Website ini dibuat oleh <strong class="text-purple">Jurusan TJKT</strong> 
      untuk mendukung <em>Digitalisasi Sekolah</em>.
    </span>
  </div>
</footer>

<!-- CSS -->
<style>
.footer-section {
  background-color: #ffffff;
  color: #333333;
  border-top: 2px solid #6b02b133; /* garis atas ungu transparan */
  font-size: 0.95rem;
  letter-spacing: 0.3px;
}

.footer-section strong {
  color: #000;
  font-weight: 600;
}

.footer-section .text-purple {
  color: #6B02B1; /* warna khas TJKT */
}

.footer-section em {
  color: #555;
  font-style: normal;
  font-weight: 500;
}
</style>
