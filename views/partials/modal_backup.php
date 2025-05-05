<?php // ========================================================================= ?>
<?php // --- ARCHIVO SUGERIDO: views/partials/modal_backup.php --- ?>
<?php // ========================================================================= ?>
<div class="modal fade" id="modal-backup-phpmyadmin" tabindex="-1" aria-labelledby="modalBackupLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalBackupLabel">Instrucciones para Backup con phpMyAdmin</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ol>
            <li>Accede a tu panel de phpMyAdmin.</li>
            <li>En el panel izquierdo, selecciona la base de datos que deseas respaldar (<code><?php echo htmlspecialchars($dbname); ?></code>).</li>
            <li>Haz clic en la pestaña "Exportar".</li>
            <li>Método "Rápido" y formato "SQL" suelen ser suficientes.</li>
            <li>Clic en "Continuar" o "Exportar".</li>
            <li>Guarda el archivo <code>.sql</code> descargado en un lugar seguro.</li>
            <li>Realiza este proceso periódicamente.</li>
        </ol>
        <p><strong>Nota:</strong> Los nombres exactos pueden variar según la versión.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php // ========================================================================= ?>
<?php // --- FIN ARCHIVO SUGERIDO: views/partials/modal_backup.php --- ?>
<?php // ========================================================================= ?>