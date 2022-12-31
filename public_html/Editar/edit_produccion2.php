<?php include("../db.php");
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
  header("location: ../index.php");   /////Visor - Deposito - Supervisor/////
}

$id_actividad= '';
$ot= '';
$direccion= '';
$localidad= '';
$zona= '';
$intervalo= '';
$actividad= '';
$codigo= '';
$cantidad_tv= '';
$estado= '';
$razon_completada= '';
$razon_no_completada= '';
$nota_cierre= '';
$inicio= '';
$fin= '';
$duracion= '';
$cliente= '';
$telefono= '';
$nim= '';
$motivo_asignacion= '';
$revisita= '';
$obs= '';
$dos_play= '';
$tres_play= '';
$stb= '';
$mudanza_interna= '';
$baja= '';
$garantia= '';
$baja_tecnica= '';
$baja_desmonte= '';
$mtto= '';
$mtto_externo= '';
$dia= '';


if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM carga_dia WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];    
    $id_actividad = $row['id_actividad'];
    $ot = $row['ot'];  
    $direccion = $row['direccion'];
    $localidad = $row['localidad'];
    $zona = $row['zona'];
    $fecha = $row['fecha'];
    $intervalo = $row['intervalo']; 
    $actividad = $row['actividad']; 
    $codigo = $row['codigo'];   
    $cantidad_tv = $row['cantidad_tv'];
    $estado = $row['estado'];
    $razon_completada = $row['razon_completada']; 
    $razon_no_completada = $row['razon_no_completada'];   
    $nota_cierre = $row['nota_cierre'];
    $inicio = $row['inicio'];
    $fin = $row['fin'];
    $duracion = $row['duracion'];
    $cliente = $row['cliente'];
    $telefono = $row['telefono'];
    $nim = $row['nim']; 
    $motivo_asignacion = $row['motivo_asignacion'];   
    $revisita = $row['revisita'];
    $obs = $row['obs'];
    $dos_play = $row['dos_play'];
    $tres_play = $row['tres_play'];
    $stb = $row['stb'];
    $mudanza_interna = $row['mudanza_interna'];
    $baja = $row['baja'];
    $garantia = $row['garantia'];
    $baja_tecnica = $row['baja_tecnica'];   
    $baja_desmonte = $row['baja_desmonte'];
    $mtto = $row['mtto'];
    $mtto_externo = $row['mtto_externo'];
    $dia = $row['dia'];


  }
}

if (isset($_POST['update']))
{
  $id = $_GET['id']; 
  $id_actividad = $_POST['id_actividad'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $localidad = $_POST['localidad'];
  $zona = $_POST['zona'];
  $intervalo = $_POST['intervalo'];  
  $codigo = $_POST['codigo'];
  $cantidad_tv = $_POST['cantidad_tv'];
  $estado = $_POST['estado'];  
  $razon_completada = $_POST['razon_completada']; 
  $razon_no_completada = $_POST['razon_no_completada'];
  $nota_cierre = $_POST['nota_cierre'];
  $inicio = $_POST['inicio'];
  $fin = $_POST['fin'];
  $duracion = $_POST['duracion'];
  $cliente = $_POST['cliente'];
  $telefono = $_POST['telefono'];
  $nim = $_POST['nim'];
  $motivo_asignacion = $_POST['motivo_asignacion'];
  $revisita = $_POST['revisita'];
  $obs = $_POST['obs'];
  $dos_play = $_POST['dos_play'];
  $tres_play = $_POST['tres_play'];  
  $stb = $_POST['stb'];
  $mudanza_interna = $_POST['mudanza_interna'];
  $baja = $_POST['baja'];  
  $garantia = $_POST['garantia'];
  $baja_tecnica = $_POST['baja_tecnica'];
  $baja_desmonte = $_POST['baja_desmonte'];
  $mtto = $_POST['mtto'];
  $mtto_externo = $_POST['mtto_externo'];
  $dia = $_POST['dia'];

  

  $update = "UPDATE carga_dia set 
  id_actividad = '$id_actividad', 
  ot = '$ot', 
  direccion = '$direccion', 
  localidad = '$localidad', 
  zona = '$zona',
  intervalo = '$intervalo', 
  actividad = '$actividad', 
  codigo = '$codigo', 
  cantidad_tv = '$cantidad_tv', 
  estado = '$estado', 
  razon_completada = '$razon_completada', 
  razon_no_completada = '$razon_no_completada', 
  nota_cierre = '$nota_cierre', 
  inicio = '$inicio', 
  fin = '$fin', 
  duracion = '$duracion',
  cliente = '$cliente', 
  telefono = '$telefono', 
  nim = '$nim', 
  motivo_asignacion = '$motivo_asignacion', 
  revisita = '$revisita', 
  obs = '$obs', 
  dos_play = '$dos_play', 
  tres_play = '$tres_play', 
  stb = '$stb', 
  mudanza_interna = '$mudanza_interna', 
  baja = '$baja', 
  garantia = '$garantia',
  baja_tecnica = '$baja_tecnica', 
  baja_desmonte = '$baja_desmonte', 
  mtto = '$mtto', 
  mtto_externo = '$mtto_externo',
  dia = '$dia'
  WHERE id = '$id'";
  mysqli_query($conn, $update);
  if(!$update)
  {
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La tarea no fue actualizada";
  $_SESSION['message_type'] = 'danger';
  header('Location: ../Basico/produccion2.php');
  }
  else
  {
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "La tarea de " .$tecnico ." fue actualizada";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/produccion2.php');
  }
  

}

?>

<?php include('../includes/header.php'); ?>

<?php
$separar_fecha = explode("-", $fecha);
$dia_separado = $separar_fecha[2];
$mess = $separar_fecha[1];

switch ($mess){
  case '12': $mmm = "diciembre";
  break;
  case '11': $mmm = "noviembre";
  break;
  case '10': $mmm = "octubre";
  break;
  case '09': $mmm = "septiembre";
  break;
  case '08': $mmm = "agosto";
  break;
  case '07': $mmm = "julio";
  break;
  case '06': $mmm = "junio";
  break;
  case '05': $mmm = "mayo";
  break;
  case '04': $mmm = "abril";
  break;
  case '03': $mmm = "marzo";
  break;
  case '02': $mmm = "febrero";
  break;
  case '01': $mmm = "enero";
  break;
  }


?>

<div class="container-fluid p-1">
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="card card-body">
        <form action="edit_produccion2.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <p class="h4 mb-4 text-center">Carga de <?php echo $tecnico .' del dia ' .$dia_separado .' de ' .$mmm; ?></p>

          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">ID actividad</label >
              <input type="number" name="id_actividad" class="form-control" value="<?php echo $id_actividad; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">OT</label >
              <input type="number" name="ot" class="form-control" value="<?php echo $ot; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Nim</label >
              <input type="number" name="nim" class="form-control" value="<?php echo $nim; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Direccion</label >
              <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Localidad</label >
              <input type="text" name="localidad" class="form-control" value="<?php echo $localidad; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Zona</label >
              <input type="text" name="zona" class="form-control" value="<?php echo $zona; ?>" readonly>
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Intervalo</label >
              <input type="text" name="intervalo" class="form-control" value="<?php echo $intervalo; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Tipo de actividad</label >
              <input type="text" name="actividad" class="form-control" value="<?php echo $actividad; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Codigo</label >
              <input type="text" name="codigo" class="form-control" value="<?php echo$codigo; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">TV</label >
              <input type="number" name="cantidad_tv" class="form-control" value="<?php echo$cantidad_tv; ?>" readonly>
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Estado</label >
              <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>" readonly>
            </div>           
            <div class="form-group col">
                <label for="exampleFormControlSelect1" class="text-center">Realizada</label >
                <input type="text" name="razon_completada" class="form-control" value="<?php echo $razon_completada; ?>" readonly>
            </div>
            <div class="form-group col">
                <label for="exampleFormControlSelect1" class="text-center">No realizada</label >
                <input type="text" name="razon_no_completada" class="form-control" value="<?php echo $razon_no_completada; ?>" readonly>
            </div>
            <div class="form-group col">
                <label for="exampleFormControlSelect1" class="text-center">Revisita</label >
                <input type="text" name="revisita" class="form-control" value="<?php echo $revisita; ?>" readonly>
            </div>
            <div class="form-group col">
                <label for="exampleFormControlSelect1" class="text-center">Motivo de asignacion</label >
                <input type="text" name="motivo_asignacion" class="form-control" value="<?php echo $motivo_asignacion; ?>" readonly>
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Notas</label >
              <textarea type="text" name="nota_cierre" readonly class="form-control"><?php echo $nota_cierre; ?></textarea> 
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Inicio</label >
              <input type="text" name="inicio" class="form-control" value="<?php echo $inicio; ?>" readonly>
            </div>           
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Fin</label >
              <input type="text" name="fin" class="form-control" value="<?php echo $fin; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Duracion</label >
              <input type="text" name="duracion" class="form-control" value="<?php echo $duracion; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Cliente</label >
              <input type="text" name="cliente" class="form-control" value="<?php echo $cliente; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Telefono</label >
              <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>" readonly>
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Dia</label >
              <select type="text" name="dia" class="form-control">
                <option selected><?php echo $dia; ?></option>
                <option value="Normal">Normal</option> 
                <option value="Ausente">Ausente</option>
                <option value="Medio dia">Medio dia</option>             
                <option value="Sabado">Sabado</option>
                <option value="Feriado">Feriado</option>
                <option value="Vacaciones">Vacaciones</option>           
              </select>
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">2P</label >
              <input type="number" name="dos_play" class="form-control" value="<?php echo $dos_play; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">3P</label >
              <input type="number" name="tres_play" class="form-control" value="<?php echo $tres_play; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Add</label >
              <input type="number" name="stb" class="form-control" value="<?php echo $stb; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Mudanza interna</label >
              <input type="number" name="mudanza_interna" class="form-control" value="<?php echo $mudanza_interna; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Baja</label >
              <input type="number" name="baja" class="form-control" value="<?php echo $baja; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Garantia</label >
              <input type="number" name="garantia" class="form-control" value="<?php echo $garantia; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Baja tecnica</label >
              <input type="number" name="baja_tecnica" class="form-control" value="<?php echo $baja_tecnica; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Baja con desmonte</label >
              <input type="number" name="baja_desmonte" class="form-control" value="<?php echo $baja_desmonte; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Mtto</label >
              <input type="number" name="mtto" class="form-control" value="<?php echo $mtto; ?>" >
            </div>
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Mtto_externo</label >
              <input type="number" name="mtto_externo" class="form-control" value="<?php echo $mtto_externo; ?>" >
            </div>
          </div>
          <div class="row align-items-end">
            <div class="form-group col">
              <label for="exampleFormControlSelect1" class="text-center">Observaciones</label >
              <textarea type="text" name="obs" class="form-control"><?php echo $obs; ?></textarea> 
            </div>
          </div>
          
          <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar tarea">
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
