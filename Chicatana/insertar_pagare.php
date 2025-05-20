<?php
session_start(); // Siempre que uses $_SESSION, asegúrate de llamar session_start()

if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

header('Content-Type: application/json');
require_once 'conexion.php';

$idusuario = $_SESSION['idusuario'];

// Obtener datos del formulario
$fecha_deuda = $_POST['fecha_deuda'] ?? '';
$cantidad = $_POST['cantidad'] ?? '';
$pagos = $_POST['pagos'] ?? 1; // Por defecto 1

// Validación simple (puedes hacerla más estricta)
if (empty($fecha_deuda) || empty($cantidad)) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan campos obligatorios."
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT idsocio FROM socio WHERE iduser = ?");
$stmt->bind_param("i",$idusuario);
$stmt->execute();
$stmt->bind_result($idsocio);
$stmt->fetch();
$stmt->close();

// Inserción
$stmt2 = $conn->prepare("INSERT INTO pagare (idsocio, fecha_deuda, cantidad, pagos) VALUES (?, ?, ?, ?)");
$stmt2->bind_param("isii", $idsocio, $fecha_deuda, $cantidad, $pagos);

if ($stmt2->execute()) {
    $idpagare = $stmt2->insert_id;
    echo json_encode([
        "success" => true,
        "idpagare" => $idpagare
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al insertar: " . $stmt2->error
    ]);
}

$stmt2->close();
$conn->close();
?>