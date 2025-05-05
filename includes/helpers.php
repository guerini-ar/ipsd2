<?php

// =========================================================================
// --- ARCHIVO SUGERIDO: includes/helpers.php o functions.php ---
// =========================================================================
function crear_enlace_ordenacion($columna, $texto_mostrar, $ordenar_actual, $direccion_actual, $direccion_opuesta, $filtros_actuales, $rpp_actual) {
  $columna_param = urlencode($columna);
  $nueva_direccion = ($ordenar_actual == $columna) ? $direccion_opuesta : 'ASC';
  $params_url = generar_parametros_url($filtros_actuales, $columna_param, $nueva_direccion, $rpp_actual);
  // --- CORRECCIÓN PAGINACIÓN: Añadir accion=leer ---
  $url = "index.php?accion=leer&" . $params_url . "&pagina=1";
  $indicador = ''; if ($ordenar_actual == $columna) { $indicador = ($direccion_actual == 'ASC') ? ' ▲' : ' ▼'; }
  return '<th><a href="' . $url . '" class="text-dark text-decoration-none">' . htmlspecialchars($texto_mostrar) . $indicador . '</a></th>';
}
function generar_parametros_url($filtros, $ordenar, $direccion, $rpp) {
  $params = []; foreach ($filtros as $key => $value) { if (!empty($value)) { $params['filtro_' . $key] = $value; } }
  $params['ordenar_por'] = $ordenar; $params['direccion'] = $direccion; $params['rpp'] = $rpp;
  return http_build_query($params);
}
// =========================================================================
// --- FIN ARCHIVO SUGERIDO: includes/helpers.php ---
// =========================================================================

?>