<?php
include("../db.php");
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
$dni= '';
$id_recurso= '';
$chomba= '';
$pantalon= '';
$zapato= '';
$ingreso= '';
$flota= '';
$modelo= '';
$sn= '';
$tel= '';
$mail= '';
$patente= '';
$tusu= '';
$tcon= '';
$sgtusu= '';
$sgtcon= '';
$activo= '';
$tipot= '';
$zona= '';
$deposito= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM tecnicos WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $dni = $row['dni'];
    $id_recurso = $row['id_recurso'];
    $chomba = $row['chomba'];
    $pantalon = $row['pantalon'];
    $zapato = $row['zapato'];
    $ingreso = $row['ingreso'];
    $flota = $row['flota'];
    $modelo = $row['modelo'];
    $sn = $row['sn'];
    $tel = $row['tel'];
    $mail = $row['mail'];
    $patente = $row['patente'];
    $tusu = $row['tusu'];
    $tcon = $row['tcon'];
    $sgtusu = $row['sgtusu'];
    $sgtcon = $row['sgtcon'];
    $activo = $row['activo'];
    $tipot = $row['tipo'];
    $zona = $row['zona'];
    $deposito = $row['deposito'];
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
    'Tecnicos',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= Renombre($_POST['tecnico']);
  $dni = $_POST['dni'];
  $id_recurso = $_POST['id_recurso'];
  $chomba = $_POST['chomba'];
  $pantalon = $_POST['pantalon'];
  $zapato = $_POST['zapato'];
  $ingreso = $_POST['ingreso'];
  $modelo = $_POST['modelo'];
  $sn = $_POST['sn'];
  $flota = $_POST['flota'];
  $tel = $_POST['tel'];
  $mail = $_POST['mail'];
  $patente = $_POST['patente'];
  $tusu = $_POST['tusu'];
  $tcon = $_POST['tcon'];
  $sgtusu = $_POST['sgtusu'];
  $sgtcon = $_POST['sgtcon'];
  $activo = $_POST['activo'];
  $tipot = $_POST['tipot'];
  $zona = $_POST['zona'];
  $deposito = $_POST['deposito'];

  $query = "UPDATE tecnicos set 
  tecnico = '$tecnico', 
  dni = '$dni', 
  id_recurso = '$id_recurso', 
  chomba = '$chomba', 
  pantalon = '$pantalon', 
  zapato = '$zapato', 
  ingreso = '$ingreso', 
  modelo = '$modelo', 
  sn = '$sn', 
  flota = '$flota', 
  tel = '$tel', 
  mail = '$mail', 
  patente = '$patente',
  tusu = '$tusu', 
  tcon = '$tcon', 
  sgtusu = '$sgtusu', 
  sgtcon = '$sgtcon', 
  activo = '$activo', 
  tipo = '$tipot', 
  zona = '$zona',
  deposito = '$deposito'
  WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
  
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al actualizar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Actualizado";
    $msj_toast = "Los datos de " .$tecnico ." fueron actualizados correctamente.";
    $color_toast = "warning";
  }
  if($tipot == 'Tecnico')
  {
    /* MSJ */
      $link = '/Editar/edit_tecnicos.php?id=' .$id;
      $icono="https://argentseal.online/images/icon_512.png";

      $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = 'Damian' AND apellido = 'Duarte' LIMIT 1");
      if (mysqli_num_rows($msj) == 1)
      {
        $row = mysqli_fetch_array($msj);
        $firebase = $row['firebase'];  
      }

      $field=array(
          'data'=>array(
          'notification'=>array(
          'title'=>'Nuevo tecnico',
          'body'=>'Ahora ' .$tecnico .' es tecnico, actualizar ID',
          'icon'=>$icono,
          'link'=>$link
          )
        ),
      'to'=>$firebase
      );
      $fields=json_encode($field);

      $header=array(
        'Authorization: key=AAAAsHb0r4c:APA91bFnf2A8l7nYJ1ajJuQSy6SJHjiGcHFU3fzw2gHyLbu9C5dYfl7n7fQ4n8LOVr8y2vg2P65O0g8wuo7S-DHZkGgxF_m2DEh9vNMYsP7_83Qb4DNj_Rgj_e0I9xuYkjAGYiGHjQhY',
        'Content-Type: application/json'
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

      $result=curl_exec($ch);
      curl_close($ch);
    /* MSJ */
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/datos.php');
}

?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_tecnicos.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizacion de tecnicos</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Nombre Completo</label >
                  <input type="text" name="tecnico" value="<?php echo $tecnico; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">DNI</label >
                  <input type="number" name="dni" value="<?php echo $dni; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">ID Recurso</label >
                  <input type="number" name="id_recurso" value="<?php echo $id_recurso; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Activo</label >
                    <select type="text" name="activo" class="form-control">
                    <option selected><?php echo $activo; ?></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>              
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Talle de chomba</label >
                  <input type="text" name="chomba" value="<?php echo $chomba; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Talle de pantalon</label >
                  <input type="text" name="pantalon" value="<?php echo $pantalon; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Talle de zapato</label >
                  <input type="text" name="zapato" value="<?php echo $zapato; ?>" class="form-control" autofocus >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha de ingreso</label >
                  <input type="text" id="ingreso" value="<?php echo $ingreso; ?>" name="ingreso" readonly="" class="form-control" >
                </div>
                
                <div class="form-group col">
                  <label for="inputEmail">E-mail</label >
                  <input type="email" name="mail" pattern="([a-zA-Z0-9_.-+])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})" maxlength="50" value="<?php echo $mail; ?>" class="form-control" autofocus >          
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Patente</label >
                  <input type="text" value="<?php echo $patente; ?>" name="patente" class="form-control" >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Modelo celular</label >
                  <input type="text" name="modelo" value="<?php echo $modelo; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">SN celular</label >
                  <input type="text" name="sn" value="<?php echo $sn; ?>"  class="form-control" autofocus >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Telefono de flota</label >
                  <input type="number" name="flota" value="<?php echo $flota; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Telefono personal</label >
                  <input type="number" name="tel" value="<?php echo $tel; ?>" class="form-control" autofocus >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">TOA usuario</label >
                  <input type="text" name="tusu" value="<?php echo $tusu; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">TOA contraseña</label >
                  <input type="text" name="tcon" value="<?php echo $tcon; ?>"  class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">SGT usuario</label >
                  <input type="text" name="sgtusu" value="<?php echo $sgtusu; ?>" class="form-control" autofocus >
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">SGT contraseña</label >
                  <input type="text" name="sgtcon" value="<?php echo $sgtcon; ?>" class="form-control" autofocus >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tipo</label >
                  <select type="text" name="tipot" class="form-control">
                    <option selected><?php echo $tipot; ?></option>
                    <option value="Ayudante">Ayudante</option>
                    <option value="Tecnico">Tecnico</option>
                    <option value="Preocupacional">Preocupacional</option>
                    <option value="Capacitacion">Capacitacion</option>
                    <option value="Supervisor">Supervisor</option> 
                  </select>
                </div>
                <div class="form-group col-sm">
                  <label for="exampleFormControlSelect1">Zona</label >
                  <select type="text" name="zona" class="form-control">
                    <option selected><?php echo $zona; ?></option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Deposito</label >
                  <select type="text" name="deposito" class="form-control">
                    <option selected><?php echo $deposito; ?></option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
              </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar tecnico">

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

</body>
</html>
