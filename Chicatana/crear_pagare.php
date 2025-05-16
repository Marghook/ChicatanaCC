<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chicatana Country Club - Creación de Pago</title>
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
      height: 100%;
      background-image: url('fondo_sinlogo.jpeg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      padding: 40px;
      color: white;
      overflow-y: auto;
      backdrop-filter: blur(4px);
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .logo {
      position: absolute;
      top: 20px;
      right: 20px;
      height: 150px;
      z-index: 10;
    }

    .pago-form {
      background-color: rgba(0, 0, 0, 1);
      padding: 30px;
      border-radius: 10px;
      width: 450px;
      text-align: center;
    }

    .pago-form h3 {
      margin-bottom: 20px;
    }

    .pago-form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: none;
      border-radius: 5px;
    }

    .pago-form button {
      width: 100%;
      padding: 10px;
      background-color: #1d2e4a;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
    }

    .pago-form button:hover {
      background-color: #0b1a38;
    }

    .pago-form p {
      text-align: center;
      font-size: 14px;
      margin-top: 15px;
    }

    .pago-form a {
      color: #00bfff;
      text-decoration: none;
    }

    .pago-form a:hover {
      text-decoration: underline;
    }

    .payment-logos {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .payment-logos img {
      height: 30px;
    }

    /* Modal Estilo */
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: rgba(46, 204, 113, 0.95);
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      color: white;
      font-size: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .modal-content i {
      font-size: 50px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    .modal-content button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #0b1a38;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
      font-size: 16px;
    }

    .modal-content button:hover {
      background-color: #1d2e4a;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
      }

      .menu-btn {
        flex: 1;
        font-size: 12px;
        justify-content: center;
      }

      .contenido {
        padding: 20px;
        height: auto;
      }

      .logo {
        top: 10px;
        right: 10px;
        height: 150px;
      }
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

      <form class="pago-form" method="post" action="crear_pagare2.php">
        <h3>Creación de Pago</h3>
        <input type="text" id="idsocio" name="idsocio" placeholder="IDsocio" inputmode="numeric" required>
        <input type="date" name="fecha" placeholder="Fecha de deuda" required>
        <input type="text" name="cantidad" placeholder="cantidad" inputmode="numeric" required>
        <input type="text" name="pagos" placeholder="pagos" inputmode="numeric" required>
        
        <div class="botones">
          <button type="button" onclick="window.location.href='inicio_admin.html'">Cancelar</button>
          <button type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
