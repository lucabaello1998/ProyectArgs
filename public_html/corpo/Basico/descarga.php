<?php
  include("../../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../indexcorpo.php");
  exit();
  }
  $tipo = $_SESSION['tipo_us'];
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../inicio.php");
  }
?>
<?php
	$usuario = new Consulta();
	$salida = "";
	$salida .= "<table>";	
	$salida .="<thead> <th>ID</th><th>Nombre</th><th>Email</th>";
	foreach($usuario->buscar() as $r){
	$salida .= "<tr> <td>" .$r->id." </td> <td>".$r->nombre."</td> <td>".$r->Email "
	}
?>

/*URL desde dónde se hará la descarga del archivo en formato excel .csv */

$url =  "http://omawww.sat.gob.mx/cifras_sat/Documents/Listado_Completo_69-B.csv";

/* Inicializa la función para obtener el archivo de la URL */
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

/* Devuelve el resultado de la transferencia como string */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

/* Ejecuta la descarga del archivo desde la URL */
$output = curl_exec($ch);

/* Convierte los datos del archivo en un array */
$csv = array_map('str_getcsv', file($url));

//var_dump($csv);

/* Variables que serviran como contadores para saber cuantos registros se actualizaron, insertaron o si hubo errores */
$insertados = 0;
$actualizados = 0;
$errores = 0;

/* Cuenta cuantos registros tiene el archivo descargado */
$nRegistros = count($csv);

/* Muestra en pantalla la cantidad de registros del archivo */
echo $nRegistros."\n";

/* Muestra en pantalla el arreglo convertido */
//var_dump($csv);

/* Comprueba la existencia del archivo descargado */
if(file_exists('listasNegras.csv'))
{
    /* Mensaje en pantalla que indica que el archivo existe */
    echo "\n Existe\n";

    /* Evalua si la tabla tiene registros insertados */
    if(mysqli_num_rows(mysqli_query($conectar, "SELECT * FROM catContribuyentes")) == 0)
    {
        /* Mensaje en pantalla que la condi */
        echo "\n No hay registros, se puede insertar\n";

        /* Este ciclo se encarga de recorrer las posiciones del arreglo */
        for ($i = 3; $i <= $nRegistros-1; $i++)
        {
            /* Muestra en pantalla algunos de los datos del archivo */
            echo utf8_encode($csv[$i][0]."\t".$csv[$i][1]."\t".$csv[$i][2]."\t".$csv[$i][3]."\n");

            /* Hace la asignacion de los datos del array a las variables, además de hacer la conversión a UTF8 para poder hacer la visualización de los acentos */
            $noContri = utf8_encode($csv[$i][0]);
            $rfcContri = utf8_encode($csv[$i][1]);
            $nombreContri = utf8_encode($csv[$i][2]);
            $situacionContri = utf8_encode($csv[$i][3]);
            $numFecContri = utf8_encode($csv[$i][4]);
            $publicacionContri = utf8_encode($csv[$i][5]);
            $numFecContriP = utf8_encode($csv[$i][6]);
            $pubDOFContri = utf8_encode($csv[$i][7]);
            $pubDesvContri = utf8_encode($csv[$i][8]);
            $numFecDesvContri = utf8_encode($csv[$i][9]);
            $publicacionDOFDes = utf8_encode($csv[$i][10]);
            $numFecDefi = utf8_encode($csv[$i][11]);
            $punlicacionDefi = utf8_encode($csv[$i][12]);
            $publicacionDOFDef = utf8_encode($csv[$i][13]);
            $numFecSentFav = utf8_encode($csv[$i][14]);
            $pubSentSATFav = utf8_encode($csv[$i][15]);
            $numFecSentFavD = utf8_encode($csv[$i][16]);
            $pubDOFSentFav = utf8_encode($csv[$i][17]);

            /* Sentencia SQL para hacer la insercion en la tabla */
            $sql = "INSERT INTO catContribuyentes (noContri, rfcContri, nombreContri, situacionContri, numFecContri, publicacionContri, numFecContriP, pubDOFContri, pubDesvContri, numFecDesvContri, publicacionDOFDes, numFecDefi, punlicacionDefi, publicacionDOFDef, numFecSentFav, pubSentSATFav, numFecSentFavD, pubDOFSentFav) VALUES ('$noContri', '$rfcContri', '$nombreContri', '$situacionContri', '$numFecContri', '$publicacionContri', '$numFecContriP', '$pubDOFContri', '$pubDesvContri', '$numFecDesvContri', '$publicacionDOFDes', '$numFecDefi', '$punlicacionDefi', '$publicacionDOFDef', '$numFecSentFav', '$pubSentSATFav', '$numFecSentFavD', '$pubDOFSentFav')";

            /* Evaluación y ejecución de la sentencia SQL */
            if(mysqli_query($conectar, $sql))
            {
                $insertados++; //Cuenta registros insertados
            }
            else
            {
                /* Muestra en pantalla el error que se pudo generar mediante la inserción */
                echo "Error: ".$sql."<br>".mysqli_error($conectar)."\n";
                $errores++; //Cueenta la cantidad de erroes generados
            }
        }
    }

    else
    {
        /* Mensaje en pantalla que indica la condición de la tabla */
        echo "\n Ya hay registros, se procedera a actualizar\n";

        for ($i = 3; $i <= $nRegistros-1; $i++)
        {
            /* Muestra en pantalla algunos de los datos del archivo */
            echo utf8_encode($csv[$i][0]."\t".$csv[$i][1]."\t".$csv[$i][2]."\t".$csv[$i][3]."\n");

            /* Hace la asignacion de los datos del array a las variables, además de hacer la conversión a UTF8 para poder hacer la visualización de los acentos */
            $noContri = utf8_encode($csv[$i][0]);
            $rfcContri = utf8_encode($csv[$i][1]);
            $nombreContri = utf8_encode($csv[$i][2]);
            $situacionContri = utf8_encode($csv[$i][3]);
            $numFecContri = utf8_encode($csv[$i][4]);
            $publicacionContri = utf8_encode($csv[$i][5]);
            $numFecContriP = utf8_encode($csv[$i][6]);
            $pubDOFContri = utf8_encode($csv[$i][7]);
            $pubDesvContri = utf8_encode($csv[$i][8]);
            $numFecDesvContri = utf8_encode($csv[$i][9]);
            $publicacionDOFDes = utf8_encode($csv[$i][10]);
            $numFecDefi = utf8_encode($csv[$i][11]);
            $punlicacionDefi = utf8_encode($csv[$i][12]);
            $publicacionDOFDef = utf8_encode($csv[$i][13]);
            $numFecSentFav = utf8_encode($csv[$i][14]);
            $pubSentSATFav = utf8_encode($csv[$i][15]);
            $numFecSentFavD = utf8_encode($csv[$i][16]);
            $pubDOFSentFav = utf8_encode($csv[$i][17]);

            /* Sentencia SQL para hacer la insercion en la tabla */
            $sql = "UPDATE catContribuyentes SET noContri = '$noContri', rfcContri = '$rfcContri', nombreContri = '$nombreContri', situacionContri = '$situacionContri', numFecContri = '$numFecContri', publicacionContri = '$publicacionContri', numFecContriP = '$numFecContriP', pubDOFContri = '$pubDOFContri', pubDesvContri = '$pubDesvContri', numFecDesvContri = '$numFecDesvContri', publicacionDOFDes = '$publicacionDOFDes', numFecDefi = '$numFecDefi', punlicacionDefi = '$punlicacionDefi', publicacionDOFDef = '$publicacionDOFDef', numFecSentFav = '$numFecSentFav', pubSentSATFav = '$pubSentSATFav', numFecSentFavD = '$numFecSentFavD', pubDOFSentFav = '$pubDOFSentFav'";

            /* Evaluación y ejecución de la sentencia SQL */
            if(mysqli_query($conectar, $sql))
            {
                $actualizados++; //Cuenta registros insertados
            }
            else
            {
                /* Muestra en pantalla el error que se pudo generar mediante la actualización */
                echo "Error: ".$sql."<br>".mysqli_error($conectar)."\n";
                $errores++; //Cueenta la cantidad de erroes generados
            }
        }
    }
}

/* Muestra en pantalla la cantidad de registros insertdos y actualizados, así como también la cantidad de errores generados */
echo "Registros Insertados: ".$insertados."\n";
echo "Errores durante la inserción: ".$errores."\n";
echo "Registros actualizados: ".$actualizados."\n";
?>

