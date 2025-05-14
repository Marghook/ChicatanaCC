<?php
session_start();
require_once 'conexion.php';
if(!isset($_SESSION['idusuario']))
{
    header("Location:login.html");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre     = $_POST['nombre'];
    $apellido   = $_POST['apellido'];
    $usuario    = $_POST['usuario'];
    $telefono   = $_POST['telefono'];
    $ciudad     = $_POST['ciudad'];
    $cp         = $_POST['cp'];
    $colonia    = $_POST['colonia'];
    $num_casa   = $_POST['numero_casa'];
    $correo     = $_POST['correo'];
    $rfc        = $_POST['rfc'];
    $password   = $_POST['password'];

    $conn->begin_transaction();
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql_usuario = "INSERT INTO usuario(nombre,user,correo,password) VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql_usuario);
        $stmt->bind_param("ssss", $nombre, $usuario, $correo, $password_hash);
        $stmt->execute();

        $user = $conn->insert_id; // en lugar de select para encontrar idusuario 

        $sql_socio = "INSERT INTO socio(iduser, apellido, telefono, ciudad, codigo_postal, colonia, num_casa, rfc)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt3 = $conn->prepare($sql_socio);
        $stmt3->bind_param("isssisss", $user, $apellido, $telefono, $ciudad, $cp, $colonia, $num_casa, $rfc);
        $stmt3->execute();

        $conn->commit();

        echo "<script>
            alert('✅ Datos actualizados correctamente.');
            window.location.href = 'inicio_admin.html';
        </script>";
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('❌ Error al actualizar los datos: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $stmt->close();
    $stmt3->close();
    $conn->close();
}