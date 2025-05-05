<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/alumnos/list.php --- ?>
        <?php // <?php require 'views/alumnos/list.php'; ?>
        <?php // ========================================================================= ?>
        <div class="p-3">
            <?php // --- Filtros (podría ser 'views/alumnos/partials/filters.php') --- ?>
            <div class="filtros-columnas">
                 <form action="index.php" method="get">
                     <input type="hidden" name="accion" value="leer">
                     <input type="hidden" name="ordenar_por" value="<?php echo htmlspecialchars($ordenar_por); ?>">
                     <input type="hidden" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>">
                     <input type="hidden" name="rpp" value="<?php echo $registros_por_pagina; ?>">
                     <input type="hidden" name="pagina" value="1">

                     <div class="row g-2 align-items-end">
                         <div class="col-auto">
                             <label for="filtro_id" class="form-label">ID Al.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_id" name="filtro_id" value="<?php echo htmlspecialchars($filtros['id']); ?>" style="width: 70px;">
                         </div>
                         <div class="col">
                             <label for="filtro_apellidos" class="form-label">Apellidos Al.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_apellidos" name="filtro_apellidos" value="<?php echo htmlspecialchars($filtros['apellidos']); ?>">
                         </div>
                         <div class="col">
                             <label for="filtro_nombres" class="form-label">Nombres Al.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_nombres" name="filtro_nombres" value="<?php echo htmlspecialchars($filtros['nombres']); ?>">
                         </div>
                         <div class="col-auto">
                             <label for="filtro_dni" class="form-label">DNI Al.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_dni" name="filtro_dni" value="<?php echo htmlspecialchars($filtros['dni']); ?>" style="width: 100px;">
                         </div>
                         <div class="col">
                             <label for="filtro_nacimiento" class="form-label">Nacimiento</label>
                             <input type="date" class="form-control form-control-sm" id="filtro_nacimiento" name="filtro_nacimiento" value="<?php echo htmlspecialchars($filtros['nacimiento']); ?>">
                         </div>
                         <div class="col">
                             <label for="filtro_genero" class="form-label">Género Al.</label>
                             <select class="form-select form-select-sm" id="filtro_genero" name="filtro_genero">
                                 <option value="" <?php echo ($filtros['genero'] == '') ? 'selected' : ''; ?>>Todos</option>
                                 <option value="Masculino" <?php echo ($filtros['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                 <option value="Femenino" <?php echo ($filtros['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                                 <option value="Otro" <?php echo ($filtros['genero'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                             </select>
                         </div>
                          <div class="col">
                             <label for="filtro_curso" class="form-label">Curso</label>
                             <select class="form-select form-select-sm" id="filtro_curso" name="filtro_curso">
                                 <option value="" <?php echo ($filtros['curso'] == '') ? 'selected' : ''; ?>>Todos</option>
                                 <?php foreach ($cursos_unicos as $curso_opcion): ?>
                                     <option value="<?php echo htmlspecialchars($curso_opcion); ?>" <?php echo ($filtros['curso'] == $curso_opcion) ? 'selected' : ''; ?>>
                                         <?php echo htmlspecialchars($curso_opcion); ?>
                                     </option>
                                 <?php endforeach; ?>
                             </select>
                         </div>
                         <?php // --- Nuevos filtros para responsable --- ?>
                         <div class="col">
                             <label for="filtro_resp_nombre" class="form-label">Nombre Resp.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_resp_nombre" name="filtro_resp_nombre" value="<?php echo htmlspecialchars($filtros['resp_nombre']); ?>">
                         </div>
                         <div class="col-auto">
                             <label for="filtro_resp_dni" class="form-label">DNI Resp.</label>
                             <input type="text" class="form-control form-control-sm filtro-resp-compacto" id="filtro_resp_dni" name="filtro_resp_dni" value="<?php echo htmlspecialchars($filtros['resp_dni']); ?>">
                         </div>
                          <div class="col">
                             <label for="filtro_resp_celular" class="form-label">Celular Resp.</label>
                             <input type="text" class="form-control form-control-sm filtro-resp-compacto" id="filtro_resp_celular" name="filtro_resp_celular" value="<?php echo htmlspecialchars($filtros['resp_celular']); ?>">
                         </div>
                          <div class="col">
                             <label for="filtro_resp_email" class="form-label">Email Resp.</label>
                             <input type="text" class="form-control form-control-sm" id="filtro_resp_email" name="filtro_resp_email" value="<?php echo htmlspecialchars($filtros['resp_email']); ?>">
                         </div>
                         <?php // --- Fin nuevos filtros --- ?>
                         <div class="col-auto"> <?php // Columna para botones ?>
                             <button type="submit" class="btn btn-primary btn-sm">Aplicar</button>
                             <?php if ($hay_filtros_activos): ?>
                                <?php $limpiar_filtros_url = "index.php?accion=leer&ordenar_por=".urlencode($ordenar_por)."&direccion=".urlencode($direccion)."&rpp=".$registros_por_pagina."&pagina=1"; ?>
                                <a href="<?php echo $limpiar_filtros_url; ?>" class="btn btn-secondary btn-sm">Limpiar</a>
                             <?php endif; ?>
                         </div>
                     </div>
                 </form>
            </div>

            <?php // --- Tabla de Resultados (movida aquí) --- ?>
            <div class="table-responsive-md">
                <table class="table table-striped table-bordered table-hover table-sm align-middle"> <?php // Añadido align-middle ?>
                    <thead class="table-light">
                        <tr>
                            <?php // Cabeceras Alumno ?>
                            <?php echo crear_enlace_ordenacion('a.id', 'ID Al.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.apellidos', 'Apellidos Al.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.nombres', 'Nombres Al.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.dni', 'DNI Al.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.nacimiento', 'Nacimiento', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.genero', 'Género Al.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('a.curso', 'Curso', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php // Cabeceras Responsable (nuevas) ?>
                            <?php echo crear_enlace_ordenacion('r.nombre_completo', 'Nombre Resp.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('r.dni', 'DNI Resp.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('r.celular', 'Celular Resp.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <?php echo crear_enlace_ordenacion('r.email', 'Email Resp.', $ordenar_por, $direccion, $direccion_opuesta, $filtros, $registros_por_pagina); ?>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // --- Lógica de consulta y muestra de datos (con JOIN) ---
                        $sql_select = "SELECT a.id, a.apellidos, a.nombres, a.dni, a.nacimiento, a.genero, a.curso,
                                              r.nombre_completo as resp_nombre, r.dni as resp_dni, r.celular as resp_celular, r.email as resp_email
                                       FROM alumnos a
                                       LEFT JOIN responsables r ON a.id = r.alumno_id"
                                       . $where_sql; // Aplicar filtros
                        $sql_select .= " ORDER BY " . $ordenar_por . " " . $direccion;
                        $sql_select .= " LIMIT ? OFFSET ?";
                        $types_select = $types_dynamic . "ii"; $params_select = $params_dynamic; $params_select[] = &$registros_por_pagina; $params_select[] = &$offset;
                        $stmt_select = $conn->prepare($sql_select); $result_select = null;
                        if ($stmt_select === false) { echo "<tr><td colspan='12'>Error prepare: " . htmlspecialchars($conn->error) . "</td></tr>"; }
                        else { if (!empty($types_select)) { call_user_func_array([$stmt_select, 'bind_param'], array_merge([$types_select], $params_select)); } if ($stmt_select->execute()) { $result_select = $stmt_select->get_result(); } else { echo "<tr><td colspan='12'>Error execute: " . htmlspecialchars($stmt_select->error) . "</td></tr>"; } }
                        if ($result_select && $result_select->num_rows > 0):
                            while($row = $result_select->fetch_assoc()):
                        ?>
                                <tr>
                                    <?php // Datos Alumno ?>
                                    <td><?php echo htmlspecialchars(str_pad($row["id"], 11, '0', STR_PAD_LEFT)); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["apellidos"]) ? $row["apellidos"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["nombres"]) ? $row["nombres"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["dni"]) ? $row["dni"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["nacimiento"]) ? $row["nacimiento"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["genero"]) ? $row["genero"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["curso"]) ? $row["curso"] : 'N/D'); ?></td>
                                    <?php // Datos Responsable (nuevos) ?>
                                    <td><?php echo htmlspecialchars(isset($row["resp_nombre"]) ? $row["resp_nombre"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["resp_dni"]) ? $row["resp_dni"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["resp_celular"]) ? $row["resp_celular"] : 'N/D'); ?></td>
                                    <td><?php echo htmlspecialchars(isset($row["resp_email"]) ? $row["resp_email"] : 'N/D'); ?></td>
                                    <td class="acciones">
                                        <?php $base_params=generar_parametros_url($filtros,$ordenar_por,$direccion,$registros_por_pagina);$editar_url="index.php?accion=editar&id=".$row["id"]."&".$base_params."&pagina=".$pagina_actual;$eliminar_url="index.php?accion=eliminar&id=".$row["id"]."&".$base_params."&pagina=".$pagina_actual; ?>
                                        <a class="btn btn-warning btn-sm" href="<?php echo $editar_url; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="<?php echo $eliminar_url; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este alumno y su responsable asociado?');">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            endwhile;
                        else:
                            $mensaje_no_resultados="No se encontraron alumnos"; if($hay_filtros_activos){$mensaje_no_resultados.=" que coincidan";} $mensaje_no_resultados.="."; if($stmt_select && !$result_select){}else{echo "<tr><td colspan='12' class='text-center text-muted'>".$mensaje_no_resultados."</td></tr>";}
                        endif;
                        if ($stmt_select) { $stmt_select->close(); } if ($result_select instanceof mysqli_result) { $result_select->free(); }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php // --- Fin Tabla de Resultados --- ?>


            <?php // --- Estadísticas (movido aquí) --- ?>
             <div class="alert alert-info d-flex flex-wrap gap-3" role="alert">
                 <span>Total Registros: <strong class="text-primary"><?php echo $total_registros; ?></strong></span>
                 <span>Varones: <strong class="text-primary"><?php echo $total_varones_filtrado; ?></strong></span>
                 <span>Mujeres: <strong class="text-primary"><?php echo $total_mujeres_filtrado; ?></strong></span>
             </div>

            <?php // --- Controles RPP y Agregar (movido aquí) --- ?>
             <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                 <div class="rpp-form">
                     <form action="index.php" method="get" class="d-flex align-items-center gap-2">
                         <input type="hidden" name="accion" value="leer">
                         <?php foreach ($filtros as $key => $value): if (!empty($value)): ?>
                             <input type="hidden" name="filtro_<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>">
                         <?php endif; endforeach; ?>
                         <input type="hidden" name="ordenar_por" value="<?php echo htmlspecialchars($ordenar_por); ?>">
                         <input type="hidden" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>">
                         <input type="hidden" name="pagina" value="1">
                         <label for="rpp" class="form-label mb-0 me-1">Mostrar:</label>
                         <select name="rpp" id="rpp" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                             <?php foreach ($registros_por_pagina_opciones as $opcion_rpp): ?>
                                 <option value="<?php echo $opcion_rpp; ?>" <?php echo ($opcion_rpp == $registros_por_pagina) ? 'selected' : ''; ?>>
                                     <?php echo $opcion_rpp; ?>
                                 </option>
                             <?php endforeach; ?>
                         </select>
                         <span class="ms-1">por página</span>
                     </form>
                </div>
                <a href="index.php?accion=crear" class="btn btn-success btn-sm">Agregar Nuevo Alumno</a>
            </div>

            <?php // --- Exportación y Backup Info (movido aquí) --- ?>
            <div class="exportar-seccion d-flex align-items-center flex-wrap gap-2">
                <span>Exportar:</span>
                <?php $export_params = generar_parametros_url($filtros, $ordenar_por, $direccion, $registros_por_pagina); ?>
                <a href="index.php?accion=exportar_csv&<?php echo $export_params; ?>" class="btn btn-info btn-sm text-white" target="_blank">CSV</a>
                <a href="index.php?accion=exportar_txt&<?php echo $export_params; ?>" class="btn btn-secondary btn-sm" target="_blank">TXT</a>
                <button class="btn btn-warning btn-sm" disabled title="Requiere biblioteca PDF">PDF</button>
                <button class="btn btn-warning btn-sm" disabled title="Requiere biblioteca Excel">Excel</button>
                <button class="btn btn-warning btn-sm" disabled title="Requiere API Google Sheets">G. Sheets</button>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-backup-phpmyadmin">Instrucciones Backup</button>
                <?php endif; ?>
            </div>
            <?php // --- Fin Exportación y Backup Info --- ?>


            <?php // --- Paginación (podría ser 'views/alumnos/partials/pagination.php') --- ?>
            <div class="d-flex justify-content-center"> <?php // Centrar paginación ?>
                <nav aria-label="Paginación de alumnos" class="paginacion">
                    <?php if ($total_paginas > 0): ?>
                        <ul class="pagination pagination-sm"> <?php // Clases Bootstrap para paginación ?>
                            <?php // --- CORRECCIÓN PAGINACIÓN: Añadir accion=leer --- ?>
                            <?php $base_url_pag = "index.php?accion=leer&" . generar_parametros_url($filtros, $ordenar_por, $direccion, $registros_por_pagina); ?>

                            <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $base_url_pag . '&pagina=' . ($pagina_actual - 1); ?>" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <?php
                            $rango_paginas=2;$inicio_bucle=max(1,$pagina_actual-$rango_paginas);$fin_bucle=min($total_paginas,$pagina_actual+$rango_paginas);
                            if($inicio_bucle > 1) echo '<li class="page-item"><a class="page-link" href="'.$base_url_pag.'&pagina=1">1</a></li>'.($inicio_bucle > 2 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : '');
                            for($i=$inicio_bucle;$i<=$fin_bucle;$i++): ?>
                                <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>" <?php echo ($i == $pagina_actual) ? 'aria-current="page"' : ''; ?>>
                                    <a class="page-link" href="<?php echo $base_url_pag . '&pagina=' . $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor;
                            if($fin_bucle < $total_paginas) echo ($fin_bucle < $total_paginas - 1 ? '<li class="page-item disabled"><span class="page-link">...</span></li>' : '') . '<li class="page-item"><a class="page-link" href="'.$base_url_pag.'&pagina='.$total_paginas.'">'.$total_paginas.'</a></li>';
                            ?>

                            <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $base_url_pag . '&pagina=' . ($pagina_actual + 1); ?>" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                 </nav>
             </div>
             <?php if ($total_paginas > 0): ?>
                <div class="info-paginacion">
                    Mostrando registros del <?php echo $offset + 1; ?> al <?php echo min($offset + $registros_por_pagina, $total_registros); ?> de un total de <?php echo $total_registros; ?>
                </div>
             <?php endif; ?>
        </div> <?php // Cierre de p-3 ?>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/alumnos/list.php --- ?>
        <?php // ========================================================================= ?>