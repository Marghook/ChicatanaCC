<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

$idusuario = $_SESSION['idusuario'];

$sql_cuenta = "SELECT s.idsocio,
c.idcuenta,
c.descripcion,
c.fecha,
c.cantidad,
c.pagado
FROM socio s
JOIN cuenta c ON s.idsocio = c.idsocio
WHERE s.iduser = ?";
$result = $conn->prepare($sql_cuenta);
$result->bind_param("i",$idusuario);
$result->execute();
$result->bind_result($idsocio,$idcuenta,$desc,$fecha,$cantidad,$pagado);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cuenta</title>
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
      position: relative; /* Añadido para el posicionamiento del logo */
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

    /* Estilos para el contenedor de la tabla y el botón de pagar */
    .tabla-placeholder-container {
      margin-top: 30px; /* Espacio sobre el área de la tabla */
      margin-bottom: 30px; /* Espacio debajo del área de la tabla */
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.4); /* Fondo semitransparente para el área */
      border-radius: 8px;
      text-align: center;
    }

    .tabla-placeholder-container p {
      font-style: italic;
      color: #f0f0f0; /* Un blanco un poco más suave */
      margin-bottom: 15px; /* Espacio antes del ejemplo de tabla si se descomenta */
    }

    .boton-pagar-container {
      text-align: center; /* Centra el botón */
      margin-top: 20px; /* Espacio sobre el botón */
      padding-bottom: 20px; /* Espacio al final del contenido */
    }

    .btn-pagar {
      padding: 8px 18px;
      border: none;
      border-radius: 5px;
      background-color: #1d2e4a;
      color: white;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-pagar:hover {
      background-color: #0b1a38;
    }

    .tabla-ejemplo {
        width: 100%;
        margin-top: 60px;
        border-collapse: collapse;
        color: white;
        background-color: rgba(0, 0, 0, 0.6);
    }
    .tabla-ejemplo th, .tabla-ejemplo td {
        padding: 12px 15px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        text-align: left;
    }
    .tabla-ejemplo thead th {
        background-color: rgba(29, 46, 74, 0.7);
        font-weight: bold;
    }
    .tabla-ejemplo tbody tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05);
    }
    .tabla-ejemplo tfoot td {
        font-weight: bold;
        text-align: right;
        background-color: rgba(29, 46, 74, 0.7);
    }
    </style>
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>MENU</h2>
      <a href="inicio.html" class="menu-btn"><i class="fas fa-home"></i> INICIO</a>
      <a href="informacion_socio.php" class="menu-btn"><i class="fas fa-user"></i> INFORMACIÓN DEL SOCIO</a>
      <a href="agregar_familiar.html" class="menu-btn"><i class="fas fa-user-plus"></i> AGREGAR FAMILIAR</a>
      <a href="agregar_invitado.html" class="menu-btn"><i class="fas fa-users"></i> AGREGAR INVITADO</a>
      <a href="cuenta.php" class="menu-btn"><i class="fas fa-money-bill"></i> CUENTA</a>
      <a href="metodo_pago_form.php" class="menu-btn"><i class="fas fa-credit-card"></i> PAGAR CUOTA</a>
      <a href="generar_pagare.html" class="menu-btn"><i class="fas fa-file-invoice-dollar"></i> GENERAR PAGARÉ</a>
      <a href="login.html" class="menu-btn"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
    </div>

    <div class="contenido">
      <img src="logo.png" alt="Logo Chicatana" class="logo">

      <div class="tabla-placeholder-container">
        <table class="tabla-ejemplo">
          <thead>
            <tr>
              <th>IDsocio</th>
              <th>IDcuenta</th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Monto</th>
              <th>Estado de pago</th>
              <th>Acciones</th>
            <tr>
          </thead>
          <tbody>
          <?php while($result->fetch()): ?>
            <tr>
              <td><?= $idsocio ?></td>
              <td><?= $idcuenta ?></td>
              <td><?= $desc ?></td>
              <td><?= $fecha ?></td>
              <td><?= $cantidad ?></td>
              <td><?= $pagado ? 'Sí' : 'No' ?></td>
              <td>
                <?php if (!$pagado): ?>
                <a href="metodo_pago_form.php?idcuenta=<?= $idcuenta ?>" class="btn-pagar">
                  <i class="fas fa-credit-card"></i> PAGAR
                </a>
                <?php else: ?>
                <span style="color: gray;">Pagado</span>
                <?php endif; ?>
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