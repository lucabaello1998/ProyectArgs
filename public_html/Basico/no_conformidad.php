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
          <input type="hidden" name="link" value="../Basico/no_conformidad.php">
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
          <input type="hidden" name="link" value="../Basico/no_conformidad.php">
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
          <div class="card card-body">
            <form action="../Guardar/save_nc.php" method="POST" enctype="multipart/form-data">
              <p class="h4 mb-4 text-center">Carga de no conformidades</p>
              <div class="form-row align-items-end">
                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label>Tecnico</label >
                  <select type="text" name="tecnico" class="form-control" required>
                      <option disabled selected="">Tecnicos...</option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo = 'Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label>Fecha</label >
                  <input type="date" name="fecha" class="form-control" required>
                </div>            
                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label>Supervisor</label >
                  <input type="text" name="supervisor" class="form-control" required>
                </div>
                <div class="form-group col-md-3 col-sm-6 col-12">
                  <label>ID</label >
                  <input type="text" name="id_nc" class="form-control" required>
                </div>
              </div>

                <div class="form-row align-items-end">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Observaciones</label >
                    <textarea type="text" name="obs" maxlength="255" class="form-control" autofocus></textarea>
                  </div>          
                </div>

                <div class="form-row align-items-end">
                  <div class="form-group col-12">
                    <label for="customRadioInline1">Subir 1° imagen</label>
                    <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                  </div>
                  <img id="mostrarImagen1" width="50%" height="50%"/>
                </div>

                <div class="form-row align-items-end">
                  <div class="form-group col-12">
                    <label for="customRadioInline1">Subir 2° imagen</label>
                    <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                  </div>
                  <img id="mostrarImagen2" width="50%" height="50%"/>
                </div>

                <div class="form-row align-items-end">
                  <div class="form-group col-12">
                    <label for="customRadioInline1">Subir 3° imagen</label>
                    <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                  </div>
                  <img id="mostrarImagen3" width="50%" height="50%"/>
                </div>

                <script type="text/javascript">
                  function previewImage(nb) {        
                    var reader = new FileReader();         
                    reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                    reader.onload = function (e) {             
                    document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                    };     
                  }
                </script>
                <br>

              <input type="submit" name="save_nc" class="btn btn-success btn-block" value="Guardar no conformidad">
            </form>
          </div>
        </div>
      </div>

      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-info" href="../BaseDatos/dtnc.php" role="button">Ver todas las no conformidades</a>
        </div>
      </div>

      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimas no conformmidades</p>
          <table class="table table-responsive table-striped table-bordered table-sm" >
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <?php if($tipo_us == 'Administrador'){ ?> 
                <th>Quien</th>
                <th>Cuando</th>
                <?php } ?>
                <th>Tecnico</th>
                <th>Fecha</th>
                <th>Supervisor</th>
                <th>ID NC</th>
                <th>Observaciones</th>
                <th>Fotos</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM no_conformidades WHERE fecha LIKE '%$mes%' ORDER BY fecha desc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
                  $imagen1 = $row['imagenpri'];
                  $imagen2 = $row['imagenseg'];
                  $imagen3 = $row['imagenter'];
                  if($imagen1 == ""){$img1 = 0;}else{$img1 = 1;}
                  if($imagen2 == ""){$img2 = 0;}else{$img2 = 1;}
                  if($imagen3 == ""){$img3 = 0;}else{$img3 = 1;}
                ?>
                <tr>
                  <td align="center">
                    <a href="../Ver/ver_nc.php?id=<?php echo $row['id']?>">
                      <i class="far fa-eye p-2"></i>
                    </a>
                    <a href="../Editar/edit_nc.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_nc.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <?php if($tipo_us == 'Administrador'){ ?> 
                  <td><?php echo $row['quien']; ?></td>
                  <td><?php echo $row['cuando']; ?></td>
                  <?php } ?>
                  <td><?php echo utf8_encode(utf8_decode($row['tecnico'])); ?></td>
                  <td><?php echo Fecha7($row['fecha']); ?></td>
                  <td><?php echo utf8_encode(utf8_decode($row['supervisor'])); ?></td>
                  <td><?php echo $row['id_nc']; ?></td>
                  <td><?php echo utf8_encode(utf8_decode($row['problema'])); ?></td>
                  <td><?php $fotos = $img1 + $img2 + $img3; echo $fotos; ?></td>                         
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
</body>
</html>