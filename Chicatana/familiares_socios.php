<?php
session_start();
require_once 'conexion.php';

if(!isset ($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}

$sql_familiar = "SELECT * FROM familiar";
$result = $conn->query($sql_familiar);
?>

<!-- informacion_familiar.html -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Información del Familiar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      width: 100%;
      font-family: Verdana, Verdana;
    }

    .container {
      display: flex;
      height: 100vh;
      width: 100vw;
    }

    .sidebar {
      width: 220px;
      background-color: rgba(44, 62, 80, 0.95);
      padding: 20px;
      color: white;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      font-size: 20px;
      margin-bottom: 25px;
      text-align: center;
    }

    .menu-btn {
      background-color: #0b1a38;
      color: white;
      border: none;
      width: 100%;
      text-align: left;
      padding: 10px 15px;
      margin-bottom: 10px;
      border-radius: 5px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .menu-btn:hover {
      background-color: #1d2e4a;
    }

    .menu-btn i {
      width: 20px;
      text-align: center;
    }

    .contenido {
      flex-grow: 1;
      background-image: url('logo.png'), url('fondo_sinlogo.jpeg');
      background-size: 150px auto, cover;
      background-position: top right, center;
      background-repeat: no-repeat, no-repeat;
      padding: 40px;
      color: white;
      overflow-y: auto;
      backdrop-filter: blur(4px);
    }
        /* Estilos para el contenedor de la tabla y el botón de pagar */
        .tabla-placeholder-container {
      margin-top: 30px; /* Espacio sobre el área de la tabla */
      margin-bottom: 30px; /* Espacio debajo del área de la tabla */
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.4); /* Fondo semitransparente para el área */
      border-radius: 8px;
      text-align: center;
      max-width: 100%;          /* Evita que se expanda más allá del viewport */
      overflow-x: auto;         /* Permite scroll si la tabla aún se desborda */
      box-sizing: border-box;
    }

    .tabla-placeholder-container p {
      font-style: italic;
      color: #f0f0f0; /* Un blanco un poco más suave */
      margin-bottom: 15px; /* Espacio antes del ejemplo de tabla si se descomenta */
    }

    /* Estilos básicos para una tabla de ejemplo (opcional, puedes personalizarla más) */
    .tabla-ejemplo {
        width: 100%;
        margin-top: 70px;
        border-collapse: collapse;
        color: white;
        background-color: rgba(0, 0, 0, 0.6); /* Fondo ligeramente más oscuro para la tabla */
    }
    .tabla-ejemplo th, .tabla-ejemplo td {
        padding: 12px 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        text-align: left;
    }
    .tabla-ejemplo thead th {
        background-color: rgba(29, 46, 74, 0.7); /* Azul oscuro semitransparente para encabezados */
        font-weight: bold;
    }
    .tabla-ejemplo tbody tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05); /* Resaltar filas pares sutilmente */
    }
    .tabla-ejemplo tfoot td {
        font-weight: bold;
        text-align: right;
        background-color: rgba(29, 46, 74, 0.7);
    }
    
    .botones {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;}

    .botones button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      background-color: #1d2e4a;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .botones button:hover {
      background-color: #0b1a38;
    }

    .logo {
      position: absolute;
      top: 20px;
      right: 20px;
      height: 150px;
      z-index: 10;
    }
    .boton_agregar {
      display: inline-block;
      padding: 10px 20px;
      background-color: #1d2e4a;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s;
      margin-bottom: 20px;
    }
    .boton-agregar:hover {
      background-color: #0b1a38;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>MENU</h2>
      <a href="Inicio_admin.html" class="menu-btn"><i class="fas fa-home"></i> INICIO</a>
      <a href="socios.php" class="menu-btn"><i class="fas fa-user"></i> SOCIOS</a>
      <a href="familiares_socios.php" class="menu-btn"><i class="fas fa-users"></i> FAMILIARES DE SOCIOS</a>
      <a href="invitados_socios.php" class="menu-btn"><i class="fas fa-users"></i> INVITADOS DE SOCIOS</a>
      <a href="pagos_cuotas.php" class="menu-btn"><i class="fas fa-credit-card"></i> PAGOS DE CUOTAS</a>
      <a href="agregar_cuenta_admin.php" class="menu-btn"><i class="fas fa-money-bill"></i>AGREGAR CUENTA</a>
      <a href="pagares_generados.php" class="menu-btn"><i class="fas fa-file-invoice-dollar"></i> PAGARÉS GENERADOS</a>
      <a href="cerrar_sesion.php" class="menu-btn"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
    </div>
    <div class="contenido">
      <!--<img src="logo.png" alt="Logo Chicatana" class="logo"> -->
      <a href="crear_familiar.html" class="boton_agregar">Agregar Familiar</a>
      <div class="tabla-placeholder-container">
      <table class="tabla-ejemplo">
        <thead>
          <tr>
            <th>IDsocio</th>
            <th>IDfamiliar</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Ciudad</th>
            <th>Codigo Postal</th>
            <th>Colonia</th>
            <th>Número de casa</th>
            <th>RFC</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['idsocio'] ?></td>
              <td><?= htmlspecialchars($row['idfamiliar']) ?></td>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['apellido']) ?></td>
              <td><?= htmlspecialchars($row['telefono']) ?></td>
              <td><?= htmlspecialchars($row['ciudad']) ?></td>
              <td><?= htmlspecialchars($row['codigo_postal']) ?></td>
              <td><?= htmlspecialchars($row['colonia']) ?></td>
              <td><?= htmlspecialchars($row['num_casa']) ?></td>
              <td><?= htmlspecialchars($row['rfc']) ?></td>
              <td>
                <a href="editar_familiar.php?idfamiliar=<?= $row['idfamiliar'] ?>">Editar</a>
                <a href="eliminar_familiar.php?idfamiliar=<?= $row['idfamiliar'] ?>" onclick="return confirm('¿Eliminar este familiar?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
          </div>
    </div>
  </div>
</body>
</html>