<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $idsocio = $_POST['idsocio'] ?? '';
    $num_tarjeta = $_POST['numero_tarjeta'] ?? '';
    $concepto = $_POST['concepto'];
    $cantidad = $_POST['cantidad'];
}
        // Insertar el pago
        $sql_pago = "INSERT INTO pago (idsocio, num_tarjeta, concepto, cantidad) 
                     VALUES (?, ?, ?, ?)";
        $stmt_pago = $conn->prepare($sql_pago);
        $stmt_pago->bind_param("issd", $idsocio, $num_tarjeta, $concepto, $cantidad);
        
        if($stmt_pago->execute();)
        {
                echo "<script>alert('✅ Datos añadidos correctamente.');
                window.location.href = 'pagos_cuotas.php';</script>";
                } else{
                    echo "Error al guardar: ".
                    $stmt3->error;
                }

        $stmt_pago->close();
    $conn->close();
?>