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
$zona_us = $_SESSION['zona'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$contratista = '';
$tecnico = '';
$ot = '';
$sn = '';
$deposito = '';
$fecha = '';
$obs = '';
$sap = '';
$material = '';
$cantidad = '';
$tipo_mat = '';
$pallet = '';
$num_caja = '';

if(isset($_GET['token']))
{
  $token = $_GET['token'];
  $result = mysqli_query($conn, "SELECT * FROM devolucion WHERE token = '$token'");
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $sn = $row['sn'];
    $deposito = $row['deposito'];
    $fecha = $row['fecha'];
    $obs = $row['obs'];
    $sap_old = $row['sap'];
    $material_old = $row['material'];
    $cantidad = $row['cantidad'];
    $tipo_mat = $row['tipo'];
    $pallet = $row['pallet'];
    $num_caja = $row['num_caja'];
  }
}

if (isset($_POST['updateb']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us_us = $_SESSION['tipo_us'];
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
    'Devolucion individual',
    '$hoy_movi',
    '$tipo_us_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $token = $_GET['token'];
  $tecnico = $_POST['tecnico'];
  $ot = $_POST['ot'];
  $sn = $_POST['sn'];
  $deposito = $_POST['deposito'];
  $fecha = $_POST['fecha'];
  $obs = $_POST['obs'];
  $sap = $_POST['sap'];
  $material = $_POST['material'];
  $cantidad = $_POST['cantidad'];
  $tipo_mat = $_POST['tipo'];
  $pallet = $_POST['pallet'];
  $num_caja = $_POST['num_caja'];

  $r = mysqli_query($conn, "UPDATE devolucion set tecnico = '$tecnico', ot = '$ot', sn = '$sn', deposito = '$deposito', fecha = '$fecha', obs = '$obs', sap = '$sap', material = '$material', cantidad = '$cantidad', tipo = '$tipo_mat', pallet = '$pallet', num_caja = '$num_caja' WHERE token = '$token'");
  if(!$r)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al actualizar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Actualizado";
    $msj_toast = "El item fue actualizado";
    $color_toast = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/devolucion.php');
}
?>
<?php include('../includes/header.php'); ?>
<style>
  .sugerido_sap
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 2.9rem !important;
      width: 100% !important;
    }

  .sugerido_sap .suggest-sap
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_sap .suggest-sap:hover
    {
      background-color: #bfe9c5;
    }
    
    .sugerido_mat
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 6.3rem ;
      width: 100% ;
    }

  .sugerido_mat .suggest-mat
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_mat .suggest-mat:hover
    {
      background-color: #bfe9c5;
    } 
</style>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_devolucion_unit.php?token=<?php echo $_GET['token']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Devolucion</p>
              <div class="form-row">
                <div class="form-group col-md-3 col-12">
                  <label>Tecnico</label >
                  <select type="text" name="tecnico" class="form-control" required>
                    <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach;
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label>OT</label >
                  <input type="number" name="ot" class="form-control" value="<?php echo $ot; ?>">
                </div>

                <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
                  <div class="form-group col-md-3 col-12">
                    <label>Deposito</label >
                    <select type="text" name="deposito" class="form-control" required>
                      <option selected value="<?php echo $deposito; ?>"><?php echo $deposito; ?></option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                <?php } else { ?>
                  <input hidden type="text" name="deposito" value="<?php echo $zona_us; ?>">
                <?php } ?>

                <div class="form-group col-md-3 col-12">
                  <label>Fecha</label >
                  <input type="date" name="fecha" class="form-control" value="<?php echo $fecha; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6 col-12">
                  <label>Pallet</label >
                  <input type="number" name="pallet" min="1" value="<?php echo $pallet; ?>" class="form-control" required>
                </div>
                <div class="form-group col-md-6 col-12">
                  <label>Num caja</label >
                  <input type="number" name="num_caja" min="1" value="<?php echo $num_caja; ?>" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3 col-12">
                  <label>Tipo</label >
                  <select type="text" name="tipo" class="form-control" required>
                    <option selected value="<?php echo $tipo_mat; ?>"><?php echo $tipo_mat; ?></option>
                    <option value="Material sin uso">Material sin uso</option>
                    <option value="Desinstalacion o desmonte">Desinstalacion o desmonte</option>
                    <option value="Material reparado">Material reparado</option>
                  </select>
                </div>
                <div class="form-group col-md-3 col-12">
                  <div class="row p-2">
                    <input class="form-control selec_sap" type="text" name="sap" placeholder="SAP" value="<?php echo $sap_old; ?>">
                    <div class="sugerido_sap"></div>
                  </div>
                  <div class="row p-2">
                    <input class="form-control selec_mat" type="text" name="material" placeholder="Material" value="<?php echo $material_old; ?>">
                    <div class="sugerido_mat"></div>
                  </div>
                </div>
                <div class="form-group col-md-3 col-12">
                  <label>Num serie</label >
                  <input type="text" name="sn" class="form-control" value="<?php echo $sn; ?>">
                </div>
                <div class="form-group col-md-3 col-12">
                  <label>Cantidad</label>
                  <input type="number" min="1" name="cantidad" class="form-control" value="1" value="<?php echo $cantidad; ?>">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-12">
                  <label>Observaciones</label >
                  <textarea type="text" name="obs" class="form-control"><?php echo $obs; ?></textarea>
                </div>
              </div>
              <input type="submit" name="updateb" class="btn btn-success btn-block" value="Actualizar item">
            </form>
          </div>
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
  <script>
    $(document).ready(function()
    {
      $('.selec_sap').on('keyup', function()
      {
        var sap = $(this).val();
        var dato = $(this);
        var dataSAP = 'sap='+sap;
        if(sap == "")
        {
          $(".selec_mat").removeAttr("readonly");
          $('.sugerido_sap').fadeOut(500);
        }
        else
        {
          $(".selec_mat").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataSAP,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_sap').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-sap').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_mat').val($('#'+id).attr('mate'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_sap').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_mat').on('keyup', function()
      {
        var mat = $(this).val();
        var dato = $(this);
        var dataMAT = 'mat='+mat;
        if(mat == "")
        {
          $(".selec_sap").removeAttr("readonly");
          $('.sugerido_mat').fadeOut(500);
        }
        else
        {
          $(".selec_sap").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataMAT,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_mat').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-mat').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_sap').val($('#'+id).attr('sapi'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_mat').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
</body>
</html>
