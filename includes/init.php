<?php

//includes
require_once "./includes/db_connection.php";

// =========================================================================
// --- ARCHIVO SUGERIDO: includes/init.php o similar ---
// =========================================================================
$mensaje = "";
$error = false;
// --- Acción por defecto es 'inicio' ---
$accion = isset($_REQUEST['accion']) ? $_REQUEST['accion'] : 'inicio';
$id_alumno = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$alumno_data = null; // Para el formulario de edición

// --- Lógica para Cerrar Sesión (pública) ---
if ($accion == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php?accion=inicio");
    exit;
}

// --- Definir acciones que requieren login ---
$acciones_protegidas = ['leer', 'crear', 'editar', 'eliminar', 'exportar_csv', 'exportar_txt', 'estadisticas']; // Añadido 'estadisticas'
$acciones_crud_post = ['actualizar']; // Acciones POST que también necesitan protección

// --- Comprobar si la acción actual requiere login Y si el usuario NO está logueado ---
$accion_real = ($accion == 'actualizar' && $_SERVER["REQUEST_METHOD"] == "POST") ? 'editar' : $accion;
$accion_real = ($accion == 'crear' && $_SERVER["REQUEST_METHOD"] == "POST") ? 'crear' : $accion_real;

if (in_array($accion_real, $acciones_protegidas) && !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// --- Comprobar si la acción requiere rol 'admin' Y el usuario NO lo tiene ---
if ($accion == 'estadisticas' && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin')) {
     // Podrías redirigir a inicio o mostrar un error de permisos
     header("Location: index.php?accion=inicio&error=permisos"); // Ejemplo redirigiendo
     exit;
}


// --- Variables para Filtro, Ordenación y Paginación (solo relevantes para accion=leer) ---
$filtros = [];
$ordenar_por = '';
$direccion = '';
$registros_por_pagina = 10;
$pagina_actual = 1;
$total_registros = 0; // Total filtrado para la tabla
$total_paginas = 0;
$offset = 0;
$total_varones_filtrado = 0; // Estadísticas específicas de género para la tabla filtrada
$total_mujeres_filtrado = 0; // Estadísticas específicas de género para la tabla filtrada
$cursos_unicos = [];
$hay_filtros_activos = false;
$columnas_validas = [];
$direccion_opuesta = 'DESC';
$where_sql = ""; // Inicializar where_sql
$where_clauses = []; // Inicializar para evitar warnings si no es accion=leer
$params_dynamic = []; // Inicializar
$types_dynamic = ""; // Inicializar

// Inicializar variables y construir WHERE solo si la acción es 'leer' o relacionada
if (in_array($accion, $acciones_protegidas) || $accion == 'actualizar') {
    $filtros = [
        'id' => isset($_GET['filtro_id']) ? trim($_GET['filtro_id']) : '',
        'apellidos' => isset($_GET['filtro_apellidos']) ? trim($_GET['filtro_apellidos']) : '',
        'nombres' => isset($_GET['filtro_nombres']) ? trim($_GET['filtro_nombres']) : '',
        'dni' => isset($_GET['filtro_dni']) ? trim($_GET['filtro_dni']) : '',
        'nacimiento' => isset($_GET['filtro_nacimiento']) ? trim($_GET['filtro_nacimiento']) : '',
        'genero' => isset($_GET['filtro_genero']) ? trim($_GET['filtro_genero']) : '',
        'curso' => isset($_GET['filtro_curso']) ? trim($_GET['filtro_curso']) : '',
        'resp_nombre' => isset($_GET['filtro_resp_nombre']) ? trim($_GET['filtro_resp_nombre']) : '',
        'resp_dni' => isset($_GET['filtro_resp_dni']) ? trim($_GET['filtro_resp_dni']) : '',
        'resp_celular' => isset($_GET['filtro_resp_celular']) ? trim($_GET['filtro_resp_celular']) : '',
        'resp_email' => isset($_GET['filtro_resp_email']) ? trim($_GET['filtro_resp_email']) : '',
    ];
    $columnas_validas = ['a.id', 'a.apellidos', 'a.nombres', 'a.dni', 'a.nacimiento', 'a.genero', 'a.curso', 'r.nombre_completo', 'r.dni', 'r.celular', 'r.email'];
    $ordenar_por_defecto = 'a.apellidos';
    $direccion_por_defecto = 'ASC';
    $ordenar_por_get = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : $ordenar_por_defecto;
    $ordenar_por = in_array($ordenar_por_get, $columnas_validas) ? $ordenar_por_get : $ordenar_por_defecto;
    $direccion = isset($_GET['direccion']) && in_array(strtoupper($_GET['direccion']), ['ASC', 'DESC']) ? strtoupper($_GET['direccion']) : $direccion_por_defecto;
    $direccion_opuesta = ($direccion == 'ASC') ? 'DESC' : 'ASC';
    $registros_por_pagina_opciones = [10, 25, 50, 100];
    $registros_por_pagina_defecto = 10;
    $registros_por_pagina = isset($_GET['rpp']) && in_array(intval($_GET['rpp']), $registros_por_pagina_opciones) ? intval($_GET['rpp']) : $registros_por_pagina_defecto;
    $pagina_actual = isset($_GET['pagina']) && intval($_GET['pagina']) > 0 ? intval($_GET['pagina']) : 1;

    // --- Obtener Cursos Únicos ---
    $sql_cursos = "SELECT DISTINCT curso FROM alumnos WHERE curso IS NOT NULL AND curso != '' ORDER BY curso ASC";
    $result_cursos = $conn->query($sql_cursos);
    if ($result_cursos) { while ($row_curso = $result_cursos->fetch_assoc()) { $cursos_unicos[] = $row_curso['curso']; } $result_cursos->free(); }

    // --- Construcción dinámica de WHERE y parámetros (para filtros) ---
    $like_apellidos = ''; $like_nombres = ''; $like_dni = ''; $like_resp_nombre = ''; $like_resp_dni = ''; $like_resp_celular = ''; $like_resp_email = '';
    $where_clauses = []; $params_dynamic = []; $types_dynamic = ""; $hay_filtros_activos = false;
    if (!empty($filtros['id'])) { $where_clauses[] = "a.id = ?"; $params_dynamic[] = &$filtros['id']; $types_dynamic .= "i"; $hay_filtros_activos = true; }
    if (!empty($filtros['apellidos'])) { $where_clauses[] = "a.apellidos LIKE ?"; $like_apellidos = "%" . $filtros['apellidos'] . "%"; $params_dynamic[] = &$like_apellidos; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['nombres'])) { $where_clauses[] = "a.nombres LIKE ?"; $like_nombres = "%" . $filtros['nombres'] . "%"; $params_dynamic[] = &$like_nombres; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['dni'])) { $where_clauses[] = "a.dni LIKE ?"; $like_dni = "%" . $filtros['dni'] . "%"; $params_dynamic[] = &$like_dni; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['nacimiento'])) { $where_clauses[] = "a.nacimiento = ?"; $params_dynamic[] = &$filtros['nacimiento']; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['genero'])) { $where_clauses[] = "a.genero = ?"; $params_dynamic[] = &$filtros['genero']; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['curso'])) { $where_clauses[] = "a.curso = ?"; $params_dynamic[] = &$filtros['curso']; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['resp_nombre'])) { $where_clauses[] = "r.nombre_completo LIKE ?"; $like_resp_nombre = "%" . $filtros['resp_nombre'] . "%"; $params_dynamic[] = &$like_resp_nombre; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['resp_dni'])) { $where_clauses[] = "r.dni LIKE ?"; $like_resp_dni = "%" . $filtros['resp_dni'] . "%"; $params_dynamic[] = &$like_resp_dni; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['resp_celular'])) { $where_clauses[] = "r.celular LIKE ?"; $like_resp_celular = "%" . $filtros['resp_celular'] . "%"; $params_dynamic[] = &$like_resp_celular; $types_dynamic .= "s"; $hay_filtros_activos = true; }
    if (!empty($filtros['resp_email'])) { $where_clauses[] = "r.email LIKE ?"; $like_resp_email = "%" . $filtros['resp_email'] . "%"; $params_dynamic[] = &$like_resp_email; $types_dynamic .= "s"; $hay_filtros_activos = true; }

    $where_sql = ""; if (!empty($where_clauses)) { $where_sql = " WHERE " . implode(" AND ", $where_clauses); }
}

// --- Calcular Estadísticas Generales (Siempre se calculan para inicio y estadísticas) ---
$stat_total_alumnos = 0;
$stat_total_cursos = 0;
$stat_cursos_inicial = 0;
$stat_cursos_primario = 0;
$stat_cursos_secundario = 0;
$stat_total_varones_general = 0; // Para dashboard
$stat_total_mujeres_general = 0; // Para dashboard
$datos_grafico_genero_curso = []; // Array para los datos del gráfico de barras
$datos_grafico_nivel = []; // Array para los datos del gráfico de torta

if ($accion == 'inicio' || $accion == 'estadisticas' || $accion == 'leer') {
    $sql_stat_alumnos = "SELECT COUNT(*) as total FROM alumnos";
    $result_stat_alumnos = $conn->query($sql_stat_alumnos);
    if ($result_stat_alumnos) { $stat_total_alumnos = $result_stat_alumnos->fetch_assoc()['total']; $result_stat_alumnos->free(); }

    $sql_stat_varones = "SELECT COUNT(*) as total FROM alumnos WHERE genero = 'Masculino'";
    $result_stat_varones = $conn->query($sql_stat_varones);
    if ($result_stat_varones) { $stat_total_varones_general = $result_stat_varones->fetch_assoc()['total']; $result_stat_varones->free(); }

    $sql_stat_mujeres = "SELECT COUNT(*) as total FROM alumnos WHERE genero = 'Femenino'";
    $result_stat_mujeres = $conn->query($sql_stat_mujeres);
    if ($result_stat_mujeres) { $stat_total_mujeres_general = $result_stat_mujeres->fetch_assoc()['total']; $result_stat_mujeres->free(); }

    $sql_stat_cursos = "SELECT COUNT(DISTINCT curso) as total FROM alumnos WHERE curso IS NOT NULL AND curso != ''";
    $result_stat_cursos = $conn->query($sql_stat_cursos);
    if ($result_stat_cursos) { $stat_total_cursos = $result_stat_cursos->fetch_assoc()['total']; $result_stat_cursos->free(); }

    $sql_cursos_nivel = "SELECT LEFT(curso, 1) as nivel, COUNT(DISTINCT curso) as total
                         FROM alumnos
                         WHERE curso IS NOT NULL AND curso != '' AND curso RLIKE '^[IPS]'
                         GROUP BY nivel";
    $result_cursos_nivel = $conn->query($sql_cursos_nivel);
    if($result_cursos_nivel) {
        while($row = $result_cursos_nivel->fetch_assoc()) {
            if ($row['nivel'] == 'I') $stat_cursos_inicial = $row['total'];
            elseif ($row['nivel'] == 'P') $stat_cursos_primario = $row['total'];
            elseif ($row['nivel'] == 'S') $stat_cursos_secundario = $row['total'];
        }
        $result_cursos_nivel->free();
    }

    // --- Obtener datos para el gráfico de Género por Curso ---
    $sql_grafico_genero = "SELECT curso,
                           SUM(CASE WHEN genero = 'Masculino' THEN 1 ELSE 0 END) as varones,
                           SUM(CASE WHEN genero = 'Femenino' THEN 1 ELSE 0 END) as mujeres
                    FROM alumnos
                    WHERE curso IS NOT NULL AND curso != ''
                    GROUP BY curso
                    ORDER BY curso ASC";
    $result_grafico_genero = $conn->query($sql_grafico_genero);
    if ($result_grafico_genero) {
        while ($row = $result_grafico_genero->fetch_assoc()) {
            $datos_grafico_genero_curso[] = $row;
        }
        $result_grafico_genero->free();
    }
    $json_datos_grafico_genero = json_encode($datos_grafico_genero_curso);

    // --- Obtener datos para el gráfico de Alumnos por Nivel ---
    $sql_grafico_nivel = "SELECT
                            SUM(CASE WHEN curso LIKE 'I%' THEN 1 ELSE 0 END) as inicial,
                            SUM(CASE WHEN curso LIKE 'P%' THEN 1 ELSE 0 END) as primario,
                            SUM(CASE WHEN curso LIKE 'S%' THEN 1 ELSE 0 END) as secundario
                          FROM alumnos
                          WHERE curso IS NOT NULL AND curso != '' AND curso RLIKE '^[IPS]'";
    $result_grafico_nivel = $conn->query($sql_grafico_nivel);
    if ($result_grafico_nivel) {
        $datos_grafico_nivel = $result_grafico_nivel->fetch_assoc();
        $result_grafico_nivel->free();
    }
    $json_datos_grafico_nivel = json_encode([
        'Inicial' => isset($datos_grafico_nivel['inicial']) ? (int)$datos_grafico_nivel['inicial'] : 0,
        'Primario' => isset($datos_grafico_nivel['primario']) ? (int)$datos_grafico_nivel['primario'] : 0,
        'Secundario' => isset($datos_grafico_nivel['secundario']) ? (int)$datos_grafico_nivel['secundario'] : 0,
    ]);
}

// =========================================================================
// --- FIN ARCHIVO SUGERIDO: includes/init.php ---
// =========================================================================

?>