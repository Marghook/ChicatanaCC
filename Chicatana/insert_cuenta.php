<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['idsocio'], $_POST['descripcion'], $_POST['cantidad'], $_POST['pagado'])) {
        $idsocio = (int)$_POST['idsocio'];
        $descripcion = trim($_POST['descripcion']);
        $cantidad = (int)$_POST['cantidad'];
        $pagado = (int)$_POST['pagado'];

        $sql = "INSERT INTO cuenta (idsocio, descripcion, cantidad, pagado) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $idsocio, $descripcion, $cantidad, $pagado);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Datos añadidos correctamente.'); window.location.href = 'agregar_cuenta_admin.php';</script>";
        } else {
            echo "❌ Error al guardar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "❌ Faltan datos del formulario.";
    }
} else {
    echo "❌ Acceso no permitido.";
}
?>