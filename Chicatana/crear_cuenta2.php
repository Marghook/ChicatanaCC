<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])){
    header("Location: login.html");
    exit();
}
$tipo = $_POST['tipo_consumidor'] ?? null;
// Obtener socios
$socios = $conexion->query("SELECT s.idsocio, u.nombre, u.user FROM socio s JOIN usuario u ON s.iduser = u.idusuario");

// Obtener familiares
$familiares = $conexion->query("SELECT idfamiliar, nombre, idsocio FROM familiar");

// Obtener invitados
$invitados = $conexion->query("SELECT idinvitado, nombre, idsocio FROM invitado");
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
      <form class="formulario" method="post" action="insert_cuenta.php">
        <h3>Creación de Cuenta</h3>
        <?php if ($tipo === 'socio'): ?>
            <label for="idsocio">Selecciona al socio:</label>
            <select name="idsocio" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($socios as $socio): ?>
                    <option value="<?= $socio['idsocio'] ?>"><?= htmlspecialchars($socio['nombre']) ?> (<?= htmlspecialchars($socio['user']) ?>)</option>
                <?php endforeach; ?>
            </select>
            
        <?php elseif ($tipo === 'familiar'): ?>
            <label for="idfamiliar">Selecciona al familiar:</label>
            <select name="idfamiliar" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($familiares as $familiar): ?>
                    <option value="<?= $familiar['idfamiliar'] ?>">Familiar ID <?= $familiar['idfamiliar'] ?> (Socio ID <?= $familiar['idsocio'] ?>)</option>
                <?php endforeach; ?>
            </select>
                
            <?php elseif ($tipo === 'invitado'): ?>
                <label for="idinvitado">Selecciona al invitado:</label>
                <select name="idinvitado" required>
                    <option value="">-- Selecciona --</option>
                    <?php foreach ($invitados as $invitado): ?>
                        <option value="<?= $invitado['idinvitado'] ?>">Invitado ID <?= $invitado['idinvitado'] ?> (Socio ID <?= $invitado['idsocio'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
                
            <label for="descripcion">Descripción del consumo</label>
            <input type="text" name="descripcion" id="descripcion" required>
                
            <label for="monto">Monto</label>
            <input type="number" name="monto" id="monto" step="0.01" required>
                
            <label for="pagado">¿Pagado?</label>
            <select name="pagado" id="pagado" required>
                <option value="1">Pagado</option>
                <option value="0">No Pagado</option>
            </select>
                
            <div class="botones">
                <button type="submit">Registrar</button>
            </div>
        </div>
    </div>
</body>
</html>