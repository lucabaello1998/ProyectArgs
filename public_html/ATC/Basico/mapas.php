<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>
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
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
?>
<!-----Deposito---->

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
  <h4 class="modal-title" text-center>Cargar mapa</h4>
</div>
  <div class="col-12 col-sm-12">
    <div class="form-row justify-content-center">
      <div class="col-5 col-sm-5">        
        <div class="row justify-content-center p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lineal">
            Lineal
          </button> 
        </div>
      </div>
       <div class="col-5 col-sm-5">        
        <div class="row justify-content-center p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#gpon">
            Gpon
          </button> 
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal 1 -->
<div class="modal fade" id="lineal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga lineal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../ATC/Guardar/save_mapa.php" method="POST" enctype="multipart/form-data">
          <div class="form-row align-items-end">
            <div class="form-group col-6">
              <label for="mapas">Nombre</label>
              <input type="text" name="nombre" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un nombre" autofocus required>
            </div>        
            <div class="form-group col-6">
              <label for="exampleFormControlSelect1">Partido</label>
              <select type="text" name="partido" class="form-control">
                <option selected>Partido...</option>
                <option value="Campana">Campana</option>
                <option value="Escobar">Escobar</option>
                <option value="Hurlingham">Hurlingham</option>
                <option value="Ituzaingo">Ituzaingo</option>
                <option value="Jose C Paz">Jose C Paz</option>
                <option value="La Matanza">La Matanza</option>
                <option value="Malvinas Argentinas">Malvinas Argentinas</option>
                <option value="Merlo">Merlo</option>
                <option value="Moreno">Moreno</option>
                <option value="Moron">Moron</option>
                <option value="Pilar">Pilar</option>
                <option value="San Fernando">San Fernando</option>
                <option value="San Isidro">San Isidro</option>
                <option value="San Martin">San Martin</option>
                <option value="San Miguel">San Miguel</option>
                <option value="Tigre">Tigre</option>
                <option value="Tres de Febrero">Tres de Febrero</option>
                <option value="Vicente Lopez" >Vicente Lopez</option>
              </select>
            </div>            
          </div>
          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="mapas">Km (maximo 3 decimales)</label>
              <input type="number" name="km" maxlength="80" pattern="[0-9_-.]{1-6}" step="0.001" class="form-control" placeholder="Ingrese los kilometros" autofocus>
            </div>
            <div class="form-group col">
              <label for="mapas">Orden</label>
              <input type="number" name="orden" maxlength="80" pattern="[0-9_-.]{1-6}" class="form-control" placeholder="Ingrese el orden" autofocus>
            </div>
            <div class="form-group col">
              <div class="form-row justify-content-center">
                <input class="p-0" name="color" id="color" type="color" value="#FB2A2A">
              </div>
            </div>
          </div>
          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="mapas">Subir mapa (kml)</label>
              <input type="file" accept=".kml" class="form-control-file" name="archivo" id="archivo">
           </div>
          </div>
          <input type="submit" name="save_mapa_lineal"  class="btn btn-success btn-block" value="Guardar mapa">
        </form>
      </div>      
    </div>
  </div>
</div>

<!-- Modal 1 -->
<div class="modal fade" id="gpon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga gpon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../ATC/Guardar/save_mapa.php" method="POST" enctype="multipart/form-data">
          <div class="form-row align-items-end">
            <div class="form-group col-6">
              <label for="mapas">Nombre</label >
              <input type="text" name="nombre" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un nombre" autofocus required>
            </div>          
            <div class="form-group col-6">
              <label for="exampleFormControlSelect1">Localidad</label >
              <select type="text" name="localidad" class="form-control">
                <option selected>Localidad...</option>
                <option value="Caseros" class="alert-warning">Caseros</option>
                <option value="Ciudad Jardin" class="alert-warning">Ciudad Jardin</option>
                <option value="Ciudadela" class="alert-warning">Ciudadela</option>
                <option value="Jose Ingeniero" class="alert-warning">Jose Ingeniero</option>
                <option value="Martin Coronado" class="alert-warning">Martin Coronado</option>
                <option value="Saenz Peña" class="alert-warning">Saenz Peña</option>
                <option value="Santos Lugares" class="alert-warning">Santos Lugares</option>
                <option value="Villa Bosch" class="alert-warning">Villa Bosch</option>
                <option value="Villa Raffo" class="alert-warning">Villa Raffo</option>
                <option value="Castelar" class="alert-success">Castelar</option>
                <option value="El Palomar" class="alert-success">El Palomar</option>
                <option value="Haedo" class="alert-success">Haedo</option>
                <option value="Moron" class="alert-success">Moron</option>
                <option value="Villa Sarmiento" class="alert-success">Villa Sarmiento</option>                
                <option value="Benavidez" class="alert-danger">Benavidez</option>
                <option value="Garin" class="alert-danger">Garin</option>
                <option value="General pacheco" class="alert-danger">General pacheco</option>
                <option value="Ingeniero Maschwitz" class="alert-danger">Ingeniero Maschwitz</option>
                <option value="Don Torcuato" class="alert-danger">Don Torcuato</option>
                <option value="El Talar" class="alert-danger">El Talar</option>
                <option value="Ricardo Rojas" class="alert-danger">Ricardo Rojas</option>
                <option value="Toncos del Talar" class="alert-danger">Toncos del Talar</option>
                <option value="Hurlingham" class="alert-success">Hurlingham</option>
                <option value="Villa Tesei" class="alert-success">Villa Tesei</option>
                <option value="Williams Morris" class="alert-success">Williams Morris</option>
                <option value="San Fernando" class="alert-danger">San Fernando</option>
                <option value="TigreSF" class="alert-danger">TigreSF</option>
                <option value="Victoria" class="alert-danger">Victoria</option>
                <option value="Virreyes" class="alert-danger">Virreyes</option>
                <option value="Carapachay" class="alert-info">Carapachay</option>
                <option value="Florida" class="alert-info">Florida</option>
                <option value="Florida Oeste" class="alert-info">Florida Oeste</option>
                <option value="La Lucila" class="alert-info">La Lucila</option>
                <option value="Munro" class="alert-info">Munro</option>
                <option value="Olivos" class="alert-info">Olivos</option>
                <option value="Vicente Lopez" class="alert-info">Vicente Lopez</option>
                <option value="Villa Adelina" class="alert-info">Villa Adelina</option>
                <option value="Villa Martelli" class="alert-info">Villa Martelli</option>
                <option value="Escobar" class="alert-warning">Escobar</option>
                <option value="Billinghurst" class="alert-success">Billinghurst</option>
                <option value="Jose Leon Suarez" class="alert-success">Jose Leon Suarez</option>
                <option value="Lomas Hermosa" class="alert-success">Lomas Hermosa</option>
                <option value="San Andres" class="alert-success">San Andres</option>
                <option value="San Martin Centro" class="alert-success">San Martin Centro</option>
                <option value="Villa Ballester" class="alert-success">Villa Ballester</option>
                <option value="Villa Libertad" class="alert-success">Villa Libertad</option>
                <option value="Villa Lynch" class="alert-success">Villa Lynch</option>
                <option value="Villa Maipu" class="alert-success">Villa Maipu</option>            
              </select>
            </div>            
          </div>
          <div class="form-row align-items-end">
            <div class="form-group col-6">
              <label for="mapas">Km (maximo 3 decimales)</label >
              <input type="number" name="km" maxlength="80" pattern="[0-9_-.]{1-6}" step="0.001" class="form-control" placeholder="Ingrese los kilometros" autofocus>
            </div>
             <div class="form-group col">
              <label for="mapas">Orden</label >
              <input type="number" name="orden" maxlength="80" pattern="[0-9_-.]{1-6}" class="form-control" placeholder="Ingrese el orden" autofocus>
            </div>
            <div class="form-group col">
              <div class="form-row justify-content-center">
                <input class="p-0" name="color" id="color" type="color" value="#2A70FB">
              </div>
            </div>
          </div>

          <div class="form-row align-items-end">
            <div class="form-group col">
              <label for="mapas">Subir mapa (kml)</label>
              <input type="file" accept=".kml" class="form-control-file" name="archivo" id="archivo">
           </div>
          </div>
          <input type="submit" name="save_mapa_gpon"  class="btn btn-success btn-block" value="Guardar mapa">
        </form>
      </div>      
    </div>
  </div>
</div>

<br>

<style>
  #tablalineal{
  min-width: 900px;  
  overflow-x:auto; 
  }
  #tabla{
  min-width: 900px;  
  overflow-x:auto; 
  }
  #fecha{ min-width: 100px; }
</style>


<div class="container-fluid p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Mapas lineal</p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm"  id="tablalineal">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th> 
              <th id="fecha">Fecha</th>
              <th>Nombre</th>
              <th>Zona</th>
              <th>Partido</th>
              <th>Orden</th>
              <th>Estado</th>              
              <th>Kilometros</th>
              <th>Color</th>  
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM atcmapas WHERE tarea = 'Lineal' ORDER BY zona, orden asc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { 
          ?>
              <tr>
                <td>
                  <a href="../../ATC/Editar/edit_mapa.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                   <?php if ($row['enlace'] != "") {?>

                    <a download="<?php echo $row['nombre'] ." (" .$row['km'] ."km)" .".kml" ; ?>" href="../Archivos/mapas/<?php echo $row['enlace'] .".kml" ; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>

                    <?php } else { ?>

                    <a><i class="fas fa-file-download text-danger"></i></a>

                  <?php } ?>
                </td>        
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['nombre'] ; ?></td>
                <td><?php echo $row['zona'] ; ?></td>
                <td><?php echo $row['partido']; ?></td>
                <td><?php echo $row['orden']; ?></td>
                <td><?php echo $row['estado']; ?></td>             
                <td><?php echo $row['km']; ?></td>
                <td><div class="alert alert-primary" role="alert" style="background-color:<?php echo $row['color']; ?>;"></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<br>

<div class="container-fluid p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Mapas gpon</p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th> 
              <th id="fecha">Fecha</th>
              <th>Nombre</th>
              <th>Zona</th>
              <th>Partido</th>
              <th>Localidad</th>
              <th>Orden</th>
              <th>Estado</th>             
              <th>Kilometros</th>
              <th>Color</th>  
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM atcmapas WHERE tarea = 'Gpon' ORDER BY zona, orden, partido, nombre asc";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { 
              
              if ($row['estado'] == 'Pendiente')
              {
                $estado = 'class= "bg-warning" '; 
              }
              if ($row['estado'] == 'Completado')
              {
                $estado = 'class= "bg-success" '; 
              }
              if ($row['estado'] == 'En proceso')
              {
                $estado = 'class= "bg-info" '; 
              }
              
              ?>
              <tr <?php echo $estado; ?> >
                <td>
                  <a href="../../ATC/Editar/edit_mapa_gpon.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                   <?php if ($row['enlace'] != "") {?>

                    <a download="<?php echo $row['nombre'] ." (" .$row['km'] ."km)" .".kml" ; ?>" href="../Archivos/mapas/<?php echo $row['enlace'] .".kml" ; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>

                    <?php } else { ?>

                    <a><i class="fas fa-file-download text-danger"></i></a>

                  <?php } ?>
                </td>        
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['nombre'] ; ?></td>
                <td><?php echo $row['zona'] ; ?></td>
                <td><?php echo $row['partido']; ?></td>
                <td><?php echo $row['localidad']; ?></td>
                <td><?php echo $row['orden']; ?></td>
                <td><?php echo $row['estado']; ?></td>            
                <td><?php echo $row['km']; ?></td>
                <td><div class="alert alert-primary" role="alert" style="background-color:<?php echo $row['color']; ?>;"></td>
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