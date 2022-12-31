<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: /index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($tipo_us == "Tecnico") { $usu = 1; }
  if($usu != 1)
  {
    header("location: /index.php");
  }
?>
	<?php include('../include/header.php'); ?>
			<div class="row p-2 m-2">
        <div class="col-12 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="tel:08001227336" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Mesa de despacho</p>
              <p class="h3 text-muted text-center">0800-1227-336</p>
            </div>
          </a>
				</div>
        <div class="col-12 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="tel:20415950" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Soporte</p>
              <p class="h3 text-muted text-center">2047-5950</p>
            </div>
          </a>
				</div>
        <div class="col-12 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="tel:20415950" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Adecuacion op1</p>
              <p class="h3 text-muted text-center">2047-5950</p>
            </div>
          </a>
				</div>
        <div class="col-12 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="tel:08001221617" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Pymes</p>
              <p class="h3 text-muted text-center">0800-1221-617</p>
            </div>
          </a>
				</div>
        <div class="col-12 align-items-center p-1">
          <div class="row rounded bg-white shadow m-1">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Jose Lopez</p>
            </div>
          </div>
          <div class="row m-1 justify-content-center">
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="tel:1130936483" style="text-decoration: none;">
              <i class="fa-solid fa-phone"></i>
            </a>
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="https://wa.me/541130936483?" style="text-decoration: none;">
              <i class="fa-brands fa-whatsapp"></i>
            </a>
          </div>
				</div>
        <div class="col-12 align-items-center p-1">
          <div class="row rounded bg-white shadow m-1">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Luca Boettger</p>
            </div>
          </div>
          <div class="row m-1 justify-content-center">
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="tel:1162595187" style="text-decoration: none;">
              <i class="fa-solid fa-phone"></i>
            </a>
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="https://wa.me/541162595187?" style="text-decoration: none;">
              <i class="fa-brands fa-whatsapp"></i>
            </a>
          </div>
				</div>
        <div class="col-12 align-items-center p-1">
          <div class="row rounded bg-white shadow m-1">
            <div class="col-12 p-2">
              <p class="h4 text-muted text-center">Matias Alancay</p>
            </div>
          </div>
          <div class="row m-1 justify-content-center">
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="tel:1131242317" style="text-decoration: none;">
              <i class="fa-solid fa-phone"></i>
            </a>
            <a class="col h4 p-4 text-muted m-1 rounded bg-white shadow  text-center" href="https://wa.me/541121593614?" style="text-decoration: none;">
              <i class="fa-brands fa-whatsapp"></i>
            </a>
          </div>
				</div>
			</div>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>