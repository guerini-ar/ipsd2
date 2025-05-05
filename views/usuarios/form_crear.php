<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/usuarios/form_crear.php --- ?>
        <?php // <?php require 'views/usuarios/form_crear.php'; ?>
        <?php // ========================================================================= ?>
        <div class="p-3">
            <h2 class="mb-4">Crear Nuevo Usuario</h2>
            <div class="card p-4 mx-auto" style="max-width: 600px;">
                <form action="index.php" method="post">
                    <input type="hidden" name="accion_form" value="guardar_usuario">
                    <div class="mb-3">
                        <label for="nuevo_usuario" class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nuevo_usuario" name="nuevo_usuario" required value="<?php echo isset($_POST['nuevo_usuario']) && $error ? htmlspecialchars($_POST['nuevo_usuario']) : ''; ?>">
                    </div>
                     <div class="mb-3">
                        <label for="nuevo_email" class="form-label">Email (Opcional)</label>
                        <input type="email" class="form-control" id="nuevo_email" name="nuevo_email" value="<?php echo isset($_POST['nuevo_email']) && $error ? htmlspecialchars($_POST['nuevo_email']) : ''; ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nuevo_pass" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="nuevo_pass" name="nuevo_pass" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nuevo_pass_confirm" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="nuevo_pass_confirm" name="nuevo_pass_confirm" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nuevo_rol" class="form-label">Rol <span class="text-danger">*</span></label>
                        <select class="form-select" id="nuevo_rol" name="nuevo_rol" required>
                            <option value="" <?php echo (!isset($_POST['nuevo_rol']) || $_POST['nuevo_rol'] == '') ? 'selected' : ''; ?>>Seleccionar rol...</option>
                            <option value="admin" <?php echo (isset($_POST['nuevo_rol']) && $_POST['nuevo_rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                            <option value="usuario" <?php echo (isset($_POST['nuevo_rol']) && $_POST['nuevo_rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                            <option value="inicial" <?php echo (isset($_POST['nuevo_rol']) && $_POST['nuevo_rol'] == 'inicial') ? 'selected' : ''; ?>>Inicial</option>
                            <option value="primario" <?php echo (isset($_POST['nuevo_rol']) && $_POST['nuevo_rol'] == 'primario') ? 'selected' : ''; ?>>Primario</option>
                            <option value="secundario" <?php echo (isset($_POST['nuevo_rol']) && $_POST['nuevo_rol'] == 'secundario') ? 'selected' : ''; ?>>Secundario</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/usuarios/form_crear.php --- ?>
        <?php // ========================================================================= ?>