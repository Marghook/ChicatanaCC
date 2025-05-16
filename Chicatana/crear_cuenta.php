<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

// Obtener socios
$socios = $conn->query("SELECT s.idsocio, u.nombre, u.user FROM socio s JOIN usuario u ON s.iduser = u.idusuario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
  <title>Creación de Cuenta</title>
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
      background-image: url('fondo_sinlogo.jpeg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      padding: 40px;
      color: white;
      overflow-y: auto;
      backdrop-filter: blur(4px);
    }

    .formulario {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: 0 auto;
    }

    .formulario h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .formulario label {
      display: block;
      margin: 10px 0 5px;
    }

    .formulario input {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 5px;
    }

    .botones {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

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
      <img src="logo.png" alt="Logo Chicatana" class="logo">
      <form class="formulario" method="post" action="crear_cuenta2.php">
        <h3>Creación de Cuenta</h3>
        
        <label for="idsocio">Selecciona al socio:</label>
        <select name="idsocio" id="idsocio" required>
          <option value="">-- Selecciona --</option>
          <?php foreach ($socios as $socio): ?>
            <option value="<?= $socio['idsocio'] ?>"><?= htmlspecialchars($socio['nombre']) ?> (<?= htmlspecialchars($socio['user']) ?>)</option>
          <?php endforeach; ?>
        </select>

        <div class="botones">
          <button type="button" onclick="window.location.href='agregar_cuenta_admin.php'">Cancelar</button>
          <button type="submit">Siguiente</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>