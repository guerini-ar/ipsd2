<?php
// =========================================================================
// --- ARCHIVO SUGERIDO: utils/generar_hash.php (uso temporal) ---
// =========================================================================

// Contraseña que quieres hashear
$contrasena_plana = '22061550';

// Opciones para password_hash (puedes ajustar el 'cost' si necesitas más seguridad, 10-12 es un buen balance)
$opciones = [
    'cost' => 11,
];

// Generar el hash seguro
// PASSWORD_DEFAULT usa el algoritmo más fuerte disponible actualmente (generalmente bcrypt)
$hash_seguro = password_hash($contrasena_plana, PASSWORD_DEFAULT, $opciones);

// Mostrar el resultado
echo "Contraseña Plana: " . htmlspecialchars($contrasena_plana) . "<br>";
echo "Hash Seguro Generado: <strong>" . htmlspecialchars($hash_seguro) . "</strong><br><br>";
echo "Copia el Hash Seguro y actualiza la columna 'contrasena_hash' en tu tabla 'usuarios' para el usuario correspondiente.";

// Ejemplo de consulta SQL para actualizar (¡Reemplaza 'HASH_GENERADO_AQUI' y el ID!)
$id_usuario_a_actualizar = 1; // Cambia esto por el ID correcto
echo "<hr>";
echo "Ejemplo de SQL para actualizar (reemplaza el hash y el ID):<br>";
echo "<pre>UPDATE usuarios SET contrasena_hash = '" . htmlspecialchars($hash_seguro) . "' WHERE id = " . $id_usuario_a_actualizar . ";</pre>";

// =========================================================================
// --- FIN ARCHIVO SUGERIDO: utils/generar_hash.php ---
// =========================================================================
?>
