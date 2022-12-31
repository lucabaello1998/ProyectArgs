<?php
  include("../db.php");
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
  $tecnico = '';
  $ot= '';
  $id_actividad= '';
  $nim= '';
  $direccion= '';
  $localidad= '';
  $zona_tarea= '';
  $cliente= '';
  $telefono= '';
  $zona= '';
  $fecha= '';
  $ont_mac= '';
  $ont_sn= '';
  $stb_mac_uno= '';
  $stb_sn_uno= '';
  $stb_sn_dos= '';
  $stb_sn_dos= '';
  $stb_sn_tres= '';
  $stb_sn_tres= '';
  $ap_uno_mac= '';
  $ap_uno_sn= '';
  $ap_dos_mac= '';
  $ap_dos_sn= '';
  $ap_tres_mac= '';
  $ap_tres_sn= '';

  if (isset($_GET['id']))
  {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM mtto WHERE id = '$id' ");
    if (mysqli_num_rows($result) == 1)
    {
      $row = mysqli_fetch_array($result);
      $tecnico = $row['tecnico'];
      $ot = $row['ot'];
      $id_actividad = $row['id_actividad'];
      $nim = $row['nim'];
      $direccion = $row['direccion'];
      $localidad = $row['localidad'];
      $zona_tarea = $row['zona_tarea'];
      $cliente = $row['cliente'];
      $telefono = $row['telefono'];
      $zona = $row['zona'];
      $fecha = $row['fecha'];
      $motivo = $row['motivo'];
      $obs = $row['obs'];
      $ont_mac = $row['ont_mac'];
      $ont_sn = $row['ont_sn'];
      $stb_mac_uno = $row['stb_mac_uno'];
      $stb_sn_uno = $row['stb_sn_uno'];
      $stb_sn_dos = $row['stb_sn_dos'];
      $stb_sn_dos = $row['stb_sn_dos'];
      $stb_sn_tres = $row['stb_sn_tres'];
      $stb_sn_tres = $row['stb_sn_tres'];
      $ap_uno_mac = $row['ap_uno_mac'];
      $ap_uno_sn = $row['ap_uno_sn'];
      $ap_dos_mac = $row['ap_dos_mac'];
      $ap_dos_sn = $row['ap_dos_sn'];
      $ap_tres_mac = $row['ap_tres_mac'];
      $ap_tres_sn = $row['ap_tres_sn'];
      $completo = $row['completo'];
    }
  }

  if(isset($_GET['act']))
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
      'Mtto',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $id = $_GET['act'];
    $tecnico = $_POST['tecnico'];
    $ot = $_POST['ot'];
    $id_actividad = $_POST['id_actividad'];
    $nim = $_POST['nim'];
    $direccion = Reemplazo($_POST['direccion']);
    $localidad = $_POST['localidad'];
    $zona_tarea = $_POST['zona_tarea'];
    $cliente = Renombre($_POST['cliente']);
    $telefono = $_POST['telefono'];
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
    $ap_uno_mac = $_POST['ap_uno_mac'];
    $ap_uno_sn = $_POST['ap_uno_sn'];
    $ap_dos_mac = $_POST['ap_dos_mac'];
    $ap_dos_sn = $_POST['ap_dos_sn'];
    $ap_tres_mac = $_POST['ap_tres_mac'];
    $ap_tres_sn = $_POST['ap_tres_sn'];
    if(isset($_POST['actualizar']))
    {
      $estado = $_POST['completo'];
    }
    else if (isset($_POST['completar']))
    {
      $estado = 'SI';
    }
    $cuando_update = date("Y-m-j H:i:s");

    $re = mysqli_query($conn, "UPDATE mtto set tecnico = '$tecnico',
    ot = '$ot',
    quien = '$quien_notas',
    cuando = '$cuando_update',
    id_actividad = '$id_actividad',
    nim = '$nim',
    direccion = '$direccion',
    localidad = '$localidad',
    zona_tarea = '$zona_tarea',
    cliente = '$cliente',
    telefono = '$telefono',
    zona = '$zona',
    fecha = '$fecha',
    ont_mac = '$ont_mac',
    ont_sn = '$ont_sn',
    stb_mac_uno = '$stb_mac_uno',
    stb_sn_uno = '$stb_sn_uno',
    stb_mac_dos = '$stb_mac_dos',
    stb_sn_dos = '$stb_sn_dos',
    stb_mac_tres = '$stb_mac_tres',
    stb_sn_tres = '$stb_sn_tres',
    ap_uno_mac = '$ap_uno_mac',
    ap_uno_sn = '$ap_uno_sn',
    ap_dos_mac = '$ap_dos_mac',
    ap_dos_sn = '$ap_dos_sn',
    ap_tres_mac = '$ap_tres_mac',
    ap_tres_sn = '$ap_tres_sn',
    completo = '$estado'
    WHERE id = '$id'");

    if(!$re)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al actualizar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Actualizado";
      $msj_toast = "La orden " .$ot ." de " .$tecnico ." fue actualizada correctamente.";
      $color_toast = "warning";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
    header('Location: ../Basico/mtto2.php');
  }
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <form action="edit_mtto2.php?act=<?php echo $_GET['id']; ?>" method="POST">
            <p class="h4 mb-4 text-center">Actualizar orden <?php echo $ot; ?></p>
            <div class="form-row">
              <div class="form-group col-md-3 col-6">
                <label>Tecnico</label>
                <select type="text" name="tecnico" class="form-control">                
                  <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo ='Tecnico' AND activo = 'SI' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-3 col-6">
                <label>Numero de OT</label>
                <input type="text" name="ot" maxlength="15" class="form-control" value="<?php echo $ot; ?>" placeholder="Actualice el numero de OT">
              </div>
              <div class="form-group col-md-3 col-6">
                <label>ID de actividad</label>
                <input type="text" name="id_actividad" readonly class="form-control" value="<?php echo $id_actividad; ?>" placeholder="Actualice el ID de actividad">
              </div>
              <div class="form-group col-md-3 col-6">
                <label>NIM</label>
                <input type="text" name="nim" readonly class="form-control" value="<?php echo $nim; ?>" placeholder="Actualice el NIM">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 col-12">
                <label>Fecha</label>
                <input type="date" name="fecha" value="<?php echo $fecha; ?>" class="form-control">
              </div>
              <div class="form-group col-md-4 col-6">
                <label>Cliente</label>
                <input type="text" name="cliente" readonly class="form-control" value="<?php echo $cliente; ?>" placeholder="Actualice el cliente">
              </div>
              <div class="form-group col-md-4 col-6">
                <label>Telefono</label>
                <input type="text" name="telefono" readonly class="form-control" value="<?php echo $telefono; ?>" placeholder="Actualice el telefono">
              </div>
            </div>
            <div class="form-row">
              
              <div class="form-group col-md-3 col-12">
                <label>Direccion</label>
                <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" placeholder="Actualice la direccion">
              </div>
              <div class="form-group col-md-3 col-12">
                <label>Localidad</label>
                <input type="text" name="localidad" readonly class="form-control" value="<?php echo $localidad; ?>" placeholder="Actualice la localidad">
              </div>
              <div class="form-group col-md-3 col-12">
                <label>Zona</label>
                <input type="text" name="zona_tarea" readonly class="form-control" value="<?php echo $zona_tarea; ?>" placeholder="Actualice la zona">
              </div>
              <div class="form-group col-md-3 col-12">
                <label class="text-center">Deposito</label>
                <select type="text" name="zona" class="form-control">
                  <option selected value="<?php echo $zona; ?>"><?php echo $zona; ?></option>
                  <option value="CABA">CABA</option>
                  <option value="Lomas de Zamora">Lomas de Zamora</option>
                  <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                  <option value="San Nicolas">San Nicolas</option>
                </select>
              </div>
            </div>
            
            <div class="form-row border border-success p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">ONT</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ont_mac" class="form-control" maxlength="50" value="<?php echo $ont_mac; ?>" placeholder="MAC ONT">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ont_sn" class="form-control" maxlength="50" value="<?php echo $ont_sn; ?>" placeholder="SN ONT">
              </div>
            </div>

            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 1</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_mac_uno" class="form-control" maxlength="50" value="<?php echo $stb_mac_uno; ?>" placeholder="MAC STB 1">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_sn_uno" class="form-control" maxlength="50" value="<?php echo $stb_sn_uno; ?>" placeholder="SN STB 1">
              </div>
            </div>
            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 2</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_mac_dos" class="form-control" maxlength="50" value="<?php echo $stb_mac_dos; ?>" placeholder="MAC STB 2">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_sn_dos" class="form-control" maxlength="50" value="<?php echo $stb_sn_dos; ?>" placeholder="SN STB 2">
              </div>
            </div>
            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 3</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_mac_tres" class="form-control" maxlength="50" value="<?php echo $stb_mac_tres; ?>" placeholder="MAC STB 3">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="stb_sn_tres" class="form-control" maxlength="50" value="<?php echo $stb_sn_tres; ?>" placeholder="SN STB 3">
              </div>
            </div>
            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 1</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_uno_mac" maxlength="50" class="form-control" value="<?php echo $ap_uno_mac; ?>" placeholder="MAC AP 1">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_uno_sn" maxlength="50" class="form-control" value="<?php echo $ap_uno_sn; ?>" placeholder="SN AP 1">
              </div>
            </div>
            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 2</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_dos_mac" maxlength="50" class="form-control" value="<?php echo $ap_dos_mac; ?>" placeholder="MAC AP 2">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_dos_sn" maxlength="50" class="form-control" value="<?php echo $ap_dos_sn; ?>" placeholder="SN AP 2">
              </div>
            </div>
            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 3</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_tres_mac" maxlength="50" class="form-control" value="<?php echo $ap_tres_mac; ?>" placeholder="MAC AP 3">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_tres_sn" maxlength="50" class="form-control" value="<?php echo $ap_tres_sn; ?>" placeholder="SN AP 3">
              </div>
            </div>
            <input hidden type="text" name="completo" value="<?php echo $completo; ?>">
            <?php if($completo !== 'SI') { ?>
                <div class="col p-1">
                  <input type="submit" name="completar" class="btn btn-success btn-block" value="Completar orden">
                </div>
              <?php } ?>
            <div class="row p-2">
              <div class="col p-1">
                <input type="submit" name="actualizar" class="btn btn-warning btn-block" value="Actualizar orden">
              </div>              
            </div>
          </form>
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
