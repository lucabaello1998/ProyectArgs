<?php include("../../db.php"); ?>
<?php 
$tipo       = $_FILES['dataCSV']['type'];
$tamanio    = $_FILES['dataCSV']['size'];
$archivotmp = $_FILES['dataCSV']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0; 

foreach ($lineas as $linea) {
      $cantidad_registros = count($lineas);
      $cantidad_regist_agregados =  ($cantidad_registros - 0);

      if ($i >= 0) {

      $datos = explode(";", $linea);

      $fecha_hora         = !empty($datos[0])  ? ($datos[0]) : '';
      $empleado           = !empty($datos[1])  ? ($datos[1]) : '';
      $numero_empleado    = !empty($datos[2])  ? ($datos[2]) : '';
      $nada               = !empty($datos[4])  ? ($datos[4]) : '';
      $direccion          = !empty($datos[5])  ? ($datos[5]) : '';
      $partido            = !empty($datos[6])  ? ($datos[6]) : '';
      $localidad          = !empty($datos[7])  ? ($datos[7]) : '';
      $pais               = !empty($datos[8])  ? ($datos[8]) : '';      
      $tipo               = !empty($datos[9])  ? ($datos[9]) : '';
      $numero             = !empty($datos[10])  ? ($datos[10]) : '';
      $tarea              = !empty($datos[11])  ? ($datos[11]) : '';
      $foto               = !empty($datos[12])  ? ($datos[12]) : '';
      $latitud            = !empty($datos[13])  ? ($datos[13]) : '';
      $longitud           = !empty($datos[14])  ? ($datos[14]) : '';
      $altura             = !empty($datos[15])  ? ($datos[15]) : '';
      $observaciones      = !empty($datos[16])  ? ($datos[16]) : '';
      $uno                = !empty($datos[17])  ? ($datos[17]) : '';
      $prioridad          = !empty($datos[18])  ? ($datos[18]) : '';
      $direccion_manual   = !empty($datos[19])  ? ($datos[19]) : '';
      $comentarios        = !empty($datos[20])  ? ($datos[20]) : '';
      
      
      if ($fecha_hora == "" || $empleado == "")
      {
      $msg ="Error en el archivo, asegurate de que este separado por ;";
      $msgColor = "danger";
      }
      else
      {
      $fecha  = $fecha_hora;             
      $solofecha = explode(" ", $fecha); // explota el string en " " espacios
      $pruebafecha = explode("/", $solofecha[0]);  // asigna un valor por el resultado del explotado
      $fechafecha = $pruebafecha[2] ."-" .$pruebafecha[1] ."-" .$pruebafecha[0];
      $horahora = $solofecha[1] ." " .$solofecha[2] .$solofecha[3] ;  // asigna un valor por el resultado del explotado

      if  (!$numero_empleado) {
        $rr = mysqli_query($conn, "SELECT * FROM tecnicosatc WHERE num_empleado = '$numero_empleado' ORDER BY id desc LIMIT 1");
        if (mysqli_num_rows($rr) == 1)
        {
          $row = mysqli_fetch_array($rr);
          $nombre_id = $row['nombre'];
          $apellido_id = $row['apellido'];
          $tecnico_empleado = $nombre_id .' ' .$apellido_id;
        }
      }
      else
      {
        $tecnico_empleado = 'Sin nombre';
      }

      $empl  = $empleado;
      $insertar = "INSERT INTO atcreporteslineal( 
      fecha,
      hora,
      empleado,
      num_empleado,
      direccion,
      partido,
      localidad,
      tipo,
      numero,
      tarea,
      latitud,
      longitud,
      observaciones,
      dias_sin,
      prioridad,      
      direccion_manual,
      comentarios
      ) VALUES(
      '$fechafecha',
      '$horahora',
      '$tecnico_empleado',
      '$numero_empleado',
      '$direccion',
      '$partido',
      '$localidad',
      '$tipo',
      '$numero',
      '$tarea',
      '$latitud',
      '$longitud',
      '$observaciones',
      '$uno',
      '$prioridad',
      '$direccion_manual',
      '$comentarios'
      )";
      $resultado = mysqli_query($conn, $insertar);
      if (!$resultado)
      {
        $msg ="Error en el servidor.";
        $msgColor = "danger";
      }
             
        $msg ="Se cargaron " .$cantidad_regist_agregados ." registros a la base de datos.";
        $msgColor = "success";
      
      }
      }

$i++;

}
$_SESSION['card'] = 1;
$_SESSION['message'] = $msg;
$_SESSION['message_type'] = $msgColor;
header('Location: ../../ATC/Basico/lineal.php');

?>