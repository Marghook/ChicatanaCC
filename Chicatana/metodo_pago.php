<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

$idusuario = $_SESSION['idusuario'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num_tarjeta = $_POST['numero_tarjeta'] ?? '';
    $concepto = "pago de suscripción";
    $cantidad = '';

    $sql_invitado = "INSERT INTO pago (idusuario, num_tarjeta, concepto, cantidad) 
                     VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql_invitado);
    $stmt->bind_param("issi", $idusuario, $num_tarjeta, $concepto, $cantidad);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ Datos añadidos correctamente.');
                window.location.href = 'inicio.html';
              </script>";
    } else {
        echo "Error al guardar pago: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
