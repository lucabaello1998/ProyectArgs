<?php include("../../db.php"); ?>

<!-----Deposito---->
<?php
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
if($tipo == "ATC") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
?>
<!-----Deposito---->
<?php include('../../ATC/includesatc/headeratc.php'); ?>
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





<!-- Button trigger modal -->
<div class="container">
  <div class="form-row justify-content-center">
  <h4 class="modal-title" text-center>Tecnicos ATC</h4>
</div>
  <div class="col-12 col-sm-12">
    <div class="form-row justify-content-center">
      <div class="col-5 col-sm-5">        
        <div class="row justify-content-center p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingreso">
            +
          </button> 
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal 1 -->
<div class="modal fade" id="ingreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de tecnicos ATC</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../ATC/Guardar/save_tecnicosatc.php" method="POST" enctype="multipart/form-data">         

          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="tecnicoatc">Nombre</label >
              <input type="text" name="nombre" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un nombre" autofocus required>
            </div>            
            <div class="form-group col">
              <label for="tecnicoatc">Apellido</label >
              <input type="text" name="apellido" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un apellido" autofocus required>
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Operativo</label >
              <select type="text" name="operativo" class="form-control">              
                <option value="SI">SI</option>
                <option value="NO">NO</option>              
              </select>
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Num ATC</label >
              <input type="num" name="num_empleado" class="form-control" placeholder="Ingrese el numero de empleado" autofocus>
            </div>          
          </div>
          <div class="form-row align-items-end">
          	<div class="form-group col">
          		<label for="tecnicoatc">DNI</label>
          		<input type="number" name="dni" maxlength="11" class="form-control" placeholder="Ingrese un DNI"  required>
          	</div>
          	<div class="form-group col">
          		<label for="tecnicoatc">Telefono</label>
          		<input type="number" name="tel" maxlength="11" class="form-control" placeholder="Ingrese un telefono" >
          	</div>
          	<div class="form-group col">
          		<label for="tecnicoatc">Tareas</label>
          		<input type="text" name="tarea" maxlength="80" class="form-control" placeholder="Ingrese tarea a realizar" >
          	</div>
            <div class="form-group col">
          		<label>Inicio</label>
          		<input type="date" name="inicio" class="form-control" placeholder="Ingrese fecha del comienzo" required value="<?php echo date('Y-m-d'); ?>">
          	</div>
          </div>

          <div class="form-row align-items-end">
          	<div class="form-group col">
	          	<label for="tecnicoatc">Subir cedencial (jpg)</label>
			        <input type="file" accept="image/jpeg" class="form-control-file" name="archivo" id="archivo">
			     </div>
           <div class="form-group col">
              <div class="form-row justify-content-center">
                <input class="p-0" id="color" type="color" value="#FFFFF">
              </div>
            </div>
          </div>

          <div class="card card-body">
           <div class="form-row justify-content-center">
           <p class="h5 mb-4 text-center"><small>Datos Office Track</small></p>
       		</div>
           <div class="form-row align-items-end justify-content-center">
           <div class="form-group col">
              <label for="tecnicoatc">Email</label >
              <input type="mail" name="mail"  class="form-control" placeholder="Ingrese un mail" autofocus>
            </div>          
            <div class="form-group col">
              <label for="tecnicoatc">Usuario</label >
              <input type="text" name="usuario" pattern="[A-Za-z0-9_-.]{3-15}"  class="form-control" placeholder="Ingrese un usuario" autofocus>
            </div>
            <div class="form-group col">
              <label for="tecnicoatc">Contraseña</label >
              <input type="text" name="pass"  pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese una contraseña" autofocus>
            </div>
             
            
          </div>
     	 </div>
          <input type="submit" name="save_usuario" class="btn btn-success btn-block" value="Guardar tecnico">
        </form>
      </div>      
    </div>
  </div>
</div>


<div class="container p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Tecnicos activos</p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>            
              <th>Nombre</th>
              <th>DNI</th>
              <th>Telefono</th>
              <th>Tarea</th>
              <th>Mail</th>
              <th>Usuario</th>
              <th>Pass</th>
              <th>Num ATC</th>
              <th>Color</th>
              <th>Inicio</th>
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM tecnicosatc WHERE operativo = 'SI' AND num_empleado <> 111 ORDER BY nombre asc";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td>
                  <a href="../../ATC/Editar/edit_tecnicosatc.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <?php if ($row['enlace'] != "") {?>

                    <a href="../Archivos/tecnicos/<?php echo $row['enlace'] .".jpg"; ?>" download="<?php echo $row['enlace']; ?>"><i class="fas fa-user"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>

                    <?php } else { ?>

                    <a><i class="fas fa-user text-danger"></i></a>

                  <?php } ?>

                </td>             
                <td><?php echo $row['nombre'] ." " .$row['apellido'] ; ?></td>
                <td><?php echo $row['dni']; ?></td>
                <td><?php echo $row['tel']; ?></td>
                <td><?php echo $row['tarea']; ?></td>
                <td><?php echo $row['mail']; ?></td>
                <td><?php echo $row['usuario']; ?></td>
                <td><?php echo $row['pass']; ?></td>
                <td><?php echo $row['num_empleado']; ?></td>
                <td><div class="alert alert-primary" role="alert" style="background-color:<?php echo $row['color']; ?>;"></td>
                <td><?php if($row['inicio'] == '0000-00-00') {echo '-'; } else {echo Fecha7($row['inicio']);} ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<br>

<div class="container p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Tecnicos no activos</p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>            
              <th>Nombre</th>
              <th>DNI</th>
              <th>Telefono</th>
              <th>Tarea</th>
              <th>Mail</th>
              <th>Usuario</th>
              <th>Pass</th>
              <th>Num ATC</th>
              <th>Inicio</th>
              <th>Fin</th>
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM tecnicosatc WHERE operativo = 'NO' ORDER BY nombre asc";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td>
                  <a href="../../ATC/Editar/edit_tecnicosatc.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                </td>             
                <td><?php echo $row['nombre'] ." " .$row['apellido'] ; ?></td>
                <td><?php echo $row['dni']; ?></td>
                <td><?php echo $row['tel']; ?></td>
                <td><?php echo $row['tarea']; ?></td>
                <td><?php echo $row['mail']; ?></td>
                <td><?php echo $row['usuario']; ?></td>
                <td><?php echo $row['pass']; ?></td>
                <td><?php echo $row['num_empleado']; ?></td>
                <td><?php if($row['inicio'] == '0000-00-00') {echo '-'; } else {echo Fecha7($row['inicio']);} ?></td>
                <td><?php if($row['fin'] == '0000-00-00') {echo '-'; } else {echo Fecha7($row['fin']);} ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
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

</body>
</html>