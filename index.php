<?php

// =========================================================================
// --- ARCHIVO PRINCIPAL SUGERIDO: index.php (o alumnos.php) ---
// =========================================================================
// --- Iniciar/Reanudar Sesión ---
session_start();

// includes
require_once "includes/init.php";
require_once "actions/export.php";
require_once "includes/helpers.php";
require_once "includes/calculations.php";
require_once "templates/header.php";
require_once "views/partials/navbar.php";
require_once "actions/crud_logic.php";



// --- Comprobar si el usuario está logueado ---
// (Protección movida más abajo, solo para acciones específicas)

?>

<div class="container-fluid container-crud <?php echo ($accion == 'inicio') ? 'inicio-container' : ''; ?>"> <?php // Clase condicional ?>

    <?php // Mostrar mensajes generales ?>
    <?php if ($mensaje): ?>
        <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show m-3" role="alert"> <?php // Añadir margen al alert ?>
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php // --- Lógica para decidir qué vista mostrar --- ?>

    <?php if ($accion == 'inicio'): ?>
      <?php require_once "views/inicio.php"; ?>

    <?php elseif ($accion == 'estadisticas'): ?>
      <?php require_once "views/estadisticas.php"; ?>

    <?php elseif ($accion == 'administracion'): ?>
      <?php require_once "views/administracion.php"; ?>

    <?php elseif ($accion == 'crear_usuario'): ?>
      <?php require_once "views/usuarios/form_crear.php"; ?>

    <?php elseif ($accion == 'estructura_sistema'): ?>
      <?php require_once "views/estructura_sistema.php"; ?>

    <?php elseif ($accion == 'crear' || $accion == 'editar'): ?>
      <?php require_once "views/alumnos/form.php"; ?>

    <?php endif; ?>

    <?php if ($accion == 'leer'): ?>
      <?php require_once "views/alumnos/list.php"; ?>

    <?php endif; // Fin if accion ?>

    <?php
      // =========================================================================
      // --- ARCHIVO SUGERIDO: templates/footer.php o views/partials/footer.php ---
      // =========================================================================
      // Cerrar conexión solo si no es una acción de exportación (que ya hizo exit())
      if ($accion != 'exportar_csv' && $accion != 'exportar_txt') {
        $conn->close();
      }
    ?>

</div>

<div>
  <!--- espacio para el footer  --->
  <?php require_once "templates/footer.php"; ?>
  <?php require_once "views/partials/modal_backup.php"; ?>
</div>