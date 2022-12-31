<?php include('../db.php');
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
if($usu != 1)
{
  header("location: ../index.php");
}

if(isset($_POST['save_asistencia'])){

  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Asistencia general ayudantes', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

        $fech = ($_POST['fecha']); 
        $hora = ($_POST['hora']);       
        $dia = ($_POST['dia']);
        


        $nom = array();
        $cont = 0;
        $query = "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Ayudante' ORDER BY tecnico asc";
        $result_tasks = mysqli_query($conn, $query);  
        while($row = mysqli_fetch_assoc($result_tasks)) {
        $nom[$cont] = '"'  .$row['tecnico'] .'"' ;
         $cont++; }


        
        

while(true) {

            //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
            $item1 = current($nom);
            $item2 = $fech;
            $item3 = current($hora);
            $item4 = current($dia);
            
            ////// ASIGNARLOS A VARIABLES ///////////////////
            $nomnom=(( $item1 !== false) ? $item1 : ", &nbsp;");
            $fechafecha=$item2;
            $horahora=(( $item3 !== false) ? $item3 : ", &nbsp;");
            $diadia=(( $item4 !== false) ? $item4 : ", &nbsp;");

            //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
            $valores='('.$nomnom.',"'.$fechafecha.'","'.$horahora.'","'.$diadia.'"),';

            //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
            $valoresQ= substr($valores, 0, -1);
            
            ///////// QUERY DE INSERCIÓN ////////////////////////////
            
            $query = "INSERT INTO asistenciaayudantes (nombre, fecha, hora, dia) VALUES $valoresQ";
            $result = mysqli_query($conn, $query);
            
            // Up! Next Value
            $item1 = next( $nom );
            
            $item3 = next( $dia );
            $item4 = next( $hora );
            
            // Check terminator
            if($item1 === false  && $item3 === false && $item4 === false) break;
            
    
        }
        $_SESSION['card'] = 1;
        $_SESSION['message'] = "El dia " .$fech ." fue guardado.";
        $_SESSION['message_type'] = 'success';
        header('Location: ../Basico/ayudantes.php');

}

?>
