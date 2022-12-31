<?php include("../db.php"); ?>

<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectec' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectec= $row['tectec'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayu' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayu= $row['ayuayu'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayusur' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Sur' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayusur= $row['ayuayusur'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectecsur' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Sur' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectecsur= $row['tectecsur'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayunorte' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Norte' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayunorte= $row['ayuayunorte'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tectecnorte' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Norte' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tectecnorte= $row['tectecnorte'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'ayuayucaba' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='CABA' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $ayuayucaba= $row['ayuayucaba'];} 
?>
<?php
  $query1 = "SELECT COUNT(tecnico) as 'tecteccaba' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='CABA' ORDER BY tecnico asc";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks)) {             
  $tecteccaba= $row['tecteccaba'];} 
?>

<?php
$name = $_POST['name'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$msg = $_POST['msg'];
	
$quien = 'planos.dd@gmail.com, despachoargentseal@gmail.com, matiasnalancay@gmail.com, coordinacionargentseal@gmail.com ';
$titulo = "Lista de compras";

$body = "<html><body>";

$body .="<p>";
$body .="<h3>Deposito Sur:</h3>";
$tecnicosur=$tectecsur + $tecteccaba;
$ayudantesur=$ayuayusur + $ayuayucaba;
$body .="<h4>Tecnicos: " .$tecnicosur ."; Ayudantes: " .$ayudantesur ."</h4>";
$body .="</p>";
$body .="<p>";
$body .="<h3>Deposito Norte:</h3>";
$body .="<h4>Tecnicos: " .$tectecnorte ."; Ayudantes: " .$ayuayunorte ."</h4>";
$body .="</p>";
	$body .="<table>";  /////tabla estructura
			$body .="<td>"; //////segunda columna
				$body .="<table style='margin: 0 auto'>"; /////inicio de tabla herramientas
				$body .="<table border='1' cellspacing='0'>";
				$body .="<tr bgcolor='#87CEFA'>"; //////color encabezado
					$body .="<th>Herramienta</th>";
					$body .="<th>Falta</th>";
				$body .="</tr>";      //////fin encabezado  

						$tectectec=$ayuayusur+ $ayuayunorte + $ayuayucaba+2;

						$query = "SELECT SUM(cantidad) as 'todos', (cantec*'$tectectec') as 'restos', material, cantec, centro FROM materiales WHERE 'todos' < (cantec*'$tectectec') AND 'restos' >= 0 GROUP BY material";
						$result_tasks = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result_tasks)) {
							$tototoa = $row['todos'];
							$tatataa = $row['cantec']*$tectectec;
							if($tototoa >= $tatataa) {$faltaa=0;}else{$faltaa=$tatataa-$tototoa;} 
				$body .="<tr>"; /////color de celdas
				if($faltaa < 1) {$colore= "<td bgcolor='#90EE90'>";}
				if($faltaa > 0 && $faltaa < 3) {$colore= "<td bgcolor='#FF6347'>";}
				if($faltaa > 2) {$colore= "<td bgcolor='#F0E68C'>";}
				///// text izq
				if($faltaa < 1) {$colores= "<td align='center' bgcolor='#90EE90'>";}
				if($faltaa > 0 && $faltaa < 3) {$colores= "<td align='center' bgcolor='#FF6347'>";}
				if($faltaa > 2) {$colores= "<td align='center' bgcolor='#F0E68C'>";}
					$body .= $colore. $row['material'] ."</td>";
					//$body .="<td>". $row['material'] . "</td>";
										
					$body .= $colores .$faltaa ."</td>";
				$body .="</tr>";  ////fin de celdas
				}
				$body .="</table>";  /////fin de tabla herramientas
			$body .="</td>"; //////fin segunda columna



			$body .="<td>"; ////primera columna
				$body .="<table style='margin: 0 auto'>";
				$body .="<table border='1' cellspacing='0'>";
				$body .="<tr bgcolor='#87CEFA'>";  ////color encabezado
					$body .="<th>Indumentaria</th>";
					$body .="<th>Talle</th>";
					$body .="<th>Falta</th>";
				$body .="</tr >";  /////fin encabezado
						$query = "SELECT SUM(cantidad) as 'todo', indumentaria, cantec, centro, talle FROM indumentaria WHERE 'todo' < (cantec*'$tectectec') AND 'todo' >= 0 GROUP BY indumentaria, talle";
						$result_tasks = mysqli_query($conn, $query);
						while($row = mysqli_fetch_assoc($result_tasks)) {
				$tototo = $row['todo'];
				$tatata = $row['cantec']*$tectectec;
				if($tototo >= $tatata) {$falta=0;}else{$falta=$tatata-$tototo;} 
				$body .="<tr>"; /////color de celdas
				if($falta < 1) {$color= "<td align='center' bgcolor='#90EE90'>";}
				if($falta > 0 && $falta < 3) {$color= "<td align='center' bgcolor='#FF6347'>";}
				if($falta > 2) {$color= "<td align='center' bgcolor='#F0E68C'>";}
				////text izq
				if($falta < 1) {$colors= "<td bgcolor='#90EE90'>";}
				if($falta > 0 && $falta < 3) {$colors= "<td bgcolor='#FF6347'>";}
				if($falta > 2) {$colors= "<td bgcolor='#F0E68C'>";}
					$body .= $colors. $row['indumentaria'] ."</td>";
					$body .= $color. $row['talle'] . "</td>";										
					$body .= $color.  $falta . "</td>";
				$body .="</tr>"; ///fin celdas
				}
				$body .="</table>"; /////fin tabla indumentaria
			$body .="</td>"; /////fin primera columna
	$body .="</table>"; //////fin tabla principal estructura
$body .="</body></html>";
 

	$headers= 'From: Deposito Web Argentseal <despachoargentseal@gmail.com>' . "\r\n".
			  'Reply-To: despachoargentseal@gmail.com' . "\r\n".	
			  'Content-type: text/html; charset=utf-8'. "\r\n".	  
			  'X-Mailer: PHP/' .phpversion();
	mail($quien, $titulo, $body, $headers);
?>

	