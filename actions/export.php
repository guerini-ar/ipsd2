<?php
// =========================================================================
// --- ARCHIVO SUGERIDO: actions/export.php o controllers/ExportController.php ---
// =========================================================================
if ($accion == 'exportar_csv' || $accion == 'exportar_txt') {
    // ... (Código de exportación sin cambios) ...
    $sql_export = "SELECT a.id, a.apellidos, a.nombres, a.dni, a.nacimiento, a.genero, a.curso,
                          r.nombre_completo as resp_nombre, r.dni as resp_dni, r.celular as resp_celular, r.email as resp_email
                   FROM alumnos a
                   LEFT JOIN responsables r ON a.id = r.alumno_id"
                   . $where_sql;
    $sql_export .= " ORDER BY " . $ordenar_por . " " . $direccion;
    $stmt_export = $conn->prepare($sql_export);
    if ($stmt_export === false) { error_log("Error export prepare: ".$conn->error); die("Error export."); }
    if (!empty($params_dynamic)) { call_user_func_array([$stmt_export, 'bind_param'], array_merge([$types_dynamic], $params_dynamic)); }
    if (!$stmt_export->execute()) { error_log("Error export execute: ".$stmt_export->error); die("Error export."); }
    $result_export = $stmt_export->get_result();
    $previous_error_reporting = error_reporting(0); ini_set('display_errors', 0);
    if ($accion == 'exportar_csv') {
        $filename = "alumnos_responsables_" . date('Ymd') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "\xEF\xBB\xBF"; $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Alumno', 'Apellidos Alumno', 'Nombres Alumno', 'DNI Alumno', 'Nacimiento', 'Género', 'Curso', 'Nombre Responsable', 'DNI Responsable', 'Celular Responsable', 'Email Responsable'], ';');
        if ($result_export) { while ($row = $result_export->fetch_assoc()) { $row_csv = [ str_pad((isset($row['id'])?$row['id']:''), 11, '0', STR_PAD_LEFT), isset($row['apellidos'])?$row['apellidos']:'', isset($row['nombres'])?$row['nombres']:'', isset($row['dni'])?$row['dni']:'', isset($row['nacimiento'])?$row['nacimiento']:'', isset($row['genero'])?$row['genero']:'', isset($row['curso'])?$row['curso']:'', isset($row['resp_nombre'])?$row['resp_nombre']:'', isset($row['resp_dni'])?$row['resp_dni']:'', isset($row['resp_celular'])?$row['resp_celular']:'', isset($row['resp_email'])?$row['resp_email']:'' ]; fputcsv($output, $row_csv, ';'); } }
        fclose($output);
    } elseif ($accion == 'exportar_txt') {
        $filename = "alumnos_responsables_" . date('Ymd') . ".txt";
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo "ID Alumno\tApellidos\tNombres\tDNI Alumno\tNacimiento\tGénero\tCurso\tNombre Resp.\tDNI Resp.\tCelular Resp.\tEmail Resp.\n"; echo str_repeat("--------\t", 11) . "\n";
        if ($result_export) { while ($row = $result_export->fetch_assoc()) { echo str_pad((isset($row["id"])?$row["id"]:''), 11, '0', STR_PAD_LEFT) . "\t"; echo (isset($row['apellidos'])?$row['apellidos']:'') . "\t"; echo (isset($row['nombres'])?$row['nombres']:'') . "\t"; echo (isset($row['dni'])?$row['dni']:'') . "\t"; echo (isset($row['nacimiento'])?$row['nacimiento']:'') . "\t"; echo (isset($row['genero'])?$row['genero']:'') . "\t"; echo (isset($row['curso'])?$row['curso']:'') . "\t"; echo (isset($row['resp_nombre'])?$row['resp_nombre']:'') . "\t"; echo (isset($row['resp_dni'])?$row['resp_dni']:'') . "\t"; echo (isset($row['resp_celular'])?$row['resp_celular']:'') . "\t"; echo (isset($row['resp_email'])?$row['resp_email']:'') . "\n"; } }
    }
    error_reporting($previous_error_reporting); ini_set('display_errors', 1);
    if ($result_export) $result_export->free(); $stmt_export->close(); exit;
}
// =========================================================================
// --- FIN ARCHIVO SUGERIDO: actions/export.php ---
// =========================================================================
?>