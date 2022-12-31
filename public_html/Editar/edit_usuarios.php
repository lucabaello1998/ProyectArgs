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
if($tipo != "Administrador")
{
header("location: ../index.php");
}
$nombreus = '';
$apellidous= '';
$mail= '';
$usuario= '';
$pass= '';
$tipous= '';
$zona= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM usuarios WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $nombreus = $row['nombre'];
    $apellidous = $row['apellido'];
    $mail = $row['mail'];
    $usuario = $row['usuario'];
    $pass = $row['pass'];
    $tipous = $row['tipo_us'];
    $zona = $row['zona'];
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
    'Usuarios',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $nombreus= $_POST['nombre'];
  $apellidous = $_POST['apellido'];
  $mail = $_POST['mail'];
  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];
  $tipous = $_POST['tipo_us'];
  $zona = $_POST['zona'];
  $arrayText = explode(" ", $zona);
  $acronym = "";
  foreach ($arrayText as $word){
    $arrayLetters = str_split($word, 1);
    $acronym =  $acronym . $arrayLetters['0'];
  }
  $abreviatura = $acronym;

  $query = "UPDATE usuarios set nombre = '$nombreus', apellido = '$apellidous', mail = '$mail', usuario = '$usuario', pass = '$pass', tipo_us = '$tipous', zona = '$zona', abreviatura = '$abreviatura' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "El usuario de " .$nombreus ." " .$apellidous ." fue actualizado";
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/usuarios.php');
}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_usuarios.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar usuario</p>
              <div class="form-row align-items-end">            
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Nombre</label >
                  <input type="text" name="nombre" class="form-control" value="<?php echo $nombreus; ?>" placeholder="Actualice el nombre" autofocus>
                </div>            
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Apellido</label >
                  <input type="text" name="apellido" class="form-control" value="<?php echo $apellidous; ?>" placeholder="Actualice el apellido" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Zona</label >
                  <select type="text" name="zona" class="form-control">
                    <option selected><?php echo $zona; ?></option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="San Nicolas">San Nicolas</option>
                    <option value="Todo">Todo</option>
                  </select>
                </div>
              </div>
              <div class="form-row align-items-end">
                
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Mail</label >
                  <input type="text" name="mail" class="form-control" value="<?php echo $mail; ?>" placeholder="Actualice el mail" autofocus>
                </div>          
                <div class="form-group col">
                  <label for="exampleFormControlSelect1" class="text-center">Tipo</label >
                  <select type="text" name="tipo_us" class="form-control">
                    <option selected><?php echo $tipous; ?></option>
                    <option value="Administrador">Administrador</option>
                    <option value="ATC">ATC</option>
                    <option value="Despacho">Despacho</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Deposito">Deposito</option>
                    <option value="Tecnico">Tecnico</option>
                  </select>
                </div>
              </div>
              <div class="form-row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Usuario</label >
                  <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>" placeholder="Actualice el usuario" autofocus>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Contraseña</label >
                  <input type="text" name="pass" class="form-control" value="<?php echo $pass; ?>" placeholder="Actualice la contraseña" autofocus>
                </div>
              </div>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar usuario">
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
<!-- Boapellidostrap -->
<script src="https://stackpath.boapellidostrapcdn.com/boapellidostrap/4.4.1/js/boapellidostrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
<!-- Calendario -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#calendario").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#calendario" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
