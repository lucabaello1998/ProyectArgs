<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
  $zona_us = $_SESSION['zona'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php
  include('../includes/header.php');

  if(isset($_GET['mes']))
  {
    $desencriptado = $_GET['mes'];
    $ultimo_mes = base64_decode($desencriptado);
  }
  else
  {
    $as = mysqli_query($conn, "SELECT * FROM asignacion_material ORDER BY fecha desc LIMIT 1");  
    while($row = mysqli_fetch_assoc($as))
    {
      $ult_fecha = $row['fecha'];
      $ultimo_mes = date("Y-m",strtotime($ult_fecha."-0 month"));
    }
  }
?>
<!-- FECHA -->
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_descarga.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ultimo_mes; ?>">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4">Descarga de <?php echo Fecha10($ultimo_mes); ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_descarga.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ultimo_mes; ?>">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col">
          <!-- MESSAGES -->
            <?php session_start();      
            if ($_SESSION['card'] == 1) { ?>
            <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
              <?= $_SESSION['message']?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php $_SESSION['card'] = 0; } ?>
          <!-- MESSAGES -->
        </div>
      </div>
        
      <div class="row justify-content-center p-1">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#descarga">
          #
        </button> 
      </div>

      <br>
      <div class="row justify-content-center p-1">
        <div class="col-auto align-self-center p-2">
          <?php
            $as = mysqli_query($conn, "SELECT * FROM asignacion_material ORDER BY fecha desc LIMIT 1");  
            while($row = mysqli_fetch_assoc($as))
            {
              $ultimo_dia = $row['fecha'];
            }
            if($zona_us == 'Todo')
            {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND tipo = 'Asignacion' GROUP BY tecnico ");}
            else
            {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND deposito = '$zona_us' AND tipo = 'Asignacion' GROUP BY tecnico ");}
            while($row = mysqli_fetch_assoc($resu))
            {
              $array[] = $row['tecnico']; 
            }
            if($zona_us == 'Todo')
            {$descar = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND tipo = 'Descarga' GROUP BY tecnico ");}
            else
            {$descar = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND deposito = '$zona_us' AND tipo = 'Descarga' GROUP BY tecnico ");}
            while($rod = mysqli_fetch_assoc($descar))
            {
              $array_descarga[] = $rod['tecnico']; 
            }
          ?>
          <style>
            :root { --del-color: #F56F84;}
              del 
              {
                --color: var(--del-color, red);
                text-decoration: none;
                padding: 0 .5em;
                background-repeat: no-repeat;
                background-image: 
                  linear-gradient(to left, rgba(255, 255, 255, .5), transparent),
                  linear-gradient(2deg, var(--color) 50%, transparent 50%),
                  linear-gradient(-.9deg, var(--color) 50%, transparent 50%),
                  linear-gradient(-60deg, var(--color) 50%, transparent 50%),
                  linear-gradient(120deg, var(--color) 50%, transparent 50%);
                
                background-size: 
                  30% 1.5px,
                  calc(100% - 20px) 10px, 
                  calc(100% - 20px) 10px,
                  10px 10px,
                  8px 8px; 
                
                background-position: 
                  100% calc(50% + 2px),
                  center center, 
                  center center, 
                  2px 50%, 
                  calc(100% - 3px) calc(50% + 1px);
              }
            :root { --sel-color: #6ded6d;}
              sel 
              {
                --color: var(--sel-color, red);
                text-decoration: none;
                padding: 0 .5em;
                background-repeat: no-repeat;
                background-image: 
                  linear-gradient(to left, rgba(255, 255, 255, .5), transparent),
                  linear-gradient(2deg, var(--color) 50%, transparent 50%),
                  linear-gradient(-.9deg, var(--color) 50%, transparent 50%),
                  linear-gradient(-60deg, var(--color) 50%, transparent 50%),
                  linear-gradient(120deg, var(--color) 50%, transparent 50%);
                
                background-size: 
                  30% 1.5px,
                  calc(100% - 20px) 10px, 
                  calc(100% - 20px) 10px,
                  10px 10px,
                  8px 8px; 
                
                background-position: 
                  100% calc(50% + 2px),
                  center center, 
                  center center, 
                  2px 50%, 
                  calc(100% - 3px) calc(50% + 1px);
              }
          </style>
          <span class="p-2"><b>Ultimo dia: </b><?php echo Fecha7($ultimo_dia); ?></span>
          <br>
          <span class="p-2"><b>Materiales asignados: </b><del>Tecnico</del></span>
          <br>
          <span class="p-2"><b>Materiales descargados: </b><sel>Tecnico</sel></span>
          <br>
          <div class="p-2">
            <?php
              if($zona_us == 'Todo')
                {$lista_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' ORDER BY tecnico asc");}
                else
                {$lista_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = '$zona_us' ORDER BY tecnico asc");}
                while($row = mysqli_fetch_assoc($lista_tec))
                {
                  $tec = $row['tecnico'];
                  if (in_array($tec, $array))
                  { 
                    if (in_array($tec, $array_descarga))
                    {
                      echo '<sel> ' .$tec .' </sel> - ';
                    }
                    else
                    {
                      echo '<del> ' .$tec .' </del> - ';
                    }
                  }
                  else
                  { echo ' ' .$tec .' - '; }
                }
            ?>
          </div>
        </div>
      </div>

      <!-- MODAL DESCARGA -->
        <div class="modal fade" id="descarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_descarga" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel_descarga" text-center>Descarga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../Guardar/save_descarga.php" method="POST" data-toggle="validator">
                    <div class="form-row justify-content-center">
                      <button type="button" class="btn btn-warning btn-sm" id="actualizar"><i class="fa-solid fa-rotate"></i></button>
                    </div>
                    <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
                      <div class="form-row">
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Tecnico</label>
                          <select type="text" id="tecnico_descarga" name="tecnico" class="form-control" require>
                            <option selected disabled value="">Tecnico...</option>
                            <?php
                              $consulta="SELECT tecnico FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' GROUP BY tecnico";
                              $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>   
                              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Fecha</label >
                          <input type="date" name="fecha" id="fecha_descarga" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Deposito</label>
                          <select type="text" id="zona_descarga" name="zona" class="form-control" require>
                            <option selected disabled value="">Deposito...</option>
                            <?php
                              $consulta="SELECT DISTINCT zona, abreviatura FROM usuarios WHERE zona <> 'Todo' AND zona <> '' ";
                              $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>   
                              <option value="<?php echo $opciones['zona'] ?>"><?php echo $opciones['zona'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">OT</label >
                          <input type="number" name="ot" class="form-control" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col" id="material_descarga">
                        </div>
                      </div>
                    <?php } else {?>
                      <div class="form-row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                          <label for="exampleFormControlSelect1">Tecnico</label>
                          <select type="text" id="tecnico_descarga" name="tecnico" class="form-control" require>
                            <option selected disabled value="">Tecnico...</option>
                            <?php
                              $consulta="SELECT tecnico FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' GROUP BY tecnico";
                              $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>   
                              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Fecha</label >
                          <input type="date" name="fecha" id="fecha_descarga" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">OT</label >
                          <input type="number" name="ot" class="form-control" required>
                        </div>
                        <input type="hidden" id="zona_descarga" name="zona" value="<?php echo $zona_us; ?>" >
                      </div>
                      <div class="form-row">
                        <div class="form-group col" id="material_descarga">
                        </div>
                      </div>
                    <?php } ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- MODAL DESCARGA -->

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
            <!-- CONTENIDO -->
              <?php
                  $query_mat1 = "SELECT * FROM asignacion_material WHERE tipo = 'Descarga' AND fecha LIKE '%$ultimo_mes%' GROUP BY fecha LIMIT 1";
                  $result_mat1 = mysqli_query($conn, $query_mat1);
                  while($row = mysqli_fetch_assoc($result_mat1)) { 
                  $anio_mat1 = $row['fecha'];
                  $hace_1_mes = date("m",strtotime($anio_mat1));
                ?>
                  <div class="row justify-content-center">
                    <div class="col-auto text-center">
                      <table class="table table-responsive table-striped table-bordered table-sm">
                        <thead class="thead-dark text-center">
                          <tr>                      
                            <th>Material</th>
                            <?php
                              $a = mysqli_query($conn, "SELECT fecha FROM asignacion_material WHERE fecha LIKE '%$ultimo_mes%' AND seriado = '' AND tipo = 'Descarga' GROUP BY fecha ");
                              while($row = mysqli_fetch_assoc($a)) {
                                $fechi_1 = $row['fecha'];
                                $encriptado_1 = base64_encode($fechi_1);
                            ?>
                            <th><a href="./descarga_dia.php?dia=<?php echo $encriptado_1;?>" class="text-white">
                              <?php
                                echo Fecha11($fechi_1) ;
                              ?>
                            </a></th>
                            <?php } ?>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                            $b = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha LIKE '%$ultimo_mes%' AND seriado = '' AND tipo = 'Descarga' GROUP BY material ");
                            while($row = mysqli_fetch_assoc($b))
                            {
                              $matemate_1 = $row['material'];
                          ?>
                            <tr>
                              <td><?php echo utf8_decode($matemate_1); ?></td>

                              <?php
                                $c = mysqli_query($conn, "SELECT fecha FROM asignacion_material WHERE fecha LIKE '%$ultimo_mes%' AND seriado = '' AND tipo = 'Descarga' GROUP BY fecha ");
                                while($row = mysqli_fetch_assoc($c)) {
                                  $fecha_group = $row['fecha'];
                              ?>
                              <?php
                                $d = mysqli_query($conn, "SELECT *, SUM(usado) as 'cant_mat_uno' FROM asignacion_material WHERE fecha = '$fecha_group' AND tipo = 'Descarga' AND material = '$matemate_1' AND seriado = '' ");
                                while($roww = mysqli_fetch_assoc($d))
                                {
                              ?>
                                <td><?php if($roww['cant_mat_uno'] == ''){echo '-';}else{ echo $roww['cant_mat_uno'];} ?></td>
                              <?php } ?>
                              <?php } ?>


                            </tr>
                          <?php } ?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
              <?php } ?>
            <!-- CONTENIDO -->
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$('#zona').on('change',function(){  /* #ID */
		var parametros= "zona="+$(this).val();
		$.ajax({
				data:  parametros,
				url:   '../Ajax/a_asignacion.php',
				type:  'post',
				beforeSend: function () { },
				success:  function (response) { 
					$("#material").html(response);
					$('#material').on('change',function(){
		})
				},
				error:function(){
					alert("error")
				}
			});
		})
	})
</script>
<script>
	$(document).ready(function(){
		$('#actualizar').on('click',function(){
    var dato1= $('#tecnico_descarga').val();
    var dato2= $('#fecha_descarga').val();
		var dato3= $('#zona_descarga').val();
    
    var parametros = 
      {
        "tecnico" : dato1,
        "fecha" : dato2,
        "zona" : dato3
      };
      $.ajax({
          data:  parametros,
          url:   '../Ajax/a_descarga.php',
          type:  'post',
          beforeSend: function () { },
          success:  function (desca) { 
            $("#material_descarga").html(desca);
            $('#material_descarga').on('change',function(){
            })
          },
          error:function(){
            alert("error")
          }
      });
		})
	})


</script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>