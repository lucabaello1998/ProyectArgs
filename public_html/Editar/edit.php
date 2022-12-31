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
  $direccion= '';
  $zona= '';
  $calendario= '';
  $mac_ont= '';
  $sn_ont= '';
  $mac_uno_stb= '';
  $sn_uno_stb= '';
  $mac_dos_stb= '';
  $sn_dos_stb= '';
  $mac_tres_stb= '';
  $sn_tres_stb= '';
  $ap_uno_mac= '';
  $ap_uno_sn= '';
  $ap_dos_mac= '';
  $ap_dos_sn= '';
  $ap_tres_mac= '';
  $ap_tres_sn= '';

  if (isset($_GET['id']))
  {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM altas WHERE id = '$id' ");
    if (mysqli_num_rows($result) == 1)
    {
      $row = mysqli_fetch_array($result);
      $tecnico = $row['tecnico'];
      $ot = $row['ot'];
      $direccion = $row['direccion'];
      $zona = $row['zona'];
      $calendario = $row['calendario'];
      $mac_ont = $row['mac_ont'];
      $sn_ont = $row['sn_ont'];
      $mac_uno_stb = $row['mac_uno_stb'];
      $sn_uno_stb = $row['sn_uno_stb'];
      $mac_dos_stb = $row['mac_dos_stb'];
      $sn_dos_stb = $row['sn_dos_stb'];
      $mac_tres_stb = $row['mac_tres_stb'];
      $sn_tres_stb = $row['sn_tres_stb'];
      $ap_uno_mac = $row['ap_uno_mac'];
      $ap_uno_sn = $row['ap_uno_sn'];
      $ap_dos_mac = $row['ap_dos_mac'];
      $ap_dos_sn = $row['ap_dos_sn'];
      $ap_tres_mac = $row['ap_tres_mac'];
      $ap_tres_sn = $row['ap_tres_sn'];
    }
  }

  if(isset($_POST['update']))
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
      'Altas',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    
    $id = $_GET['id'];
    $tecnico= $_POST['tecnico'];
    $ot = $_POST['ot'];
    $direccion = $_POST['direccion'];
    $zona = $_POST['zona'];
    $calendario = $_POST['calendario'];
    $mac_ont = $_POST['mac_ont'];
    $sn_ont = $_POST['sn_ont'];
    $mac_uno_stb = $_POST['mac_uno_stb'];
    $sn_uno_stb = $_POST['sn_uno_stb'];
    $mac_dos_stb = $_POST['mac_dos_stb'];
    $sn_dos_stb = $_POST['sn_dos_stb'];
    $mac_tres_stb = $_POST['mac_tres_stb'];
    $sn_tres_stb = $_POST['sn_tres_stb'];
    $ap_uno_mac = $_POST['ap_uno_mac'];
    $ap_uno_sn = $_POST['ap_uno_sn'];
    $ap_dos_mac = $_POST['ap_dos_mac'];
    $ap_dos_sn = $_POST['ap_dos_sn'];
    $ap_tres_mac = $_POST['ap_tres_mac'];
    $ap_tres_sn = $_POST['ap_tres_sn'];

    $re = mysqli_query($conn, "UPDATE altas set tecnico = '$tecnico',
    ot = '$ot',
    direccion = '$direccion',
    zona = '$zona',
    calendario = '$calendario',
    mac_ont = '$mac_ont',
    sn_ont = '$sn_ont',
    mac_uno_stb = '$mac_uno_stb',
    sn_uno_stb = '$sn_uno_stb',
    mac_dos_stb = '$mac_dos_stb',
    sn_dos_stb = '$sn_dos_stb',
    mac_tres_stb = '$mac_tres_stb',
    sn_tres_stb = '$sn_tres_stb',
    ap_uno_mac = '$ap_uno_mac',
    ap_uno_sn = '$ap_uno_sn',
    ap_dos_mac = '$ap_dos_mac',
    ap_dos_sn = '$ap_dos_sn',
    ap_tres_mac = '$ap_tres_mac',
    ap_tres_sn = '$ap_tres_sn'
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
    header('Location: ../Basico/altas.php');
  }
?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar orden <?php echo $ot; ?></p>
              <div class="form-row">
                <div class="form-group col-md-4 col-6">
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
                <div class="form-group col-md-4 col-6">
                  <label>Numero de OT</label>
                  <input type="text" name="ot" maxlength="15" class="form-control" value="<?php echo $ot; ?>" placeholder="Actualice el numero de OT">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>Direccion</label>
                  <input type="text" name="direccion" maxlength="200" class="form-control" value="<?php echo $direccion; ?>" placeholder="Actualice la direccion">
                </div>
                <div class="form-group col-md-6 col-6">
                  <label class="text-center">Zona</label>
                  <select type="text" name="zona" class="form-control">
                    <option selected value="<?php echo $zona; ?>"><?php echo $zona; ?></option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
                <div class="form-group col-md-6 col-6">
                  <label>Fecha</label>
                  <input type="date" name="calendario" value="<?php echo $calendario; ?>" class="form-control">
                </div>
              </div>
              
              <div class="form-row border border-success p-1 mb-2">
                <div class="col-12 align-self-center">
                  <span class="text-center">ONT</span>
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="mac_ont" class="form-control" maxlength="50" value="<?php echo $mac_ont; ?>" placeholder="MAC ONT">
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="sn_ont" class="form-control" maxlength="50" value="<?php echo $sn_ont; ?>" placeholder="SN ONT">
                </div>
              </div>

              <div class="form-row border border-info p-1 mb-2">
                <div class="col-12 align-self-center">
                  <span class="text-center">STB 1</span>
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="mac_uno_stb" class="form-control" maxlength="50" value="<?php echo $mac_uno_stb; ?>" placeholder="MAC STB 1">
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="sn_uno_stb" class="form-control" maxlength="50" value="<?php echo $sn_uno_stb; ?>" placeholder="SN STB 1">
                </div>
              </div>
              <div class="form-row border border-info p-1 mb-2">
                <div class="col-12 align-self-center">
                  <span class="text-center">STB 2</span>
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="mac_dos_stb" class="form-control" maxlength="50" value="<?php echo $mac_dos_stb; ?>" placeholder="MAC STB 2">
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="sn_dos_stb" class="form-control" maxlength="50" value="<?php echo $sn_dos_stb; ?>" placeholder="MAC STB 2">
                </div>
              </div>
              <div class="form-row border border-info p-1 mb-2">
                <div class="col-12 align-self-center">
                  <span class="text-center">STB 3</span>
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="mac_tres_stb" class="form-control" maxlength="50" value="<?php echo $mac_tres_stb; ?>" placeholder="MAC STB 3">
                </div>
                <div class="form-group col-md-6 col-12 p-1 mb-0">
                  <input type="text" name="sn_tres_stb" class="form-control" maxlength="50" value="<?php echo $sn_tres_stb; ?>" placeholder="SN STB 3">
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

              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar orden">

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
</body>
</html>
