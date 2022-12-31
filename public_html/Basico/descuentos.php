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
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<!-- FECHA -->
  <?php
    $mes = date ('Y-m', strtotime('-0 month'));
    if(isset($_GET['mes']))
    {
      $desencriptado = $_GET['mes'];
      $mes = base64_decode($desencriptado);
    }

    $b = explode("-", $mes);
    switch ($b[1])
    {
      case '12': $mes_nom = "Diciembre";
      break;
      case '11': $mes_nom = "Noviembre";
      break;
      case '10': $mes_nom = "Octubre";
      break;
      case '09': $mes_nom = "Septiembre";
      break;
      case '08': $mes_nom = "Agosto";
      break;
      case '07': $mes_nom = "Julio";
      break;
      case '06': $mes_nom = "Junio";
      break;
      case '05': $mes_nom = "Mayo";
      break;
      case '04': $mes_nom = "Abril";
      break;
      case '03': $mes_nom = "Marzo";
      break;
      case '02': $mes_nom = "Febrero";
      break;
      case '01': $mes_nom = "Enero";
      break;
    }
  ?>
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/descuentos.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/descuentos.php">
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
        <div class="col-auto">
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
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Tipos de penalizaciones</p>
          <table class="table table-responsive table-striped table-bordered table-sm" align="center">
            <thead class="thead-dark text-center">
              <tr align="center">                                
                <th>Motivos</th>        
                <th>Descuentos</th>
                <th>Observaciones</th>                            
              </tr>
            </thead>
            <tbody>            
                <tr>         
                  <td>Falta de EPP</td>
                  <td align="center">60%</td>
                  <td>La no utilizacion del equipo de seguridad: Casco, arnes, zapatos, guantes</td>                
                </tr>   
                <tr>         
                  <td>Instalacion</td>
                  <td align="center">50%</td>
                  <td>Recorrido inadecuado: Acometida, rosetta, interior</td>                
                </tr>   
                <tr>         
                  <td>Calidad</td>
                  <td align="center">25%</td>
                  <td>Miscelaneos, rotura</td>                
                </tr>
                <tr>         
                  <td>Indumentaria</td>
                  <td align="center">25%</td>
                  <td>Chomba, campera, gorra, pantalon, zapatos</td>                
                </tr>
                <tr>         
                  <td>Higiene</td>
                  <td align="center">25%</td>
                  <td>Vehiculo, personal, herramientas</td>                
                </tr> 
                <tr>         
                  <td>TOA</td>
                  <td align="center">25%</td>
                  <td>Inicio, cierre de ruta y tareas, inventario</td>                
                </tr>   
                  <tr>         
                  <td>Falta de planillas</td>
                  <td align="center">100%</td>
                  <td>Falta de entrega de planilla baja o numero de interaccion (descuento total de la tarea)</td>                
                </tr>  
                  <tr>         
                  <td>Baja mal cerrada</td>
                  <td align="center">100%</td>
                  <td>Baja mal cerrada, incompleta o sin aviso (descuento total de la baja)</td>                
                </tr>  
                <td>Descuento total</td>
                  <td align="center">100%</td>
                  <td>Penalizacion de una tarea completa</td>                
                </tr>               
            </tbody>
          </table>
        </div>
      </div>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_descuentos.php" method="POST" enctype="multipart/form-data">
              <p class="h4 mb-4 text-center">Carga de Descuentos y penalizaciones</p>
              <div class="form-row">
                <div class="form-group col-md-4 col-12">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control" required>
                    <option selected value="" disabled>Tecnicos...</option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="fecha" class="form-control" required>
                </div>            
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="number" name="ot" maxlength="11" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6 col-6">
                  <label for="exampleFormControlSelect1">Tipo de falla</label required>
                  <select type="text" name="falla" class="form-control">
                    <option disabled selected value="">Falla...</option>
                    <option value="Falta de EPP">Falta de EPP</option>
                    <option value="Instalacion">Instalacion</option>
                    <option value="Calidad">Calidad</option>
                    <option value="Indumentaria">Indumentaria</option>
                    <option value="Higiene">Higiene</option>
                    <option value="TOA">TOA</option>
                    <option value="Falta de planillas">Falta de planillas</option>
                    <option value="Baja mal cerrada">Baja mal cerrada</option>
                    <option value="Descuento total">Descuento total</option>
                    <option value="Otro">Otro</option>
                  </select>
                </div>
                <div class="form-group col-md-6 col-6">
                  <label for="exampleFormControlSelect1">Monto</label >
                  <input type="number" name="monto" maxlength="11" class="form-control" placeholder="Ingrese el monto">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-12">
                  <div class="form-row align-items-start justify-content-center"> 
                    <label for="customRadioInline1">Subir 1° imagen</label>
                    <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                    <br>
                    <img id="mostrarImagen1" width="50%" height="50%"/>
                  </div>
                </div>
              </div>            

              <div class="form-row">
                <div class="form-group col-12">
                  <div class="form-row align-items-start justify-content-center"> 
                    <label for="customRadioInline1">Subir 2° imagen</label>
                    <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                    <br>
                    <img id="mostrarImagen2" width="50%" height="50%"/>
                  </div>
                </div>
              </div>            

              <script type="text/javascript">
                function previewImage(nb)
                {        
                  var reader = new FileReader();         
                  reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                  reader.onload = function (e)
                  {             
                    document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                  };     
                }
              </script>
              <div class="form-row">
                <label for="exampleFormControlSelect1">Observaciones</label >
                <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion" autofocus></textarea>         
              </div>
              <div class="form-row align-items-center">
                <input type="submit" name="save_descuentos" class="btn btn-success btn-block" value="Guardar penalizacion">
              </div>
            </form>
          </div>
        </div>
      </div>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">   
          <a class="btn btn-info" href="../BaseDatos/dtdescuentos.php" role="button">Ver todas los descuentos</a>             
        </div>
      </div>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto"> 
          <p class="h4 mb-4 text-center">Ultimas penalizaciones</p>
          <table id="descuentos" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>Fecha</th>
                <th>OT</th>
                <th>Falla</th>
                <th>Monto</th>
                <th>Observaciones</th>
                <th>Fotos</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $pena = mysqli_query($conn, "SELECT * FROM descuentos WHERE fecha LIKE '%$mes%' ORDER BY fecha desc");
                while($row = mysqli_fetch_assoc($pena))
                { 
                  $imagen1 = $row['imagenpri'];
                  $imagen2 = $row['imagenseg'];
                  if($imagen1 == "")
                  {
                    $img1 = 0;
                  }
                  else
                  {
                    $img1 = 1;
                  }
                  if($imagen2 == "")
                  {
                    $img2 = 0;
                  }
                  else
                  {
                    $img2 = 1;
                  }
              ?>
                <tr>
                  <td align="center">
                    <a href="../Ver/ver_penalizacion.php?id=<?php echo $row['id']?>">
                      <i class="far fa-eye p-2"></i>
                    </a>
                    <a href="../Editar/edit_descuentos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_descuentos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td align="center"><?php echo Fecha7($row['fecha']); ?></td>                
                  <td align="center"><?php echo $row['ot']; ?></td>
                  <td align="center"><?php echo $row['falla']; ?></td>
                  <td align="center"><?php if($row['monto'] == 0){echo '-'; } else { echo '$' .$row['monto'] ; } ?></td>
                  <td><?php echo $row['obs']; ?></td>
                  <td><?php $fotos = $img1 + $img2 + $img3 + $img4; echo $fotos; ?></td>                         
                </tr>
              <?php } ?>
            </tbody>
          </table>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#descuentos').DataTable( {
          "dom": '<"top"if>rt<"bottom"><"clear">',
          "scrollY":        "500px",
          "scrollX": true,
          "scrollCollapse": true,
          "paging":         false,
          "language": {
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "lengthMenu":     "Mostrar _MENU_ bajas por pagina...",
          "zeroRecords":    "No se encontro ninguna baja",
          "info":           "",
          "infoEmpty":      "No hay bajas disponibles",
          "infoFiltered":   "filtrado entre _MAX_ bajas",
          "loadingRecords": "Cargando...",
          },
          "ordering": false
      } );
  } );
</script>
</body>
</html>