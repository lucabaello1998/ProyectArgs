<?php
session_start();
//Conectar a la base de datos
    $dbhost = '';
    $dbuser = '';
    $dbpass = '';
    $dbname = '';

	$conn = mysqli_connect 
	(	$dbhost,
		$dbuser,
		$dbpass,
		$dbname
	);
// window.history.back();    //Retrocede a la página anterior
//window.history.forward(); //Avanza a la página siguiente almacenada en la cache de la máquina.
//window.history.go();  //Avanza o retrocede en la lista de páginas visitadas.

function Reemplazo($texto)
{
	$texto = str_replace( '"', "&#34;", $texto );
	$texto = str_replace( "'", "&#39;", $texto );
	$texto = str_replace( "(", "&#40;", $texto );
	$texto = str_replace( ")", "&#41;", $texto );
	$texto = str_replace( "´", "&#96;", $texto );
	$texto = str_replace( "$", "&#36;", $texto );
	$texto = str_replace( "*", "&#42;", $texto );
	$texto = str_replace( "+", "&#43;", $texto );
	$texto = str_replace( "-", "&#45;", $texto );
	$texto = str_replace( "/", "&#47;", $texto );
	$texto = str_replace( "°", "&#176;", $texto );
	$texto = str_replace( "º", "&#186;", $texto );
	$texto = str_replace( "{", "&#123;", $texto );
	$texto = str_replace( "}", "&#125;", $texto );
	$texto = str_replace( "|", "&#124;", $texto );
	$texto = str_replace( "%", "&#37;", $texto );
	$texto = str_replace( "¼", "&#188;", $texto );
	$texto = str_replace( "½", "&#189;", $texto );
	$texto = str_replace( "¾", "&#190;", $texto );
	$texto = str_replace( "¿", "&#191;", $texto );
	$texto = str_replace( "?", "&#63;", $texto );
	$texto = str_replace( "á", "a", $texto );
	$texto = str_replace( "Á", "A", $texto );
	$texto = str_replace( "é", "e", $texto );
	$texto = str_replace( "É", "E", $texto );
	$texto = str_replace( "í", "i", $texto );
	$texto = str_replace( "Í", "I", $texto );
	$texto = str_replace( "ó", "o", $texto );
	$texto = str_replace( "Ó", "O", $texto );
	$texto = str_replace( "ú", "u", $texto );
	$texto = str_replace( "Ú", "U", $texto );
	$texto = trim(preg_replace('/\s+/', ' ',$texto));
	return $texto;
};

function limitar_cadena($texto, $limite)
{
	// Si la longitud es mayor que el límite...
	if(strlen($texto) > $limite)
	{
		// Entonces corta la cadena y ponle el sufijo
		return substr($texto, 0, $limite) . '...';
	}
	// Si no, entonces devuelve la cadena normal
	return $texto;
}

function Renombre($texto,$separadores = array("'","-"," ","_"))
{   
	//$texto texto al cual aplicar la funcion
	//$separadores caraacteres a tener en cuanta para separar.
	$resultado = strtolower($texto);
	foreach ($separadores as $temp)
	{
		$pos = strpos($resultado,$temp);
		if ($pos)
		{
			//Se analiza el array/separadores.
			$mend = '';
			$a_split = explode($temp,$resultado);
			foreach ($a_split as $temp2)
			{
				//Separacion de los caracteres
				$mend .= ucfirst($temp2).$temp;
			}
		$resultado = substr($mend,0,-1);
		}   
	}
  $resultado = str_replace( "Ñ", "Ã±", $resultado );
	return ucfirst($resultado);
}

function Fecha1($fecha1) /* Lunes, 08 de marzo de 2015 a las 09:24:32 */
{
	$z = explode(" ", $fecha1);
	$y = $z[1];

	$a = date("l j m Y", strtotime($fecha1));
	$b = explode(" ", $a);
	$c = $b[0];
	$d = $b[1];
	$e = $b[2];
	$f = $b[3];

	switch ($c)
	{
		case 'Monday': $g = "Lunes";
		break;
		case 'Tuesday': $g = "Martes";
		break;
		case 'Wednesday': $g = "Miercoles";
		break;
		case 'Thursday': $g = "Jueves";
		break;
		case 'Friday': $g = "Viernes";
		break;
		case 'Saturday': $g = "Sabado";
		break;
		case 'Sunday': $g = "Domingo";
		break;
	}
	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $g .', ' .$d .' de ' .$h .' de ' .$f .' a las ' .$y;
}

function Fecha2($fecha2) /* Lunes, 08 de marzo de 2015 a las 09:24 */
{
	$z = explode(" ", $fecha2);
	$x = $z[1];
	$y= substr($x, 0, -3);

	$a = date("l j m Y", strtotime($fecha2));
	$b = explode(" ", $a);
	$c = $b[0];
	$d = $b[1];
	$e = $b[2];
	$f = $b[3];

	switch ($c)
	{
		case 'Monday': $g = "Lunes";
		break;
		case 'Tuesday': $g = "Martes";
		break;
		case 'Wednesday': $g = "Miercoles";
		break;
		case 'Thursday': $g = "Jueves";
		break;
		case 'Friday': $g = "Viernes";
		break;
		case 'Saturday': $g = "Sabado";
		break;
		case 'Sunday': $g = "Domingo";
		break;
	}
	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $g .', ' .$d .' de ' .$h .' de ' .$f .' a las ' .$y;
}

function Fecha3($fecha3) /* Lunes, 08 de marzo de 2015 */
{
	$a = date("l j m Y", strtotime($fecha3));
	$b = explode(" ", $a);
	$c = $b[0];
	$d = $b[1];
	$e = $b[2];
	$f = $b[3];

	switch ($c)
	{
		case 'Monday': $g = "Lunes";
		break;
		case 'Tuesday': $g = "Martes";
		break;
		case 'Wednesday': $g = "Miercoles";
		break;
		case 'Thursday': $g = "Jueves";
		break;
		case 'Friday': $g = "Viernes";
		break;
		case 'Saturday': $g = "Sabado";
		break;
		case 'Sunday': $g = "Domingo";
		break;
	}
	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $g .', ' .$d .' de ' .$h .' de ' .$f;
}

function Fecha4($fecha4) /* 08 de marzo de 2015 */
{
	$a = date("j m Y", strtotime($fecha4));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];
	$f = $b[2];

	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $d .' de ' .$h .' de ' .$f;
}

function Fecha5($fecha5) /* Lunes, 08 de marzo */
{
	$a = date("l j m", strtotime($fecha5));
	$b = explode(" ", $a);
	$c = $b[0];
	$d = $b[1];
	$e = $b[2];

	switch ($c)
	{
		case 'Monday': $g = "Lunes";
		break;
		case 'Tuesday': $g = "Martes";
		break;
		case 'Wednesday': $g = "Miercoles";
		break;
		case 'Thursday': $g = "Jueves";
		break;
		case 'Friday': $g = "Viernes";
		break;
		case 'Saturday': $g = "Sabado";
		break;
		case 'Sunday': $g = "Domingo";
		break;
	}
	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $g .', ' .$d .' de ' .$h;
}

function Fecha6($fecha6) /* 08 de marzo */
{
	$a = date("j m", strtotime($fecha6));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];

	switch ($e)
	{
		case '12': $h = "diciembre";
		break;
		case '11': $h = "noviembre";
		break;
		case '10': $h = "octubre";
		break;
		case '09': $h = "septiembre";
		break;
		case '08': $h = "agosto";
		break;
		case '07': $h = "julio";
		break;
		case '06': $h = "junio";
		break;
		case '05': $h = "mayo";
		break;
		case '04': $h = "abril";
		break;
		case '03': $h = "marzo";
		break;
		case '02': $h = "febrero";
		break;
		case '01': $h = "enero";
		break;
	}
	return $d .' de ' .$h;
}

/**
 * Formato de fecha (08 de mar)
 * 
 * @param string $fecha
 * 
 * @return string
 */
function Fecha7($fecha7) /* 08 de mar */
{
	$a = date("j m", strtotime($fecha7));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];

	switch ($e)
	{
		case '12': $h = "dic";
		break;
		case '11': $h = "nov";
		break;
		case '10': $h = "oct";
		break;
		case '09': $h = "sep";
		break;
		case '08': $h = "ago";
		break;
		case '07': $h = "jul";
		break;
		case '06': $h = "jun";
		break;
		case '05': $h = "may";
		break;
		case '04': $h = "abr";
		break;
		case '03': $h = "mar";
		break;
		case '02': $h = "feb";
		break;
		case '01': $h = "ene";
		break;
	}
	return $d .' de ' .$h;
}

/**
 * Formato de fecha (08 - 03)
 */
function Fecha8($fecha8) /* 08 - 03 */
{
	$a = date("j m", strtotime($fecha8));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];
	return $d .'-' .$e;
}

/**
 * Formato de fecha (08 mar)
 */
function Fecha9($fecha9) /* 08 mar */
{
	$a = date("j m", strtotime($fecha9));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];

	switch ($e)
	{
		case '12': $h = "dic";
		break;
		case '11': $h = "nov";
		break;
		case '10': $h = "oct";
		break;
		case '09': $h = "sep";
		break;
		case '08': $h = "ago";
		break;
		case '07': $h = "jul";
		break;
		case '06': $h = "jun";
		break;
		case '05': $h = "may";
		break;
		case '04': $h = "abr";
		break;
		case '03': $h = "mar";
		break;
		case '02': $h = "feb";
		break;
		case '01': $h = "ene";
		break;
	}
	return $d .' ' .$h;
}

/**
 * Formato de fecha (marzo)
 */
function Fecha10($fecha10) /* marzo */
{
	$a = date("m", strtotime($fecha10));
	switch ($a)
	{
		case '12': $h = "Diciembre";
		break;
		case '11': $h = "Noviembre";
		break;
		case '10': $h = "Octubre";
		break;
		case '09': $h = "Septiembre";
		break;
		case '08': $h = "Agosto";
		break;
		case '07': $h = "Julio";
		break;
		case '06': $h = "Junio";
		break;
		case '05': $h = "Mayo";
		break;
		case '04': $h = "Abril";
		break;
		case '03': $h = "Marzo";
		break;
		case '02': $h = "Febrero";
		break;
		case '01': $h = "Enero";
		break;
	}
	return $h;
}

/**
 * Formato de fecha (Lunes 08)
 */
function Fecha11($fecha11) /* Lunes 08 */
{
	$a = date("l j", strtotime($fecha11));
	$b = explode(" ", $a);
	$c = $b[0];
	$d = $b[1];

	switch ($c)
	{
		case 'Monday': $g = "Lunes";
		break;
		case 'Tuesday': $g = "Martes";
		break;
		case 'Wednesday': $g = "Miercoles";
		break;
		case 'Thursday': $g = "Jueves";
		break;
		case 'Friday': $g = "Viernes";
		break;
		case 'Saturday': $g = "Sabado";
		break;
		case 'Sunday': $g = "Domingo";
		break;
	}
	return $g .' ' .$d ;
}

/**
 * Formato de fecha (08 de mar, 09:24:32)
 */
function Fecha12($fecha12) /* 08 de mar, 09:24:32 */
{
	$z = explode(" ", $fecha12);
	$y = $z[1];

	$a = date("j m", strtotime($fecha12));
	$b = explode(" ", $a);
	$d = $b[0];
	$e = $b[1];

	switch ($e)
	{
		case '12': $h = "Dic";
		break;
		case '11': $h = "Nov";
		break;
		case '10': $h = "Oct";
		break;
		case '09': $h = "Sep";
		break;
		case '08': $h = "Ago";
		break;
		case '07': $h = "Jul";
		break;
		case '06': $h = "Jun";
		break;
		case '05': $h = "May";
		break;
		case '04': $h = "Abr";
		break;
		case '03': $h = "Mar";
		break;
		case '02': $h = "Feb";
		break;
		case '01': $h = "Ene";
		break;
	}
	return $d .' de ' .$h .', ' .$y;
}

/**
 * Formato de fecha (09:24)
 */
function Fecha13($fecha13) /* 09:24 */
{
	$z = explode(" ", $fecha13);
	$x = $z[1];
	$y= substr($x, 0, -3);

	return $y;
}
?>