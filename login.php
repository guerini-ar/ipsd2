<?php
// =========================================================================
// --- ARCHIVO SUGERIDO: login.php (Archivo principal para login) ---
// =========================================================================

// --- Iniciar/Reanudar Sesión ---
session_start();

// --- Incluir conexión a BBDD (Temporalmente aquí) ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ipsd";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) { die("Error de conexión a la base de datos."); }

// --- Variables ---
$login_error = "";

// --- Redirigir si ya está logueado ---
if (isset($_SESSION['user_id'])) {
    // --- MODIFICACIÓN: Redirigir según rol si ya está logueado ---
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        header("Location: index.php?accion=estadisticas"); // Admin a Estadísticas
    } else {
        header("Location: index.php?accion=leer"); // Otros a Gestión Alumnos
    }
    exit;
}

// --- Procesar Envío del Formulario (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario_ingresado = isset($_POST['nombre_usuario']) ? trim($_POST['nombre_usuario']) : '';
    $contrasena_ingresada = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    if (empty($nombre_usuario_ingresado) || empty($contrasena_ingresada)) {
        $login_error = "Por favor, ingrese nombre de usuario y contraseña.";
    } else {
        $sql = "SELECT id, nombre_usuario, contrasena_hash, rol FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $login_error = "Error interno del servidor. Intente más tarde.";
            error_log("Error al preparar consulta de login: " . $conn->error);
        } else {
            $stmt->bind_param("s", $nombre_usuario_ingresado);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $usuario = $result->fetch_assoc();
                if (password_verify($contrasena_ingresada, $usuario['contrasena_hash'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $usuario['id'];
                    $_SESSION['username'] = $usuario['nombre_usuario'];
                    $_SESSION['user_role'] = $usuario['rol']; // Guardar rol

                    // --- MODIFICACIÓN: Redirigir según rol ---
                    if ($usuario['rol'] == 'admin') {
                         header("Location: index.php?accion=estadisticas"); // Admin a Estadísticas
                    } else {
                         header("Location: index.php?accion=leer"); // Otros a Gestión Alumnos
                    }
                    exit;

                } else { $login_error = "Nombre de usuario o contraseña incorrectos."; }
            } else { $login_error = "Nombre de usuario o contraseña incorrectos."; }
            $stmt->close();
        }
    }
    $conn->close();
}
// =========================================================================
// --- FIN LÓGICA PHP ---
// =========================================================================
?>
<?php // ========================================================================= ?>
<?php // --- ARCHIVO SUGERIDO: views/login_form.php o templates/login.php --- ?>
<?php // ========================================================================= ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Instituto Privado Santa Doménica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .login-container { background-color: #fff; padding: 30px 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .login-container h1 { color: #0056b3; margin-bottom: 25px; font-size: 1.8em; }
        .login-form label { display: block; text-align: left; margin-bottom: 5px; font-weight: 500; color: #555; }
        .login-form input[type="text"], .login-form input[type="password"] { width: 100%; box-sizing: border-box; }
        .login-form button { width: 100%; }
        .error-mensaje { color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 0.9em; }
        .volver-link { margin-top: 20px; display: block; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>

        <?php if (!empty($login_error)): ?>
            <div class="error-mensaje"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post" class="login-form">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required autofocus>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
            </div>
        </form>

        <div class="mt-3">
             <a href="index.php?accion=inicio" class="btn btn-secondary btn-sm" title="Volver al Inicio" aria-label="Volver al Inicio">
                 <i class="bi bi-house-door-fill"></i>
             </a>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php // ========================================================================= ?>
<?php // --- FIN ARCHIVO SUGERIDO: views/login_form.php --- ?>
<?php // ========================================================================= ?>
<?php // ========================================================================= ?>
<?php // --- FIN ARCHIVO SUGERIDO: login.php --- ?>
<?php // ========================================================================= ?>
