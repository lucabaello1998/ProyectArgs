<?php

include('../../db.php');
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
if($tipo == "ATC") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   
}
//////////////////////// PRESIONAR EL BOTÓN //////////////////////////

  


if(isset($_POST['save_kilometros'])){

        $fech = ($_POST['fecha']); 
        $hora = ($_POST['hora']);       
        $dia = ($_POST['dia']);
        $hora = ($_POST['hora']);
        $km = ($_POST['km']);
        $localidad = ($_POST['localidad']);
        $obs = ($_POST['obs']);
        
        $nom = array();
        $cont = 0;
        $query = "SELECT * FROM tecnicosatc WHERE operativo = 'SI' ORDER BY nombre asc";
        $result_tasks = mysqli_query($conn, $query);  
        while($row = mysqli_fetch_assoc($result_tasks)) {
        $nom[$cont] = '"'  .$row['nombre'] .' ' .$row['apellido'] .'"' ;
         $cont++; }

while(true) {

            //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
            $item1 = current($nom);
            $item2 = $fech;
            $item3 = current($hora);
            $item4 = current($dia);
            $item5 = current($km);
            $item6 = current($localidad);
            $item7 = current($obs);
            
            ////// ASIGNARLOS A VARIABLES ///////////////////
            $nomnom=(( $item1 !== false) ? $item1 : ", &nbsp;");
            $fechafecha=$item2;
            $horahora=(( $item3 !== false) ? $item3 : ", &nbsp;");
            $diadia=(( $item4 !== false) ? $item4 : ", &nbsp;");
            $kmkm=(( $item5 !== false) ? $item5 : ", &nbsp;");
            $localoca=(( $item6 !== false) ? $item6 : ", &nbsp;");
            $obsobs=(( $item7 !== false) ? $item7 : ", &nbsp;");

            //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
            $valores='('.$nomnom.',"'.$fechafecha.'","'.$horahora.'","'.$diadia.'","'.$kmkm.'","'.$localoca.'","'.$obsobs.'"),';

            //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
            $valoresQ= substr($valores, 0, -1);
            
            ///////// QUERY DE INSERCIÓN ////////////////////////////
            
            $query = "INSERT INTO atckilometros (nombre, fecha, hora, dia, km, localidad, obs) VALUES $valoresQ";
            $result = mysqli_query($conn, $query);
            
            // Up! Next Value
            $item1 = next( $nom );
            $item3 = next( $dia );
            $item4 = next( $hora );
            $item5 = next( $km );
            $item6 = next( $localidad );
            $item7 = next( $obs );
            
            // Check terminator
            if($item1 === false  && $item3 === false && $item4 === false && $item5 === false && $item6 === false && $item7 === false) break;
            
    
        }
        $_SESSION['card'] = 1;
        $_SESSION['message'] = "los kilometros del dia " .$fech ." fueron guardados.";
        $_SESSION['message_type'] = 'success';
        header('Location: ../../ATC/indexatc.php');

}

?>
