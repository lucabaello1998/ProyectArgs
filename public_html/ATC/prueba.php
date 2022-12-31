<?php include("../db.php"); ?>
<?php include('includesatc/headeratc.php'); ?>
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
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
?>

<h4>Prueba 2 filtros</h4>


<label for="clima">Seleccione el tipo de clima de hoy: </label>
<select id="clima">
  <option value="">--Haga una elección--</option>
  <option value="soleado">Soleado</option>
  <option value="lluvioso">Lluvioso</option>
  <option value="nevando">Nevando</option>
  <option value="nublado">Nublado</option>
</select>

<p></p>


<script type="text/javascript">
  let seleccionar = document.querySelector('select');
let parrafo = document.querySelector('p');

seleccionar.addEventListener('change', establecerClima);

function establecerClima() {
  let eleccion = seleccionar.value;

  if (eleccion === 'soleado') {
    parrafo.textContent = 'El día esta agradable y soleado hoy. ¡Use pantalones cortos! Ve a la playa o al parque y come un helado.';
  } else if (eleccion === 'lluvioso') {
    parrafo.textContent = 'Está lloviendo, tome un abrigo para lluvia y un paraguas, y no se quede por fuera mucho tiempo.';
  } else if (eleccion === 'nevando') {
    parrafo.textContent = 'Está nevando ─ ¡está congelando! Lo mejor es quedarse en casa con una taza caliente de chocolate, o hacer un muñeco de nieve.';
  } else if (eleccion === 'nublado') {
    var primerId = document.querySelector('#inforadio');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
 primerId.innerHTML = <?php echo "'" ."casa" ."'" ; ?> ;
  } else {
    parrafo.textContent = '';
  }
}
</script>



<br>



<br>
<label>-------------------------------------------------------------------</label>
<br>
<form id="radios">
  <label>Gpon</label>
  <input type="radio" id="gpon" name="reporte" value="gpon">
  <label>Lineal</label>
  <input type="radio" id="lineal" name="reporte" value="lineal">
</form>

<script type="text/javascript">
  const data = document.getElementById('radios');

data.addEventListener('click', () => {
  let form = new FormData(data);
  
  if(form.getAll('reporte')[0] === 'gpon'){
    var primerId = document.querySelector('#relevador');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
    primerId.innerHTML =  '<select type="text" name="relevador" class="form-control">'+
                            '<option>Relevador...</option>'+
                            <?php include "../../db.php";
                            $consulta="SELECT * FROM tecnicosatc WHERE operativo = 'SI' AND tarea like '%ATC Gpon%' ORDER BY nombre asc";
                            $ejecutar=mysqli_query($conn,$consulta) or die (mysql_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opcioness): ?>
                            '<option value="<?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?>"><?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?></option>'+
                            <?php endforeach ?>  
                          '</select>' ;
  }
  if(form.getAll('reporte')[0] === 'lineal'){
    var primerId = document.querySelector('#relevador');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
    primerId.innerHTML = '<select type="text" name="relevador" class="form-control">'+
                            '<option>Relevador...</option>'+
                            <?php include "../../db.php";
                            $consulta="SELECT * FROM tecnicosatc WHERE operativo = 'SI' AND tarea = 'Relevamiento lineal' ORDER BY nombre asc";
                            $ejecutar=mysqli_query($conn,$consulta) or die (mysql_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opcioness): ?>
                            '<option value="<?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?>"><?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?></option>'+
                            <?php endforeach ?>  
                          '</select>' ; ;
  }
});
</script>
<label class="p-3" id="relevador">Informacion</label>
<br>
<label>*****************************************************************</label>
<form action="../../ATC/prueba.php" method="POST">
  <p class="h4 mb-4 text-center">Reportes</p>
  <div class="form-row">
    <div class="form-group col">
      <label>Rango de fecha</label >
      <div class="input-group">
        <input type="date" name="fecha_uno" class="input-sm form-control">
          <span class="input-group-addon">-</span>
        <input type="date" name="fecha_dos" class="input-sm form-control">
      </div>
      <br>
      <div class="form-row">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="reporte" id="reporte1" value="gpon" checked>
          <label class="form-check-label">
            Gpon
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="reporte" id="reporte2" value="lineal">
          <label class="form-check-label">
            Lineal
          </label>
        </div>
      </div>
    </div>
  </div> 
  <input type="submit" name="save_fechas" class="btn btn-success btn-block" value="Cargar reportes">
</form>

<?php 
if(isset($_POST['save_fechas']))
{
  $fecha_uno = $_POST['fecha_uno'];
  $fecha_dos = $_POST['fecha_dos'];
  $reporte = $_POST['reporte'];

}

echo $fecha_uno ." hasta la fecha " .$fecha_dos ."<br>";
echo $reporte;
?>
<br>
<div class="container p-2">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Kilometros por tecnico</p>
      <div class="container-fluid">
        <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Relevador</th>
                <th>Fecha</th>
                <th>Primer reporte</th>
                <th>Ultimo reporte</th>
                <th>Dia</th>
                <th>Partido</th>             
                <th>Kilometros</th>
                <th>Obs</th>
              </tr>
            </thead>
            <tbody align="center">

            <?php
            $query = "SELECT * FROM atckilometros WHERE fecha BETWEEN '$fecha_uno' AND '$fecha_dos' ";
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
                <td><?php echo $row['fecha']; ?></td>
                <td><?php echo $row['hora']; ?></td>
                <td><?php echo $row['fin']; ?></td>
                <td><?php echo $row['dia']; ?></td>                
                <td><?php echo $row['partido']; ?></td>
                <td><?php echo $row['km']; ?></td>
                <td><?php echo $row['obs']; ?></td>              
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