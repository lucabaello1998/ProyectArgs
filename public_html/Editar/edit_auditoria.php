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
if($usu != 1)
{
  header("location: ../index.php"); 
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

$tecnico = '';
$fecha= '';
$aire = '';
$alargue = '';
$alcohol = '';
$alicate = '';
$arnes = '';
$campera = '';
$casco = '';
$celular = '';
$chomba = '';
$pasacable = '';
$cleaver = '';
$conos = '';
$crimpeadora = '';
$dest_phillips = '';
$dest_plano = '';
$tension = '';
$enduido = '';
$escalera_chica = '';
$escalera_grande = '';
$escoba = '';
$fibron = '';
$gafas = '';
$gorra = '';
$alta_tension = '';
$guante_trabajo = '';
$lapiz_limpiador = '';
$lapiz_optico = '';
$linga = '';
$martillo = '';
$mecha6 = '';
$mecha_pasante = '';
$pala = '';
$pantalon = '';
$panos = '';
$peladora_fo = '';
$peladora_uni = '';
$percutora = '';
$pinza = '';
$silicona = '';
$power = '';
$tel = '';
$tester_rj = '';
$tijera = '';
$zapatos = '';
$bolso_kit = '';
$bolso_cleaver = '';
$caja = '';
$obs = '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM auditoria WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $aire = $row['aire'];
    $alargue = $row['alargue'];
    $alcohol = $row['alcohol'];
    $alicate = $row['alicate'];
    $arnes = $row['arnes'];
    $campera = $row['campera'];
    $casco = $row['casco'];
    $celular = $row['celular'];
    $chomba = $row['chomba'];
    $pasacable = $row['pasacable'];
    $cleaver = $row['cleaver'];
    $conos = $row['conos'];
    $crimpeadora = $row['crimpeadora'];
    $dest_phillips = $row['dest_phillips'];
    $dest_plano = $row['dest_plano'];
    $tension = $row['tension'];
    $enduido = $row['enduido'];
    $escalera_chica = $row['escalera_chica'];
    $escalera_grande = $row['escalera_grande'];
    $escoba = $row['escoba'];
    $fibron = $row['fibron'];
    $gafas = $row['gafas'];
    $gorra = $row['gorra'];
    $alta_tension = $row['alta_tension'];
    $guante_trabajo = $row['guante_trabajo'];
    $lapiz_limpiador = $row['lapiz_limpiador'];
    $lapiz_optico = $row['lapiz_optico'];
    $linga = $row['linga'];
    $martillo = $row['martillo'];
    $mecha6 = $row['mecha6'];
    $mecha_pasante = $row['mecha_pasante'];
    $pala = $row['pala'];
    $pantalon = $row['pantalon'];
    $panos = $row['panos'];
    $peladora_fo = $row['peladora_fo'];
    $peladora_uni = $row['peladora_uni'];
    $percutora = $row['percutora'];
    $pinza = $row['pinza'];
    $silicona = $row['silicona'];
    $power = $row['power'];
    $tel = $row['tel'];
    $tester_rj = $row['tester_rj'];
    $tijera = $row['tijera'];
    $zapatos = $row['zapatos'];
    $bolso_kit = $row['bolso_kit'];
    $bolso_cleaver = $row['bolso_cleaver'];
    $caja = $row['caja'];
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
    'Auditoria herramientas',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $aire = $_POST['aire'];
  $alargue = $_POST['alargue'];
  $alcohol = $_POST['alcohol'];
  $alicate = $_POST['alicate'];
  $arnes = $_POST['arnes'];
  $campera = $_POST['campera'];
  $casco = $_POST['casco'];
  $celular = $_POST['celular'];
  $chomba = $_POST['chomba'];
  $pasacable = $_POST['pasacable'];
  $cleaver = $_POST['cleaver'];
  $conos = $_POST['conos'];
  $crimpeadora = $_POST['crimpeadora'];
  $dest_phillips = $_POST['dest_phillips'];
  $dest_plano = $_POST['dest_plano'];
  $tension = $_POST['tension'];
  $enduido = $_POST['enduido'];
  $escalera_chica = $_POST['escalera_chica'];
  $escalera_grande = $_POST['escalera_grande'];
  $escoba = $_POST['escoba'];
  $fibron = $_POST['fibron'];
  $gafas = $_POST['gafas'];
  $gorra = $_POST['gorra'];
  $alta_tension = $_POST['alta_tension'];
  $guante_trabajo = $_POST['guante_trabajo'];
  $lapiz_limpiador = $_POST['lapiz_limpiador'];
  $lapiz_optico = $_POST['lapiz_optico'];
  $linga = $_POST['linga'];
  $martillo = $_POST['martillo'];
  $mecha6 = $_POST['mecha6'];
  $mecha_pasante = $_POST['mecha_pasante'];
  $pala = $_POST['pala'];
  $pantalon = $_POST['pantalon'];
  $panos = $_POST['panos'];
  $peladora_fo = $_POST['peladora_fo'];
  $peladora_uni = $_POST['peladora_uni'];
  $percutora = $_POST['percutora'];
  $pinza = $_POST['pinza'];
  $silicona = $_POST['silicona'];
  $power = $_POST['power'];
  $tel = $_POST['tel'];
  $tester_rj = $_POST['tester_rj'];
  $tijera = $_POST['tijera'];
  $zapatos = $_POST['zapatos'];
  $bolso_kit = $_POST['bolso_kit'];
  $bolso_cleaver = $_POST['bolso_cleaver'];
  $caja = $_POST['caja'];
  $obs = $_POST['obs'];


  $query = "UPDATE auditoria set tecnico = '$tecnico', fecha = '$fecha', aire = '$aire', alargue = '$alargue', alcohol = '$alcohol', alicate = '$alicate', arnes = '$arnes', campera = '$campera', casco = '$casco', celular = '$celular', chomba = '$chomba', pasacable = '$pasacable', cleaver = '$cleaver', conos = '$conos', crimpeadora = '$crimpeadora', dest_phillips = '$dest_phillips', dest_plano = '$dest_plano', tension = '$tension', enduido = '$enduido', escalera_chica = '$escalera_chica', escalera_grande = '$escalera_grande', escoba = '$escoba', fibron = '$fibron', gafas = '$gafas', gorra = '$gorra', alta_tension = '$alta_tension', guante_trabajo = '$guante_trabajo', lapiz_limpiador = '$lapiz_limpiador', lapiz_optico = '$lapiz_optico', linga = '$linga', martillo = '$martillo', mecha6 = '$mecha6', mecha_pasante = '$mecha_pasante', pala = '$pala', pantalon = '$pantalon', panos = '$panos', peladora_fo = '$peladora_fo', peladora_uni = '$peladora_uni', percutora = '$percutora', pinza = '$pinza', silicona = '$silicona', power = '$power', tel = '$tel', tester_rj = '$tester_rj', tijera = '$tijera', zapatos = '$zapatos', bolso_kit = '$bolso_kit', bolso_cleaver = '$bolso_cleaver', caja = '$caja', obs = '$obs' WHERE id=$id";
  $resultado = mysqli_query($conn, $query);
  if(!$resultado) {
  $msj = "Recuerda que el comentario es como maximo de 255 caracteres.";
  $color = "danger";
  }else{
  $msj = "La auditoria de " .$tecnico ." fue actualizada.";
  $color = "warning";
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias.php');
}
?>

<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_auditoria.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar auditoria</p>
              <div class="form-row align-items-end">            
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">                
                    <option selected><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
                  <input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>" readonly="" class="form-control" >
                </div> 
              </div>

              <div class="card card-body border-info">

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Aire comprimido</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="BIEN" <?php if ($aire == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="MAL" <?php if ($aire == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alargue</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="BIEN" <?php if ($alargue == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="MAL" <?php if ($alargue == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alcohol isopropilico</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="BIEN" <?php if ($alcohol == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="MAL" <?php if ($alcohol == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alicate</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="BIEN" <?php if ($alicate == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="MAL" <?php if ($alicate == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Arnes</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="BIEN" <?php if ($arnes == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="MAL" <?php if ($arnes == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bolso kit</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="BIEN" <?php if ($bolso_kit == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="MAL" <?php if ($bolso_kit == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bolso del cleaver</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="BIEN" <?php if ($bolso_cleaver == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="MAL" <?php if ($bolso_cleaver == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Campera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="BIEN" <?php if ($campera == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="MAL" <?php if ($campera == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Caja de herramientas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="BIEN" <?php if ($caja == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="MAL" <?php if ($caja == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Casco</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="BIEN" <?php if ($casco == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="MAL" <?php if ($casco == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Celular</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="BIEN" <?php if ($celular == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="MAL" <?php if ($celular == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Chomba</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="BIEN" <?php if ($chomba == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="MAL" <?php if ($chomba == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cinta pasacable</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="BIEN" <?php if ($pasacable == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="MAL" <?php if ($pasacable == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cleaver</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="BIEN" <?php if ($cleaver == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="MAL" <?php if ($cleaver == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Conos</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="BIEN" <?php if ($conos == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="MAL" <?php if ($conos == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Crimpeadora</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="BIEN" <?php if ($crimpeadora == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="MAL" <?php if ($crimpeadora == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Destornillador phillips</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="BIEN" <?php if ($dest_phillips == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="MAL" <?php if ($dest_phillips == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Destornillador plano</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="BIEN" <?php if ($dest_plano == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="MAL" <?php if ($dest_plano == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Detector de tension</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="BIEN" <?php if ($tension == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="MAL" <?php if ($tension == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Espatula y enduido</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="BIEN" <?php if ($enduido == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="MAL" <?php if ($enduido == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Escalera chica</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="BIEN" <?php if ($escalera_chica == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="MAL" <?php if ($escalera_chica == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Escalera grande</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="BIEN" <?php if ($escalera_grande == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="MAL" <?php if ($escalera_grande == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Escoba</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="BIEN" <?php if ($escoba == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="MAL" <?php if ($escoba == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Fibron</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="BIEN" <?php if ($fibron == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="MAL" <?php if ($fibron == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Gafas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="BIEN" <?php if ($gafas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="MAL" <?php if ($gafas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Gorra</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="BIEN" <?php if ($gorra == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="MAL" <?php if ($gorra == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Guante de alta tension</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="BIEN" <?php if ($alta_tension == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="MAL" <?php if ($alta_tension == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Guante de trabajo</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="BIEN" <?php if ($guante_trabajo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="MAL" <?php if ($guante_trabajo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label> 
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Lapiz limpiador</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="BIEN" <?php if ($lapiz_limpiador == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="MAL" <?php if ($lapiz_limpiador == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Lapiz optico</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="BIEN" <?php if ($lapiz_optico == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="MAL" <?php if ($lapiz_optico == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Linga</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="BIEN" <?php if ($linga == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="MAL" <?php if ($linga == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Martillo</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="BIEN" <?php if ($martillo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="MAL" <?php if ($martillo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Mecha del 6"</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="BIEN" <?php if ($mecha6 == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="MAL" <?php if ($mecha6 == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Mecha pasante</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="BIEN" <?php if ($mecha_pasante == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="MAL" <?php if ($mecha_pasante == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Pala</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="BIEN" <?php if ($pala == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="MAL" <?php if ($pala == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Pantalon</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="BIEN" <?php if ($pantalon == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="MAL" <?php if ($pantalon == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Paños</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="BIEN" <?php if ($panos == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="MAL" <?php if ($panos == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Peladora FO</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="BIEN" <?php if ($peladora_fo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="MAL" <?php if ($peladora_fo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Peladora universal</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="BIEN" <?php if ($peladora_uni == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="MAL" <?php if ($peladora_uni == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Percutora</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="BIEN" <?php if ($percutora == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="MAL" <?php if ($percutora == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Pinza</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="BIEN" <?php if ($pinza == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="MAL" <?php if ($pinza == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Pistola de silicona</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="BIEN" <?php if ($silicona == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="MAL" <?php if ($silicona == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Power meter</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="BIEN" <?php if ($power == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="MAL" <?php if ($power == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Telefono de prueba</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="BIEN" <?php if ($tel == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="MAL" <?php if ($tel == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Tester de RJ45</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="BIEN" <?php if ($tester_rj == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="MAL" <?php if ($tester_rj == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Tijera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="BIEN" <?php if ($tijera == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="MAL" <?php if ($tijera == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Zapatos</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="BIEN" <?php if ($zapatos == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="MAL" <?php if ($zapatos == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>
              <br>
                <div class="col">
                  <label for="exampleFormControlSelect1"><b>Observaciones (Max 255 caracteres)</b></label >
                  <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"><?php echo $obs; ?></textarea>
                </div> 
              </div>
              
              <br>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar auditoria">
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
    $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
