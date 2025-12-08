@extends('frontend.app')

@section('title', 'Blog - Culture Bénin')

@section('content')
  <!-- <section class="blog section">
    <div class="container">
      <h1>Blog</h1>
      <p>Blog coming soon.</p>
    </div>
  </section> -->
   <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/travel/showcase-8.webp);">
      <div class="container position-relative">
        <h1>Blog</h1>
        <p>Découvrez les actualités culturelles du Bénin : festivals, événements traditionnels et célébrations du patrimoine béninois.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">Blog</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Blog Hero Section -->
    <section id="blog-hero" class="blog-hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="blog-grid">

          <!-- Main Featured Post -->
          <article class="blog-item main-feature" data-aos="fade-up">
            <img src="assets/img/travel/vodun.jpeg" alt="Festival Vodoun Days" class="img-fluid">
            <div class="blog-content">
              <div class="post-meta">
                <span class="date">10 Janvier 2025</span>
                <span class="category">Festivals</span>
              </div>
              <h2 class="post-title">
                <a href="blog-details.html" title="Vodoun Days 2025: Le Bénin célèbre sa spiritualité ancestrale">Vodoun Days 2025: Le Bénin célèbre sa spiritualité ancestrale</a>
              </h2>
              <p class="post-excerpt">Chaque année, le 10 janvier marque la fête nationale du Vodoun au Bénin. Cette célébration unique rassemble des milliers de fidèles et visiteurs pour honorer les traditions spirituelles ancestrales. Ouidah, berceau du Vodoun, accueille les cérémonies principales avec des rituels, danses et chants traditionnels.</p>
            </div>
          </article><!-- End Main Featured Post -->

          <!-- Secondary Featured Posts -->
          <div class="secondary-features">
            <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
              <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Festival des Masques" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">15 Février 2025</span>
                  <span class="category">Traditions</span>
                </div>
                <h3 class="post-title">
                  <a href="blog-details.html" title="Festival International des Masques et Arts de Ouidah">Festival International des Masques et Arts de Ouidah</a>
                </h3>
              </div>
            </article>

            <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
              <img src="assets/img/blog/blog-post-portrait-2.webp" alt="Journée des Religions Traditionnelles" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">10 Janvier 2025</span>
                  <span class="category">Culture</span>
                </div>
                <h3 class="post-title">
                  <a href="blog-details.html" title="Journée Nationale des Religions Traditionnelles au Bénin">Journée Nationale des Religions Traditionnelles au Bénin</a>
                </h3>
              </div>
            </article>
          </div><!-- End Secondary Features -->

          <!-- Regular Posts Grid -->
          <div class="regular-posts">
            <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
              <img src="assets/img/blog/blog-post-9.webp" alt="Festival Quintessence" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">20 Décembre 2024</span>
                  <span class="category">Arts</span>
                </div>
                <h3 class="post-title">
                  <a href="blog-details.html" title="Festival Quintessence: Célébration des arts au Bénin">Festival Quintessence: Célébration des arts au Bénin</a>
                </h3>
              </div>
            </article>

            <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
              <img src="assets/img/blog/blog-post-3.webp" alt="Patrimoine Oral" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">5 Novembre 2024</span>
                  <span class="category">Patrimoine</span>
                </div>
                <h3 class="post-title">
                  <a href="blog-details.html" title="Préservation du patrimoine oral béninois: Les griots témoignent">Préservation du patrimoine oral béninois: Les griots témoignent</a>
                </h3>
              </div>
            </article>

            <article class="blog-item" data-aos="fade-up" data-aos-delay="500">
              <img src="assets/img/blog/blog-post-6.webp" alt="Artisanat Béninois" class="img-fluid">
              <div class="blog-content">
                <div class="post-meta">
                  <span class="date">18 Octobre 2024</span>
                  <span class="category">Artisanat</span>
                </div>
                <h3 class="post-title">
                  <a href="blog-details.html" title="L'artisanat béninois à l'honneur: Tissage et poterie traditionnels">L'artisanat béninois à l'honneur: Tissage et poterie traditionnels</a>
                </h3>
              </div>
            </article>
          </div><!-- End Regular Posts -->

        </div>

      </div>

    </section><!-- /Blog Hero Section -->

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Festivals</p>

              <h2 class="title">
                <a href="blog-details.html">La Route de l'Esclave: Mémoire et réconciliation à Ouidah</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-12.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Aïcha Kossou</p>
                  <p class="post-date">
                    <time datetime="2025-01-10">10 Jan, 2025</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-2.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Musique</p>

              <h2 class="title">
                <a href="blog-details.html">Le Festival Gani-Oké: La musique traditionnelle à l'honneur</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-13.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Sandrine Dossou</p>
                  <p class="post-date">
                    <time datetime="2024-11-15">15 Nov, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-3.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Danses</p>

              <h2 class="title">
                <a href="blog-details.html">Les danses Zangbéto: Gardiens de la nuit et traditions vivantes</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-10.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Kofi Agbodjan</p>
                  <p class="post-date">
                    <time datetime="2024-10-28">28 Oct, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-4.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Cuisine</p>

              <h2 class="title">
                <a href="blog-details.html">Les saveurs du Bénin: Festival de la gastronomie traditionnelle</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-14.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mariam Soglo</p>
                  <p class="post-date">
                    <time datetime="2024-09-20">20 Sep, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-5.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Royauté</p>

              <h2 class="title">
                <a href="blog-details.html">Les Palais Royaux d'Abomey: Trésors du patrimoine mondial</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-11.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Yves Hounguè</p>
                  <p class="post-date">
                    <time datetime="2024-08-12">12 Août, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-lg-4">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-6.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Textiles</p>

              <h2 class="title">
                <a href="blog-details.html">Le tissage Kente et les étoffes royales du Bénin</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-15.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Nadège Assogba</p>
                  <p class="post-date">
                    <time datetime="2024-07-18">18 Juil, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

        </div>
      </div>

    </section><!-- /Blog Posts Section -->

    <!-- Pagination 2 Section -->
    <section id="pagination-2" class="pagination-2 section">

      <div class="container">
        <div class="d-flex justify-content-center">
          <ul>
            <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
            <li><a href="#">1</a></li>
            <li><a href="#" class="active">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li>...</li>
            <li><a href="#">10</a></li>
            <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>

    </section><!-- /Pagination 2 Section -->

  </main>
@endsection
