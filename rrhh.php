<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SmartAgro</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../assets/img/favicon_aga.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="../assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Resi
  * Template URL: https://bootstrapmade.com/resi-free-bootstrap-html-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  
  <style>
        .section {
            display: none; /* Ocultamos todas las secciones por defecto */
        }
        .section.active {
            display: block; /* Mostramos solo la sección activa */
        }
    </style>
  
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="menu.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">SmartAgro</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
            <div class="dropdown">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">RR.HH.</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" onclick="showSection('section1')">Cuadrillas</a></li>
                    <li><a class="dropdown-item" href="rrhh.php">Nomina</a></li>
                    <li><a class="dropdown-item" href="rrhh.php">Trabajadores</a></li>
                </ul>
          </div>
          <li><a href="#about">Cultivos</a></li>
          
          <li><a href="#services">Ganado</a></li>
          
          <li><a href="#portfolio">Rentabilidad</a></li>
          
          <li><a href="#contact">Catálogos</a></li>
          
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="btn-getstarted" href="../index.html">Salir</a>
    </div>
  </header>

  <main class="main">
    
    <!-- Why Us Section -->
    <section id="why-us" class="why-us section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Recursos Humanos</h2>
        
        <div id="content">
            <div id="section1" class="section">Contenido de la Sección 1</div>
            <div id="section2" class="section">Contenido de la Sección 2</div>
            <div id="section3" class="section">Contenido de la Sección 3</div>
        </div>

        <script>
            function showSection(sectionId) {
                // Oculta todas las secciones
                const sections = document.querySelectorAll('.section');
                sections.forEach(section => section.classList.remove('active'));
    
                // Muestra la sección seleccionada
                const selectedSection = document.getElementById(sectionId);
                selectedSection.classList.add('active');
            }
        </script>
          
    </div><!-- End Section Title -->
    </section><!-- /Why Us Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">AGA</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>