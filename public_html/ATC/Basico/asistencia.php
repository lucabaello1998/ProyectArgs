<?php
  include("../../db.php");
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
  if($usu != 1)
  {
    header("location: ../inicio.php");
  }
?>

<?php include('../includesatc/headeratc.php'); ?>
<?php
  $mes = date ('Y-m', strtotime('-0 month'));
  if(isset($_POST['meses']))
  {
    $mes1 = $_POST['mes'];
    $mes = "20" .date ('y-m', strtotime($mes1));
  }
?>
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
  <h4 class="modal-title" text-center>Asistencia individual</h4>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga del dia individual</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../ATC/Guardar/save_asistenciaindividual.php" method="POST">
          <div class="form-row align-items-center">  
           <div class="form-group col">
              <label for="exampleFormControlSelect1">Tecnico</label >
               <select type="text" name="tecnico" class="form-control">                
                  <option>Tecnicos...</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicosatc ORDER BY nombre asc");
                  ?>
                  <?php foreach ($ejecutar as $opcioness): ?>   
                    <option value="<?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?>"><?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?></option>                                      
                  <?php endforeach ?>
                </select>
            </div>         
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Fecha</label >
              <input type="date" name="fechaa" required>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Inicio</label >
              <input type="text" class="form-control individual" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horaa" required>
            </div>       
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Dia</label >
              <select type="text" name="diaa" class="form-control">
              <option selected>Presente</option>
              <option>Ausente</option>  
              <option>Justificado</option>
              <option>Ya no trabaja</option>
              <option>Aun no ingresa</option>
            </select>
            </div>
          </div>
          <input type="submit" name="save_asistenciaindividual" class="btn btn-success btn-block" value="Guardar dia">
        </form>
      </div>      
    </div>
  </div>
</div>

<div class="container">
  <div class="form-row justify-content-center">
  <h4 class="modal-title" text-center>Asistencia diaria</h4>
</div>
  <div class="col-12 col-sm-12">
    <div class="form-row justify-content-center">
      <div class="col-5 col-sm-5">        
        <div class="row justify-content-center p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingresodiario">
            +
          </button> 
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal 1 -->
<div class="modal fade" id="ingresodiario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga del dia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		        <form action="../../ATC/Guardar/save_asistencia.php" method="POST">
		        <p class="h4 mb-4 text-center">Carga de Asistencias</p>
            <div class="form-row justify-content-center">
              <div class="form-group col-2 text-center">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="fecha" required>
                </div>
            </div>
		        <div class="form-row">
						<?php
						  $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicosatc WHERE operativo = 'SI' ORDER BY nombre asc");
						foreach ($ejecutar as $opciones): ?>	
						<div class="form-group col-md-6 col-lg-4  text-center">
						  <label name ='tecnico' ><?php echo ucwords(strtolower($opciones['nombre']))  .". " .strtoupper(substr($opciones['apellido'], 0, 1)) ?></label> 
							<div class="form-group">
                <div class="form-row">                						    				   
							    <select type="text" name="dia[]" class="form-control">
                    <option>Presente</option>
							      <option>Ausente</option>	
							      <option>Justificado</option>
                    <option>Ya no trabaja</option>
                    <option>Aun no ingresa</option>					      					      
							    </select>						    
						    </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Inicio</label >
                  <input type="text" class="form-control diario" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="hora[]" required>
                </div>
              </div>
						</div>

						<?php endforeach ?>	                
		           
		        </div>
	            <div class="form-row align-items-end">
	         		<input type="submit" name="save_asistencia" class="btn btn-success btn-block" value="Guardar asistencia">
	            </div>
		        </form>
		      </div>      
    </div>
  </div>
</div>

<?php
  $query = "SELECT count(dia) as 'totalausente' FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Ausente'";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result)) {             
  $totalausente= $row['totalausente'];} 
?>

<?php
  $query = "SELECT count(dia) as 'totalausentes', nombre FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Ausente' GROUP BY nombre ORDER BY totalausentes desc LIMIT 1";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result)) {             
  $totalausentes= $row['totalausentes'];} 
?>

<?php
  $query = "SELECT count(dia) as 'totalausentess' FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Justificado'";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result)) {             
  $totalausentess= $row['totalausentess'];} 
?>

<?php
  $query = "SELECT count(dia) as 'totalausentessss', nombre FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Justificado' GROUP BY nombre ORDER BY totalausentessss desc LIMIT 1";
  $result = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result)) {            
  $totalausentessss= $row['totalausentessss'];} 
?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-3">      
      <p class="h4 mb-4 text-center"><a class="btn btn-danger" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Ausentes <span class="badge badge-light"><?php echo $totalausente; ?></span></a></p>
      <div class="collapse multi-collapse" id="multiCollapseExample1">
        
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>            
              <th>Nombre</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Ausente' ORDER BY nombre asc";
            $result_tasks = mysqli_query($conn, $query);   
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>               
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['fecha']; ?></td>  
              </tr>
            <?php } ?>
          </tbody>
        </table>
     
      </div>
    </div>
    <div class="col-3">      
      <p class="h4 mb-4 text-center"><a class="btn btn-danger" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">Ausente Por tecnico <span class="badge badge-light"><?php echo $totalausentes; ?></a></p>
      <div class="collapse multi-collapse" id="multiCollapseExample3">
        
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>            
              <th>Nombre</th>
              <th>Cantidad</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT count(dia) as 'diaa', nombre FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Ausente' GROUP BY nombre ORDER BY diaa desc";
            $result_tasks = mysqli_query($conn, $query);   
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>               
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['diaa']; ?></td>  
              </tr>
            <?php } ?>
          </tbody>
        </table>
   
      </div>
    </div>
    <div class="col-3">      
      <p class="h4 mb-4 text-center"><a class="btn btn-warning" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Justificados <span class="badge badge-light"><?php echo $totalausentessss; ?></a></p>
      <div class="collapse multi-collapse" id="multiCollapseExample2">
  
        
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>            
              <th>Nombre</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Justificado' ORDER BY fecha desc";
            $result_tasks = mysqli_query($conn, $query);   
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>               
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['fecha']; ?></td>  
              </tr>
            <?php } ?>
          </tbody>
        </table>
      
     
      </div>
    </div>    
    <div class="col-3">      
      <p class="h4 mb-4 text-center"><a class="btn btn-warning" data-toggle="collapse" href="#multiCollapseExample4" role="button" aria-expanded="false" aria-controls="multiCollapseExample4">Justificado por tecnico <span class="badge badge-light"><?php echo $totalausentessss; ?></a></p>
      <div class="collapse multi-collapse" id="multiCollapseExample4">
 
        
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>            
              <th>Nombre</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT count(dia) as 'diaaa', nombre FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Justificado' GROUP BY nombre ORDER BY diaaa desc";
            $result_tasks = mysqli_query($conn, $query);   
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>               
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['diaaa']; ?></td>  
              </tr>
            <?php } ?>
          </tbody>
        </table>
      

      </div>
    </div>
  </div>
</div>

<?php
    $solofefe = explode("-", $mes);
    $mess = $solofefe[1];
?>

<p class="h4 mb-4 text-center">Asistencia de <?php 
switch ($mess){
  case '12': echo "Diciembre";
  break;
  case '11': echo "Noviembre";
  break;
  case '10': echo "Octubre";
  break;
  case '09': echo "Septiembre";
  break;
  case '08': echo "Agosto";
  break;
  case '07': echo "Julio";
  break;
  case '06': echo "Junio";
  break;
  case '05': echo "Mayo";
  break;
  case '04': echo "Abril";
  break;
  case '03': echo "Marzo";
  break;
  case '02': echo "Febrero";
  break;
  case '01': echo "Enero";
  break;
  }
  ?>
</p>


<div class="container-fluid">
<i class="fas fa-check-circle text-success text-center"></i><span> Presente</span>
<br>
<i class="fas fa-times-circle text-danger text-center"></i><span> Ausente</span>
<br>
<i class="fas fa-minus-circle text-warning text-center"></i><span> Justificado</span>
<br>
<i class="fas fa-minus-circle text-dark text-center"></i><span> Aun no ingresa</span>
<br>
<i class="fas fa-times-circle text-dark text-center"></i><span> Ya no trabaja</span>

    <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
      <thead class="thead-dark text-center">
        <tr>           
          <th>Nombre</th>
          <th>P</th>
          <th>A</th>
          <?php
            $queryyy = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' GROUP BY fecha ORDER BY fecha asc";
            $result_tasksa = mysqli_query($conn, $queryyy);   
            while($row = mysqli_fetch_assoc($result_tasksa)) { 
            $fech  = $row['fecha'];             
            $solofech = explode("-", $fech);
            $fechafecha = $solofech[2];
            ?>
          <th><?php echo $fechafecha; ?></th>
          <?php } ?>

        </tr>
      </thead>
      <tbody align="center">
        
          <?php
          $queryy = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' GROUP BY nombre ORDER BY nombre, fecha asc";
          $result_task = mysqli_query($conn, $queryy);   
          while($row = mysqli_fetch_array($result_task)) { ?>
        <tr>
          <td><?php $nom = $row['nombre']; echo $nom; ?></td>

          <?php
          $consulta2 = "SELECT count(dia) as 'prese' FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Presente' AND nombre ='$nom'";
          $respuesta2 = mysqli_query($conn, $consulta2);   
          while($row = mysqli_fetch_array($respuesta2)) { ?>
          <td><?php echo $row['prese']; ?></td>
          <?php  }?>

          <?php
          $consulta3 = "SELECT count(dia) as 'ausen' FROM asistenciaatc WHERE fecha LIKE '$mes%' AND dia = 'Ausente' AND nombre ='$nom'";
          $respuesta3 = mysqli_query($conn, $consulta3);   
          while($row = mysqli_fetch_array($respuesta3)) { ?>
          <td><?php echo $row['ausen']; ?></td>
          <?php  }?>




          <?php
          $query = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' AND nombre ='$nom' GROUP BY fecha ORDER BY fecha asc";
          $result_tas = mysqli_query($conn, $query);   
          while($row = mysqli_fetch_array($result_tas)) { ?>
          <td><?php if ($row['dia'] == 'Presente'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                    if ($row['dia'] == 'Ausente'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} 
                    if ($row['dia'] == 'Justificado'){echo '<i class="fas fa-minus-circle text-warning text-center"></i>';}
                    if ($row['dia'] == 'Aun no ingresa'){echo '<i class="fas fa-minus-circle text-dark text-center"></i>';}
                    if ($row['dia'] == 'Ya no trabaja'){echo '<i class="fas fa-times-circle text-dark text-center"></i>';}?></td>
          <?php } ?>

       </tr>  
    <?php } ?>
            
          
      </tbody>
    </table>
</div>

<style>
  table{ table-layout: fixed; }
  #contenedor{
    overflow-x: auto;
    height: 400px;
    width: 400px;
  }
  #tabla{
    min-width: 400px;  
    overflow-x:auto; 
  }
  #fecha{ min-width: 100px; }
</style>

<div class="container p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Ultimas dias</p>
      <div class="container-fluid" id="contenedor">
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>            
              <th>Nombre</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Dia</th> 
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM asistenciaatc WHERE fecha LIKE '$mes%' ORDER BY fecha desc";
            $result_tasks = mysqli_query($conn, $query);   
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr> 
              <td>
                  <a href="../../ATC/Editar/edit_asistencia.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../../ATC/Borrar/delete_asistencia.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt p-2"></i>
                  </a>
                </td>               
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['hora']; ?></td>
                <td><?php echo $row['dia']; ?></td>   
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="asistencia.php" method="POST">
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

<!-- PIE DE PAGINA -->

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- then Popper -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
 <!------Timepicker 1---->
<script src="../../clockpicker.js"></script>
<script type="text/javascript">
    var input = $('.individual').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
</script>

 <!------Timepicker 1---->
<script src="../../clockpicker.js"></script>
<script type="text/javascript">
    var input = $('.diario').clockpicker({
      placement: 'top',
      align: 'left',
      autoclose: true,
      'default': 'now'});
</script>
</body>
</html>