<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>
<?php
$mes = date ('Y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = date ('Y-m', strtotime($mes1));
}
?>


<?php
switch ($mes)
{
case '2022-12': $nommes = "Diciembre";
break;
case '2022-11': $nommes = "Noviembre";
break;
case '2022-10': $nommes = "Octubre";
break;
case '2022-09': $nommes = "Septiembre";
break;
case '2022-08': $nommes = "Agosto";
break;
case '2022-07': $nommes = "Julio";
break;
case '2022-06': $nommes = "Junio";
break;
case '2022-05': $nommes = "Mayo";
break;
case '2022-04': $nommes = "Abril";
break;
case '2022-03': $nommes = "Marzo";
break;
case '2022-02': $nommes = "Febrero";
break;
case '2022-01': $nommes = "Enero";
break;
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
<style type="text/css">
  #fecha{ min-width: 100px; }
</style>

<br>
<div class="col-12 col-sm-12">
  <div class="form-row justify-content-center">
    <div class="col-5 col-sm-5">        
      <div class="row justify-content-end p-1 pr-3">
        <button type="button" href="../Basico/kmanalisis.php" class="btn btn-success" disabled>
          Analisis
        </button> 
      </div>     
    </div>      
     <div class="col-5 col-sm-5">        
      <div class="row justify-content-start p-1 pl-3">
         <button type="button" href="../../BaseDatos/dtkm.php" class="btn btn-primary" disabled>
          Total
        </button> 
      </div>       
    </div>
  </div>
</div>
<div class="container p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Kilometros por tecnico de <?php echo $nommes; ?></p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Relevador</th>
                <th id="fecha">Fecha</th>
                <th>Primer reporte</th>
                <th>Ultimo reporte</th>
                <th>Dia</th>
                <th>Partido</th>             
                <th>Kilometros</th>
                <th>Reportes</th>
                <th>Obs</th>
              </tr>
            </thead>
            <tbody align="center">

            <?php
            $query = "SELECT * FROM atckilometros WHERE fecha like '%$mes%' ORDER BY fecha desc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td>
                  <a href="../../ATC/Editar/edit_km.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../../ATC/Borrar/delete_km.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo Fecha7($row['fecha']); ?></td>
                <td><?php echo $row['hora']; ?></td>
                <td><?php echo $row['fin']; ?></td>
                <td><?php echo $row['dia']; ?></td>                
                <td><?php echo $row['partido']; ?></td>
                <td><?php echo $row['km']; ?></td>
                <td><?php echo $row['reportes']; ?></td>
                <td><?php echo $row['obs']; ?></td>              
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
        <form action="../Basico/km.php" method="POST">
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

</body>
</html>