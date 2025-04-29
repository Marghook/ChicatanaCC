<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se ha recibido un 'id' por GET
if (isset($_GET['id'])) {
    $id_socio = $_GET['id'];

    // Consultar los datos del socio en la base de datos
    $query = "SELECT * FROM socios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_socio); // 'i' es para entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener los datos del socio
        $socio = $result->fetch_assoc();
    } else {
        // Si no se encuentra el socio
        echo "Socio no encontrado.";
        exit();
    }
} else {
    // Si no se pasa el id en la URL, redirigir o mostrar error
    echo "ID de socio no especificado.";
    exit();
}
?>