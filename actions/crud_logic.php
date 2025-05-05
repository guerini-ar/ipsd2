<?php

// =========================================================================
// --- ARCHIVO SUGERIDO: actions/crud_logic.php o controllers/AlumnosController.php ---
// =========================================================================
// --- Lógica CRUD (POST/GET para Crear/Editar/Eliminar) ---
// Solo ejecutar si la acción está protegida
if (in_array($accion_real, $acciones_protegidas) || $accion == 'actualizar' || $accion == 'crear') {
  // == PROCESAR ACCIONES POST ==
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // --- Procesamiento para GUARDAR USUARIO ---
      if (isset($_POST['accion_form']) && $_POST['accion_form'] == 'guardar_usuario') {
           // Asegurarse que solo admin pueda ejecutar esto (doble chequeo)
          if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
              die("Acceso denegado."); // O manejar de forma más elegante
          }

          $nuevo_usuario = isset($_POST['nuevo_usuario']) ? trim($_POST['nuevo_usuario']) : '';
          $nuevo_email = isset($_POST['nuevo_email']) ? trim($_POST['nuevo_email']) : null;
          $nuevo_pass = isset($_POST['nuevo_pass']) ? $_POST['nuevo_pass'] : '';
          $nuevo_pass_confirm = isset($_POST['nuevo_pass_confirm']) ? $_POST['nuevo_pass_confirm'] : '';
          $nuevo_rol = isset($_POST['nuevo_rol']) ? $_POST['nuevo_rol'] : '';

          // Validaciones
          if (empty($nuevo_usuario) || empty($nuevo_pass) || empty($nuevo_pass_confirm) || empty($nuevo_rol)) {
              $mensaje = "Error: Nombre de usuario, contraseña y rol son obligatorios.";
              $error = true;
          } elseif ($nuevo_pass !== $nuevo_pass_confirm) {
              $mensaje = "Error: Las contraseñas no coinciden.";
              $error = true;
          } elseif (!empty($nuevo_email) && !filter_var($nuevo_email, FILTER_VALIDATE_EMAIL)) {
               $mensaje = "Error: El formato del email no es válido.";
               $error = true;
          } else {
              // Verificar si el usuario ya existe
              $sql_check = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
              $stmt_check = $conn->prepare($sql_check);
              $stmt_check->bind_param("s", $nuevo_usuario);
              $stmt_check->execute();
              $stmt_check->store_result();
              if ($stmt_check->num_rows > 0) {
                  $mensaje = "Error: El nombre de usuario ya existe.";
                  $error = true;
              }
              $stmt_check->close();

               // Verificar si el email ya existe (si se proporcionó)
               if (!$error && !empty($nuevo_email)) {
                   $sql_check_email = "SELECT id FROM usuarios WHERE email = ?";
                   $stmt_check_email = $conn->prepare($sql_check_email);
                   $stmt_check_email->bind_param("s", $nuevo_email);
                   $stmt_check_email->execute();
                   $stmt_check_email->store_result();
                   if ($stmt_check_email->num_rows > 0) {
                       $mensaje = "Error: El email ya está registrado.";
                       $error = true;
                   }
                   $stmt_check_email->close();
               }
          }

          // Si no hay errores, proceder a insertar
          if (!$error) {
              $contrasena_hash = password_hash($nuevo_pass, PASSWORD_DEFAULT);
              $sql_insert_user = "INSERT INTO usuarios (nombre_usuario, contrasena_hash, email, rol) VALUES (?, ?, ?, ?)";
              $stmt_insert_user = $conn->prepare($sql_insert_user);
              if ($stmt_insert_user === false) {
                   $mensaje = "Error al preparar la inserción de usuario: " . $conn->error;
                   $error = true;
              } else {
                  // Usar NULL si el email está vacío
                  $email_param = !empty($nuevo_email) ? $nuevo_email : null;
                  $stmt_insert_user->bind_param("ssss", $nuevo_usuario, $contrasena_hash, $email_param, $nuevo_rol);
                  if ($stmt_insert_user->execute()) {
                      $mensaje = "Usuario '" . htmlspecialchars($nuevo_usuario) . "' creado exitosamente.";
                      // Limpiar datos del formulario para la siguiente creación
                      $_POST = array(); // Limpiar POST para que el form aparezca vacío
                  } else {
                      $mensaje = "Error al crear el usuario: " . $stmt_insert_user->error;
                      $error = true;
                  }
                  $stmt_insert_user->close();
              }
          }
           // Mantener la acción actual para mostrar el formulario de nuevo
          $accion = 'crear_usuario';

      } // Fin if accion_form == 'guardar_usuario'

      // --- Procesamiento para Crear/Actualizar ALUMNO ---
      elseif (isset($_POST['accion']) && ($_POST['accion'] == 'crear' || $_POST['accion'] == 'actualizar')) {
          // ... (Código POST para Crear/Actualizar Alumno y Responsable, sin cambios) ...
          $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : null;
          $nombres = isset($_POST['nombres']) ? trim($_POST['nombres']) : null;
          $dni_alumno = isset($_POST['dni']) ? trim($_POST['dni']) : null;
          $nacimiento = isset($_POST['nacimiento']) ? trim($_POST['nacimiento']) : null;
          $genero = isset($_POST['genero']) ? trim($_POST['genero']) : null;
          $curso = isset($_POST['curso']) ? trim($_POST['curso']) : null;
          $resp_nombre = isset($_POST['resp_nombre']) ? trim($_POST['resp_nombre']) : null;
          $resp_dni = isset($_POST['resp_dni']) ? trim($_POST['resp_dni']) : null;
          $resp_celular = isset($_POST['resp_celular']) ? trim($_POST['resp_celular']) : null;
          $resp_email = isset($_POST['resp_email']) ? trim($_POST['resp_email']) : null;
          $post_accion = isset($_POST['accion']) ? $_POST['accion'] : null;
          $post_id_alumno = isset($_POST['id']) ? $_POST['id'] : null;
          $apellidos = empty($apellidos)?null:$apellidos; $nombres = empty($nombres)?null:$nombres; $dni_alumno = empty($dni_alumno)?null:$dni_alumno; $nacimiento = empty($nacimiento)?null:$nacimiento; $genero = empty($genero)?null:$genero; $curso = empty($curso)?null:$curso;
          $resp_nombre = empty($resp_nombre)?null:$resp_nombre; $resp_dni = empty($resp_dni)?null:$resp_dni; $resp_celular = empty($resp_celular)?null:$resp_celular; $resp_email = empty($resp_email)?null:$resp_email;
          if ($dni_alumno !== null && !preg_match('/^\d{1,8}$/', $dni_alumno)) { $mensaje = "Error: DNI de Alumno inválido."; $error = true; }
          elseif ($nacimiento !== null && !empty($nacimiento) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $nacimiento)) { $mensaje = "Error: Fecha de Nacimiento inválida."; $error = true; }
          elseif ($resp_dni !== null && !empty($resp_dni) && !preg_match('/^\d{1,10}$/', $resp_dni)) { $mensaje = "Error: DNI de Responsable inválido."; $error = true; }
          elseif ($resp_email !== null && !empty($resp_email) && !filter_var($resp_email, FILTER_VALIDATE_EMAIL)) { $mensaje = "Error: Email de Responsable inválido."; $error = true; }
          if ($error) { $alumno_data = $_POST; $accion = $post_accion == 'actualizar' ? 'editar' : 'crear'; if ($accion == 'editar') $id_alumno = $post_id_alumno; }
          else {
              $conn->begin_transaction(); $operacion_exitosa = true;
              if ($post_accion == 'crear') {
                  $sql_alumno = "INSERT INTO alumnos (apellidos, nombres, dni, nacimiento, genero, curso) VALUES (?, ?, ?, ?, ?, ?)"; $stmt_alumno = $conn->prepare($sql_alumno);
                  if ($stmt_alumno === false) { $mensaje = "Error INSERT alumno prepare: " . $conn->error; $operacion_exitosa = false; }
                  else { $stmt_alumno->bind_param("ssssss", $apellidos, $nombres, $dni_alumno, $nacimiento, $genero, $curso); if ($stmt_alumno->execute()) { $nuevo_alumno_id = $conn->insert_id; } else { $mensaje = "Error INSERT alumno execute: " . $stmt_alumno->error; $operacion_exitosa = false; } $stmt_alumno->close(); }
                  if ($operacion_exitosa && isset($nuevo_alumno_id)) {
                      $sql_resp = "INSERT INTO responsables (alumno_id, nombre_completo, dni, celular, email) VALUES (?, ?, ?, ?, ?)"; $stmt_resp = $conn->prepare($sql_resp);
                      if ($stmt_resp === false) { $mensaje = "Error INSERT resp prepare: " . $conn->error; $operacion_exitosa = false; }
                      else { $stmt_resp->bind_param("issss", $nuevo_alumno_id, $resp_nombre, $resp_dni, $resp_celular, $resp_email); if (!$stmt_resp->execute()) { $mensaje = "Error INSERT resp execute: " . $stmt_resp->error; if ($conn->errno == 1062) { $mensaje .= " (ID Alumno duplicado)"; } $operacion_exitosa = false; } $stmt_resp->close(); }
                  }
              } elseif ($post_accion == 'actualizar' && $post_id_alumno) {
                  $sql_alumno = "UPDATE alumnos SET apellidos=?, nombres=?, dni=?, nacimiento=?, genero=?, curso=? WHERE id=?"; $stmt_alumno = $conn->prepare($sql_alumno);
                  if ($stmt_alumno === false) { $mensaje = "Error UPDATE alumno prepare: " . $conn->error; $operacion_exitosa = false; }
                  else { $stmt_alumno->bind_param("ssssssi", $apellidos, $nombres, $dni_alumno, $nacimiento, $genero, $curso, $post_id_alumno); if (!$stmt_alumno->execute()) { $mensaje = "Error UPDATE alumno execute: " . $stmt_alumno->error; $operacion_exitosa = false; } $stmt_alumno->close(); }
                  if ($operacion_exitosa) {
                      $sql_resp = "INSERT INTO responsables (alumno_id, nombre_completo, dni, celular, email) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nombre_completo = VALUES(nombre_completo), dni = VALUES(dni), celular = VALUES(celular), email = VALUES(email)"; $stmt_resp = $conn->prepare($sql_resp);
                       if ($stmt_resp === false) { $mensaje = "Error INSERT/UPDATE resp prepare: " . $conn->error; $operacion_exitosa = false; }
                       else { $stmt_resp->bind_param("issss", $post_id_alumno, $resp_nombre, $resp_dni, $resp_celular, $resp_email); if (!$stmt_resp->execute()) { $mensaje = "Error INSERT/UPDATE resp execute: " . $stmt_resp->error; $operacion_exitosa = false; } $stmt_resp->close(); }
                  }
              }
              if ($operacion_exitosa) { $conn->commit(); $mensaje = ($post_accion == 'crear') ? "Alumno y responsable creados." : "Alumno y responsable actualizados."; $accion = 'leer'; }
              else { $conn->rollback(); $error = true; $alumno_data = $_POST; $accion = $post_accion == 'actualizar' ? 'editar' : 'crear'; if ($accion == 'editar') $id_alumno = $post_id_alumno; }
          }
      } // Fin elseif accion crear/actualizar alumno

  } // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")

  // == PROCESAR ACCIONES GET o si hubo error POST ==
  // (Podría estar en actions/alumno_eliminar.php o dentro de index.php)
  if (($_SERVER["REQUEST_METHOD"] == "GET" || $error) && $accion != 'logout' && $accion != 'inicio') {
      if ($accion=='eliminar' && $id_alumno && !$error) {
          $sql="DELETE FROM alumnos WHERE id=?"; $stmt=$conn->prepare($sql);
          if($stmt===false){$mensaje="Error DELETE prepare: ".$conn->error;$error=true;}else{$stmt->bind_param("i",$id_alumno); if($stmt->execute()){$mensaje="Alumno y responsable asociado eliminados.";}else{$mensaje="Error DELETE execute: ".$stmt->error;$error=true;}$stmt->close();}
          $accion='leer';
      } elseif ($accion=='editar' && $id_alumno && !$error) {
          $sql="SELECT a.*, r.nombre_completo as resp_nombre, r.dni as resp_dni, r.celular as resp_celular, r.email as resp_email FROM alumnos a LEFT JOIN responsables r ON a.id = r.alumno_id WHERE a.id = ?";
          $stmt=$conn->prepare($sql);
          if($stmt===false){$mensaje="Error SELECT edit prepare: ".$conn->error;$error=true;$accion='leer';}else{$stmt->bind_param("i",$id_alumno);if($stmt->execute()){$result=$stmt->get_result();if($result instanceof mysqli_result){if($result->num_rows===1){$alumno_data=$result->fetch_assoc(); $accion='editar';}else{$mensaje="Alumno no encontrado.";$error=true;$accion='leer';}$result->free();}else{$mensaje="Error get_result edit.";$error=true;$accion='leer';}}else{$mensaje="Error SELECT edit execute: ".$stmt->error;$error=true;$accion='leer';}$stmt->close();}
      }
      // No necesitamos cargar datos para 'crear_usuario' en GET
  }
} // Fin del if que protege las acciones CRUD
// =========================================================================
// --- FIN ARCHIVO SUGERIDO: actions/crud_logic.php ---
// =========================================================================

?>