<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerardo_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión"]);
    exit();
}
$conn->set_charset("utf8mb4");

// Verificar usuario
if (!isset($_SESSION['usuario'])) {
    echo json_encode(["error" => "No hay sesión activa"]);
    exit();
}

$sqlUsuario = "SELECT usuario_id, rol FROM usuarios WHERE nombre = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("s", $_SESSION['usuario']);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();
$usuarioActual = $resultUsuario->fetch_assoc();

if (!$usuarioActual) {
    echo json_encode(["error" => "Usuario no encontrado"]);
    exit();
}

$usuarioRol = $usuarioActual['rol'];
$usuarioId = $usuarioActual['usuario_id'];
$stmtUsuario->close();

// Obtener parámetros de búsqueda
$search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%%";
$categoria = $_GET['categoria'] ?? 'todas';

$sql = "";
$params = [];
$types = "";

// Construcción de la consulta SQL
if ($usuarioRol == 'usuario') {
    $sql = "(
                SELECT m.materia_id AS id, 'materia' AS tipo, m.nombre, m.descripcion
                FROM materias m
                JOIN accesos a ON m.materia_id = a.materia_id
                WHERE a.usuario_id = ? AND (m.nombre LIKE ? OR m.descripcion LIKE ?)
            ) UNION (
                SELECT j.juego_id AS id, 'juego' AS tipo, j.nombre, j.descripcion
                FROM juegos j
                JOIN accesos a ON j.juego_id = a.juego_id
                WHERE a.usuario_id = ? AND (j.nombre LIKE ? OR j.descripcion LIKE ?)
            ) UNION (
                SELECT p.proyecto_id AS id, 'proyecto' AS tipo, p.nombre, p.descripcion
                FROM proyectos p
                JOIN accesos a ON p.proyecto_id = a.proyecto_id
                WHERE a.usuario_id = ? AND (p.nombre LIKE ? OR p.descripcion LIKE ?)
            )";
    $params = [$usuarioId, $search, $search, $usuarioId, $search, $search, $usuarioId, $search, $search];
    $types = "issssssss";
} else {
    $sql = "(
                SELECT m.materia_id AS id, 'materia' AS tipo, m.nombre, m.descripcion
                FROM materias m
                JOIN accesos a ON m.materia_id = a.materia_id
                JOIN usuarios u ON a.usuario_id = u.usuario_id
                WHERE u.rol = 'usuario' AND (m.nombre LIKE ? OR m.descripcion LIKE ?)
            ) UNION (
                SELECT j.juego_id AS id, 'juego' AS tipo, j.nombre, j.descripcion
                FROM juegos j
                JOIN accesos a ON j.juego_id = a.juego_id
                JOIN usuarios u ON a.usuario_id = u.usuario_id
                WHERE u.rol = 'usuario' AND (j.nombre LIKE ? OR j.descripcion LIKE ?)
            ) UNION (
                SELECT p.proyecto_id AS id, 'proyecto' AS tipo, p.nombre, p.descripcion
                FROM proyectos p
                JOIN accesos a ON p.proyecto_id = a.proyecto_id
                JOIN usuarios u ON a.usuario_id = u.usuario_id
                WHERE u.rol = 'usuario' AND (p.nombre LIKE ? OR p.descripcion LIKE ?)
            )";
    $params = [$search, $search, $search, $search, $search, $search];
    $types = "ssssss";
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(["error" => "Error en la consulta SQL"]);
    exit();
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
