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
if($tipo == "Visor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

$formatos = array('.pdf', '.PDF');

$patente = '';
$auto= '';
$color= '';
$vtv= '';
$seguro= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM vehiculos WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $patente = $row['patente'];
    $auto = $row['auto'];
    $color = $row['color'];
    $vtvviejo = $row['vtv'];
    $seguroviejo = $row['seguro'];
    $pdfviejo = $row['archivo'].".pdf";
    $vigenteold = $row['vigente']; 
  }
}

if (isset($_POST['update']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token,
    quien,
    movimiento,
    pag,
    inicio,
    tipo,
    zona) VALUES ('$token_movi',
    '$quien_notas',
    'Editado',
    'Vehiculos',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $patente= $_POST['patente'];
  $auto = $_POST['auto'];
  $color = $_POST['color'];
  $vtvnuevo = $_POST['vtvnuevo'];
  $seguronuevo = $_POST['seguronuevo'];

  if ($vtvnuevo > $vtvviejo)
  {
    $vtvvtv = $vtvnuevo;
    if($vtvnuevo > date('Y-m-d'))
    {
      $vigente = 'SI';
    }
    else
    {
      $vigente = 'NO';
    }
  }
  else
  {
    $vtvvtv = $vtvviejo;
    if($vtvviejo > date('Y-m-d'))
    {
      $vigente = 'SI';
    }
    else
    {
      $vigente = 'NO';
    }
  }

  if ($seguronuevo > $seguroviejo)
  {
  	
  	/////ACTUALIZAR ARCHIVO//////  	  
    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreTmpArchivo = $_FILES['archivo']['tmp_name'];
    $ext = substr($nombreArchivo, strrpos($nombreArchivo, '.'));
    $pdf = $_POST['patente'] ."-" .$_POST['auto'] ." " .$_POST['seguronuevo'];
    if (in_array($ext, $formatos)) ////buscame este elemento en esta lista
    {
      if ($_FILES['archivo']['size']<4000000)
      {
        if (move_uploaded_file($nombreTmpArchivo, "../Archivos/vehiculos/$pdf" .".pdf"))
        {	  	   	
          $pdfpdf = $pdf .".pdf"; //ultima modificacion   	    			  
          $msg = "Los datos del " .$patente ." fueron actualizados"; 
          $msgColor = "warning";      

          $query = "UPDATE vehiculos set patente = '$patente', auto = '$auto', color = '$color', seguro = '$seguronuevo', archivo = '$pdfpdf', vigenteseg = 'SI' WHERE id=$id";
          $result = mysqli_query($conn, $query);

          $pdf = $row['archivo'].".pdf";
          $filename = "../Archivos/vehiculos/$pdfviejo";
          if (file_exists($filename))
          {
            $success = unlink($filename);						
          }

          if(!$result) 
          {
            $msg ="Error en el servidor, recuerde subir el archivo actualizado.";
            $msgColor = "danger";
          }
        }
        else
        {
          $msg = "Error, intentamente nuevamente";
          $msgColor = "danger";
        }
      }
      else
      {
        $msg = "El archivo que intenta subir es muy pesado";
        $msgColor = "danger";
      }
    }
    else
    {
    $msg = "Falta el archivo PDF.";
    $msgColor = "danger";
    }	  
  	/////ACTUALIZAR ARCHIVO//////
  }
  else
  {  	
  	$msg = "Los datos del " .$patente ." fueron actualizados a excepcion del seguro";
	  $msgColor = "warning";  

    $query = "UPDATE vehiculos set patente = '$patente', auto = '$auto', color = '$color', vigente = '$vigente', vtv = '$vtvvtv', seguro = '$seguroviejo' WHERE id=$id";
    mysqli_query($conn, $query);
  }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msg;
  $_SESSION['message_type'] = $msgColor;
  header('Location: ../Basico/vehiculos.php');
}

?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_vehiculos.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
              <p class="h4 mb-4 text-center">Actualizar vehiculo</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Patente</label >
                  <input type="text" name="patente" class="form-control" value="<?php echo $patente; ?>" placeholder="Actualice la patente" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Auto</label >
                  <input type="text" name="auto" class="form-control" value="<?php echo $auto; ?>" placeholder="Actualice el modelo" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Color</label >
                  <input type="text" name="color" class="form-control" value="<?php echo $color; ?>" placeholder="Actualice el color" autofocus>
                </div>
                
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">VTV</label >
                  <input type="text" id="vtv" name="vtvnuevo" value="<?php echo $vtvviejo; ?>" readonly="" class="form-control">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Seguro</label >
                  <input type="text" id="seguro" name="seguronuevo" value="<?php echo $seguroviejo; ?>" readonly="" class="form-control">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <div class="form-row">
                    <label for="exampleFormControlFile1">Ultimo seguro cargado</label>
                  </div>
                  <div class="form-row">
                      <label><?php echo $seguroviejo; ?></label>
                  </div>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlFile1">Actualizar PDF</label>
                  <input type="file" accept="application/pdf" class="form-control-file" name="archivo" id="archivo">
                </div> 
              </div>         
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar vehiculo">

            </form>
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
<!-- Boautostrap -->
<script src="https://stackpath.boautostrapcdn.com/boautostrap/4.4.1/js/boautostrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<!-- vtv -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#vtv").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#vtv" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<!-- seguro -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#seguro").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#seguro" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
