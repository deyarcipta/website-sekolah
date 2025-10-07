<section 
  class="hero-section d-flex justify-content-center align-items-center text-center"
  style="
    position: relative;
    background:
      linear-gradient(rgba(169, 72, 234, 0.7), rgba(169, 72, 234, 0.7)),
      url('{{ asset($backgroundImage ?? "assets/img/default-bg.png") }}') center/cover no-repeat;
    height: {{ $height ?? '250px' }};
    color: #fff;
    margin-top: 70px;
  "
>
  <div class="container">
    <h1 class="fw-bold fs-2 mb-0" style="line-height: 1.2;">{{ $title ?? 'Judul Halaman' }}</h1>
  </div>
</section>
