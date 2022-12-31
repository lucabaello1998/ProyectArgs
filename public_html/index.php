<?php
  include("db.php");
  $user = mysqli_query($conn, "SELECT * FROM usuarios");
  while($row = mysqli_fetch_assoc($user))
  {
    if($_COOKIE['U'] == sha1($row['usuario']) && $_COOKIE['P'] == sha1($row['pass']))
    {
      header('Location: /includes/login.php');
    }
  }
?>
<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <!-- PWA -->
    <meta name="theme-color" content="#343a40">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" href="/images/icon_1024.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="/manifest.json">
  <!-- PWA -->
  <meta name="description" content="PGA, Portal de Gestion Argentseal, para el control y desarrollo especializado en tecnologia FTTH.">
  <meta name="keywords" content="argentseal, argent, PGA, FTTH, fibra optica, instalacion, relevamiento, gestion de materiales, control de stock, febra hasta el hogar, modem, access point, stb, claro, tecnico instalador, capacitacion FTTH, FO">
  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Argentseal</title><!--titulo de pestaña-->
  <link rel="shortcut icon" href="https://www.argentseal.com.ar//vistas/images/favicon/favicon.ico" type="image/x-icon">
</head>
<body>

<?php
  session_destroy();
  $inicio = "Iniciar sesion";
  $usuario = "";
  $pass = "";
  if (isset($_SESSION['mensaje']))
  { 
    $inicio = $_SESSION['mensaje'];
    $colorus = $_SESSION['colorus'];
    $colorpass = $_SESSION['colorpass'];
    $usuario = $_SESSION['usuario'];
    $pass = $_SESSION['pass'];
    session_unset($_SESSION['mensaje']);
  }
?> 
<div class="container">
	<div class="row vh-100 justify-content-center align-items-top">
		<div class="col-auto p-2 text-center">
			<div class="row justify-content-center align-items-top">
				<img src="/Image/inicio.webp" width="300" height="300" class="d-inline-block align-top" alt="logo_argentseal" loading="lazy">
			</div>
			<div class="row justify-content-center">
				<div class="col-auto p-2 text-center">
					<h4><?php echo $inicio; ?> </h4>
					<br>
					<div class="col-auto p-5 text-center shadow-lg bg-white rounded">	
						<form action="includes/login.php" method="POST">					
							<div class="col">
								<div class="form-row justify-content-center">
									<input pattern="[A-Za-z0-9_-.]{3-15}" class="<?php echo $colorus; ?> form-control" type="text" name="usuario"  value="<?php echo $usuario; ?>" placeholder="Usuario" required autofocus>
								</div>
								<br>
								<div class="form-row justify-content-center">
									<input class="<?php echo $colorpass; ?> form-control" type="password" name="pass" pattern="[A-Za-z0-9_-.]{3-15}" value="<?php echo $pass; ?>" placeholder="Contraseña" required>
								</div>
								<br>
                <div class="form-row">
                  <label class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="recordar" value="SI"/>
                    <span class="form-check-label">Recordar usuario</span>
                  </label>
                </div>
                <br>
								<div class="form-row justify-content-center">
									<input type="submit" name="iniciar" class="btn btn-success btn-block text-center" value="Iniciar sesion">
								</div>
							</div>
						</form>			
					</div>
				</div>
			</div>
		</div>
	</div>					
</div>
</body>
</html>







