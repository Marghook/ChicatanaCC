
<?php
session_start();
require_once 'conexion.php';

if(!isset($_SESSION['idusuario'])){
  header("Location: login.html");
  exit();
}

$idfam = $_GET['idfamiliar'];

$stmt = $conn->prepare("SELECT nombre,apellido,telefono,ciudad,codigo_postal,colonia,num_casa,correo,rfc 
                        FROM familiar WHERE idfamiliar = ?");
$stmt->bind_param("i",$idfam);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nombre,$apellido,$telefono,$ciudad,$cp,$colonia,$num_casa,$correo,$rfc);
$stmt->fetch();
$stmt->close();
?>

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
      <form class="formulario" method="POST" action="actualizar_familiar.php">
        <h3>Información del Familiar</h3>

        <input type="hidden" id="idfamiliar" name="idfamiliar" value="<?= htmlspecialchars($idfam)?>">

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" required>

        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" required>

        <label for="ciudad">Ciudad</label>
        <input type="text" id="ciudad" name="ciudad" value="<?= htmlspecialchars($ciudad) ?>" required>

        <label for="cp">C.P</label>
        <input type="text" id="cp" name="cp" value="<?= htmlspecialchars($cp) ?>" required>

        <label for="colonia">Colonia</label>
        <input type="text" id="colonia" name="colonia" value="<?= htmlspecialchars($colonia) ?>" required>

        <label for="num_casa">Número de Casa</label>
        <input type="text" id="num_casa" name="num_casa" value="<?= htmlspecialchars($num_casa) ?>" required>

        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" required>

        <label for="rfc">RFC</label>
        <input type="text" id="rfc" name="rfc" value="<?= htmlspecialchars($rfc) ?>">

        <div class="botones">
          <button type="button" onclick="window.location.href='inicio_admin.html'">Cancelar</button>
          <button type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
