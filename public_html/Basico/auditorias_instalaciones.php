<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
  session_destroy();
  header("location: ../index.php");
  exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$supervisor = $nombre ." " .$apellido;
}
?>
<?php
  include('../includes/header.php'); 
  $mes = "20" .date ('y-m', strtotime('-0 month'));
  if(isset($_POST['meses']))
  {
    $mes1 = $_POST['mes'];
    $mes = "20" .date ('y-m', strtotime($mes1));
  }
?>


<div class="container-fluid">

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
    <div class="col-5 col-sm-5 p-1">
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-info m-4" href="../Basico/auditorias_instalaciones2.php" role="button">Instalaciones <i class="fas fa-camera"></i></a>
      </div>
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-success m-4" href="../Basico/auditorias2.php" role="button">Herramientas <i class="fas fa-camera"></i></a>
      </div>
      <div class="row justify-content-center p-1 pr-3">
        <a class="btn btn-primary m-4" href="../Basico/auditorias_vehiculo2.php" role="button">Vehiculos <i class="fas fa-camera"></i></a>
      </div>
    </div>
  </div>

  <!-----Supervisor---->
    <?php if ($tipo == 'Supervisor'){ ?>
      <div class="row justify-content-center p-1">
        <div class="col">
          <div class="card card-body">
            <form action="../Guardar/save_auditorias_instalaciones.php" method="POST" enctype="multipart/form-data">
              <p class="h4 mb-4 text-center">Auditoria de instalaciones</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tecnico</label>
                  <select type="text" name="tecnico" class="form-control" required>                
                    <option selected value="" disabled>Tecnicos...</option>                
                    <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                  <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha</label>
                  <input type="text" id="fecha" name="fecha" readonly="" class="form-control" required>
                </div>
              </div>
              <div class="card card-body border-info">

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>OT</b></label >
                  <div class="form-row align-items-center">                  
                      <input type="number" maxlength="10" name="ot" class="form-control" autofocus>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Instalacion externa</b></label>
                  <div class="form-row align-items-center">
                    <div class="form-group col-xs-2">
                      <legend class="col-form-label col">Estado</legend>
                    </div>
                    <div class="form-group col-xs-10">
                      <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="BIEN" checked>
                        <label class="form-check-label" for="customRadioInline1">Bien</label>
                      </div>
                      <div class="form-check custom-control-inline">
                        <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="MAL">
                        <label class="form-check-label" for="customRadioInline2">Mal</label>
                      </div>
                    </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Foto del nomenclador</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cadena</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Altura de la acometida</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Punto de retencion</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Curva de goteo</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ingreso al domicilio</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Engrampado interior</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Amurado de ONT</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Residuos</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Trato con el cliente</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Uso de herramientas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Uso de epp</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="BIEN" checked>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="MAL">
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <br>

                <br>
                <div class="col">
                  <label for="exampleFormControlSelect1"><b>Observaciones (Max 1000 caracteres)</b></label >
                  <textarea type="text" name="obs" maxlength="1000" class="form-control" placeholder="Ingrese una observacion"></textarea>
                </div> 
              </div>
              <br>
              <input type="submit" name="save_auditoria_instalaciones" class="btn btn-success btn-block" value="Guardar auditoria">
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  <!-----Supervisor---->

  <style type="text/css">
    .table .sticky{
      position: sticky;
      left: 0;
    }
    .table tbody tr .sticky {
      background: #f2f2f2;
    }
    .table tbody tr:nth-child(2n) .sticky {    
      background: white;
    }
  </style>

  <!-----VISTA SUPERVISOR---->
    <?php
      if ($tipo == 'Administrador' OR $tipo == 'Despacho')
      { 
    ?>
    <br>
    <div class="row justify-content-center p-1">
      <a class="btn btn-info" href="../Basico/auditoriasanalisis.php" role="button">Ver analisis</a>        
    </div>
    <div class="row justify-content-center p-1">
      <div class="col">
        <p class="h4 mb-4 text-center">Auditorias instalaciones vista de <?php echo $tipo; ?> </p>
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>ID</th>
              <th>Supervisor</th>
              <th>Fecha auditoria</th>
              <th class="sticky pl-0">Tecnico</th>
              <th>Fecha</th>
              <th>OT</th>
              <th>Instalacion externa</th>              
              <th>Foto del nomenclador</th>
              <th>Cadena</th>
              <th>Altura de acometida</th>
              <th>Punto de retencion</th>
              <th>Curva de goteo</th>
              <th>Ingreso al domicilio</th>
              <th>Engrampado interior</th>
              <th>Amurado de ONT</th>
              <th>Residuos</th>
              <th>Trato con el cliente</th>
              <th>Uso de herramientas</th>
              <th>Uso de EPP</th>
              <th>Observaciones</th>
              <th>Fotos</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
              $result = mysqli_query($conn, "SELECT * FROM auditoria_instalaciones ORDER BY fecha desc LIMIT 60");
              while($row = mysqli_fetch_assoc($result)) {
              $imagen1 = $row['imagenpri'];
              $imagen2 = $row['imagenseg'];
              $imagen3 = $row['imagenter'];
              $imagen4 = $row['imagencuar'];
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
              if($imagen3 == "")
              {
                $img3 = 0;
              }
              else
              {
                $img3 = 1;
              }
              if($imagen4 == "")
              {
                $img4 = 0;
              }
              else
              {
                $img4 = 1;
              }
            ?>
              <tr>
                <td>
                  <a href="../Ver/ver_auditoria_instalaciones.php?id=<?php echo $row['id']?>">
                    <i class="far fa-eye p-2"></i>
                  </a>
                  <a href="../Editar/edit_auditoria_instalaciones.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_auditoria_instalaciones.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['identificador']; ?></td>
                <td><?php echo $row['supervisor']; ?></td>
                <td><?php echo $row['fecha_relevo']; ?></td>
                <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['ot']; ?></td> 
                <td><?php if ($row['instalacion_externa'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['instalacion_externa'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>           
                <td><?php if ($row['foto_nomenclador'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['foto_nomenclador'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['cadena'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['cadena'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['altura_acometida'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['altura_acometida'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['punto_retencion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['punto_retencion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['curva_goteo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['curva_goteo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['ingreso_domicilio'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['ingreso_domicilio'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['engrampado_interior'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['engrampado_interior'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['ont'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['ont'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['residuos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['residuos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                <td><?php if ($row['trato_cliente'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['trato_cliente'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['uso_herramientas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['uso_herramientas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php if ($row['epp'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['epp'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                <td><?php echo utf8_decode($row['obs']); ?></td>
                <td><?php $fotos = $img1 + $img2 + $img3 + $img4; echo $fotos; ?></td>              
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="form-row justify-content-md-center">
          <div class="form-group col col-md-auto"> 
            <div class="container">
              <a class="btn btn-info" href="../BaseDatos/dtauditoria_instalaciones.php" role="button">Ver todas las auditorias de instalaciones</a>
            </div>
          </div>
        </div>
      </div>
      </br>
        <div class="row justify-content-center p-1">
          <div class="col">
            <div class="card card-body">
              <form action="../Basico/auditorias_instalaciones.php" method="POST">
                <p class="h4 mb-4 text-center">Mes</p>
                <div class="form-row align-items-end">
                  <div class="col">
                    <select type="text" name="mes" class="form-control">
                      <option selected>Mes...</option>
                      <option value="-0 month">Mes actual</option>
                      <option value="-1 month">Hace un mes</option>
                      <option value="-2 month">Hace dos meses</option>
                      <option value="-3 month">Hace tres meses</option>
                    </select>
                  </div>            
                  <div class="col">
                    <input type="submit" name="meses" class="btn btn-success btn-block" value="Cargar mes">
                  </div>            
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <?php } else {  ?>
  <!-----VISTA SUPERVISOR---->

    <div class="row justify-content-center p-1">
      <div class="col">
        <p class="h4 mb-4 text-center">Auditorias de instalaciones <?php echo $supervisor; ?> </p>
        <div class="container-fluid">
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>ID</th>
                <th class="sticky pl-0">Tecnico</th>
                <th>Fecha</th>
                <th>OT</th>
                <th>Instalacion externa</th>              
                <th>Foto del nomenclador</th>
                <th>Cadena</th>
                <th>Altura de acometida</th>
                <th>Punto de retencion</th>
                <th>Curva de goteo</th>
                <th>Ingreso al domicilio</th>
                <th>Engrampado interior</th>
                <th>Amurado de ONT</th>
                <th>Residuos</th>
                <th>Trato con el cliente</th>
                <th>Uso de herramientas</th>
                <th>Uso de EPP</th>
                <th>Observaciones</th>
                <th>Fotos</th>             
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $query = "SELECT * FROM auditoria_instalaciones WHERE supervisor = '$supervisor' ORDER BY fecha_relevo desc LIMIT 60";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) {
                $imagen1 = $row['imagenpri'];
                $imagen2 = $row['imagenseg'];
                $imagen3 = $row['imagenter'];
                $imagen4 = $row['imagencuar'];
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
                if($imagen3 == "")
                {
                  $img3 = 0;
                }
                else
                {
                  $img3 = 1;
                }
                if($imagen4 == "")
                {
                  $img4 = 0;
                }
                else
                {
                  $img4 = 1;
                }
              ?>
                <tr>
                  <td>
                    <a href="../Ver/ver_auditoria_instalaciones.php?id=<?php echo $row['id']?>">
                      <i class="far fa-eye p-2"></i>
                    </a>
                    <a href="../Editar/edit_auditoria_instalaciones.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['identificador']; ?></td>
                  <td class="sticky pl-0"><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['fecha']; ?></td>
                  <td><?php echo $row['ot']; ?></td> 
                  <td><?php if ($row['instalacion_externa'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['instalacion_externa'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>           
                  <td><?php if ($row['foto_nomenclador'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['foto_nomenclador'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['cadena'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['cadena'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['altura_acometida'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['altura_acometida'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['punto_retencion'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['punto_retencion'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['curva_goteo'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['curva_goteo'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['ingreso_domicilio'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['ingreso_domicilio'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['engrampado_interior'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['engrampado_interior'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['ont'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['ont'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['residuos'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['residuos'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>                
                  <td><?php if ($row['trato_cliente'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['trato_cliente'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['uso_herramientas'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['uso_herramientas'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php if ($row['epp'] == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                            if ($row['epp'] == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></td>
                  <td><?php echo utf8_decode($row['obs']); ?></td>
                  <td><?php $fotos = $img1 + $img2 + $img3 + $img4; echo $fotos; ?></td>                          
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <?php } ?>
</div>

  <!-- PIE DE PAGINA -->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- then Popper -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!-- Calendario 1-->
  <script src="../jquery-3.3.1.min.js"></script>
  <script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  <script type="text/javascript">
    $(function() {
      $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
      $( "#anim" ).on( "change", function() {
        $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
      });
    } );
  </script>
</body>
</html>

