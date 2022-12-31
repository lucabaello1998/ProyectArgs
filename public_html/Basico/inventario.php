<?php include("../db.php"); ?>
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
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor/////
}
?>
<!-----Deposito---->
<?php include('../includes/header.php'); ?>


<!---- Este mes y el anterior---->
<?php $mes_anterior = "20" .date ('y-m', strtotime('-1 month'));?>
<?php $mes_dos = "20" .date ('y-m', strtotime('-2 month'));?>
<?php $mes = "20" .date ('y-m', strtotime('-0 month'));?>
<!---- Mes palabra---->

<?php
$tectec = $_POST['tectec'];
isset($_POST["atec"])
?>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">
      <!-- ADD TASK FORM -->
      <div class="card card-body">
        <form method="POST">
          <p class="h4 mb-4 text-center">Inventario de <?php echo $tectec ?></p>
          <div class="row">
            <div class="col">
          <select type="text" name="tectec" class="form-control">                
            <option selected="0">Tecnicos...</option>                
            <?php
            $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo ='SI' ORDER BY tecnico asc");
            ?>
            <?php foreach ($ejecutar as $opciones): ?>   
              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
            <?php endforeach ?>                          
            <?php
            $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo ='NO' ORDER BY tecnico asc");
            ?>
            <?php foreach ($ejecutar as $opciones): ?>   
            <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
            <?php endforeach ?>
          </select>  
          </div>
          <div class="col">          
          <input type="submit" name="atec" class="btn btn-success btn-block" value="Cargar tecnico">
          </div>
          </div>  
        </form>
      </div>
    </div>
  </div>
</main>


<!-- TABLA HERRAMIENTAS-->

<div class="container p-5">
  <div class="row">
    <div class="col-lg">
      <p class="h4 mb-4 text-center">Entrega de material de <?php echo $tectec ?></p>
      <div class="container">
        <table class="table  table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>             
              <th>Material</th>
              <th>Cantidad</th>              
              <th>Centro</th>
              <th>Ultima fecha</th>             
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT * FROM entregamaterial WHERE tecnico='$tectec' ORDER BY fechaegre asc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>      
                <td><?php echo $row['material']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>                
                <td><?php echo $row['centro']; ?></td>
                <td><?php echo Fecha7($row['fechaegre']); ?></td>                            
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<br>

<!-- TABLA HERRAMIENTAS-->

<div class="container p-5">
  <div class="row">
    <div class="col-lg">
      <p class="h4 mb-4 text-center">Entrega de indumentaria de <?php echo $tectec ?></p>
      <div class="container">
        <table class="table table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>             
              <th>Indumentaria</th>
              <th>Talle</th>
              <th>Cantidad</th>              
              <th>Centro</th>
              <th>Ultima fecha</th>             
            </tr>
          </thead>
          <tbody align="center">
            <?php
            $query = "SELECT SUM(cantidad) as 'canindu', indumentaria, talle, centro, fechaegre FROM entregaindumentaria WHERE tecnico='$tectec' GROUP BY indumentaria, talle, fechaegre ORDER BY fechaegre desc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>      
                <td><?php echo $row['indumentaria']; ?></td>
                <td><?php echo $row['talle']; ?></td>
                <td><?php echo $row['canindu']; ?></td>                
                <td><?php echo $row['centro']; ?></td>
                <td><?php echo Fecha7($row['fechaegre']); ?></td>                            
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