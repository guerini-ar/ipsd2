<!--- =========================================================================
      // --- ARCHIVO SUGERIDO: views/partials/navbar.php ---
      ========================================================================= --->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3"> <?php // Cambiado a bg-dark y py-3 ?>
  <div class="container-fluid">
    <a class="navbar-brand fs-5 text-warning" href="index.php?accion=inicio">Instituto Privado Santa Doménica</a> <?php // Texto completo y color warning ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php echo ($accion == 'inicio') ? 'active' : ''; ?>" href="index.php?accion=inicio">Inicio</a>
        </li>
        <?php // Mostrar enlaces protegidos solo si está logueado ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php // Mostrar Estadísticas y Administración solo a admin ?>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                <li class="nav-item">
                  <a class="nav-link <?php echo ($accion == 'estadisticas') ? 'active' : ''; ?>" href="index.php?accion=estadisticas">Estadísticas</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo ($accion == 'administracion') ? 'active' : ''; ?>" href="index.php?accion=administracion">Administración</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo ($accion == 'crear_usuario') ? 'active' : ''; ?>" href="index.php?accion=crear_usuario">Crear Usuario</a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo ($accion == 'estructura_sistema') ? 'active' : ''; ?>" href="index.php?accion=estructura_sistema">Estructura Sistema</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
               <?php $is_gestion_active = in_array($accion, ['leer', 'crear', 'editar']); ?>
              <a class="nav-link <?php echo $is_gestion_active ? 'active' : ''; ?>" <?php echo $is_gestion_active ? 'aria-current="page"' : ''; ?> href="index.php?accion=leer">Gestión de Alumnos</a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="#">Otro</a> <?php // Mantener como ejemplo ?>
        </li>
      </ul>
      <div class="d-flex align-items-center">
         <?php if (isset($_SESSION['user_id'])): ?>
             <span class="navbar-text me-3">
               Usuario: <?php echo htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : 'Desconocido'); ?>
             </span>
             <a href="index.php?accion=logout" class="btn btn-danger btn-sm">Cerrar Sesión</a>
         <?php else: ?>
             <a href="login.php" class="btn btn-light btn-sm">Iniciar Sesión</a>
         <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<!---   =========================================================================
        // --- FIN ARCHIVO SUGERIDO: views/partials/navbar.php --- 
        // ========================================================================= --->