<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

?>
<?php include('../includes/header.php'); ?>
<!-- FECHA -->
  <?php
    $mes = date ('Y-m-d', strtotime('-0 month'));
  ?>
  <div class="container-fluid p-4">
    <div class="row justify-content-center p-2">
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo Fecha3($mes); ?></span>
      </div>
    </div>
  </div>
<!-- FECHA -->

<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <form action="../Guardar/save_asistencia_interna.php" method="POST">
            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">
            <button type="submit" name="inicio" class="btn btn-success">Marcar comienzo del dia</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  const funcionInits = () => {
    
  if (!"geolocation" in navigator) {
    return alert("Tu navegador no soporta el acceso a la ubicación. Intenta con otro");
  }

  const $latitud = document.querySelector("#latitud"),
    $longitud = document.querySelector("#longitud");

  const onUbicacionConcedidas = ubicacion => {
    const coordenadass = ubicacion.coords;
    $ilatitud = coordenadass.latitude;
    $ilongitud = coordenadass.longitude;
    $("#latitud").val($ilatitud);
    $("#longitud").val($ilongitud);
  }

  const onErrorDeUbicacions = err => {
    $("#latitud").val("No se obtuvo la coordenada");
    $("#longitud").val("No se obtuvo la coordenada");
  }

  const opcionesDeSolicituds = {
    enableHighAccuracy: true, // Alta precisión
    maximumAge: 0, // No queremos caché
    timeout: 5000 // Esperar solo 5 segundos
  };

  navigator.geolocation.getCurrentPosition(onUbicacionConcedidas, onErrorDeUbicacions, opcionesDeSolicituds);

  };
  document.addEventListener("DOMContentLoaded", funcionInits);
</script>
<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>