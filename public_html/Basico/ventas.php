<?php include("../db.php"); ?>
<!-----Supervisor---->
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
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}
?>
<!-----Supervisor---->
<?php include('../includes/header.php'); ?>

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


<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="../Guardar/save_ventas.php" method="POST" data-toggle="validator">
          <p class="h4 mb-4 text-center">Carga de visita</p>

          <div class="form-row">
            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Nombre</label >
              <input type="text" name="nombre" maxlength="70" class="form-control" autofocus required>
            </div> 

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Apellido</label >
              <input type="text" name="apellido" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">DNI</label >
              <input type="number" name="dni" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Contacto</label >
              <input type="number" name="contacto" maxlength="70" class="form-control" autofocus required>
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Direccion</label >
              <input type="text" name="direccion" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Entrecalle A</label >
              <input type="text" name="entrecallea" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Entrecalle B</label >
              <input type="text" name="entrecalleb" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Provincia</label >
              <input type="text" name="provincia" maxlength="70" class="form-control" autofocus required>
            </div>

            <div class="form-group col-sm">
              <label for="exampleFormControlSelect1">Localidad</label >
              <input type="text" name="localidad" maxlength="70" class="form-control" autofocus required>
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
              <input type="date" name="fecha" class="form-control" required>
            </div>     
            
            <div class="col">
              <legend class="col-form-label col">Turno</legend>
              <div class="col-sm">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="gridRadios1" value="AM">
                  <label class="form-check-label" for="gridRadios1">
                    AM
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="gridRadios2" value="PM">
                  <label class="form-check-label" for="gridRadios2">
                    PM
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group col">
              <label for="exampleFormControlSelect1">Instalacion</label >
              <select type="text" name="instalacion" class="form-control">
                <option selected>Tipo...</option>
                <option value="2P">2P</option>
                <option value="3P">3P</option>
                <option value="3P1D">3P1D</option>
                <option value="3P2D">3P2D</option>
                <option value="1D">1D</option>
                <option value="2D">2D</option>
                <option value="3D">3D</option>
              </select>
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Observaciones</label >
              <textarea type="text" maxlength="255" name="obs" class="form-control" autofocus></textarea>
            </div>
          </div>
          <input type="submit" name="save_ventas" class="btn btn-success btn-block" value="Guardar garantia">
        </form>
      </div>
    </div>
  </div>  
</div>
<br>


<div class="container-fluid">
<div class="container">
  <div class="row justify-content-center">
    <div class="col p-2 text-center">
        <p class="h4 mb-4 text-center">Clientes cargados</p>
        <table id="example" class="display table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
              <tr>
                <th class="col-auto">Acciones</th>
                <th class="col-auto">Cliente</th>
                <th class="col-auto">Nombre</th>
                <th class="col-auto">Apellido</th>
                <th class="col-auto">DNI</th>
                <th class="col-auto">Contacto</th>
                <th class="col-auto">Direccion</th>
                <th class="col-auto">Entrecalle A</th>
                <th class="col-auto">Entrecalle B</th>
                <th class="col-auto">Provincia</th>
                <th class="col-auto">Localidad</th>
                <th class="col-auto">Fecha</th>
                <th class="col-auto">Turno</th>
                <th class="col-auto">Instalacion</th>
                <th class="col-auto">Observaciones</th>
              </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT * FROM ventas ORDER BY id desc";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td>
                  <a href="../Editar/edit_ventas.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_ventas.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt p-2"></i>
                  </a>
                </td>              
                <td><?php echo $row['cliente']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['apellido']; ?></td>
                <td><?php echo $row['dni']; ?></td>
                <td><?php echo $row['contacto']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['entrecallea']; ?></td>
                <td><?php echo $row['entrecalleb']; ?></td>
                <td><?php echo $row['provincia']; ?></td>
                <td><?php echo $row['localidad']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['turno']; ?></td>
                <td><?php echo $row['instalacion']; ?></td>              
                <td><?php echo $row['obs']; ?></td> 
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "lengthMenu":     "Mostrar _MENU_ clientes por pagina...",
          "zeroRecords":    "No se encontro ningun cliente",
          "info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ clientes",
          "infoEmpty":      "No hay datos disponibles",
          "infoFiltered":   "(filtrado de _MAX_ clientes)",
          "loadingRecords": "Cargando...",
          "paginate":
          {
            "first":      "Primer",
            "previous":   "Anterior",
            "next":       "Siguiente",
            "last":       "Ultimo"
          }
        }
    } );
} );
</script>

</body>
</html>