<!-- Hero Section -->
<section class="navbar-section">
  <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
  </div>
</section>

<!-- Header Section -->
<header class="text-white text-center py-5 header-animate" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
  <h1><b>KAMPUS <?= $tentang['nama_kampus'] ?></b></h1>
  <p class="lead">Mewujudkan Pendidikan Berkualitas dan Inovasi Teknologi</p>
</header>

<!-- Info Cards Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-center card-animate card-animate">
          <div class="card-body">
            <div class="feature-icon">
              <i class="fas fa-map-marker-alt fa-2x"></i>
            </div>
            <h5 class="card-title">Lokasi</h5>
            <p class="card-text"><?= $tentang['alamat_kampus'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-center card-animate">
          <div class="card-body">
            <div class="feature-icon">
              <i class="fas fa-clock fa-2x"></i>
            </div>
            <h5 class="card-title">Jam Operasional</h5>
            <p class="card-text">Subuh -> Isya<br>untuk 5 Waktu Shalat</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-center card-animate">
          <div class="card-body">
            <div class="feature-icon">
              <i class="fas fa-phone fa-2x"></i>
            </div>
            <h5 class="card-title">Kontak</h5>
            <p class="card-text">
              <i class="fas fa-envelope me-2"></i>Email: -<br>
              <i class="fas fa-phone-square-alt me-2"></i>Telepon: -
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-5 pt-0">
  <div class="container">
    <h2 class="text-center section-title mt-3">Tentang Kampus</h2>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4 pt-0">
            <article class="bg-white p-4 rounded shadow-sm">
              <?= $tentang['keterangan'] ?>
            </article>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center section-title">Galeri Kampus</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 gallery-animate">
          <img src="<?= base_url('pictures') ?>/bg-outdoor.jpg" class="card-img-top gallery-img" alt="Eksterior">
          <div class="card-body text-center">
            <h5 class="card-title">Eksterior</h5>
            <p class="card-text text-muted">Tampak luar kampus yang modern</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 gallery-animate">
          <img src="<?= base_url('pictures') ?>/alquran.jpeg" class="card-img-top gallery-img" alt="Al-Quran">
          <div class="card-body text-center">
            <h5 class="card-title">Al-Qur'an</h5>
            <p class="card-text text-muted">Perpustakaan Digital</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 gallery-animate">
          <img src="<?= base_url('pictures') ?>/bg.jpg" class="card-img-top gallery-img" alt="Interior">
          <div class="card-body text-center">
            <h5 class="card-title">Interior</h5>
            <p class="card-text text-muted">Suasana ruang kelas yang nyaman</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('header').classList.add('header-animate');

    function isInViewport(element) {
      const rect = element.getBoundingClientRect();
      return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.bottom >= 0
      );
    }

    function animateOnScroll() {
      document.querySelectorAll('.card').forEach((card) => {
        if (isInViewport(card) && !card.classList.contains('show')) {
          card.classList.add('card-animate', 'show');
        }
      });
      document.querySelectorAll('.gallery-img').forEach((item) => {
        if (isInViewport(item) && !item.classList.contains('show')) {
          item.parentElement.classList.add('gallery-animate', 'show');
        }
      });
      document.querySelectorAll('.section-title').forEach((title) => {
        if (isInViewport(title) && !title.classList.contains('show')) {
          title.classList.add('show');
        }
      });
    }
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
  });
</script>

<style>
  article {
    display: flex;
    flex-direction: column;
    gap: 0;
  }

  /* article img {
    max-width: 100%;
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: contain;
    display: block;
    margin: 0;
    padding: 0;
  } */

  article p {
    margin: 0;
    padding: 0;
  }

  article p:empty {
    display: none;
  }
</style>

<style>
  .feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #dc2626;
  }

  .section-title {
    position: relative;
    padding-bottom: 40px;
    margin-bottom: 0px;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background-color: #1C7947;
  }

  .gallery-img {
    transition: transform 0.3s;
    cursor: pointer;
  }

  .gallery-img:hover {
    transform: scale(1.05);
  }
</style>

<style>
  .navbar-section {
    background: linear-gradient(135deg, #dc2626, #ef4444);
    width: 100%;
    height: 15vh;
  }
</style>

<style>
  .header-animate {
    animation: fadeInDown 1s ease-out;
  }

  .card-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-out;
  }

  .card-animate.show {
    opacity: 1;
    transform: translateY(0);
  }

  .gallery-animate {
    opacity: 0;
    transform: scale(0.9);
    transition: all 0.8s ease-out;
  }

  .gallery-animate.show {
    opacity: 1;
    transform: scale(1);
  }

  .card {
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
  }

  .feature-icon {
    transition: all 0.3s ease;
  }

  .card:hover .feature-icon {
    transform: rotate(360deg);
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: white;
  }

  .section-title {
    position: relative;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease-out;
  }

  .section-title.show {
    opacity: 1;
    transform: translateY(0);
  }

  .section-title::after {
    transform: scaleX(0);
    transition: transform 0.8s ease-out;
  }

  .section-title.show::after {
    transform: scaleX(1);
  }

  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .gallery-img {
    transition: all 0.5s ease;
  }

  .gallery-img:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .card {
    overflow: hidden;
  }

  .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent);
    transition: 0.5s;
  }

  .card:hover::before {
    left: 100%;
  }
</style>