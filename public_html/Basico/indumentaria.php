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
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
?>
<?php include('../includes/header.php'); ?>

<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectec' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectec= $row['tectec'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayu' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayu= $row['ayuayu'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayusur' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Lomas de Zamora' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayusur= $row['ayuayusur'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectecsur' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Lomas de Zamora' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectecsur= $row['tectecsur'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayunorte' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Jose Leon Suarez' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayunorte= $row['ayuayunorte'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectecnorte' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Jose Leon Suarez' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectecnorte= $row['tectecnorte'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayucaba' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='CABA' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayucaba= $row['ayuayucaba'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tecteccaba' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='CABA' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tecteccaba= $row['tecteccaba'];} 
?>

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
          <div class="form-row justify-content-center">
            <h4 class="modal-title" text-center>Ingreso de indumentaria</h4>
          </div>
          <div class="col-12 col-sm-12">
            <div class="form-row justify-content-center">
              <div class="col-5 col-sm-5">
                <div class="row justify-content-end p-1 pr-3">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingreso">
                    +
                  </button> 
                </div>      
                <div class="row justify-content-end p-1 pr-3">
                  <a class="btn btn-success" href="../BaseDatos/dtindumentaria.php" role="button">Ver todos los ingresos</a>
                </div>
                <div class="row justify-content-end p-1 pr-3">
                  <label>Tecnicos: <?php echo $tectec; ?></label>
                </div>
                <div class="row justify-content-end p-1 pl-3">
                  <label><?php echo " (Lomas de Zamora: " .($tectecsur+$tecteccaba) ." ; Jose Leon Suarez: " .$tectecnorte .")-" ; ?></label>
                </div>         
              </div>
              
              <div class="col-5 col-sm-5">
                <div class="row justify-content-start p-1 pl-3">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#egreso">
                    #
                  </button> 
                </div>
                <div class="row justify-content-start p-1 pl-3">
                  <a class="btn btn-primary" href="../BaseDatos/dtindumentariaegreso.php" role="button">Ver todos los egresos</a>
                </div>
                <div class="row justify-content-start p-1 pl-3">
                  <label>Ayudantes: <?php echo $ayuayu; ?></label>         
                </div> 
                <div class="row justify-content-start p-1 pl-3">
                  <label><?php echo " (Lomas de Zamora: " .($ayuayusur+$ayuayucaba) ." ; Jose Leon Suarez: " .$ayuayunorte .")" ; ?></label>
                </div>       
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
              <h5 class="modal-title" id="exampleModalLabel" text-center>Ingreso</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Guardar/save_indumentaria.php" method="POST">
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md-6">
                    <label for="exampleFormControlSelect1">Indumentaria nuevo</label >
                    <input type="text" name="indumentaria" class="form-control" placeholder="Ingrese la indumentaria" autofocus>
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="exampleFormControlSelect1">Indumentaria ya ingresada</label >
                    <select type="text" name="indumentariadentro" class="form-control">                
                      <option selected="0">Indumentaria...</option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM indumentaria GROUP BY indumentaria ORDER BY indumentaria asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['indumentaria'] ?>"><?php echo $opciones['indumentaria'] ?></option>                    
                      <?php endforeach ?>                    
                    </select>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md-4">
                    <label for="exampleFormControlSelect1">Numero de SAP</label >
                    <input type="number" name="sap" class="form-control" maxlength="20" placeholder="Ingrese el SAP" autofocus>
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Pedido</label >
                    <input type="number" name="pedido" class="form-control" maxlength="30" placeholder="Ingrese un numero de pedido" autofocus>
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Talle</label >
                    <input type="text" name="talle" class="form-control" maxlength="5" placeholder="Ingrese el talle" autofocus>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md-4">
                    <label for="exampleFormControlSelect1">Centro deposito</label >
                    <select type="text" name="centro" class="form-control" required>
                      <option selected value="" disabled>Centro...</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Cantidad</label >
                    <input type="number" name="cantidad" maxlength="10" class="form-control" placeholder="Ingrese una cantidad" autofocus value="1">
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Fecha</label >
                    <input type="text" id="fecha" name="fecha" readonly="" class="form-control" required>
                  </div>
                </div>
                <div class="form-row align-items-center">
                  <input type="submit" name="save_indumentaria" class="btn btn-success btn-block" value="Guardar indumentaria">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal 2-->
      <div class="modal fade" id="egreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Egreso</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Guardar/save_entregaindumentaria.php" method="POST">
                <div class="form-row align-items-end">
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Indumentaria</label >
                    <select type="text" name="indumentaria" class="form-control" required>
                      <option selected value="" disabled>Indumentaria...</option>
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM indumentaria GROUP BY indumentaria ORDER BY indumentaria asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>
                        <option value="<?php echo $opciones['indumentaria'] ?>"><?php echo $opciones['indumentaria'] ?></option>                    
                      <?php endforeach ?>
                    </select>  
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Talle</label >
                    <select type="text" name="talle" class="form-control" required>
                      <option selected value="" disabled>Talle...</option>
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM indumentaria GROUP BY talle ORDER BY talle asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>
                        <option value="<?php echo $opciones['talle'] ?>"><?php echo $opciones['talle'] ?></option>
                      <?php endforeach ?>
                    </select>  
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="exampleFormControlSelect1">Entrega a...</label >
                    <select type="text" name="tecnico" class="form-control" required>
                      <option selected value="" disabled>Tecnicos...</option>
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo ='SI' ORDER BY tecnico asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                      <option class="text-primary" value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option class="text-primary" value="Lomas de Zamora">Lomas de Zamora</option>
                      <option class="text-primary" value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md-4">
                    <label for="exampleFormControlSelect1">Centro deposito</label>
                    <select type="text" name="centro" class="form-control" required>
                      <option selected disabled value="">Centro...</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Cantidad</label >
                    <input type="number" name="cantidad" class="form-control" placeholder="Ingrese una cantidad" autofocus value="1">
                  </div>
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Fecha</label >
                    <input type="text" id="fechaegre" name="fechaegre" readonly="" class="form-control" required>
                  </div>
                </div>
                <div class="form-row align-items-center">
                  <input type="submit" name="save_entregaindumentaria" class="btn btn-success btn-block" value="Guardar indumentaria">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
        $operacion = "Todos los depositos";
        if(isset($_POST['depo']))
        {
          $operacion = $_POST['operacion'];     
        }  
      ?>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="card card-body">
            <p class="h4 mb-4 text-center">Indumentaria <?php echo $operacion; ?></p>
            <form method="POST">
              <div class="form-row justify-content-center">                
                <div class="form-group col p-2">
                  <div class="form-row justify-content-center p-2">
                    <select name="operacion" id="operacion" requiered>
                      <option selected>Todos los depositos</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="San Nicolas">San Nicolas</option>
                      <option value="Total">Total</option>
                    </select>
                  </div>
                  <div class="form-row justify-content-center p-2">
                    <div class="form-group col-sm-12 col-md-4 p-2">                                   
                      <input type="submit" name="depo" id="depo" class="btn btn-success btn-block" value="Cargar">
                    </div>
                  </div>
                  <div class="form-row justify-content-center p-2">                                          
                    <a href="../Editar/edit_indumentaria.php"><i class="fas fa-pen p-2"></i></a>                   
                  </div>
                </div>                
              </div>
            </form>
            <?php 
              if(isset($_POST["depo"]))
              if (!strcmp("Todos los depositos", $operacion))
              {
                $query = "SELECT SUM(cantidad) as 'todo', indumentaria, sap, centro, talle FROM indumentaria GROUP BY indumentaria ";
            ?>
            <table class="table table-responsive table-striped table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Indumentaria</th>
                  <th>Talle</th>
                  <th>Cantidad</th>
                  <th>Centro</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(isset($_POST["depo"]))
                  if (!strcmp("Todos los depositos", $operacion))
                  { $query = "SELECT SUM(cantidad) as 'todo', indumentaria, centro, talle FROM indumentaria GROUP BY indumentaria, centro, talle";}
                  $result_tasks = mysqli_query($conn, $query);    
                  while($row = mysqli_fetch_assoc($result_tasks))
                  {
                ?>
                  <tr>
                    <td><?php echo $row['indumentaria']; ?></td> 
                    <td  align="center"><?php echo $row['talle']; ?></td>                   
                    <td  align="center"><?php echo $row['todo']; ?></td>    
                    <td  align="center"><?php echo $row['centro']; ?></td>       
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php }  else { ?>
              <table class="table table-responsive table-striped table-bordered table-sm">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Indumentaria</th> 
                    <th>Talle</th>              
                    <th>Cantidad</th>
                    <th>Minimo (2 extras)</th>
                    <th>Faltante</th>                       
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    switch ($operacion)
                    {
                      case 'Jose Leon Suarez': $tectectec=$ayuayunorte+2;
                      break;
                      case 'Lomas de Zamora': $tectectec=$ayuayusur + $ayuayucaba+2;
                      break;
                      case 'Total': $tectectec=$ayuayusur + $ayuayucaba + $ayuayunorte+4;
                      break;     
                    }
                  ?>
                  <?php
                    if(isset($_POST["depo"]))
                    if (!strcmp("Lomas de Zamora", $operacion))
                    {
                      $query = "SELECT SUM(cantidad) as 'todo', indumentaria, sap, centro, fecha, cantec, talle FROM indumentaria WHERE centro = 'Lomas de Zamora' GROUP BY indumentaria, talle ";
                    }
                    if (!strcmp("Jose Leon Suarez", $operacion))
                    {
                      $query = "SELECT SUM(cantidad) as 'todo', indumentaria, sap, centro, fecha, cantec, talle FROM indumentaria WHERE centro = 'Jose Leon Suarez' GROUP BY indumentaria, talle ";
                    }
                    if (!strcmp("San Nicolas", $operacion))
                    {
                      $query = "SELECT SUM(cantidad) as 'todo', indumentaria, sap, centro, fecha, cantec, talle FROM indumentaria WHERE centro = 'San Nicolas' GROUP BY indumentaria, talle ";
                    }
                    if (!strcmp("Total", $operacion))
                    {
                      $query = "SELECT SUM(cantidad) as 'todo', indumentaria, sap, centro, fecha, cantec, talle FROM indumentaria GROUP BY indumentaria, talle ";
                    }
                    $result_tasks = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result_tasks))
                    {
                  ?>
                    <tr>
                      <td><?php echo $row['indumentaria']; ?></td> 
                      <td align="center"><?php echo $row['talle']; ?></td>                    
                      <td align="center"><?php $tototo = $row['todo']; echo $tototo; ?></td>
                      <td align="center"><?php $tatata = $row['cantec']*$tectectec; echo $tatata; ?></td> 
                          <?php if($tototo >= $tatata) {$falta=0;}else{$falta=$tatata-$tototo;}; ?>
                      <td><?php echo $falta; ?></td>      
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>            
          </div>
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
    $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<!-- Calendario -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fechaegre").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fechaegre" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>

