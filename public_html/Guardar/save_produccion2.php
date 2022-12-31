<?php include("../db.php");

if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito - Supervisor/////
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

require_once('../Basico/excel/vendor/php-excel-reader/excel_reader2.php');
require_once('../Basico/excel/vendor/SpreadsheetReader.php');

if(isset($_POST['cargar_dia'])){

$quien = $nombre ." " .$apellido;
    
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = '../Basico/excel/produccion/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                
                $id_actividad = "";
                if(isset($Row[0])) {
                    $id_actividad = mysqli_real_escape_string($conn,$Row[0]);
                }
        
                $ot = "";
                if(isset($Row[1])) {
                    $ot = mysqli_real_escape_string($conn,$Row[1]);
                }
        
                $codigo_pais = "";
                if(isset($Row[2])) {
                    $codigo_pais = mysqli_real_escape_string($conn,$Row[2]);
                }

                $nombre = "";
                if(isset($Row[3])) {
                    $nombre = mysqli_real_escape_string($conn,$Row[3]);
                }

                $direccion = "";
                if(isset($Row[4])) {
                    $direccion = mysqli_real_escape_string($conn,$Row[4]);
                }

                $piso = "";
                if(isset($Row[5])) {
                    $piso = mysqli_real_escape_string($conn,$Row[5]);
                }

                $torre = "";
                if(isset($Row[6])) {
                    $torre = mysqli_real_escape_string($conn,$Row[6]);
                }

                $estado = "";
                if(isset($Row[7])) {
                    $estado = mysqli_real_escape_string($conn,$Row[7]);
                }

                $zona_trabajo = "";
                if(isset($Row[8])) {
                    $zona_trabajo = mysqli_real_escape_string($conn,$Row[8]);
                }

                $provincia = "";
                if(isset($Row[9])) {
                    $provincia = mysqli_real_escape_string($conn,$Row[9]);
                }

                $fech = "";
                if(isset($Row[10])) {
                    $fech = mysqli_real_escape_string($conn,$Row[10]);

                    if (strpos($fech, "/") !== false) {
                        $fechin = explode("/", $fech);
                        $fecha = '20'.$fechin[2] ."-" .$fechin[1] ."-" .$fechin[0] ;
                    }
                }

                $intervalo = "";
                if(isset($Row[11])) {
                    $intervalo = mysqli_real_escape_string($conn,$Row[11]);
                }

                $ventana = "";
                if(isset($Row[12])) {
                    $ventana = mysqli_real_escape_string($conn,$Row[12]);
                }

                $tipo_actividad = "";
                if(isset($Row[13])) {
                    $tipo_actividad = mysqli_real_escape_string($conn,$Row[13]);
                }

                $tipo_act = "";
                if(isset($Row[14])) {
                    $tipo_act = mysqli_real_escape_string($conn,$Row[14]);
                }

                $tecnologia = "";
                if(isset($Row[15])) {
                    $tecnologia = mysqli_real_escape_string($conn,$Row[15]);
                }

                $segmento = "";
                if(isset($Row[16])) {
                    $segmento = mysqli_real_escape_string($conn,$Row[16]);
                }

                $codigo_servicio = "";
                if(isset($Row[17])) {
                    $codigo_servicio = mysqli_real_escape_string($conn,$Row[17]);
                }

                $cantidad_tv = "";
                if(isset($Row[18])) {
                    $cantidad_tv = mysqli_real_escape_string($conn,$Row[18]);
                }

                $estado_actividad = "";
                if(isset($Row[19])) {
                    $estado_actividad = mysqli_real_escape_string($conn,$Row[19]);
                }

                $razon_completada = "";
                if(isset($Row[20])) {
                    $razon_completada = mysqli_real_escape_string($conn,$Row[20]);
                }

                $razon_no_realizada = "";
                if(isset($Row[21])) {
                    $razon_no_realizada = mysqli_real_escape_string($conn,$Row[21]);
                }

                $notas_cierre = "";
                if(isset($Row[22])) {
                    $notas_cierre = mysqli_real_escape_string($conn,$Row[22]);
                }

                $tk = "";
                if(isset($Row[23])) {
                    $tk = mysqli_real_escape_string($conn,$Row[23]);
                }

                $id_recurso = "";
                $zona_recurso = "";
                if(isset($Row[24])) {
                    $id_recurso = mysqli_real_escape_string($conn,$Row[24]);
                

                    $consulta_recurso = "SELECT * FROM tecnicos WHERE id_recurso = '$id_recurso' ";
                    $resultado_id_recurso = mysqli_query($conn, $consulta_recurso);
                    while($row = mysqli_fetch_assoc($resultado_id_recurso)) {
                        $id_recu = $row['tecnico'];
                        $id_recu_id = $row['id_recurso'];
                        

                        if( $id_recurso == $id_recu_id ){
                            $id_recurso = $row['tecnico'];
                            $zona_recurso = $row['zona'];
                        }
                    } 

                }

                $aptitud = "";
                if(isset($Row[25])) {
                    $aptitud = mysqli_real_escape_string($conn,$Row[25]);
                }

                $hora_asignacion = "";
                if(isset($Row[26])) {
                    $hora_asignacion = mysqli_real_escape_string($conn,$Row[26]);
                }

                $hora_reserva = "";
                if(isset($Row[27])) {
                    $hora_reserva = mysqli_real_escape_string($conn,$Row[27]);
                }

                $ventana_entrega = "";
                if(isset($Row[28])) {
                    $ventana_entrega = mysqli_real_escape_string($conn,$Row[28]);
                }

                $nota_ejecucion = "";
                if(isset($Row[29])) {
                    $nota_ejecucion = mysqli_real_escape_string($conn,$Row[29]);
                }

                $hora_inicio = "";
                if(isset($Row[30])) {
                    $hora_inicio = mysqli_real_escape_string($conn,$Row[30]);

                    $inicio = $hora_inicio .':00';
                }

                $hora_fin = "";
                if(isset($Row[31])) {
                    $hora_fin = mysqli_real_escape_string($conn,$Row[31]);

                    $fin = $hora_fin .':00';
                }

                $inicio_fin = "";
                if(isset($Row[32])) {
                    $inicio_fin = mysqli_real_escape_string($conn,$Row[32]);
                }

                $duracion = "";
                if(isset($Row[33])) {
                    $duracion = mysqli_real_escape_string($conn,$Row[33]);
                }

                $tiempo_viaje = "";
                if(isset($Row[34])) {
                    $tiempo_viaje = mysqli_real_escape_string($conn,$Row[34]);
                }

                $coordenada_inicio = "";
                if(isset($Row[35])) {
                    $coordenada_inicio = mysqli_real_escape_string($conn,$Row[35]);
                }

                $coordenada_fin = "";
                if(isset($Row[36])) {
                    $coordenada_fin = mysqli_real_escape_string($conn,$Row[36]);
                }

                $ciudad = "";
                if(isset($Row[37])) {
                    $ciudad = mysqli_real_escape_string($conn,$Row[37]);
                }

                $codigo_postal = "";
                if(isset($Row[38])) {
                    $codigo_postal = mysqli_real_escape_string($conn,$Row[38]);
                }

                $telefono = "";
                if(isset($Row[39])) {
                    $telefono = mysqli_real_escape_string($conn,$Row[39]);
                }

                $inicio_sla = "";
                if(isset($Row[40])) {
                    $inicio_sla = mysqli_real_escape_string($conn,$Row[40]);
                }

                $fin_sla = "";
                if(isset($Row[41])) {
                    $fin_sla = mysqli_real_escape_string($conn,$Row[41]);
                }

                $num_cuenta = "";
                if(isset($Row[42])) {
                    $num_cuenta = mysqli_real_escape_string($conn,$Row[42]);
                }

                $nombre_cliente = "";
                if(isset($Row[43])) {
                    $nombre_cliente = mysqli_real_escape_string($conn,$Row[43]);
                }

                $telefono_movil = "";
                if(isset($Row[44])) {
                    $telefono_movil = mysqli_real_escape_string($conn,$Row[44]);
                }

                $mail = "";
                if(isset($Row[45])) {
                    $mail = mysqli_real_escape_string($conn,$Row[45]);
                }

                $titular = "";
                if(isset($Row[46])) {
                    $titular = mysqli_real_escape_string($conn,$Row[46]);
                }

                $referente = "";
                if(isset($Row[47])) {
                    $referente = mysqli_real_escape_string($conn,$Row[47]);
                }

                $tipo_documento = "";
                if(isset($Row[48])) {
                    $tipo_documento = mysqli_real_escape_string($conn,$Row[48]);
                }

                $dni = "";
                if(isset($Row[49])) {
                    $dni = mysqli_real_escape_string($conn,$Row[49]);
                }

                $observaciones = "";
                if(isset($Row[50])) {
                    $observaciones = mysqli_real_escape_string($conn,$Row[50]);
                }

                $tipo_servicio = "";
                if(isset($Row[51])) {
                    $tipo_servicio = mysqli_real_escape_string($conn,$Row[51]);
                }

                $conxion_tv = "";
                if(isset($Row[52])) {
                    $conxion_tv = mysqli_real_escape_string($conn,$Row[52]);
                }

                $conforme_servicio = "";
                if(isset($Row[53])) {
                    $conforme_servicio = mysqli_real_escape_string($conn,$Row[53]);
                }

                $disconformidad = "";
                if(isset($Row[54])) {
                    $disconformidad = mysqli_real_escape_string($conn,$Row[54]);
                }

                $cobro = "";
                if(isset($Row[55])) {
                    $cobro = mysqli_real_escape_string($conn,$Row[55]);
                }

                $motivo_cobro = "";
                if(isset($Row[56])) {
                    $motivo_cobro = mysqli_real_escape_string($conn,$Row[56]);
                }

                $auditoria_tel = "";
                if(isset($Row[57])) {
                    $auditoria_tel = mysqli_real_escape_string($conn,$Row[57]);
                }

                $explico_servicio = "";
                if(isset($Row[58])) {
                    $explico_servicio = mysqli_real_escape_string($conn,$Row[58]);
                }

                $conforme_internet = "";
                if(isset($Row[59])) {
                    $conforme_internet = mysqli_real_escape_string($conn,$Row[59]);
                }

                $conforme_tv = "";
                if(isset($Row[60])) {
                    $conforme_tv = mysqli_real_escape_string($conn,$Row[60]);
                }

                $auditoria = "";
                if(isset($Row[61])) {
                    $auditoria = mysqli_real_escape_string($conn,$Row[61]);
                }

                $niveles_rango = "";
                if(isset($Row[62])) {
                    $niveles_rango = mysqli_real_escape_string($conn,$Row[62]);
                }

                $antena = "";
                if(isset($Row[63])) {
                    $antena = mysqli_real_escape_string($conn,$Row[63]);
                }

                $nota_cableado = "";
                if(isset($Row[64])) {
                    $nota_cableado = mysqli_real_escape_string($conn,$Row[64]);
                }

                $conectorizado = "";
                if(isset($Row[65])) {
                    $conectorizado = mysqli_real_escape_string($conn,$Row[65]);
                }

                $loop_expansion = "";
                if(isset($Row[66])) {
                    $loop_expansion = mysqli_real_escape_string($conn,$Row[66]);
                }

                $loop_goteo = "";
                if(isset($Row[67])) {
                    $loop_goteo = mysqli_real_escape_string($conn,$Row[67]);
                }

                $loop_mantenimiento = "";
                if(isset($Row[68])) {
                    $loop_mantenimiento = mysqli_real_escape_string($conn,$Row[68]);
                }

                $recorrido_cable = "";
                if(isset($Row[69])) {
                    $recorrido_cable = mysqli_real_escape_string($conn,$Row[69]);
                }

                $metraje_cable = "";
                if(isset($Row[70])) {
                    $metraje_cable = mysqli_real_escape_string($conn,$Row[70]);
                }

                $lnb = "";
                if(isset($Row[71])) {
                    $lnb = mysqli_real_escape_string($conn,$Row[71]);
                }

                $nim = "";
                if(isset($Row[72])) {
                    $nim = mysqli_real_escape_string($conn,$Row[72]);
                }

                $motivo_asignacion = "";
                if(isset($Row[73])) {
                    $motivo_asignacion = mysqli_real_escape_string($conn,$Row[73]);
                }

                $revisita = "";
                if(isset($Row[74])) {
                    $revisita = mysqli_real_escape_string($conn,$Row[74]);
                }

                if (!empty($quien) || (!empty($id_actividad)))
                {

                	if($id_actividad != 'ID de actividad' && $estado_actividad != 'cancelada')
                	{
                        $dosplay = 0;
                        $tresplay = 0;
                        $stb = 0;
                        $mudanza_interna = 0;
                        $baja = 0;
                        $baja_desmonte = 0;
                        $mtto = 0;
                        $mtto_ext = 0;
                        /////////////////////////////////////////////////SI INSTALACION ES VERDADERO
                        if(strpos($tipo_act, 'Instalaci') !== false){
                            $instalacion_palabra = 'SI';
                        }
                        else{
                            $instalacion_palabra = 'NO';
                        }
                        //////////////////////////////////////////////////SI VISITA TECNICA POR BAJA ES VERDADERO
                        if(strpos($tipo_act, 'cnica por baja') !== false){
                            $desmonte = 'SI';
                        }
                        else{
                            $desmonte = 'NO';
                        }
                        /////////////////////////////////////////////////SI VISITA TECNICO DEL TECNICO AL CLIENTE ES VERDADERO
                        if(strpos($tipo_act, 'cnico al cliente') !== false){
                            $mtto_palabra = 'SI';
                        }
                        else{
                            $mtto_palabra = 'NO';
                        }
                        /////////////////////////////////////////////////SI MUDANZA ES VERDADERO
                        if(strpos($tipo_act, 'cnica por mudanza') !== false)
                        {
                            if(strpos($tipo_act, 'cnica por mudanza interna') !== false)
                            {
                                $mudanza_interna_palabra = 'SI';
                                $mudanza_palabra = 'NO';
                            }
                            else
                            {
                                $mudanza_interna_palabra = 'NO';
                                $mudanza_palabra = 'SI';
                            }
                        }
                        else
                        {
                            $mudanza_palabra = 'NO';
                            $mudanza_interna_palabra = 'NO';
                        }                        
                        /////////////////////////////////////////////////REINSTALACION CON CAMBIO DE EQUIPO
                        if(strpos($razon_completada, 'n tendido drop con cambio de equipo') !== false){
                            $reinstalacion_cambio_equipo = 'SI';
                        }
                        else{
                            $reinstalacion_cambio_equipo = 'NO';
                        }
                        /////////////////////////////////////////////////INSTALACION DE ACCESS POINT
                        if(strpos($tipo_act, 'n AP') !== false){
                            $ap_palabra = 'SI';
                        }
                        else{
                            $ap_palabra = 'NO';
                        }
                        /////////////////////////////////////////////////REINSTALACION CON CAMBIO DE EQUIPO
                        if($razon_completada === 'Reinstalacion tendido Drop' || $reinstalacion_cambio_equipo === 'SI'){
                            $razon_completada_palabra = 'SI';
                        }
                        else{
                            $razon_completada_palabra = 'NO';
                        }
                        /////////////////////////////////////////////////DOS PLAY
                        if($codigo_servicio === '2P' && $revisita === 'NO' && $estado_actividad === 'finalizada' && $instalacion_palabra === 'SI'  ){
                            $dosplay = 1;
                        }
                        /////////////////////////////////////////////////TRES PLAY
                        if($codigo_servicio === '3P1D' && $revisita === 'NO' && $estado_actividad === 'finalizada' && $instalacion_palabra === 'SI'  ){
                            $tresplay = 1;
                        }
                        /////////////////////////////////////////////////TRES PLAY CON UN DECO
                        if($codigo_servicio === '3P2D' && $revisita === 'NO' && $estado_actividad === 'finalizada' && $instalacion_palabra === 'SI'  ){
                            $tresplay = 1;
                            $stb = 1;
                        }
                        /////////////////////////////////////////////////TRES PLAY CON 2 DECOS
                        if($codigo_servicio === '3P3D' && $revisita === 'NO' && $estado_actividad === 'finalizada' && $instalacion_palabra === 'SI'  ){
                            $tresplay = 1;
                            $stb = 2;
                        }                        
                        /////////////////////////////////////////////////ADICIONAL DE TV
                        if($codigo_servicio === 'ADTV' && $revisita === 'NO' && $estado_actividad === 'finalizada' && $instalacion_palabra === 'SI'){
                            $stb = $cantidad_tv;
                        }
                        /////////////////////////////////////////////////ADICIONAL DE AP
                        if( $ap_palabra === 'SI' && $estado_actividad === 'finalizada'){
                            $stb = 1;
                        }
                        /////////////////////////////////////////////////SI CIERRE POR LLUVIA ES VERDADERO
                        if(strpos($razon_no_realizada, 'Inconvenientes ') !== false){
                            $lluvia = 'SI';
                        }
                        else{
                            $lluvia = 'NO';
                        }
                        /////////////////////////////////////////////////LAS BAJAS POR LLUVIA NO SE CUENTAN
                        if($estado_actividad === 'no realizado' && $lluvia === 'NO' ){                            
                            $baja = 1;
                        }else{                            
                            $baja = 0;
                        }
                        /////////////////////////////////////////////////BAJA CON DESMONTE
                        if($estado_actividad === 'finalizada' && $desmonte === 'SI'){
                            $baja_desmonte = 1;
                        }
                        /////////////////////////////////////////////////MANTENIMINETO INTERNO (TODO LO QUE NO ES REINSTALCIONES TENDIDO DROP)
                        if($estado_actividad === 'finalizada' && $mtto_palabra === 'SI' && $razon_completada_palabra === 'NO' && $mudanza_interna_palabra === 'NO' && $mudanza_palabra === 'NO' ){
                            $mtto = 1;
                        }
                        /////////////////////////////////////////////////MANTENIMIENTO EXTERNO CAMBIO DE DROP
                        if($estado_actividad === 'finalizada' && $mtto_palabra === 'SI' && $razon_completada_palabra === 'SI' ){
                            $mtto_ext = 1;
                        }
                        /////////////////////////////////////////////////MUDANZA INTERNA
                        if($estado_actividad === 'finalizada' && $mudanza_interna_palabra === 'SI'){
                            if($cantidad_tv == 0 ){ ///////SI NO TIENE TV, SE CUENTA COMO 1
                                $mudanza_interna = 1;
                            }
                            else //////SI TIENE TV, SE CUENTAN LAS TV
                            {
                                $mudanza_interna = $cantidad_tv;
                            }
                        }
                        /////////////////////////////////////////////////MUDANZA
                        if($estado_actividad === 'finalizada' && $mudanza_palabra === 'SI'){
                            if($cantidad_tv == 0 ){ ///////SI NO TIENE TV, SE CUENTA COMO 1 DOS PLAY
                                $dosplay = 1;
                            }
                            if($cantidad_tv == 1 ){ ///////SI TIENE 1 TV, SE CUENTA COMO 1 TRIPLE PLAY
                                $tresplay = 1;
                            }
                            if($cantidad_tv == 2 ){ ///////SI TIENE 2 TV, SE CUENTA COMO 1 TRIPLE PLAY Y 1 DECO
                                $tresplay = 1;
                                $stb = 1;
                            }
                            if($cantidad_tv == 3 ){ ///////SI TIENE 2 TV, SE CUENTA COMO 1 TRIPLE PLAY Y 2 DECO
                                $tresplay = 1;
                                $stb = 2;
                            }
                        }
                        /////////////////////////////////////////////////MANTENIMIENTO EXTERNO CAMBIO DE DROP
                        if($estado_actividad === 'finalizada' && $mtto_palabra === 'SI' && $razon_completada_palabra === 'SI' ){
                            $mtto_ext = 1;
                        }
                        

                        $consulta = "INSERT INTO carga_dia(quien,
                        tecnico,
                        id_actividad,
                        ot,
                        direccion,
                        localidad,
                        zona,
                        fecha,
                        intervalo,
                        actividad,
                        codigo,
                        cantidad_tv,
                        estado,
                        razon_completada,
                        razon_no_completada,
                        nota_cierre,
                        inicio,
                        fin,
                        duracion,
                        cliente,
                        telefono,
                        nim,
                        motivo_asignacion,
                        revisita,
                        obs,
                        dos_play,
                        tres_play,
                        stb,
                        mudanza_interna,
                        baja,
                        garantia,
                        garantia_justificada,
                        baja_tecnica,
                        baja_desmonte,
                        mtto,
                        mtto_externo,
                        dia,
                        zona_recurso)VALUES('$quien',
                        '$id_recurso',
                        '$id_actividad',
                        '$ot',
                        '$direccion',
                        '$estado',
                        '$zona_trabajo',
                        '$fecha',
                        '$intervalo',
                        '$tipo_act',
                        '$codigo_servicio',
                        '$cantidad_tv',
                        '$estado_actividad',
                        '$razon_completada',
                        '$razon_no_realizada',
                        '$notas_cierre',
                        '$inicio',
                        '$fin',
                        '$duracion',
                        '$nombre_cliente',
                        '$telefono_movil',
                        '$nim',
                        '$motivo_asignacion',
                        '$revisita',
                        '',
                        '$dosplay',
                        '$tresplay',
                        '$stb',
                        '$mudanza_interna',
                        '$baja',
                        '0',
                        '0',
                        '0',
                        '$baja_desmonte',
                        '$mtto',
                        '$mtto_ext',
                        'Normal',
                        '$zona_recurso')";
                        $resultado = mysqli_query($conn, $consulta);
                
	                    if (!empty($resultado))
	                    {
	                        $msgColor = "success";
	                        $msg = "El excel del dia " .$fecha ." fue cargado correctamente.";
                            $_SESSION['card'] = 1;
                            $_SESSION['message'] = $msg;
                            $_SESSION['message_type'] = $msgColor;
                            header('Location: ../Basico/produccion2.php');                          
	                    }
	                    else
	                    {
	                        $msgColor = "danger";
	                        $msg = "Hubo un problema al cargar los datos.";
                            $_SESSION['card'] = 1;
                            $_SESSION['message'] = $msg;
                            $_SESSION['message_type'] = $msgColor;
                            header('Location: ../Basico/produccion2.php');
	                    }
	                }
                }
            }
        
         }
  }
  else
  { 
        $msgColor = "danger";
        $msg = "Fallo el envio del archivo. Por favor vuelva a intentarlo.";
        $_SESSION['card'] = 1;
        $_SESSION['message'] = $msg;
        $_SESSION['message_type'] = $msgColor;
        header('Location: ../Basico/produccion2.php');
  }

?>
<script src="../Basico/excel/assets/jquery-1.12.4-jquery.min.js"></script>
<?php

$_SESSION['card'] = 1;
$_SESSION['message'] = $msg;
$_SESSION['message_type'] = $msgColor;
header('Location: ../Basico/produccion2.php');
}
?>