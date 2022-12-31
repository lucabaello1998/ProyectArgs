<?php include("../db.php"); ?>

<?php
  $mes = date ('y-m', strtotime('-0 month'));
?>

<?php	
// $quien = 'planos.dd@gmail.com';
$titulo = "Asistencia de ATC y ayudantes";

$body = "<html><body>";
$body .="<p>";
$body .="<h3>Asistencia</h3>";
$body .="</p>";
	$body .="<table>";  /////tabla estructura
			$body .="<td>"; //////segunda columna
				$body .="<table style='margin: 0 auto'>"; /////inicio de tabla herramientas
				$body .="<table border='1' cellspacing='0'>";
				$body .="<tr bgcolor='#87CEFA'>"; //////color encabezado
					$body .="<th>Tecnico</th>";
					$body .="<th>Fecha</th>";
					$body .="<th>Dia</th>";
				$body .="</tr>";      //////fin encabezado  
						
						$query = "SELECT * FROM asistenciaatc WHERE fecha like '%$mes%' ORDER BY fecha desc";
						$result = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result)) {
						$dia = $row['dia'];
						switch ($dia)
						{
						case 'Presente': $color = "<td bgcolor='#9be8a0'>";
						break;
						case 'Ausente': $color = "<td bgcolor='#f67272'>";
						break;
						case 'Justificado': $color = "<td bgcolor='#FFEE58'>";
						break;
						}
				
				$body .="<tr>"; /////color de celdas
				///// text izq
				$body .= $color .$row['nombre'] ."</td>";
				$body .= $color .$row['fecha'] ."</td>";
				$body .= $color .$dia ."</td>"; }
				$body .="</tr>"; 
				$body .="</table>";  /////fin de tabla herramientas
			$body .="</td>"; //////fin segunda columna
	$body .="</table>"; //////fin tabla principal estructura
$body .="</body></html>";
 

	// $headers= 'From: Deposito Web Argentseal <despachoargentseal@gmail.com>' . "\r\n".
	// 		  'Reply-To: despachoargentseal@gmail.com' . "\r\n".	
	// 		  'Content-type: text/html; charset=utf-8'. "\r\n".	  
	// 		  'X-Mailer: PHP/' .phpversion();
	// mail($quien, $titulo, $body, $headers);
	echo $body;
?>

	