<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/inicio.php --- ?>
        <?php // <?php require 'views/inicio.php'; ?>
        <?php // ========================================================================= ?>
        <?php // --- Sección de Noticias --- ?>
        <div class="row g-0 mb-4 news-section">
            <div class="col-md-6 d-flex">
                <div class="p-3 bg-light border flex-grow-1 d-flex flex-column">
                    <h4>Noticia Destacada</h4>
                    <img src="https://placehold.co/600x400/0056b3/FFF?text=Noticia+Principal" class="img-fluid mb-2" alt="Imagen Noticia Principal">
                    <figcaption class="figure-caption text-center mb-2">Pie de foto para la noticia principal.</figcaption>
                    <p class="flex-grow-1">Este es un breve resumen de la noticia más importante del instituto. Aquí se puede detallar información relevante sobre eventos, anuncios o logros recientes.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-auto">Leer más</a>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="p-3 bg-light border news-secondary flex-grow-1">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex align-items-start news-item">
                            <img src="https://placehold.co/180x135/6c757d/FFF?text=Noticia+1" alt="Imagen Noticia Secundaria 1">
                            <div>
                                <h6>Título Noticia Secundaria 1</h6>
                                <p>Breve descripción o bajada para la primera noticia secundaria.</p>
                            </div>
                        </div>
                         <div class="d-flex align-items-start news-item">
                            <img src="https://placehold.co/180x135/6c757d/FFF?text=Noticia+2" alt="Imagen Noticia Secundaria 2">
                            <div>
                                <h6>Título Noticia Secundaria 2</h6>
                                <p>Breve descripción o bajada para la segunda noticia secundaria.</p>
                            </div>
                        </div>
                         <div class="d-flex align-items-start news-item">
                            <img src="https://placehold.co/180x135/6c757d/FFF?text=Noticia+3" alt="Imagen Noticia Secundaria 3">
                            <div>
                                <h6>Título Noticia Secundaria 3</h6>
                                <p>Breve descripción o bajada para la tercera noticia secundaria.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php // --- Fin Sección de Noticias --- ?>
        <div class="p-5 mb-0 bg-white rounded-0">
          <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bienvenido al Sistema de Gestión</h1>
            <p class="col-md-8 fs-4">Instituto Privado Santa Doménica.</p>
            <p>Utilice la barra de navegación superior para acceder a las diferentes secciones.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="btn btn-primary btn-lg">Iniciar Sesión</a>
            <?php else: ?>
                 <a href="index.php?accion=leer" class="btn btn-primary btn-lg">Ir a Gestión de Alumnos</a>
            <?php endif; ?>
          </div>
        </div>
        <div class="row align-items-md-stretch g-0">
          <div class="col-md-6">
            <div class="h-100 p-5 text-bg-dark rounded-0">
              <h2>Gestión Rápida</h2>
              <p>Acceda directamente a la gestión de alumnos para altas, bajas y modificaciones.</p>
              <a class="btn btn-outline-light" href="index.php?accion=leer">Gestionar Alumnos</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="h-100 p-5 bg-body-tertiary border-start border-top border-bottom rounded-0">
              <h2>Estadísticas Clave</h2>
              <p>Visualice gráficos y resúmenes importantes sobre la matrícula estudiantil.</p>
               <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                    <a class="btn btn-outline-secondary" href="index.php?accion=estadisticas">Ver Estadísticas</a>
               <?php else: ?>
                    <button class="btn btn-outline-secondary" disabled>Ver Estadísticas (Admin)</button>
               <?php endif; ?>
            </div>
          </div>
        </div>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/inicio.php --- ?>
        <?php // ========================================================================= ?>