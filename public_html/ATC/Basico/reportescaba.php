<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>

<style>
$width: 900px;
table{ table-layout: fixed; }
#contenedor{
  overflow-x: auto;
  height: 1200px;
  width: $width;
}
#tabla{
  min-width: $width;  
  overflow-x:auto; 
}
#fecha{ min-width: 100px; }
#acronimo{ min-width: 145px; }
#direccion{ min-width: 250px; }
#calle{ min-width: 180px; }
#obs{ min-width: 400px; }
/*La propiedad overflow: auto la utilizo para que, en caso de ser necesario el scroll, este aparezca automáticamente. También podrías usar overflow-x para hacer referencia solamente al scroll horizontal o overflow-y para hacer referencia al scroll vertical.
Este es tu ejemplo modificado. Le he puesto un borde a cada una de las cabeceras de columnas (th) para que se pueda ver que todas tienen el mismo tamaño.
CSS
.size{width: 330px;}
<th><div class="size"> I.E.</div></th>*/
</style>
<div class="container p-2">
  <div class="row">
    <div class="col-lg">
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
  <div class="card card-body">

<form action="../../ATC/Guardar/save_asistenciaindividual.php" method="POST">
  <div class="form-row align-items-center">  
   <div class="form-group col">
      <label for="exampleFormControlSelect1">Tecnico</label >
       <select type="text" name="tecnico" class="form-control">                
          <option>Tecnicos...</option>                
          <?php include "../../db.php";
          $consulta="SELECT * FROM tecnicosatc WHERE operativo ='SI' ORDER BY nombre asc";
          $ejecutar=mysqli_query($conn,$consulta) or die (mysql_error($conn));
          ?>
          <?php foreach ($ejecutar as $opcioness): ?>   
            <option value="<?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?>"><?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?></option>                                      
          <?php endforeach ?>
        </select>
    </div>         
    <div class="form-group col">
      <label for="exampleFormControlSelect1">Fecha</label >
      <input type="text" id="fechaa" name="fechaa" readonly="" class="form-control">
    </div>
    <div class="form-group col">
        <label for="exampleFormControlSelect1">Inicio</label >
        <input type="text" class="form-control clockpicker" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horaa" required>
    </div>         
    <div class="form-group col">
      <label for="exampleFormControlSelect1" class="text-center">Dia</label >
      <select type="text" name="diaa" class="form-control">
      <option selected>Presente</option>
      <option>Ausente</option>  
      <option>Justificado</option>  
    </select>
    </div>
  </div>
  <input type="submit" name="save_asistenciaindividual" class="btn btn-success btn-block" value="Guardar reporte">
</form>
</div>
</div>
</div>
</div>








  <div class="row justify-content-center">    
      <p class="h4 mb-4 text-center">Reportes de camaras</p>
  </div>
  <div class="container-fluid" id="contenedor">    
        <table class="table table-striped  table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>
              <th id="fecha">Fecha</th>              
              <th id="acronimo">Acronimo</th>
              <th id="direccion">Direccion</th>
              <th id="calle">Calle y altura</th>
              <th>Rotulada</th>
              <th>Tipo</th> 
              <th>Conectados</th>           
              <th>Latitud</th>
              <th>Longitud</th>
              <th>Fleje faltante</th>
              <th>Trabas dañadas</th>
              <th>Splitter dañados</th>
              <th>Prioridad</th>
              <th id="obs">Observaciones</th>
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM caba ORDER BY fecha desc LIMIT 20";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td><?php echo $row['fecha']; ?></td>                
                <td><?php echo $row['acronimo']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['callealtura']; ?></td>
                <td><?php echo $row['rotulada']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo $row['cant_drop']; ?></td>
                <td><?php echo $row['latitud']; ?></td>
                <td><?php echo $row['longitud']; ?></td>
                <td><?php echo $row['fleje']; ?></td>
                <td><?php echo $row['trabas']; ?></td>
                <td><?php echo $row['splitter_conectores'];; ?></td>
                <td><?php echo $row['prioridad']; ?></td>
                <td><?php echo $row['obs']; ?></td>                            
              </tr>
            <?php } ?>
          </tbody>
        </table>
      
    
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