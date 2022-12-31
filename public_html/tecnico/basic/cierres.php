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
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($tipo_us == "Tecnico") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
	<?php include('../include/header.php'); ?>
  <!-- MESSAGES -->
    <?php
      if ($_SESSION['card'] == 1) { ?>
      <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
          <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
            <?php switch($_SESSION['color_toast'])
              {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
              case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
              case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
            ?>
            <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
        </div>
      </div>
      <script>
        $(document).ready(function(){
          $('.toast').toast('show');
        });
      </script>
    <?php $_SESSION['card'] = 0; } ?>
  <!-- MESSAGES -->
			<div class="row p-2 m-2">
        <div class="col-12 align-items-center p-1">
          <div class="row rounded bg-white shadow m-1">
            <div class="col-12 p-2">
              <p class="h4 text-center">Complete los datos para registrar la orden</p>
              <br>
              <form action="../save/cierres.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">
                <div class="form-row align-items-end">
                  <div class="form-group col-md-6 col-12">
                    <label for="ot">Numero de orden (OT)</label >
                    <input id="ot" type="number" name="ot" pattern="[0-9]{6-15}" maxlength="15" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label for="fecha">Fecha de la instalacion</label>
                    <input id="fecha" type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                  </div>  
                </div>
                <div class="form-row align-items-center">
                  <div class="form-group col-12">
                    <div class="row m-0">
                      <label for="tipo_tarea">Cierre</label>
                    </div>
                    <div class="row m-0 justify-content-around">
                      <div class="btn-group p-0 m-0" data-toggle="buttons">
                        <div class="col-auto">
                          <label class="btn btn-outline-success ml-6"><input class="radio" type="radio" name="tipo_tarea" id="exitoso" value="Exitoso" autocomplete="off" required hidden> Exitoso</label>
                        </div>
                        <div class="col-auto">
                          <label class="btn btn-outline-danger ml-6"><input class="radio" type="radio" name="tipo_tarea" id="fallido" value="Fallido" autocomplete="off" required hidden> Fallido</label>
                        </div>
                      </div>
                    </div>
                  </div>           
                </div>
                
                  <style>
                    .form-control-file {
                      position: relative;
                      display: inline-block;
                      cursor: pointer;
                      padding: .25rem .5rem;
                    }
                    .form-control-file::before {
                      background-color: #17a2b8;
                      color: white;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      border-radius: .2rem;
                      content: 'Seleccionar imagen'; /* testo por defecto */
                      position: absolute;
                      left: 0;
                      right: 0;
                      top: 0;
                      bottom: 0;
                    }
                    .form-control-file input[type="file"] {
                      opacity: 0;
                      width: 200px;
                      height: 32px;
                      display: inline-block;
                    }
                  </style>
                  <!-- EXITOSAS -->
                    <div class="form-row align-items-end border p-2 m-0" id="primera_img" hidden>
                      <div class="form-group col-12">
                        <label for="cargaImagen1">Subir foto de los equipos instalados</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                      </div>
                      <div class="row p-0 m-0 justify-content-center">
                        <img id="mostrarImagen1" width="50%" height="50%"/>
                      </div>
                      <br>
                    </div>
                    <div class="form-row align-items-end border p-2 m-0" id="segunda_img" hidden>
                      <div class="form-group col-12">
                        <label for="cargaImagen2">Subir foto del interior engrampado</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                      </div>
                      <div class="row p-0 m-0 justify-content-center">
                        <img id="mostrarImagen2" width="50%" height="50%"/>
                      </div>
                      <br>
                    </div>
                    <div class="form-row align-items-end border p-2 m-0" id="tercera_img" hidden>
                      <div class="form-group col-12">
                        <label for="cargaImagen3">Subir foto del punto de retencion de acometida</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                      </div>
                      <div class="row p-0 m-0 justify-content-center">
                        <img id="mostrarImagen3" width="50%" height="50%"/>
                      </div>
                      <br>
                    </div>
                  <!-- EXITOSAS -->
                  <!-- FALLIDAS -->
                    <div class="form-row align-items-end border p-2 m-0" id="fallida_img" hidden>
                      <div class="form-group col-12">
                        <label for="cargaImagen4">Subir foto de la planila con numero de ticekt</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                      </div>
                      <div class="row p-0 m-0 justify-content-center">
                        <img id="mostrarImagen4" width="50%" height="50%"/>
                      </div>
                      <br>
                    </div>
                    
                  <!-- FALLIDAS -->
                  <script type="text/javascript">
                    function previewImage(nb) {        
                      var reader = new FileReader();         
                      reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                      reader.onload = function (e) {             
                        document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                      };     
                    }
                  </script>
                <div class="form-row align-items-end" id="obs_text" hidden>
                  <div class="form-group col-12">
                    <label for="obs">Observaciones (opcional)</label >
                    <textarea id="obs" type="text" name="obs" maxlength="500" class="form-control" placeholder="Ingrese una observacion"></textarea>
                  </div>      
                </div>
                <input id="fin" type="submit" name="save_orden" class="btn btn-success btn-block" value="Registrar orden" hidden>
              </form>
            </div>
          </div>
				</div>
			</div>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
    <script>
      $(function(){
      $(".radio").click(function(){
        if($(this).val()=='Exitoso'){
          $("#fallida_img").attr('hidden','hidden');
          $("#fin").attr('hidden','hidden');
          $("#obs_text").attr('hidden','hidden');
          $("#primera_img").removeAttr('hidden');
          document.querySelector('#cargaImagen1').addEventListener('change', () =>
          {
            $("#segunda_img").removeAttr('hidden');
            document.querySelector('#cargaImagen2').addEventListener('change', () =>
            {
              $("#tercera_img").removeAttr('hidden');
              document.querySelector('#cargaImagen3').addEventListener('change', () =>
              {
                $("#fin").removeAttr('hidden');
                $("#obs_text").removeAttr('hidden');
              });
            });
          });
        }
        else
        {
          $("#primera_img").attr('hidden','hidden');
          $("#segunda_img").attr('hidden','hidden');
          $("#tercera_img").attr('hidden','hidden');
          $("#fallida_img").removeAttr('hidden');
          document.querySelector('#cargaImagen4').addEventListener('change', () =>
          {
            $("#fin").removeAttr('hidden');
            $("#obs_text").removeAttr('hidden');
          });
        }
      })
    })
    </script>
	</body>
</html>