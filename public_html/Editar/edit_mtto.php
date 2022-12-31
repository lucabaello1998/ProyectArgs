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
if($usu != 1)
{
  header("location: ../index.php");
}

$tecnico = '';
$ot= '';
$direccion= '';
$zona= '';
$fecha= '';
$ont_mac= '';
$ont_sn= '';
$stb_mac_uno= '';
$stb_sn_uno= '';
$stb_mac_dos= '';
$stb_sn_dos= '';
$stb_mac_tres= '';
$stb_sn_tres= '';
$motivo= '';
$obs= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM mtto WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $direccion = $row['direccion'];
    $zona = $row['zona'];
    $fecha = $row['fecha'];
    $ont_mac = $row['ont_mac'];
    $ont_sn = $row['ont_sn'];
    $stb_mac_uno = $row['stb_mac_uno'];
    $stb_sn_uno = $row['stb_sn_uno'];
    $stb_mac_dos = $row['stb_mac_dos'];
    $stb_sn_dos = $row['stb_sn_dos'];
    $stb_mac_tres = $row['stb_mac_tres'];
    $stb_sn_tres = $row['stb_sn_tres'];
    $motivo = $row['motivo'];
    $obs = $row['obs'];
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
    'Mantenimiento',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $ot = $_POST['ot'];
  $direccion = $_POST['direccion'];
  $zona = $_POST['zona'];
  $fecha = $_POST['fecha'];
  $ont_mac = $_POST['ont_mac'];
  $ont_sn = $_POST['ont_sn'];
  $stb_mac_uno = $_POST['stb_mac_uno'];
  $stb_sn_uno = $_POST['stb_sn_uno'];
  $stb_mac_dos = $_POST['stb_mac_dos'];
  $stb_sn_dos = $_POST['stb_sn_dos'];
  $stb_mac_tres = $_POST['stb_mac_tres'];
  $stb_sn_tres = $_POST['stb_sn_tres'];
  $motivo = $_POST['motivo'];
  $obs = $_POST['obs'];

  $query = "UPDATE mtto set tecnico = '$tecnico', ot = '$ot', direccion = '$direccion', zona = '$zona', fecha = '$fecha', ont_mac = '$ont_mac', ont_sn = '$ont_sn', stb_mac_uno = '$stb_mac_uno', stb_sn_uno = '$stb_sn_uno', stb_mac_dos = '$stb_mac_dos', stb_sn_dos = '$stb_sn_dos', stb_mac_tres = '$stb_mac_tres', stb_sn_tres = '$stb_sn_tres', motivo = '$motivo', obs = '$obs' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El Mantenimiento de " .$tecnico ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/mtto.php');
}

?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_mtto.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar Mantenimiento</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">                
                    <option selected="0"><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo='SI' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="text" name="ot" class="form-control" value="<?php echo $ot; ?>" placeholder="Actualice el numero de OT" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" placeholder="Actualice la direccion" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Zona</label >
                  <select type="text" name="zona" class="form-control">
                  <option selected><?php echo $zona; ?></option>
                  <option value="CABA">CABA</option>
                  <option value="Lomas de Zamora">Lomas de Zamora</option>
                  <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                  <option value="San Nicolas">San Nicolas</option>
                </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>" readonly="" class="form-control">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC ONT</label >
                  <input type="text" name="ont_mac" class="form-control" value="<?php echo $ont_mac; ?>" placeholder="Actualice la MAC del modem" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN ONT</label >
                  <input type="text" name="ont_sn" class="form-control" value="<?php echo $ont_sn; ?>" placeholder="Actualice el numero de serie del modem" autofocus>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 1</label >
                  <input type="text" name="stb_mac_uno" class="form-control" value="<?php echo $stb_mac_uno; ?>" placeholder="Actualice la MAC del primer deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 1</label >
                  <input type="text" name="stb_sn_uno" class="form-control" value="<?php echo $stb_sn_uno; ?>" placeholder="Actualice el numero de serie del primer deco" autofocus>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 2</label >
                  <input type="text" name="stb_mac_dos" class="form-control" value="<?php echo $stb_mac_dos; ?>" placeholder="Actualice la MAC del segundo deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 2</label >
                  <input type="text" name="stb_sn_dos" class="form-control" value="<?php echo $stb_sn_dos; ?>" placeholder="Actualice el numero de serie del segundo deco" autofocus>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 3</label >
                  <input type="text" name="stb_mac_tres" class="form-control" value="<?php echo $stb_mac_tres; ?>" placeholder="Actualice la MAC del tercer deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 3</label >
                  <input type="text" name="stb_sn_tres" class="form-control" value="<?php echo $stb_sn_tres; ?>" placeholder="Actualice el numero de serie del tercer deco" autofocus>
                </div>
                <div class="form-row">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Motivo de cierre</label >
                    <textarea type="text" name="motivo" maxlength="120"  class="form-control" placeholder="Actualice el motivo" autofocus required><?php echo $motivo; ?></textarea>
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1">Observaciones</label >
                    <textarea type="text" name="obs" maxlength="255"  class="form-control" placeholder="actualice la observacion" autofocus required><?php echo $obs; ?></textarea>
                  </div>
                </div>
              </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar mantenimiento">
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
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<!-- fecha -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
