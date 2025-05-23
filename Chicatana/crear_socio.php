<?php 
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location:login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Creación del Socio</title>
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
      <a href="pagares_generados.php" class="menu-btn"><i class="fas fa-file-invoice-dollar"></i> PAGARÉS GENERADOS</a>
      <a href="cerrar_sesion.php" class="menu-btn"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
    </div>

    <div class="contenido">
      <img src="logo.png" alt="Logo Chicatana" class="logo">
      <form class="formulario" method="post" action="crear_usuario_socio.php">
        <h3>Creación del Socio</h3>
        
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Apellido/s" required>

        <label for="usuario">Nombre de Usuario</label>
        <input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario" required>

        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Teléfono" required>

        <label for="ciudad">Ciudad</label>
        <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad" required>

        <label for="cp">C.P</label>
        <input type="text" id="cp" name="cp" placeholder="Código Postal" required>

        <label for="colonia">Colonia</label>
        <input type="text" id="colonia" name="colonia" placeholder="Colonia" required>

        <label for="numero_casa">Número de Casa</label>
        <input type="text" id="numero_casa" name="numero_casa" placeholder="Número de casa" required>

        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" placeholder="Correo electrónico" required>

        <label for="rfc">RFC</label>
        <input type="text" id="rfc" name="rfc" placeholder="RFC" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>

        <div class="botones">
          <button type="button" onclick="window.location.href='Inicio_admin.html'">Cancelar</button>
          <button type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
