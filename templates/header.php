<!--- ======================================================================
// --- ARCHIVO SUGERIDO: templates/header.php o views/partials/header.php ---
// ========================================================================= --->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecimiento Educativo Instituto Privado Santa Doménica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Estilos CSS */
        body { background-color: #f8f9fa; }
        .container-crud { background-color: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-top: 20px; }
        .inicio-container { padding: 0 !important; margin: 0 !important; box-shadow: none; border-radius: 0; margin-top: 0 !important; background-color: transparent;}
        .inicio-container .p-5 { border-radius: 0 !important; }
        .inicio-container .row > div > div { border-radius: 0 !important; }
        .inicio-container .border-start { border-left: 1px solid #dee2e6 !important;}
        .inicio-container .border-top { border-top: 1px solid #dee2e6 !important;}
        .inicio-container .border-bottom { border-bottom: 1px solid #dee2e6 !important;}
        /* --- Ajuste Navbar --- */
        .navbar { padding-top: 1.2rem; padding-bottom: 1.2rem; } /* Aumentado padding vertical */
        .navbar-brand { font-size: 1.5rem !important; } /* Tamaño brand */
        .navbar .nav-link {
            padding-top: 0.8rem !important; /* Más padding vertical para enlaces */
            padding-bottom: 0.8rem !important;
            transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }
        .navbar .nav-link:hover:not(.active) {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.15); /* Hover más notorio */
        }
        /* --- Fin Ajuste Navbar --- */
        .filtros-columnas { background-color: #e9ecef; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; }
        .filtros-columnas .row > div { padding-right: 0.5rem; padding-left: 0.5rem; }
        .filtros-columnas label { font-size: 0.875em; margin-bottom: 0.25rem; }
        .filtros-columnas .form-control, .filtros-columnas .form-select { font-size: 0.875em; padding: 0.375rem 0.75rem; height: auto; }
        .filtros-columnas .botones-filtro { align-self: flex-end; padding-bottom: 0.375rem; }
        .acciones a, .acciones form button { font-size: 1em !important; padding: 0.2rem 0.5rem !important; line-height: 1; margin-right: 0.25rem !important; }
        .acciones a:last-child, .acciones form:last-child button { margin-right: 0 !important; }
        .estadisticas { background-color: #e2e6ea; padding: 0.75rem 1rem; border-radius: 0.375rem; border: 1px solid #dae0e5; display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.95em; margin-bottom: 1.5rem; }
        .exportar-seccion { margin-bottom: 1.5rem; padding: 0.75rem 0; border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6; }
        .exportar-seccion .btn { font-size: 0.85em !important; padding: 0.25rem 0.5rem !important; }
        .paginacion .page-link { padding: 0.375rem 0.75rem; font-size: 0.9em; }
        .paginacion .page-item.active .page-link { z-index: 3; }
        .paginacion .page-item.disabled .page-link { color: #6c757d; pointer-events: none; background-color: #fff; border-color: #dee2e6; }
        .info-paginacion { font-size: 0.85em; color: #6c757d; margin-top: 0.5rem; text-align: center; }
        #modal-backup-phpmyadmin .modal-body ol { padding-left: 1.5rem; }
        #modal-backup-phpmyadmin .modal-body code { font-size: 0.9em; }
        .table-responsive-md { margin-bottom: 1rem; }
        th a:hover { color: #0d6efd; }
        .acciones { white-space: nowrap; }
        .filtro-resp-compacto { max-width: 120px !important; }
        .table tbody td { font-size: 0.875em; vertical-align: middle; }
        .table th { vertical-align: middle; font-size: 0.9em; }
        .acciones .btn { vertical-align: middle; }
        .dashboard-card { min-height: 140px; display: flex; flex-direction: column; }
        .dashboard-card .card-body { display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; flex-grow: 1; }
        .dashboard-card .stat-number { font-size: 2.2rem; font-weight: bold; color: #0d6efd; line-height: 1.1; }
        .dashboard-card .card-title { font-size: 0.95rem; color: #6c757d; margin-top: 5px; margin-bottom: 0.5rem; }
        .dashboard-card .stat-details { font-size: 0.85em; color: #495057; margin-top: auto; }
        .dashboard-cursos-nivel ul { list-style: none; padding: 0; margin: 5px 0 0 0; text-align: left; font-size: 1em; }
        .dashboard-cursos-nivel li { margin-bottom: 5px; }
        .dashboard-cursos-nivel strong { color: #0d6efd; }
        .chart-container { position: relative; height: 300px; width: 100%; }
        #graficoAlumnosNivelContainer { height: 250px; max-width: 300px; margin: 0 auto; }
        /* Estilo para tarjeta circular (Eliminado) */
        /* Estilo para la tarjeta de alumnos con desglose */
        .stat-gender-split { display: flex; justify-content: space-around; width: 100%; margin-top: 0.5rem; align-items: center;}
        .stat-gender-split div { text-align: center; }
        .stat-gender-split i { font-size: 2.5rem; margin-bottom: 0.1rem; display: block; }
        .stat-gender-split strong { font-size: 1.5em; display: block; font-weight: bold; }
        .stat-gender-split .female { color: #d63384; }
        .stat-gender-split .male { color: #0d6efd; }
        /* Estilos para sección noticias */
        .news-section .border { border-color: #dee2e6 !important; }
        .news-section img { max-width: 100%; height: auto; }
        .news-secondary img {
            width: 180px; /* Más grande */
            height: 135px; /* Ajustar proporción */
            object-fit: cover;
            margin-right: 15px;
        }
        .news-secondary .news-item { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; flex-grow: 1; display: flex; align-items: center; }
        .news-secondary .news-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .news-secondary h6 { font-size: 1rem; margin-bottom: 3px; }
        .news-secondary p { font-size: 0.9em; color: #6c757d; margin-bottom: 0; }
        .news-secondary > div { display: flex; flex-direction: column; height: 100%; }

    </style>
</head>
<body>

<!--- ======================================================================
// --- FIN ARCHIVO SUGERIDO: templates/header.php ---
// ========================================================================= --->