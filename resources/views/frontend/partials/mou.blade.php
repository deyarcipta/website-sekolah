<section id="mou">
  <div class="container">
    <div class="swiper mouSwiper">
      <div class="swiper-wrapper">
        @forelse ($mouPartners as $partner)
          <div class="swiper-slide">
            <img
              src="{{ $partner->logo_url }}"
              class="img-fluid w-100"
              alt="{{ $partner->company_name }}"
              loading="lazy"
              onerror="this.src='{{ asset('assets/img/default-company.png') }}'"
            >
          </div>
        @empty
          <div class="swiper-slide text-center py-5">
            <span class="text-muted">Belum ada mitra kerjasama</span>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</section>

<style>
/* Efek fade kanan kiri TANPA mengubah design asli */
.swiper.mouSwiper {
  position: relative;
  overflow: hidden;
}

.mouSwiper::before,
.mouSwiper::after {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  width: 100px;
  z-index: 2;
  pointer-events: none;
}

.mouSwiper::before {
  left: 0;
  background: linear-gradient(90deg, 
    rgba(255,255,255,1) 0%, 
    rgba(255,255,255,0.7) 50%,
    rgba(255,255,255,0) 100%);
}

.mouSwiper::after {
  right: 0;
  background: linear-gradient(90deg, 
    rgba(255,255,255,0) 0%, 
    rgba(255,255,255,0.7) 50%,
    rgba(255,255,255,1) 100%);
}

/* Responsive */
@media (max-width: 768px) {
  .mouSwiper::before,
  .mouSwiper::after {
    width: 50px;
  }
}
</style>