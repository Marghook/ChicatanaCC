<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.html");
    exit();
}

$idcuenta = $_GET['idcuenta'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chicatana Country Club - Método de Pago</title>
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
      <a href="inicio.html" class="menu-btn"><i class="fas fa-home"></i> INICIO</a>
      <a href="informacion_socio.php" class="menu-btn"><i class="fas fa-user"></i> INFORMACIÓN DEL SOCIO</a>
      <a href="agregar_familiar.html" class="menu-btn"><i class="fas fa-user-plus"></i> AGREGAR FAMILIAR</a>
      <a href="agregar_invitado.html" class="menu-btn"><i class="fas fa-users"></i> AGREGAR INVITADO</a>
      <a href="cuenta.php" class="menu-btn"><i class="fas fa-money-bill"></i> CUENTA</a>
      <a href="metodo_pago.html" class="menu-btn"><i class="fas fa-credit-card"></i> PAGAR CUOTA</a>
      <a href="generar_pagare.html" class="menu-btn"><i class="fas fa-file-invoice-dollar"></i> GENERAR PAGARÉ</a>
      <a href="login.html" class="menu-btn"><i class="fas fa-sign-out-alt"></i> CERRAR SESIÓN</a>
    </div>

    <div class="contenido">
      <img src="logo.png" alt="Logo Chicatana" class="logo">

      <form class="pago-form" method="post" action="metodo_pago.php" onsubmit="mostrarModal(event) ">
        <h3>Método de Pago</h3>
        <input type="hidden" id="idcuenta" name="idcuenta" value="<?=htmlspecialchars($idcuenta) ?>">
        <input type="text" name="nombre" placeholder="Nombre del Titular" required>
        <input type="text" name="numero_tarjeta" placeholder="Número de Tarjeta" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric">
        <input type="text" name="fecha_vencimiento" placeholder="mm/aa" required maxlength="5"
        pattern="(0[1-9]|1[0-2])\/\d{2}" title="Ingresa un mes válido y dos dígitos de año (ej. 02/26)"
        oninput="const v=this.value.replace(/[^0-9]/g,'');this.value=v.length>=3?v.slice(0,2)+'/'+v.slice(2,4):v;"
        onpaste="event.preventDefault()">
        <input type="text" name="codigo_seguridad" placeholder="Código de Seguridad" required minlength="3" maxlength="3">

        <div class="payment-logos">
          <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa">
          <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard">
          <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg" alt="American Express">
        </div>

        <button type="submit">Pagar</button>

        <p>Cancela cuando quieras</p>
        <p>Se aplican <a href="terminos_y_condiciones.html">Términos y Condiciones</a></p>
      </form>
    </div>
  </div>

  <!-- Modal -->
  <div id="modalPagoExitoso" class="modal">
    <div class="modal-content">
      <p>PAGO EXITOSO</p>
      <i class="fas fa-check"></i>
      <button onclick="enviarFormulario()">Salir</button>
    </div>
  </div>

  <script>
    let formularioPendiente;
    function mostrarModal(event) {
      event.preventDefault();
      formularioPendiente = event.target; // guardamos el formulario que se iba a enviar
      document.getElementById('modalPagoExitoso').style.display = 'flex';
    }

    function enviarFormulario() {
    document.getElementById('modalPagoExitoso').style.display = 'none';
    if (formularioPendiente) {
      formularioPendiente.submit(); // enviamos el formulario manualmente
    }
  }

    function cerrarModal() {
      document.getElementById('modalPagoExitoso').style.display = 'none';
    }
  </script>
</body>
</html>
