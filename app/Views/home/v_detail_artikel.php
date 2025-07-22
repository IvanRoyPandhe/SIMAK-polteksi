<!-- Hero Section -->
<section class="navbar-section">
  <div class="container d-flex align-items-center justify-content-center fs-1 text-white text-center flex-column">
  </div>
</section>

<!-- Header -->
<header class="text-white py-5 mb-3 animate-header" style="background-color: #ff9800;">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mx-auto text-center">
        <h1 class="display-6 fw-bold animate-title"><?= $artikel['judul'] ?></h1>
        <div class="d-flex flex-wrap flex-column flex-md-row justify-content-center align-items-center mt-3 animate-meta">
          <div class="d-flex align-items-center mb-2 mb-md-0">
            <i class="far fa-edit me-1 bounce"></i>
            <span><?= $artikel['penulis'] ?></span>
          </div>
          <span class="text-light d-none d-md-inline mx-2">|</span>
          <div class="d-flex align-items-center">
            <i class="far fa-calendar-alt me-1 bounce"></i>
            <?php
            $tgl = new DateTime($artikel['created_at']);
            $tgl_format = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            echo $tgl_format->format($tgl);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Main Content -->
<main class="container mb-5">
  <div class="row">
    <div class="col-lg-10 mx-auto">
      <a href="<?= base_url() ?>#artikel" class="btn btn-light mb-3 animate-button">
        <i class="fas fa-arrow-left me-2"></i>Kembali
      </a>
      <div class="rounded overflow-hidden mb-4 shadow-sm animate-image">
        <img src="<?= base_url('uploaded/thumbnail_artikel/' . $artikel['thumbnail']) ?>"
          class="img-fluid w-100"
          alt="<?= $artikel['judul'] ?>">
      </div>
      <article class="bg-white p-4 rounded shadow-sm animate-content">
        <div class="article-body">
          <?= $artikel['isi'] ?>
        </div>
        <div class="mt-4 pt-4 border-top animate-tags">
          <h5 class="mb-3">Kategori :</h5>
          <a href="<?= base_url() . '#artikel' ?>"
            class="btn btn-sm btn-outline-primary mb-2 tag-button">
            <?= $artikel['nama_kategori'] ?>
          </a>
        </div>
        <div class="share-container mt-4 pt-4 border-top animate-share">
          <h5 class="mb-3">Bagikan Artikel:</h5>
          <div class="d-flex flex-wrap gap-2">
            <a href="#" class="btn btn-primary share-button">
              <i class="fab fa-facebook-f me-2"></i>
              <span>Facebook</span>
            </a>
            <a href="#" class="btn btn-info text-white share-button">
              <i class="fab fa-twitter me-2"></i>
              <span>Twitter</span>
            </a>
            <a href="#" class="btn btn-success share-button">
              <i class="fab fa-whatsapp me-2"></i>
              <span>WhatsApp</span>
            </a>
          </div>
        </div>
      </article>
    </div>
  </div>
</main>

<script>
  function shareFacebook(url) {
    const shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
  }

  function shareTwitter(url, text) {
    const shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
    window.open(shareUrl, '_blank', 'width=600,height=400');
  }

  function shareWhatsApp(url, text) {
    const shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text + ' ' + url)}`;
    window.open(shareUrl, '_blank');
  }
  document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const shareText = document.title;
    document.querySelector('.btn-primary').addEventListener('click', function(e) {
      e.preventDefault();
      shareFacebook(currentUrl);
    });
    document.querySelector('.btn-info').addEventListener('click', function(e) {
      e.preventDefault();
      shareTwitter(currentUrl, shareText);
    });
    document.querySelector('.btn-success').addEventListener('click', function(e) {
      e.preventDefault();
      shareWhatsApp(currentUrl, shareText);
    });
  });
</script>

<style>
  .animate-header {
    animation: fadeIn 1s ease-out;
  }

  .animate-title {
    animation: slideDown 1s ease-out;
  }

  .animate-meta {
    animation: fadeIn 1.5s ease-out;
  }

  .animate-image {
    animation: zoomIn 1s ease-out;
    overflow: hidden;
  }

  .animate-image img {
    transition: transform 0.5s ease;
  }

  .animate-image:hover img {
    transform: scale(1.05);
  }

  .animate-content {
    animation: fadeIn 1.5s ease-out;
  }

  .animate-tags {
    animation: slideRight 1s ease-out;
  }

  .animate-share {
    animation: slideUp 1s ease-out;
  }

  .share-button {
    transition: all 0.3s ease;
    transform: scale(1);
  }

  .share-button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  .tag-button {
    transition: all 0.3s ease;
  }

  .tag-button:hover {
    background-color: #ff9800;
    border-color: #ff9800;
    color: white;
    transform: translateY(-2px);
  }

  .bounce {
    animation: bounce 2s infinite;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  @keyframes slideDown {
    from {
      transform: translateY(-50px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes slideRight {
    from {
      transform: translateX(-50px);
      opacity: 0;
    }

    to {
      transform: translateX(0);
      opacity: 1;
    }
  }

  @keyframes slideUp {
    from {
      transform: translateY(50px);
      opacity: 0;
    }

    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  @keyframes zoomIn {
    from {
      transform: scale(0.95);
      opacity: 0;
    }

    to {
      transform: scale(1);
      opacity: 1;
    }
  }

  @keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
      transform: translateY(0);
    }

    40% {
      transform: translateY(-3px);
    }

    60% {
      transform: translateY(-2px);
    }
  }

  @media (max-width: 768px) {
    .animate-meta {
      flex-direction: column;
      align-items: center;
    }

    .share-button {
      width: 100%;
      margin-bottom: 10px;
    }
  }

  .article-body {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #2c3e50;
  }

  .article-body p {
    /* margin-bottom: 1.5rem; */
  }

  .article-body img {
    /* border-radius: 80px; */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    /* margin: 1.5rem 0; */
  }

  .navbar-section {
    background-color: #ff9800;
    width: 100%;
    height: 15vh;
  }

  .btn-light {
    transition: all 0.3s ease;
    background-color: white;
  }

  .btn-light:hover {
    background-color: #ff9800;
    transform: translateX(-5px);
  }

  .article-body {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #2c3e50;
  }

  .article-body img {
    max-width: 100% !important;
    height: auto !important;
    /* display: block; */
    /* margin: 1.5rem auto; */
  }

  article {
    /* overflow-x: hidden; */
    width: 100%;
    /* box-sizing: border-box; */
  }

  @media (min-width: 768px) {
    .article-body img {
      max-width: 80% !important;
    }
  }
</style>