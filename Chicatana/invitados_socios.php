<?php
session_start();
require_once 'conexion.php';

if(!isset ($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}

$sql_invitado = "SELECT * FROM invitado";
$result = $conn->query($sql_invitado);
?>

<!-- informacion_invitado.html -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Información del Invitado</title>
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 70px;
      background-color: white;
      color: black;
    }
    
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
    }
    
    th {
      background-color: #1d2e4a;
      color: white;
    }
    
    td a {
      color: #007bff;
      text-decoration: none;
    }
    
    td a:hover {
      text-decoration: underline;
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
      <a href="pagares_generados.php" class="menu-btn"><i class="fas fa-file-invoice-dollar"></i> PAGARÉS GENERADOS</a>
      <a href="cerrar_sesion.php" class="menu-btn"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
    </div>
    <div class="contenido">
      <!--<img src="logo.png" alt="Logo Chicatana" class="logo"> -->
      <a href="crear_invitado.php" class="boton_agregar">Agregar Invitado</a>
      <table>
        <thead>
          <tr>
            <th>IDsocio</th>
            <th>IDinvitado</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['idinvitado'] ?></td>
              <td><?= htmlspecialchars($row['idsocio']) ?></td>
              <td><?= htmlspecialchars($row['nombre']) ?></td>
              <td><?= htmlspecialchars($row['apellido']) ?></td>
              <td><?= htmlspecialchars($row['telefono']) ?></td>
              <td><?= htmlspecialchars($row['correo']) ?></td>
              <td><?= htmlspecialchars($row['fecha']) ?></td>
              <td>
                <a href="editar_invitado.php?id=<?= $row['idinvitado'] ?>">Editar</a> |
                <a href="eliminar_invitado.php?id=<?= $row['idinvitado'] ?>" onclick="return confirm('¿Eliminar este invitado?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>