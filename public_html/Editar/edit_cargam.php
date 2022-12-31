<?php
include('../db.php');
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
<!-----Deposito---->
<?php include('../includes/header.php'); ?>
<!-- TABLA-->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimos ingresos</p>
          <table class="table table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Herramienta</th>              
                <th>Cantidad</th>
                <th>Zona</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM materiales  ORDER BY fecha desc";
              $result_tasks = mysqli_query($conn, $query);
              while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                <tr>
                  <td>
                    <a href="edit_cargam_individual.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_cargam.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['material']; ?></td>                
                  <td><?php echo $row['cantidad']; ?></td>             
                  <td><?php echo $row['centro']; ?></td>
                  <td><?php echo $row['fecha']; ?></td>              
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
</body>
</html>
