<?php
//includes
require_once "./config/database.php";

// =========================================================================
// --- ARCHIVO SUGERIDO: includes/db_connection.php ---
// =========================================================================
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) { die("Conexión fallida: " . $conn->connect_error); }
// =========================================================================
// --- FIN ARCHIVO SUGERIDO: includes/db_connection.php ---
// =========================================================================

?>