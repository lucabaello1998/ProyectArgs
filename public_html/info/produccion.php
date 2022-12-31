<?php
  include("../db.php"); 
  $mes = $_POST['mes'];
?>
<style type="text/css">
  #fecha{ min-width: 80px; }
</style>
<table id="produccion" class="table table-responsive table-striped table-bordered table-sm">
  <thead class="thead-dark text-center">
    <tr>
      <th>Acciones</th>
      <th>Tecnico</th>
      <th id="fecha">Fecha</th>
      <th>Dia</th>
      <th>Hora deposito</th>
      <th>Hora primera tarea</th>
      <th>2 play</th>
      <th>3 play</th>
      <th>STB</th>
      <th>Mud</th>
      <th>Tareas cumplidas</th>
      <th>Tareas mtto</th>
      <th>Bajas</th>            
      <th>Garantias del tecnico</th>
      <th>Garantias de un compañero</th>
      <th>Bajas tecnicas</th>
      <th>Bajas con desmonte</th>
      <th>Mtto Reacond</th>
      <th>Mtto Interno</th>
      <th>Mtto Externo</th>
      <th>Reclamos</th>           
      <th>Fin del dia</th>
      <th>Zona</th>
      <th>Observaciones</th>           
    </tr>
  </thead>
  <tbody align="center">
    <?php
      $result_tasks = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' ORDER BY id desc");
      while($row = mysqli_fetch_assoc($result_tasks))
      {
    ?>
      <tr>
        <td>
          <a href="../Editar/edit_produccion.php?id=<?php echo $row['id']?>">
            <i class="fas fa-pen p-2"></i>
          </a>
          <a href="../Borrar/delete_produccion.php?id=<?php echo $row['id']?>">
            <i class="far fa-trash-alt p-2"></i>
          </a>
        </td>
        <td><?php echo $row['tecnico']; ?></td>
        <td><?php echo Fecha8($row['fecha']); ?></td>
        <td><?php echo $row['dia']; ?></td>
        <td><?php echo $row['horadep']; ?></td>
        <td><?php echo $row['horatarea']; ?></td>
        <td><?php echo $row['dosplay']; ?></td>
        <td><?php echo $row['tresplay']; ?></td>
        <td><?php echo $row['stb']; ?></td>
        <td><?php echo $row['mudanza']; ?></td>
        <td><?php echo $row['tcumplida']; ?></td>
        <td><?php echo $row['tareasmtto']; ?></td>
        <td><?php echo $row['bajas']; ?></td>               
        <td><?php echo $row['garantec']; ?></td>                
        <td><?php echo $row['garancom']; ?></td>
        <td><?php echo $row['bajatec']; ?></td>
        <td><?php echo $row['baja_desmonte']; ?></td>
        <td><?php echo $row['mtto_reaco']; ?></td>
        <td><?php echo $row['mtto_int']; ?></td>
        <td><?php echo $row['mtto_ext']; ?></td>
        <td><?php echo $row['reclamo']; ?></td>              
        <td><?php echo $row['fin']; ?></td>
        <td><?php echo $row['zona']; ?></td>
        <td><?php echo $row['obs']; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table> 
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#produccion').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "scrollY":        "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "lengthMenu":     "Mostrar _MENU_ bajas por pagina...",
            "zeroRecords":    "No se encontro ninguna baja",
            "info":           "",
            "infoEmpty":      "No hay bajas disponibles",
            "infoFiltered":   "filtrado entre _MAX_ bajas",
            "loadingRecords": "Cargando...",
            },
            "ordering": false
        } );
    } );
  </script>