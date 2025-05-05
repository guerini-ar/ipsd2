<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/alumnos/form.php --- ?>
        <?php // <?php require 'views/alumnos/form.php'; ?>
        <?php // ========================================================================= ?>
        <div class="p-3">
            <h2><?php echo ($accion == 'editar') ? 'Editar Alumno y Responsable' : 'Agregar Nuevo Alumno y Responsable'; ?></h2>
            <div class="card p-4">
                <form action="index.php" method="post">
                    <input type="hidden" name="accion" value="<?php echo ($accion == 'editar') ? 'actualizar' : 'crear'; ?>">
                    <?php if ($accion == 'editar' && isset($id_alumno)): ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_alumno); ?>">
                    <?php endif; ?>

                    <h5 class="mb-3">Datos del Alumno</h5>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo isset($alumno_data['apellidos']) ? htmlspecialchars($alumno_data['apellidos']) : ''; ?>" maxlength="50">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo isset($alumno_data['nombres']) ? htmlspecialchars($alumno_data['nombres']) : ''; ?>" maxlength="50">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dni" class="form-label">DNI Alumno:</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo isset($alumno_data['dni']) ? htmlspecialchars($alumno_data['dni']) : ''; ?>" maxlength="8" pattern="\d{1,8}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?php echo isset($alumno_data['nacimiento']) ? htmlspecialchars($alumno_data['nacimiento']) : ''; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="genero" class="form-label">Género:</label>
                            <select class="form-select" id="genero" name="genero">
                                <option value="" <?php echo (!isset($alumno_data['genero']) || $alumno_data['genero'] === null || $alumno_data['genero'] === '') ? 'selected' : ''; ?>>Seleccionar...</option>
                                <option value="Masculino" <?php echo (isset($alumno_data['genero']) && $alumno_data['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Femenino" <?php echo (isset($alumno_data['genero']) && $alumno_data['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Otro" <?php echo (isset($alumno_data['genero']) && $alumno_data['genero'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                        </div>
                         <div class="col-md-4 mb-3">
                            <label for="curso" class="form-label">Curso:</label>
                            <input type="text" class="form-control" id="curso" name="curso" value="<?php echo isset($alumno_data['curso']) ? htmlspecialchars($alumno_data['curso']) : ''; ?>" maxlength="3">
                        </div>
                    </div>

                    <hr class="my-4"> <?php // Separador ?>

                    <h5 class="mb-3">Datos del Responsable</h5>
                     <div class="row g-3">
                         <div class="col-md-6 mb-3">
                            <label for="resp_nombre" class="form-label">Nombre Completo Responsable:</label>
                            <input type="text" class="form-control" id="resp_nombre" name="resp_nombre" value="<?php echo isset($alumno_data['resp_nombre']) ? htmlspecialchars($alumno_data['resp_nombre']) : ''; ?>" maxlength="100">
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="resp_dni" class="form-label">DNI Responsable:</label>
                            <input type="text" class="form-control" id="resp_dni" name="resp_dni" value="<?php echo isset($alumno_data['resp_dni']) ? htmlspecialchars($alumno_data['resp_dni']) : ''; ?>" maxlength="10">
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="resp_celular" class="form-label">Celular Responsable:</label>
                            <input type="text" class="form-control" id="resp_celular" name="resp_celular" value="<?php echo isset($alumno_data['resp_celular']) ? htmlspecialchars($alumno_data['resp_celular']) : ''; ?>" maxlength="20">
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="resp_email" class="form-label">Email Responsable:</label>
                            <input type="email" class="form-control" id="resp_email" name="resp_email" value="<?php echo isset($alumno_data['resp_email']) ? htmlspecialchars($alumno_data['resp_email']) : ''; ?>" maxlength="100">
                        </div>
                     </div>

                    <div class="mt-4"> <?php // Margen superior botones ?>
                        <button type="submit" class="btn btn-primary"><?php echo ($accion == 'editar') ? 'Actualizar Datos' : 'Guardar Alumno y Responsable'; ?></button>
                        <?php
                            $cancelar_url = "index.php?accion=leer&" . generar_parametros_url($filtros, $ordenar_por, $direccion, $registros_por_pagina) . "&pagina=" . $pagina_actual;
                        ?>
                        <a href="<?php echo $cancelar_url; ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/alumnos/form.php --- ?>
        <?php // ========================================================================= ?>