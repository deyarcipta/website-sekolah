@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
<section id="hero" class="pd-top-100 pd-bottom-100 d-flex align-items-center">
  <div class="container">
    <div class="img-mockup">
      <img src="{{ asset('assets/img/rectangle.svg') }}" alt="Rectangle Image" class="img-custom" />
    </div>
    <div class="row">
      <div class="col-md-6 .col-lg-6 d-flex flex-column justify-content-center">
        <div class="hero-text">
          <h1>Selamat Datang di <br>{{ $settings->site_name }}</h1>
          <p>{{ $settings->site_tagline }}</p>
          <a href="https://ppdb.smkwisataindonesia.sch.id/" target="_blank" class="btn btn-join-now">Join Now</a>
        </div>
      </div>
      <div class="col-md-6 .col-lg-6 d-flex flex-column justify-content-center">
        <div class="hero-imgs">
          <img src="{{ asset($settings->hero_image) }}" alt="Hero Image" class="w-100 h-100" style="object-fit: cover;" />
        </div>
      </div>
    </div>
  </div>
</section>

<section id="alasan" class="pd-top-50 pd-bottom-50">
  <div class="container">
    <div class="section-title text-center">
      <h1>Kenapa harus wistin ?</h1>
      <p>Alasan kenapa kalian harus bergabung bersama kami</p>
    </div>
    <div class="row">
  @foreach ($keunggulan as $item)
    <div class="col-md-3 mb-3">
      <div class="card h-100 custom-card text-center">
        <div class="card-body">
          
          @php
              // Default color jika tidak ada
              $warna = $item->warna ?? '#0d6efd';
              
              // Jika warna dalam format hex, konversi ke rgba dengan opacity
              if (str_starts_with($warna, '#')) {
                  // Hapus tanda #
                  $hex = str_replace('#', '', $warna);
                  
                  // Konversi hex ke rgb
                  if(strlen($hex) == 3) {
                      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
                  } else {
                      $r = hexdec(substr($hex,0,2));
                      $g = hexdec(substr($hex,2,2));
                      $b = hexdec(substr($hex,4,2));
                  }
                  
                  $bgColor = "rgba($r, $g, $b, 0.15)";
              } else {
                  // Jika bukan hex, gunakan warna asli dengan opacity
                  $bgColor = $warna . '22'; // Hex dengan opacity 15% (22 dalam hex)
              }
          @endphp
          
          <div class="icon-wrapper mb-3" 
              style="background-color: {{ $bgColor }};
                      width: 70px; 
                      height: 70px; 
                      border-radius: 15%; 
                      display: flex; 
                      align-items: center; 
                      justify-content: center; 
                      margin: 0 auto;">
            <i class="{{ $item->icon }} fa-2x"
              style="color: {{ $warna }}"></i>
          </div>
          
          <h5 class="card-title">{{ $item->judul }}</h5>
          <p class="card-text">{!! $item->deskripsi !!}</p>
          
        </div>
      </div>
    </div>
  @endforeach
</div>

  </div>
</section>

<section id="programs-card">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Program Keahlian</h2>
            <h1>Konsentrasi Keahlian</h1>
            <hr class="mx-auto">
        </div>
        <div class="row">
            @foreach($majors as $major)
            <div class="col-md-4 mb-4">
                <div class="card h-100 custom-card text-center">
                    @if($major->logo)
                    <img src="{{ asset('storage/' . $major->logo) }}" class="card-img-top mx-auto d-block" alt="{{ $major->name }}" style="max-width: 150px; height: 150px; object-fit: contain;">
                    @else
                    <!-- Fallback images berdasarkan nama jurusan -->
                    @php
                        $fallbackLogos = [
                            'Kuliner' => 'assets/img/kuliner.png',
                            'Perhotelan' => 'assets/img/perhotelan.png',
                            'Teknik Komputer dan Jaringan' => 'assets/img/tkj.png'
                        ];
                        $fallbackLogo = $fallbackLogos[$major->name] ?? 'assets/img/default.png';
                    @endphp
                    <img src="{{ asset($fallbackLogo) }}" class="card-img-top mx-auto d-block" alt="{{ $major->name }}" style="max-width: 150px; height: 150px; object-fit: contain;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $major->name }}</h5>
                        @if($major->short_name)
                        <p class="text-muted">{{ $major->short_name }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="programs">
    <div class="container">
        @foreach($majors as $index => $major)
        <div class="row gx-md-5 gx-3 gy-4 mb-5 align-items-center">
            <!-- Teks di kiri untuk index genap (0, 2, 4...), di kanan untuk index ganjil (1, 3, 5...) -->
            <div class="col-md-6 @if($index % 2 == 1) order-md-2 @endif">
                <h1>{{ $major->name }}</h1>
                <p>{{ $major->description }}</p>
                
                @if($major->accordion_items && count($major->accordion_items) > 0)
                <div class="accordion" id="accordionExample{{ $index }}">
                    @foreach($major->accordion_items as $accordionIndex => $item)
                    @php
                        if (is_array($item)) {
                            $itemTitle = $item['title'] ?? 'Item';
                            $itemContent = $item['content'] ?? 'Content not available';
                            $itemIcon = $item['icon'] ?? 'fas fa-cog';
                        } else {
                            $itemTitle = $item;
                            $itemContent = 'Content for ' . $item;
                            $itemIcon = 'fas fa-cog';
                        }
                    @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $accordionIndex }}{{ $index }}">
                            <button class="accordion-button {{ $accordionIndex === 0 ? '' : 'collapsed' }}" 
                                    type="button" 
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $accordionIndex }}{{ $index }}" 
                                    aria-expanded="{{ $accordionIndex === 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $accordionIndex }}{{ $index }}">
                                <i class="{{ $itemIcon }} me-2 text-danger custom-icon"></i>
                                {{ $itemTitle }}
                            </button>
                        </h2>
                        <div id="collapse{{ $accordionIndex }}{{ $index }}" 
                             class="accordion-collapse collapse {{ $accordionIndex === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $accordionIndex }}{{ $index }}" 
                             data-bs-parent="#accordionExample{{ $index }}">
                            <div class="accordion-body">
                                {{ $itemContent }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Info jika tidak ada data accordion -->
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-3 fs-4"></i>
                    <div>
                        <strong>Data materi pembelajaran belum tersedia</strong>
                        <p class="mb-0 small">Admin akan segera mengupload data untuk jurusan ini.</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Gambar di kanan untuk index genap, di kiri untuk index ganjil -->
            <div class="col-md-6 @if($index % 2 == 1) order-md-1 @endif">
                <div class="position-relative">
                    @if($major->accordion_image)
                    <img src="{{ asset('storage/' . $major->accordion_image) }}" alt="{{ $major->name }}" class="img-fluid rounded shadow">
                    @elseif($major->overview_image)
                    <img src="{{ asset('storage/' . $major->overview_image) }}" alt="{{ $major->name }}" class="img-fluid rounded shadow">
                    @elseif($major->hero_image)
                    <img src="{{ asset('storage/' . $major->hero_image) }}" alt="{{ $major->name }}" class="img-fluid rounded shadow">
                    @else
                    <!-- Info jika tidak ada gambar -->
                    <div class="border rounded p-4 text-center bg-light">
                        <div class="mb-3">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted mb-2">Gambar Belum Diupload</h5>
                        <p class="text-muted small mb-0">
                            Gambar untuk jurusan {{ $major->name }} akan segera diupload oleh admin.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section id="konten-utama">
  <div class="container">
    <div class="row">
      <!-- Section Berita Sekolah (8 kolom) -->
      <div class="col-md-8 mb-4 mb-md-0">
          <section id="berita-sekolah" class="p-4 bg-light rounded">
              <h1 class="mb-3">Berita Sekolah</h1>
              <hr class="garis">
              
              @if($berita->count() > 0)
                  <div class="row">
                      @foreach($berita as $item)
                          <div class="col-md-6 mb-3">
                              <a href="{{ route('detail-informasi.show', $item->slug) }}">
                                  <div class="card berita-card text-white mb-3">
                                      <div class="berita-img" 
                                          style="background-image: url('{{ $item->gambar_thumbnail ? asset('storage/' . $item->gambar_thumbnail) : ($item->gambar ? asset('storage/' . $item->gambar) : asset('assets/img/default-news.jpg')) }}'); 
                                                  background-size: cover; 
                                                  background-position: center;
                                                  height: 250px;
                                                  position: relative;">
                                          <div class="berita-overlay d-flex align-items-end p-3" 
                                              style="position: absolute; 
                                                      bottom: 0; 
                                                      left: 0; 
                                                      right: 0; 
                                                      background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                                              <div>
                                                  <!-- Kategori Badge -->
                                                  @if($item->kategori)
                                                      <span class="badge bg-primary mb-2">
                                                          {{ $item->kategori->nama }}
                                                      </span>
                                                  @endif
                                                  
                                                  <h5 class="card-title mb-1" style="font-size: 1.1rem; line-height: 1.4;">
                                                      {{ Str::limit($item->judul, 60) }}
                                                  </h5>
                                                  
                                                  <div class="d-flex justify-content-between align-items-center mt-2">
                                                      <small class="text-white-50">
                                                          <i class="fas fa-calendar-alt me-1"></i>
                                                          {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}
                                                      </small>
                                                      <small class="text-white-50">
                                                          <i class="fas fa-eye me-1"></i> {{ $item->views }}
                                                      </small>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </a>
                          </div>
                      @endforeach
                  </div>
                  
              @else
                  <div class="text-center py-5">
                      <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                      <h5 class="text-muted">Belum ada berita</h5>
                      <p class="text-muted">Berita akan segera ditambahkan</p>
                  </div>
              @endif
              
              <a href="{{ route('detail-informasi.index') }}" class="btn all-berita">Lihat Semua Berita</a>
          </section>
      </div>

      <!-- Section Agenda Sekolah (4 kolom) -->
      <div class="col-md-4">
          <section id="agenda-sekolah" class="p-4 bg-white border rounded h-100">
              <h1 class="mb-3">Agenda Sekolah</h1>
              <hr class="garis">

              <ul class="list-unstyled">
                  @foreach($agendaSekolah as $agenda)
                      <!-- Item Agenda -->
                      <li class="mb-4">
                          <div class="d-flex gap-3 align-items-start">
                              <!-- Tanggal -->
                              <div class="agenda-date flex-shrink-0" style="color: {{ $agenda->warna }};">
                                  <div class="agenda-month" style="background-color: {{ $agenda->warna }}; color: white;">
                                      {{ $agenda->bulan }}
                                  </div>
                                  <div class="agenda-day" style="color: {{ $agenda->warna }};">{{ $agenda->hari }}</div>
                              </div>

                              <!-- KONTEN -->
                              <div class="agenda-content d-flex flex-column">
                                  <!-- Judul -->
                                  <strong class="agenda-title mb-1">
                                      {{ $agenda->judul }}
                                  </strong>

                                  <!-- Detail (PASTI DI BAWAH) -->
                                  <div class="agenda-detail">
                                      @if($agenda->deskripsi)
                                          <div class="small text-muted mb-1">
                                              {{ Str::limit($agenda->deskripsi, 100) }}
                                          </div>
                                      @endif

                                      @if($agenda->waktu || $agenda->lokasi)
                                          <div class="small text-muted">
                                              @if($agenda->waktu)
                                                  <span class="me-2">
                                                      <i class="fas fa-clock me-1"></i>
                                                      {{ date('H:i', strtotime($agenda->waktu)) }}
                                                  </span>
                                              @endif

                                              @if($agenda->lokasi)
                                                  <span>
                                                      <i class="fas fa-map-marker-alt me-1"></i>
                                                      {{ $agenda->lokasi }}
                                                  </span>
                                              @endif
                                          </div>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </li>
                  @endforeach
                  
                  @if($agendaSekolah->isEmpty())
                      <li class="text-center py-3 text-muted">
                          <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                          <p>Tidak ada agenda untuk saat ini</p>
                      </li>
                  @endif
              </ul>
          </section>
      </div>
    </div>
  </div>
</section>

<section id="galery" class="py-5 bg-purple">
    <div class="container-fluid px-0">
        <div class="section-title text-center mb-4">
            <h2>Yuk, Lihat lebih dekat aktifitas dari wistin</h2>
            <h1>Galeri Foto Aktivitas Wistin</h1>
        </div>

        <!-- Swiper -->
        <div class="swiper galerySwiper">
          <div class="swiper-wrapper">

              {{-- SLIDE ASLI --}}
              @foreach($galleries as $gallery)
                  <div class="swiper-slide">
                      <a href="{{ route('frontend.gallery.show', $gallery->slug) }}"
                        class="image-overlay-wrapper">
                        {{-- ganti href jika nanti mau ke detail --}}
                        {{-- href="{{ route('gallery.show', $gallery->slug) }}" --}}

                          <img
                              src="{{ asset('storage/' . $gallery->cover_image) }}"
                              class="img-fluid gallery-image"
                              alt="{{ $gallery->judul }}">

                          <div class="overlay">
                              <div class="overlay-text">
                                  {{ $gallery->judul }}
                              </div>
                          </div>
                      </a>
                  </div>
              @endforeach

              {{-- DUPLIKASI --}}
              @foreach($galleries as $gallery)
                  <div class="swiper-slide">
                      <a href="#"
                        class="image-overlay-wrapper">

                          <img
                              src="{{ asset('storage/' . $gallery->cover_image) }}"
                              class="img-fluid gallery-image"
                              alt="{{ $gallery->judul }}">

                          <div class="overlay">
                              <div class="overlay-text">
                                  {{ $gallery->judul }}
                              </div>
                          </div>
                      </a>
                  </div>
              @endforeach

              {{-- DUPLIKASI TAMBAHAN JIKA DATA SEDIKIT --}}
              @if($galleries->count() < 6)
                  @foreach($galleries as $gallery)
                      <div class="swiper-slide">
                          <a href="#"
                            class="image-overlay-wrapper">

                              <img
                                  src="{{ asset('storage/' . $gallery->cover_image) }}"
                                  class="img-fluid gallery-image"
                                  alt="{{ $gallery->judul }}">

                              <div class="overlay">
                                  <div class="overlay-text">
                                      {{ $gallery->judul }}
                                  </div>
                              </div>
                          </a>
                      </div>
                  @endforeach
              @endif

          </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>


<section id="testimoni">
    <div class="container">
        <div class="swiper alumniSwiper">
            <div class="swiper-wrapper">
                @if($testimoniAlumni && count($testimoniAlumni) > 0)
                    @foreach($testimoniAlumni as $testimoni)
                        <div class="swiper-slide">
                            <div class="row align-items-center">
                                <!-- Kiri: Text -->
                                <div class="col-md-7 textAlumni">
                                    <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
                                    <p class="mb-3">
                                        {{ $testimoni->testimoni }}
                                    </p>
                                    <p class="fw-medium">
                                        {{ $testimoni->nama }} 
                                        @if($testimoni->program_studi)
                                            ({{ $testimoni->program_studi }})
                                        @endif
                                    </p>
                                </div>
                                <!-- Kanan: Gambar -->
                                <div class="col-md-5 d-flex align-items-center justify-content-center">
                                    <img src="{{ $testimoni->foto_url }}" 
                                         alt="{{ $testimoni->nama }}"
                                         class="img-fluid rounded-4 shadow">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback ketika tidak ada data -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-12 text-center">
                                <div class="alert alert-info" role="alert">
                                    <div class="d-flex flex-column align-items-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h4 class="fw-bold mb-2">Apa Kata Alumni?</h4>
                                        <p class="mb-3">
                                            Testimoni dari alumni akan ditampilkan di sini. 
                                            Admin sedang mempersiapkan konten terbaik untuk Anda.
                                        </p>
                                        <p class="text-muted mb-0">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Bagikan pengalaman Anda setelah lulus dari SMK Wisata Indonesia
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Optional pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endsection
