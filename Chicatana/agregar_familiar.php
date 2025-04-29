<?php
// agregar_familiar.php
include('conexion.php'); // Incluir la conexión a la base de datos

// Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $colonia = $_POST['colonia'];
    $numero_casa = $_POST['numero_casa'];
    $correo = $_POST['correo'];
    $rfc = $_POST['rfc'];

    // ID del socio, este debe pasarse de alguna manera (por ejemplo, por GET o en una sesión)
    $id_socio = $_GET['id_socio']; // Asegúrate de pasar el ID correctamente

    // Preparamos la consulta SQL para insertar los datos en la tabla Familiar
    $sql = "INSERT INTO Familiar (nombre, apellido, telefono, ciudad, cp, colonia, numero_casa, correo, rfc, id_socio)
            VALUES (:nombre, :apellido, :telefono, :ciudad, :cp, :colonia, :numero_casa, :correo, :rfc, :id_socio)";

    // Ejecutamos la consulta con los valores capturados
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':telefono' => $telefono,
            ':ciudad' => $ciudad,
            ':cp' => $cp,
            ':colonia' => $colonia,
            ':numero_casa' => $numero_casa,
            ':correo' => $correo,
            ':rfc' => $rfc,
            ':id_socio' => $id_socio
        ]);
        echo "Familiar agregado correctamente";
    } catch (PDOException $e) {
        echo "Error al insertar datos: " . $e->getMessage();
    }
}
?>

