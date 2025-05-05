<?php

// =========================================================================
// --- ARCHIVO SUGERIDO: includes/calculations.php o models/AlumnoModel.php ---
// =========================================================================
// Calcular estadísticas y paginación solo si la acción es 'leer'
if ($accion == 'leer') {
  // 1. Contar total de registros (con filtro y JOIN)
  $sql_count = "SELECT COUNT(a.id) as total FROM alumnos a LEFT JOIN responsables r ON a.id = r.alumno_id" . $where_sql; // $where_sql ya incluye filtro de rol
  $stmt_count = $conn->prepare($sql_count);
  if ($stmt_count) { if (!empty($params_dynamic)) { $params_count_total=$params_dynamic; call_user_func_array([$stmt_count,'bind_param'],array_merge([$types_dynamic],$params_count_total)); } if ($stmt_count->execute()) { $result_count=$stmt_count->get_result(); if ($result_count) { $total_registros=$result_count->fetch_assoc()['total']; $result_count->free(); } } else { $mensaje.=" Error count: ".$stmt_count->error; $error=true; } $stmt_count->close(); } else { $mensaje.=" Error count prepare: ".$conn->error; $error=true; }
  // 2. Calcular total de páginas y offset (sin cambios)
  if ($total_registros > 0) { $total_paginas=ceil($total_registros/$registros_por_pagina); if ($pagina_actual>$total_paginas)$pagina_actual=$total_paginas; if ($pagina_actual<1)$pagina_actual=1; $offset=($pagina_actual-1)*$registros_por_pagina; } else { $total_paginas=0; $pagina_actual=1; $offset=0; }
  // 3. Calcular Estadísticas de Género (con filtros y JOIN) - Para la tabla filtrada
  // --- where_sql ya incluye el filtro de rol si aplica ---
  $sql_count_varones_f="SELECT COUNT(a.id) as total FROM alumnos a LEFT JOIN responsables r ON a.id = r.alumno_id".$where_sql.(empty($where_sql)?" WHERE":" AND")." a.genero = ?"; $stmt_varones_f=$conn->prepare($sql_count_varones_f);
  if($stmt_varones_f){$params_varones_f=$params_dynamic;$genero_varon='Masculino';$params_varones_f[]=&$genero_varon;$types_varones_f=$types_dynamic."s";call_user_func_array([$stmt_varones_f,'bind_param'],array_merge([$types_varones_f],$params_varones_f));if($stmt_varones_f->execute()){$result_varones_f=$stmt_varones_f->get_result();if($result_varones_f){$total_varones_filtrado=$result_varones_f->fetch_assoc()['total'];$result_varones_f->free();}}else{$mensaje.=" Error count varones: ".$stmt_varones_f->error;$error=true;}$stmt_varones_f->close();}else{$mensaje.=" Error prepare varones: ".$conn->error;$error=true;}
  $sql_count_mujeres_f="SELECT COUNT(a.id) as total FROM alumnos a LEFT JOIN responsables r ON a.id = r.alumno_id".$where_sql.(empty($where_sql)?" WHERE":" AND")." a.genero = ?"; $stmt_mujeres_f=$conn->prepare($sql_count_mujeres_f);
  if($stmt_mujeres_f){$params_mujeres_f=$params_dynamic;$genero_mujer='Femenino';$params_mujeres_f[]=&$genero_mujer;$types_mujeres_f=$types_dynamic."s";call_user_func_array([$stmt_mujeres_f,'bind_param'],array_merge([$types_mujeres_f],$params_mujeres_f));if($stmt_mujeres_f->execute()){$result_mujeres_f=$stmt_mujeres_f->get_result();if($result_mujeres_f){$total_mujeres_filtrado=$result_mujeres_f->fetch_assoc()['total'];$result_mujeres_f->free();}}else{$mensaje.=" Error count mujeres: ".$stmt_mujeres_f->error;$error=true;}$stmt_mujeres_f->close();}else{$mensaje.=" Error prepare mujeres: ".$conn->error;$error=true;}
}
// =========================================================================
// --- FIN ARCHIVO SUGERIDO: includes/calculations.php ---
// =========================================================================

?>