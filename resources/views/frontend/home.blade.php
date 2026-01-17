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
          <img src="{{ asset('assets/img/hero.png') }}" alt="Hero Image" class="w-100 h-100" style="object-fit: cover;" />
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
        <div class="row gx-md-5 gx-2 mb-5 @if($index % 2 == 1) flex-md-row-reverse @endif">
            <div class="col-md-6 @if($index % 2 == 1) order-md-2 @endif">
                <h1>{{ $major->name }}</h1>
                <p>{{ $major->description }}</p>
                
                @if($major->accordion_items && count($major->accordion_items) > 0)
                <div class="accordion" id="accordionExample{{ $index }}">
                    @foreach($major->accordion_items as $accordionIndex => $item)
                    @php
                        // PERUBAHAN DISINI: Gunakan icon dari database jika ada
                        if (is_array($item)) {
                            $itemTitle = $item['title'] ?? 'Item';
                            $itemContent = $item['content'] ?? 'Content not available';
                            $itemIcon = $item['icon'] ?? 'fas fa-cog'; // Ambil icon dari database
                        } else {
                            // Jika item adalah string (format lama)
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
                                <!-- PERUBAHAN DISINI: Gunakan $itemIcon dari database -->
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
                <!-- Fallback accordion jika tidak ada data -->
                <div class="accordion" id="accordionExample{{ $index }}">
                    @php
                        // Data fallback berdasarkan nama jurusan
                        $fallbackAccordions = [
                            'Kuliner' => [
                                ['title' => 'Dasar Memasak', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'],
                                ['title' => 'Manajemen Dapur Profesional', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'],
                                ['title' => 'Kesempatan Kerja', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.']
                            ],
                            'Perhotelan' => [
                                ['title' => 'Manajemen Hotel', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu melakukan Pelayanan dan pengelolaan operasional hotel berbasis standar industri'],
                                ['title' => 'House Keeping', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'],
                                ['title' => 'Kesempatan Kerja', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.']
                            ],
                            'Teknik Komputer dan Jaringan' => [
                                ['title' => 'Dasar Teknik Komputer & Jaringan', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'],
                                ['title' => 'Administrasi Server', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.'],
                                ['title' => 'Kesempatan Kerja', 'content' => 'Siswa nantinya akan belajar dan dituntut untuk mampu mengolah berbagai jenis makanan dan minuman sesuai standar industri kuliner.']
                            ]
                        ];
                        
                        $fallbackData = $fallbackAccordions[$major->name] ?? [
                            ['title' => 'Pembelajaran', 'content' => 'Konten pembelajaran akan diisi kemudian.'],
                            ['title' => 'Praktik', 'content' => 'Konten praktik akan diisi kemudian.'],
                            ['title' => 'Peluang Karir', 'content' => 'Konten peluang karir akan diisi kemudian.']
                        ];
                    @endphp
                    
                    @foreach($fallbackData as $accordionIndex => $item)
                    @php
                        $accordionIcons = [
                            'fas fa-bowl-rice',
                            'fas fa-cake-candles',
                            'fas fa-briefcase',
                            'fas fa-hotel',
                            'fas fa-bed',
                            'fas fa-network-wired',
                            'fas fa-desktop'
                        ];
                        $icon = $accordionIcons[$accordionIndex % count($accordionIcons)] ?? 'fas fa-info-circle';
                    @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $accordionIndex }}{{ $index }}">
                            <button class="accordion-button {{ $accordionIndex === 0 ? '' : 'collapsed' }}" 
                                    type="button" 
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $accordionIndex }}{{ $index }}" 
                                    aria-expanded="{{ $accordionIndex === 0 ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ $accordionIndex }}{{ $index }}">
                                <i class="{{ $icon }} me-2 text-danger custom-icon"></i>
                                {{ $item['title'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $accordionIndex }}{{ $index }}" 
                             class="accordion-collapse collapse {{ $accordionIndex === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $accordionIndex }}{{ $index }}" 
                             data-bs-parent="#accordionExample{{ $index }}">
                            <div class="accordion-body">
                                {{ $item['content'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="col-md-6 @if($index % 2 == 1) order-md-1 @endif d-none d-md-block position-relative p-0">
                <!-- PERUBAHAN DISINI: UTAMAKAN accordion_image -->
                @if($major->accordion_image)
                <img src="{{ asset('storage/' . $major->accordion_image) }}" alt="{{ $major->name }}" class="img-fluid">
                @elseif($major->overview_image)
                <img src="{{ asset('storage/' . $major->overview_image) }}" alt="{{ $major->name }}" class="img-fluid">
                @elseif($major->hero_image)
                <img src="{{ asset('storage/' . $major->hero_image) }}" alt="{{ $major->name }}" class="img-fluid">
                @else
                <!-- Fallback images berdasarkan nama jurusan -->
                @php
                    $fallbackImages = [
                        'Kuliner' => 'assets/img/kuliner-program.png',
                        'Perhotelan' => 'assets/img/perhotelan-program.png',
                        'Teknik Komputer dan Jaringan' => 'assets/img/tkj-program.png'
                    ];
                    $fallbackImage = $fallbackImages[$major->name] ?? 'assets/img/default-program.png';
                @endphp
                <img src="{{ asset($fallbackImage) }}" alt="{{ $major->name }}" class="img-fluid">
                @endif
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
          <div class="row">
            <!-- Card 1 -->
            <div class="col-md-6 mb-3">
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 1</h5>
                      <p class="card-text">Isi singkat berita pertama yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 mb-3">
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 2</h5>
                      <p class="card-text">Isi singkat berita kedua yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 mb-3">.
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 3</h5>
                      <p class="card-text">Isi singkat berita ketiga yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 mb-3">.
              <a href="#">
              <div class="card berita-card text-white mb-3">
                <div class="berita-img" style="background-image: url('{{ asset('assets/img/home-decor-1.jpg') }}');">
                  <div class="berita-overlay d-flex align-items-end p-3">
                    <div>
                      <h5 class="card-title">Judul Berita 3</h5>
                      <p class="card-text">Isi singkat berita ketiga yang akan ditampilkan kepada pengunjung.</p>
                    </div>
                  </div>
                </div>
              </div>
              </a>
            </div>
          </div>
          <a href="#" class="btn all-berita">Lihat Semua Berita</a>
        </section>
      </div>

      <!-- Section Agenda Sekolah (4 kolom) -->
      <div class="col-md-4">
        <section id="agenda-sekolah" class="p-4 bg-white border rounded h-100">
          <h1 class="mb-3">Agenda Sekolah</h1>
          <hr class="garis">

          <ul class="list-unstyled">
            <!-- Item Agenda -->
            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah</strong>
              </div>
            </li>

            <li class="d-flex gap-3 mb-4">
              <!-- Kotak Tanggal -->
              <div class="agenda-date flex-shrink-0">
                <div class="agenda-month">Jun 2025</div>
                <div class="agenda-day">15</div>
              </div>

              <!-- Teks Agenda -->
              <div class="agenda-content">
                <strong>Assessment Sumatif Akhir Sekolah yang judulnya sangat panjang dan bisa dua baris atau lebih tapi tetap sejajar atas</strong>
              </div>
            </li>
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
        <!-- Slide 1 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 1</div>
            </div>
          </a>
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 2</div>
            </div>
          </a>
        </div>
        <!-- Slide 3 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/carousel-3.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 3</div>
            </div>
          </a>
        </div>
        <!-- Slide 4 -->
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/home-decor-1.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 4</div>
            </div>
          </a>
        </div>
        <div class="swiper-slide">
          <a href="" class="image-overlay-wrapper">
            <img src="{{ asset('assets/img/home-decor-2.jpg') }}" class="img-fluid w-100" alt="Gallery 1">
            <div class="overlay">
              <div class="overlay-text">Judul Gambar 5</div>
            </div>
          </a>
        </div>
        <!-- Tambah slide lainnya -->
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

        <!-- Slide 1 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <!-- Kiri: Text -->
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                SMK Wisata Indonesia mengajarkanku lebih dari sekadar teori—pengalaman magang di hotel bintang 5 membentukku menjadi profesional siap kerja. Terima kasih, guru-guruku!
              </p>
              <p class="fw-medium">Ilham Muhammad Alamsyah (SMK Wisata Indonesia)</p>
            </div>
            <!-- Kanan: Gambar -->
            <div class="col-md-5 d-flex align-items-center justify-content-center">
              <img src="{{ asset('assets/img/team-1.jpg') }}" alt="Ilham Muhammad Alamsyah"
                class="img-fluid rounded-4 shadow" >
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                Pembelajaran di SMK WI membuat saya percaya diri menghadapi dunia kerja. Banyak praktik nyata yang saya alami langsung.
              </p>
              <p class="fw-medium">Putri Anjani (SMK WI - Perhotelan)</p>
            </div>
            <div class="col-md-5 text-center">
              <img src="{{ asset('assets/img/team-2.jpg') }}" alt="Putri Anjani"
                class="img-fluid rounded-4 shadow">
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide">
          <div class="row align-items-center">
            <div class="col-md-7 textAlumni">
              <h4 class="fw-bold mb-3">Apa Kata Alumni?</h4>
              <p class="mb-3">
                Pembelajaran di SMK WI membuat saya percaya diri menghadapi dunia kerja. Banyak praktik nyata yang saya alami langsung.
              </p>
              <p class="fw-medium">Putri Anjani (SMK WI - Perhotelan)</p>
            </div>
            <div class="col-md-5 text-center">
              <img src="{{ asset('assets/img/team-3.jpg') }}" alt="Putri Anjani"
                class="img-fluid rounded-4 shadow">
            </div>
          </div>
        </div>

        <!-- Tambah slide lain jika perlu -->

      </div>

      <!-- Optional pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
@endsection
