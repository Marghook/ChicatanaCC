<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idsocio = $_POST['idsocio'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $pagos = $_POST['pagos'] ?? 0;

    if (!is_numeric($idsocio) || !is_numeric($cantidad) || !is_numeric($pagos)) {
        echo "Error: Todos los campos deben ser numéricos.";
        exit();
    }

    if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
        echo "Error: Fecha inválida.";
        exit();
    }

    // Insertar el pago
    $sql_pago = "INSERT INTO pagare (idsocio, fecha_deuda, cantidad, pagos) 
                 VALUES (?, ?, ?, ?)";
    $stmt_pago = $conn->prepare($sql_pago);
    $stmt_pago->bind_param("isii", $idsocio, $fecha, $cantidad, $pagos);

    if ($stmt_pago->execute()) {
        echo "<script>alert('✅ Datos añadidos correctamente.');
        window.location.href = 'pagares_generados.php';</script>";
    } else {
        echo "Error al guardar: " . $stmt_pago->error;
    }

    $stmt_pago->close();
    $conn->close();
}
?>
