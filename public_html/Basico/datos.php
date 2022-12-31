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
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <h4 class="modal-title" text-center>Datos generales</h4>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingresotec">
            +
          </button>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="ingresotec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de usuarios</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card card-body">
              <form action="../Guardar/save_tecnicos.php" method="POST" data-toggle="validator">
                <p class="h4 mb-4 text-center">Carga de tecnicos</p>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Nombre y Apellido</label >
                    <input type="text" name="tecnico" class="form-control"  autofocus required>
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">DNI</label >
                    <input type="number" name="dni"  class="form-control" autofocus required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4 col-6">
                    <label for="exampleFormControlSelect1">Talle de chomba</label >
                    <input type="text" name="chomba" class="form-control" maxlength="11" autofocus>
                  </div>
                  <div class="form-group col-md-4 col-6">
                    <label for="exampleFormControlSelect1">Talle de pantalon</label >
                    <input type="text" name="pantalon" class="form-control" maxlength="11" autofocus>
                  </div>
                  <div class="form-group col-md-4 col-12">
                    <label for="exampleFormControlSelect1">Talle de zapato</label >
                    <input type="text" name="zapato" class="form-control" maxlength="11" autofocus>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Fecha de ingreso</label >
                    <input type="date" name="ingreso" class="form-control" required>
                  </div>
                  <div class="form-group col-6">
                    <label for="inputEmail">E-mail</label >
                    <input type="email" name="mail"  class="form-control" autofocus>        
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Modelo celular</label >
                    <input type="text" name="modelo" class="form-control" autofocus >
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">SN celular</label >
                    <input type="text" name="sn" class="form-control" autofocus>
                  </div>          
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Telefono de flota</label >
                    <input type="number" name="flota" class="form-control" autofocus>
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Telefono personal</label >
                    <input type="number" name="tel" class="form-control" autofocus>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">TOA usuario</label >
                    <input type="text" name="tusu" class="form-control" autofocus >
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">TOA contraseña</label >
                    <input type="text" name="tcon" class="form-control" autofocus>
                  </div>         
                </div>
                <div class="form-row">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">SGT usuario</label >
                    <input type="text" name="sgtusu" class="form-control" autofocus>
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">SGT contraseña</label >
                    <input type="text" name="sgtcon" class="form-control" autofocus>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4 col-6">
                    <label for="exampleFormControlSelect1">Tipo</label >
                    <select type="text" name="tipo" class="form-control">
                      <option selected>Tipo...</option>
                      <option value="Ayudante">Ayudante</option>
                      <option value="Tecnico">Tecnico</option>
                      <option value="Preocupacional">Preocupacional</option>
                      <option value="Capacitacion">Capacitacion</option>              
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-6">
                    <label for="exampleFormControlSelect1">Zona</label >
                    <select type="text" name="zona" class="form-control">
                      <option selected>Zona...</option>
                      <option value="CABA">CABA</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4 col-12">
                    <label for="exampleFormControlSelect1">Deposito</label >
                    <select type="text" name="deposito" class="form-control" require>
                      <option selected disabled >Deposito...</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                </div>
                <input type="submit" name="save_tecnicos" class="btn btn-success btn-block" value="Guardar datos del tecnico">
              </form>
            </div>      
          </div>
        </div>
      </div>

      <?php
        $query = "SELECT count(tecnico) as 'totalnorte' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = 'Jose Leon Suarez'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalnorte= $row['totalnorte'];} 
      ?>

      <?php
        $query = "SELECT count(tecnico) as 'totalsur' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = 'Lomas de Zamora'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalsur= $row['totalsur'];} 
      ?>

      <?php
        $query = "SELECT count(tecnico) as 'totalcapanorte' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Capacitacion' AND zona = 'Jose Leon Suarez'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalcapanorte= $row['totalcapanorte'];} 
      ?>

      <?php
        $query = "SELECT count(tecnico) as 'totalcapasur' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Capacitacion' AND zona = 'Lomas de Zamora'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalcapasur= $row['totalcapasur'];} 
      ?>

      <?php
        $query = "SELECT count(tecnico) as 'totalpreocunorte' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Preocupacional' AND zona = 'Jose Leon Suarez'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalpreocunorte= $row['totalpreocunorte'];} 
      ?>

      <?php
        $query = "SELECT count(tecnico) as 'totalpreocusur' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Preocupacional' AND zona = 'Lomas de Zamora'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {             
        $totalpreocusur= $row['totalpreocusur'];} 
      ?>

      <div class="row justify-content-center p-1">
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Norte <span class="badge badge-light"><?php echo $totalnorte; ?></span></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample1">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = 'Jose Leon Suarez' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td> 
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">Sur <span class="badge badge-light"><?php echo $totalsur; ?></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample3">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = 'Lomas de Zamora' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td> 
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-info" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Capacitacion norte <span class="badge badge-light"><?php echo $totalcapanorte; ?></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample2">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Capacitacion' AND zona = 'Jose Leon Suarez' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div> 
            </div>
          </div>
        </div>    
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-info" data-toggle="collapse" href="#multiCollapseExample4" role="button" aria-expanded="false" aria-controls="multiCollapseExample4">Capacitacion sur <span class="badge badge-light"><?php echo $totalcapasur; ?></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample4">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Capacitacion' AND zona = 'Lomas de Zamora' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-warning" data-toggle="collapse" href="#multiCollapseExample5" role="button" aria-expanded="false" aria-controls="multiCollapseExample5">Preocupacional norte <span class="badge badge-light"><?php echo $totalpreocunorte; ?></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample5">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Preocupacional' AND zona = 'Jose Leon Suarez' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div> 
            </div> 
          </div>
        </div>    
        <div class="col-md-2 col-6">
          <p class="h4 mb-4 text-center"><a class="btn btn-warning" data-toggle="collapse" href="#multiCollapseExample6" role="button" aria-expanded="false" aria-controls="multiCollapseExample6">Preocupacional sur <span class="badge badge-light"><?php echo $totalpreocusur; ?></a></p>
          <div class="collapse multi-collapse" id="multiCollapseExample6">
            <div class="container p-0">
              <div class="row justify-content-center">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
                    <thead class="thead-dark text-center">
                      <tr>            
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Preocupacional' AND zona = 'Lomas de Zamora' ORDER BY tecnico asc");   
                        while($row = mysqli_fetch_assoc($result_tasks))
                        {
                      ?>
                        <tr>               
                          <td><?php echo $row['tecnico']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TECNICOS-->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Tecnicos Activos</p>
          <p class="h4 mb-4 text-center"><a class="h6" href="https://identidades.claro.com.ar/iam/im/public/ui7/index.jsp?task.tag=autogestiondecontraseniaexternosouthouse" target="_blank">Actualizar contraseña SGT</a></p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>DNI</th>
                <th>Recurso</th>
                <th>Chomba</th>
                <th>Pantalon</th>
                <th>Zapato</th>
                <th>Ingreso</th>
                <th>Modelo celular</th>
                <th>SN celular</th>
                <th>Telefono de flota</th>
                <th>Telefono personal</th>
                <th>Mail</th>
                <th>Patente</th>
                <th>TOA usuario</th>
                <th>TOA contraseña</th>
                <th>SGT usuario</th>
                <th>SGT contraseña</th>
                <th>Zona</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['dni']; ?></td>
                  <td><?php echo $row['id_recurso']; ?></td>
                  <td><?php echo $row['chomba']; ?></td>
                  <td><?php echo $row['pantalon']; ?></td>
                  <td><?php echo $row['zapato']; ?></td>
                  <td><?php echo Fecha4($row['ingreso']); ?></td>
                  <td><?php echo $row['modelo']; ?></td>
                  <td><?php echo $row['sn']; ?></td>
                  <td><?php echo $row['flota']; ?></td>
                  <td><?php echo $row['tel']; ?></td>
                  <td><?php echo $row['mail']; ?></td>
                  <td><?php echo $row['patente']; ?></td>
                  <td><?php echo $row['tusu']; ?></td>
                  <td><?php echo $row['tcon']; ?></td>
                  <td><?php echo $row['sgtusu']; ?></td>
                  <td><?php echo $row['sgtcon']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>   
        </div>
      </div>
      <br>

      <!-- AYUDANTES-->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ayudantes Activos</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>DNI</th>
                <th>Chomba</th>
                <th>Pantalon</th>
                <th>Zapato</th>
                <th>Ingreso</th>
                <th>Tipo</th>
                <th>Zona</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='SI' AND tipo <>'Tecnico' ORDER BY tecnico asc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['dni']; ?></td>
                  <td><?php echo $row['chomba']; ?></td>
                  <td><?php echo $row['pantalon']; ?></td>
                  <td><?php echo $row['zapato']; ?></td>
                  <td><?php echo Fecha4($row['ingreso']); ?></td>
                  <td><?php echo $row['tipo']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>   
        </div>
      </div>
      <br>

      <!-- DESAFECTADOS-->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Tecnicos Desafectados</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>DNI</th>
                <th>Chomba</th>
                <th>Pantalon</th>
                <th>Zapato</th>
                <th>Ingreso</th>
                <th>Modelo celular</th>
                <th>SN celular</th>
                <th>Telefono de flota</th>
                <th>Telefono personal</th>
                <th>Mail</th>
                <th>TOA usuario</th>
                <th>TOA contraseña</th>
                <th>SGT usuario</th>
                <th>SGT contraseña</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='NO' ORDER BY tecnico asc");    
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_tecnicos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['dni']; ?></td>
                  <td><?php echo $row['chomba']; ?></td>
                  <td><?php echo $row['pantalon']; ?></td>
                  <td><?php echo $row['zapato']; ?></td>
                  <td><?php echo Fecha4($row['ingreso']); ?></td>
                  <td><?php echo $row['modelo']; ?></td>
                  <td><?php echo $row['sn']; ?></td>
                  <td><?php echo $row['flota']; ?></td>
                  <td><?php echo $row['tel']; ?></td>
                  <td><?php echo $row['mail']; ?></td>
                  <td><?php echo $row['tusu']; ?></td>
                  <td><?php echo $row['tcon']; ?></td>
                  <td><?php echo $row['sgtusu']; ?></td>
                  <td><?php echo $row['sgtcon']; ?></td>
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
<!-- Calendario -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#ingreso").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#ingreso" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>

