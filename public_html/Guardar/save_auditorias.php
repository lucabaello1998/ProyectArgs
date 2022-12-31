<?php

include('../db.php');
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
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

if (isset($_POST['save_auditoria']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Auditoria herramientas', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $supervisor = $nombre ." " .$apellido ;
  $tecnico = $_POST['tecnico'];
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



  


  $query = "INSERT INTO auditoria(supervisor, tecnico, fecha, aire, alargue, alcohol, alicate, arnes, campera, casco, celular, chomba, pasacable, cleaver, conos, crimpeadora, dest_phillips, dest_plano, tension, enduido, escalera_chica, escalera_grande, escoba, fibron, gafas, gorra, alta_tension, guante_trabajo, lapiz_limpiador, lapiz_optico, linga, martillo, mecha6, mecha_pasante, pala, pantalon, panos, peladora_fo, peladora_uni, percutora, pinza, silicona, power, tel, tester_rj, tijera, zapatos, bolso_kit, bolso_cleaver, caja, obs) VALUES ('$supervisor', '$tecnico', '$fecha', '$aire', '$alargue', '$alcohol', '$alicate', '$arnes', '$campera', '$casco', '$celular', '$chomba', '$pasacable', '$cleaver', '$conos', '$crimpeadora', '$dest_phillips', '$dest_plano', '$tension', '$enduido', '$escalera_chica', '$escalera_grande', '$escoba', '$fibron', '$gafas', '$gorra', '$alta_tension', '$guante_trabajo', '$lapiz_limpiador', '$lapiz_optico', '$linga', '$martillo', '$mecha6', '$mecha_pasante', '$pala', '$pantalon', '$panos', '$peladora_fo', '$peladora_uni', '$percutora', '$pinza', '$silicona', '$power', '$tel', '$tester_rj', '$tijera', '$zapatos', '$bolso_kit', '$bolso_cleaver', '$caja', '$obs')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    $msj = "Recuerda que el tecnico, la fecha son obligatorios y el comentario maximo 255 caracteres.";
    $color = "danger";
  }else{
  $msj = "La auditoria de " .$tecnico ." fue guardada.";
  $color = "success";
  }
}
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias.php');
?>
