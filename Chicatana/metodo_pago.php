<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

$idusuario = $_SESSION['idusuario'];

// Si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idcuenta = $_POST['idcuenta'] ?? '';
    $num_tarjeta = $_POST['numero_tarjeta'] ?? '';

    // Obtener la cantidad y descripción de la cuenta
    $sql = "SELECT descripcion, cantidad FROM cuenta WHERE idcuenta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idcuenta);
    $stmt->execute();
    $stmt->bind_result($descripcion,$cantidad);
    
    if ($stmt->fetch()) {
        $stmt->close();

        $stmt2 = $conn->prepare("SELECT idsocio from socio WHERE iduser = ?");
        $stmt2->bind_param("i",$idusuario);
        $stmt2->execute();
        $stmt2->bind_result($idsocio);
        $stmt2->fetch();
        $stmt2->close();

        // Insertar el pago
        $sql_pago = "INSERT INTO pago (idsocio, num_tarjeta, concepto, cantidad) 
                     VALUES (?, ?, ?, ?)";
        $stmt_pago = $conn->prepare($sql_pago);
        $stmt_pago->bind_param("issd", $idsocio, $num_tarjeta, $descripcion, $cantidad);
        
        if ($stmt_pago->execute()) {
            // Marcar la cuenta como pagada
            $sql_update = "UPDATE cuenta SET pagado = 1 WHERE idcuenta = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $idcuenta);
            $stmt_update->execute();
            $stmt_update->close();

            echo "<script>
                    alert('✅ Pago realizado exitosamente.');
                    window.location.href = 'cuenta.php';
                  </script>";
        } else {
            echo "Error al guardar pago: " . $stmt_pago->error;
        }

        $stmt_pago->close();
    } else {
        echo "La cuenta ya fue pagada o no existe.";
    }

    $conn->close();
}
?>