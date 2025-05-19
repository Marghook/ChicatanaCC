<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

$idusuario = $_SESSION['idusuario'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Obtener datos del formulario
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $ciudad   = $_POST['ciudad'];
    $cp       = intval($_POST['cp']);
    $colonia  = $_POST['colonia'];
    $num_casa = $_POST['numero_casa'];
    $correo   = $_POST['correo'];
    $rfc      = $_POST['rfc'];

    $conn->begin_transaction();

    try {
        // Actualizar usuario
        $sql_usuario = "UPDATE usuario SET nombre = ?, correo = ? WHERE idusuario = ?";
        $stmt1 = $conn->prepare($sql_usuario);
        if (!$stmt1) {
            throw new Exception("Error preparando stmt1: " . $conn->error);
        }
        $stmt1->bind_param("ssi", $nombre, $correo, $idusuario);
        $stmt1->execute();

        // Insertar o actualizar socio
        $sql_socio = "
            INSERT INTO socio (iduser, apellido, telefono, ciudad, codigo_postal, colonia, num_casa, rfc)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                apellido = VALUES(apellido),
                telefono = VALUES(telefono),
                ciudad = VALUES(ciudad),
                codigo_postal = VALUES(codigo_postal),
                colonia = VALUES(colonia),
                num_casa = VALUES(num_casa),
                rfc = VALUES(rfc)
        ";
        $stmt2 = $conn->prepare($sql_socio);
        if (!$stmt2) {
            throw new Exception("Error preparando stmt2: " . $conn->error);
        }
        $stmt2->bind_param("isssisss", $idusuario, $apellido, $telefono, $ciudad, $cp, $colonia, $num_casa, $rfc);
        $stmt2->execute();

        $conn->commit();
        $_SESSION['nombre'] = $nombre;

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'inicio.html';
        </script>";
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('❌ Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt1->close();
    $stmt2->close();
}
$conn->close();
?>
