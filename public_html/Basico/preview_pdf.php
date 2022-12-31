<?php include("../db.php"); ?> 
<?php 
if(isset($_POST['crear'])){
	$tecnico = $_POST['tecnico'];
	$mes = $_POST['mes'];
}
?>
<div id="cabecera">	
	<img align="center" src="../Image/logo.png" width="160" height="80" align="center">
	<h3 align="center">Produccion de <?php echo $tecnico ?></h3>
</div>

<div border="0.1">
<h4 align="center">Tareas realizadas en <?php switch ($mes)
{
case '2021-12': echo "Diciembre";
break;
case '2021-11': echo "Noviembre";
break;
case '2021-10': echo "Octubre";
break;
case '2022-01': echo "Enero";
break;
case '2022-02': echo "Febrero";
break;
case '2022-03': echo "Marzo";
break;
case '2022-04': echo "Abril";
break;
case '2022-05': echo "Mayo";
break;
case '2022-06': echo "Junio";
break;
case '2022-07': echo "Julio";
break;
case '2022-08': echo "Agosto";
break;
case '2022-09': echo "Septiembre";
break;
case '2022-10': echo "Octubre";
break;
case '2022-11': echo "Noviembre";
break;
case '2022-12': echo "Diciembre";
break;
} ?></h4>
	<table border="1" cellspacing="-1" align="center">	
		<thead>
			<tr bgcolor="#f6d9bc" align="center">			
				<th width=70>Fecha</th>		
				<th width=40>Doble play</th>
				<th width=40>Triple play</th>
				<th width=40>Set to Box</th>
				<th width=70>Mudanzas internas</th>
				<th width=100>Tareas(2play y 3play)</th>
				<th width=40>Bajas</th>				
				<th width=65>Garantias Tecnico</th>			
				<th width=75>Garantias compañero</th>
				<th width=70>Reclamos</th>			
				<th width=40>Zona</th>			         
			</tr>
		</thead>
		<tbody align="center">
			<?php
				$result_tasks = mysqli_query($conn, "SELECT * FROM produccion WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha asc");    
				while($row = mysqli_fetch_assoc($result_tasks))
				{
				$fecha_resumida  =	Fecha7($row['fecha']);
			?>
				<tr>				
					<?php switch ($row['dia']){
						case 'Normal': echo "<td bgcolor='#ffffff'>$fecha_resumida</td>";
						break;
						case 'Lluvia': echo "<td bgcolor='#ffffff'>$fecha_resumida</td>";
						break;
						case 'Medio dia': echo "<td bgcolor='#ffffff'>$fecha_resumida</td>";
						break;
						case 'Vacaciones': echo "<td bgcolor='#ffffff'>$fecha_resumida</td>";
						break;
						case 'Sabado': echo "<td bgcolor='#005b96'>$fecha_resumida</td>";
						break;
						case 'Feriado': echo "<td bgcolor='#008080'>$fecha_resumida</td>";
						break;
						case 'Ausente': echo "<td bgcolor='#fa6b6b'>$fecha_resumida</td>";
						break;

					} ?>		
					<?php switch ($row['dosplay']){
						case '0': echo "<td bgcolor='#ffffff'>$row[dosplay]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[dosplay]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[dosplay]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[dosplay]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[dosplay]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[dosplay]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[dosplay]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[dosplay]</td>";
						break;
					} ?>
					<?php switch ($row['tresplay']){
						case '0': echo "<td bgcolor='#ffffff'>$row[tresplay]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[tresplay]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[tresplay]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[tresplay]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[tresplay]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[tresplay]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[tresplay]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[tresplay]</td>";
						break;
					} ?>
					<?php switch ($row['stb']){
						case '0': echo "<td bgcolor='#ffffff'>$row[stb]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[stb]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[stb]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[stb]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[stb]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[stb]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[stb]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[stb]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[stb]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[stb]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[stb]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[stb]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[stb]</td>";
						break;
						case '13': echo "<td bgcolor='#2ca834'>$row[stb]</td>";
						break;
						case '14': echo "<td bgcolor='#2ca834'>$row[stb]</td>";
						break;
					} ?>
					<?php switch ($row['mudanza']){
						case '0': echo "<td bgcolor='#ffffff'>$row[mudanza]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[mudanza]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[mudanza]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[mudanza]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[mudanza]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[mudanza]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[mudanza]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[mudanza]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[mudanza]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[mudanza]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[mudanza]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[mudanza]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[mudanza]</td>";
						break;
					} ?>
					<?php switch ($row['tcumplida']){
						case '0': echo "<td bgcolor='#ffffff'>$row[tcumplida]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[tcumplida]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[tcumplida]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[tcumplida]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[tcumplida]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[tcumplida]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[tcumplida]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[tcumplida]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[tcumplida]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[tcumplida]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[tcumplida]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[tcumplida]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[tcumplida]</td>";
						break;
					} ?>
					<?php switch ($row['bajas']){
						case '0': echo "<td bgcolor='#ffffff'>$row[bajas]</td>";
						break;
						case '1': echo "<td bgcolor='#fcd0d0'>$row[bajas]</td>";
						break;
						case '2': echo "<td bgcolor='#fab8b8'>$row[bajas]</td>";
						break;
						case '3': echo "<td bgcolor='#f9a1a1'>$row[bajas]</td>";
						break;
						case '4': echo "<td bgcolor='#f78a8a'>$row[bajas]</td>";
						break;
						case '5': echo "<td bgcolor='#f67272'>$row[bajas]</td>";
						break;
						case '6': echo "<td bgcolor='#f45b5b'>$row[bajas]</td>";
						break;
						case '7': echo "<td bgcolor='#f34343'>$row[bajas]</td>";
						break;
						case '8': echo "<td bgcolor='#f12c2c'>$row[bajas]</td>";
						break;
						case '9': echo "<td bgcolor='#f01515'>$row[bajas]</td>";
						break;
						case '10': echo "<td bgcolor='#d81212'>$row[bajas]</td>";
						break;
						case '11': echo "<td bgcolor='#c01010'>$row[bajas]</td>";
						break;
						case '12': echo "<td bgcolor='#a80e0e'>$row[bajas]</td>";
						break;
					} ?>					
					<?php switch ($row['garantec']){
						case '0': echo "<td bgcolor='#ffffff'>$row[garantec]</td>";
						break;
						case '1': echo "<td bgcolor='#fcd0d0'>$row[garantec]</td>";
						break;
						case '2': echo "<td bgcolor='#fab8b8'>$row[garantec]</td>";
						break;
						case '3': echo "<td bgcolor='#f9a1a1'>$row[garantec]</td>";
						break;
						case '4': echo "<td bgcolor='#f78a8a'>$row[garantec]</td>";
						break;
						case '5': echo "<td bgcolor='#f67272'>$row[garantec]</td>";
						break;
						case '6': echo "<td bgcolor='#f45b5b'>$row[garantec]</td>";
						break;
						case '7': echo "<td bgcolor='#f34343'>$row[garantec]</td>";
						break;
						case '8': echo "<td bgcolor='#f12c2c'>$row[garantec]</td>";
						break;
						case '9': echo "<td bgcolor='#f01515'>$row[garantec]</td>";
						break;
						case '10': echo "<td bgcolor='#d81212'>$row[garantec]</td>";
						break;
						case '11': echo "<td bgcolor='#c01010'>$row[garantec]</td>";
						break;
						case '12': echo "<td bgcolor='#a80e0e'>$row[garantec]</td>";
						break;
					} ?>				
					<?php switch ($row['garancom']){
						case '0': echo "<td bgcolor='#ffffff'>$row[garancom]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[garancom]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[garancom]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[garancom]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[garancom]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[garancom]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[garancom]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[garancom]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[garancom]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[garancom]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[garancom]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[garancom]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[garancom]</td>";
						break;
					} ?>
					<?php switch ($row['reclamo']){
						case '0': echo "<td bgcolor='#ffffff'>$row[reclamo]</td>";
						break;
						case '1': echo "<td bgcolor='#fcd0d0'>$row[reclamo]</td>";
						break;
						case '2': echo "<td bgcolor='#fab8b8'>$row[reclamo]</td>";
						break;
						case '3': echo "<td bgcolor='#f9a1a1'>$row[reclamo]</td>";
						break;
						case '4': echo "<td bgcolor='#f78a8a'>$row[reclamo]</td>";
						break;
						case '5': echo "<td bgcolor='#f67272'>$row[reclamo]</td>";
						break;
						case '6': echo "<td bgcolor='#f45b5b'>$row[reclamo]</td>";
						break;
						case '7': echo "<td bgcolor='#f34343'>$row[reclamo]</td>";
						break;
						case '8': echo "<td bgcolor='#f12c2c'>$row[reclamo]</td>";
						break;
						case '9': echo "<td bgcolor='#f01515'>$row[reclamo]</td>";
						break;
						case '10': echo "<td bgcolor='#d81212'>$row[reclamo]</td>";
						break;
						case '11': echo "<td bgcolor='#c01010'>$row[reclamo]</td>";
						break;
						case '12': echo "<td bgcolor='#a80e0e'>$row[reclamo]</td>";
						break;
					} ?>			
					<?php switch ($row['zona']){
						case 'CABA': echo "<td bgcolor='#dec5da'>$row[zona]</td>";
						break;
						case 'Lomas de Zamora': echo "<td bgcolor='#c7eae3'>LZ</td>";
						break;
						case 'Jose Leon Suarez': echo "<td bgcolor='#e5ffff'>JLS</td>";
						break;
            case 'San Nicolas': echo "<td bgcolor='#dec5da'>SN</td>";
						break;
						case '-': echo "<td bgcolor='#ffffff'>$row[zona]</td>";
						break;					
					} ?>

				</tr>
			<?php } ?>
		</tbody>
	</table>
	
<!-- TOTAL SABFE-->
<?php $query= "SELECT SUM(tcumplida) as 'sab' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico' AND dia='Sabado'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$sab= $row['sab'];}?>

<?php $query= "SELECT SUM(tcumplida) as 'feb' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico' AND dia='Feriado'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$feb= $row['feb'];}?>
<?php $sabfer = $sab; ?>
<!-- TOTAL SABFE-->


<!-- TOTAL DOSPLAY-->
<?php $query= "SELECT SUM(dosplay) as 'tododos' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$tododos= $row['tododos'];}?>
<!-- TOTAL DOSPLAY-->

<!-- TOTAL TRESPLAY-->
<?php $query= "SELECT SUM(tresplay) as 'todotres' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todotres= $row['todotres'];}?>
<!-- TOTAL TRESPLAY-->

<!-- SET TO BOX-->
<?php $query= "SELECT SUM(stb) as 'todostb' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todostb= $row['todostb'];}?>
<!-- SET TO BOX-->

<!-- TOTAL MUDANZA-->
<?php $query= "SELECT SUM(mudanza) as 'todomud' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomud= $row['todomud'];}?>
<!-- TOTAL MUDANZA-->

<!-- TOTAL TAREAS-->
<?php $query= "SELECT SUM(tcumplida) as 'todotodo' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todotodo= $row['todotodo'];}?>
<!-- TOTAL TAREAS-->

<!-- TOTAL TAREAS MTTO-->
<?php $query= "SELECT SUM(tareasmtto) as 'todomtto' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto= $row['todomtto'];}?>
<!-- TOTAL TAREAS MTTO-->

<!-- TOTAL BAJAS-->
<?php $query= "SELECT SUM(bajas) as 'todobaja' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobaja= $row['todobaja'];}?>
<!-- TOTAL BAJAS-->

<!-- TOTAL BAJAS TEC-->
<?php $query= "SELECT SUM(bajatec) as 'todobajatec' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobajatec= $row['todobajatec'];}?>
<!-- TOTAL BAJAS TEC-->

<!-- TOTAL GARANTIA TEC-->
<?php $query= "SELECT SUM(garantec) as 'todogarantec' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todogarantec= $row['todogarantec'];}?>
<!-- TOTAL GARANTIA TEC-->

<!-- TOTAL GARANTIA TEC-->
<?php $query= "SELECT COUNT(intervencion) as 'todogaranint' FROM garantias WHERE fecharep like '%$mes%'  AND tecnico='$tecnico' AND tecrep='$tecnico' AND intervencion='NO' AND repa='SI'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todogaranint= $row['todogaranint'];}?>
<!-- TOTAL GARANTIA TEC-->

<!-- TOTAL GARANTIA COM-->
<?php $query= "SELECT SUM(garancom) as 'todogarancom' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todogarancom= $row['todogarancom'];}?>
<!-- TOTAL GARANTIA COM-->

<!-- TOTAL RECLAMOS-->
<?php $query= "SELECT SUM(reclamo) as 'todoreclamos' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todoreclamos= $row['todoreclamos'];}?>
<!-- TOTAL RECLAMOS-->

	<table border="1" cellspacing="-1" align="center">
	
	<tbody>
		<tr bgcolor="#a3c4e8" align="center">
			<th width=70>TOTAL</th>		
			<th width=40><?php echo $tododos ?></th>
			<th width=40><?php echo $todotres ?></th>
			<th width=40><?php echo $todostb ?></th>
			<th width=70><?php echo $todomud ?></th>
			<th width=100><?php echo $todotodo ?></th>			
			<th width=40><?php echo $todobaja ?></th>
			<th width=65><?php echo $todogarantec ?></th>			
			<th width=75><?php echo $todogarancom ?></th>
			<th width=70><?php echo $todoreclamos ?></th>			
			<th width=40>-</th>	
		</tr>
	</tbody>
</table>

<br>


<h4 align="center">
<?php $query= "SELECT SUM(bajatec + mtto_int + mtto_ext + baja_desmonte) as 'mtto' FROM produccion WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha desc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$mtto= $row['mtto'];
if ($mtto >= 1)
{
	?>
	<h4 align="center">Mantenimientos realizados</h4> 
	<table border="1" cellspacing="-1" align="center">	
		<thead>
			<tr bgcolor="#f6d9bc" align="center">			
				<th width=70>Fecha</th>		
				<th width=70>Baja tecnica</th>
				<th width=100>Baja con desmonte</th>
        <th width=70>Mtto Reacond</th>
				<th width=70>Mtto Interno</th>
				<th width=70>Mtto Externo</th>
				<th width=70>Total</th>							         
			</tr>
		</thead>
		<tbody align="center">
	
			<?php
				$query = "SELECT * FROM produccion WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND bajatec >= 1 OR tecnico='$tecnico' AND fecha like '%$mes%' AND baja_desmonte >= 1 OR tecnico='$tecnico' AND fecha like '%$mes%' AND mtto_reaco >= 1 OR tecnico='$tecnico' AND fecha like '%$mes%' AND mtto_int >= 1 OR tecnico='$tecnico' AND fecha like '%$mes%' AND mtto_ext >= 1 ORDER BY fecha asc";
				$result_tasks = mysqli_query($conn, $query);    
				while($row = mysqli_fetch_assoc($result_tasks))
				{
					$fecha_resumidaa  =	Fecha7($row['fecha']);
			?>
				<tr>				
					<?php switch ($row['dia']){
						case 'Normal': echo "<td bgcolor='#ffffff'>$fecha_resumidaa</td>";
						break;
						case 'Lluvia': echo "<td bgcolor='#ffffff'>$fecha_resumidaa</td>";
						break;
						case 'Medio dia': echo "<td bgcolor='#ffffff'>$fecha_resumidaa</td>";
						break;
						case 'Vacaciones': echo "<td bgcolor='#ffffff'>$fecha_resumidaa</td>";
						break;
						case 'Sabado': echo "<td bgcolor='#005b96'>$fecha_resumidaa</td>";
						break;
						case 'Feriado': echo "<td bgcolor='#008080'>$fecha_resumidaa</td>";
						break;
						case 'Ausente': echo "<td bgcolor='#fa6b6b'>$fecha_resumidaa</td>";
						break;

					} ?>		
					<?php switch ($row['bajatec']){
						case '0': echo "<td bgcolor='#ffffff'>$row[bajatec]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[bajatec]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[bajatec]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[bajatec]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[bajatec]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[bajatec]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[bajatec]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[bajatec]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[bajatec]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[bajatec]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[bajatec]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[bajatec]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[bajatec]</td>";
						break;
					} ?>
					<?php switch ($row['baja_desmonte']){
						case '0': echo "<td bgcolor='#ffffff'>$row[baja_desmonte]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[baja_desmonte]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[baja_desmonte]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[baja_desmonte]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[baja_desmonte]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[baja_desmonte]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[baja_desmonte]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[baja_desmonte]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[baja_desmonte]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[baja_desmonte]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[baja_desmonte]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[baja_desmonte]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[baja_desmonte]</td>";
						break;
					} ?>
          <?php switch ($row['mtto_reaco']){
						case '0': echo "<td bgcolor='#ffffff'>$row[mtto_reaco]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[mtto_reaco]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[mtto_reaco]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[mtto_reaco]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[mtto_reaco]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[mtto_reaco]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[mtto_reaco]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[mtto_reaco]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[mtto_reaco]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[mtto_reaco]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[mtto_reaco]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[mtto_reaco]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[mtto_reaco]</td>";
						break;
					} ?>
					<?php switch ($row['mtto_int']){
						case '0': echo "<td bgcolor='#ffffff'>$row[mtto_int]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[mtto_int]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[mtto_int]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[mtto_int]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[mtto_int]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[mtto_int]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[mtto_int]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[mtto_int]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[mtto_int]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[mtto_int]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[mtto_int]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[mtto_int]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[mtto_int]</td>";
						break;
					} ?>
					<?php switch ($row['mtto_ext']){
						case '0': echo "<td bgcolor='#ffffff'>$row[mtto_ext]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[mtto_ext]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[mtto_ext]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[mtto_ext]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[mtto_ext]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[mtto_ext]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[mtto_ext]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[mtto_ext]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[mtto_ext]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[mtto_ext]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[mtto_ext]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[mtto_ext]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[mtto_ext]</td>";
						break;
					} ?>
					<?php switch ($row['tareasmtto']){
						case '0': echo "<td bgcolor='#ffffff'>$row[tareasmtto]</td>";
						break;
						case '1': echo "<td bgcolor='#ebfaec'>$row[tareasmtto]</td>";
						break;
						case '2': echo "<td bgcolor='#d7f6d9'>$row[tareasmtto]</td>";
						break;
						case '3': echo "<td bgcolor='#c3f1c6'>$row[tareasmtto]</td>";
						break;
						case '4': echo "<td bgcolor='#afedb3'>$row[tareasmtto]</td>";
						break;
						case '5': echo "<td bgcolor='#9be8a0'>$row[tareasmtto]</td>";
						break;
						case '6': echo "<td bgcolor='#87e48d'>$row[tareasmtto]</td>";
						break;
						case '7': echo "<td bgcolor='#73df7a'>$row[tareasmtto]</td>";
						break;
						case '8': echo "<td bgcolor='#5edb67'>$row[tareasmtto]</td>";
						break;
						case '9': echo "<td bgcolor='#4bd654'>$row[tareasmtto]</td>";
						break;
						case '10': echo "<td bgcolor='#37d242'>$row[tareasmtto]</td>";
						break;
						case '11': echo "<td bgcolor='#31bd3b'>$row[tareasmtto]</td>";
						break;
						case '12': echo "<td bgcolor='#2ca834'>$row[tareasmtto]</td>";
						break;
					} ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>

<!-- TOTAL BAJAS TEC-->
<?php $query= "SELECT SUM(bajatec) as 'todobajatec' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobajatec= $row['todobajatec'];}?>
<!-- TOTAL BAJAS TEC-->

<!-- TOTAL BAJA DESMONTE-->
<?php $query= "SELECT SUM(baja_desmonte) as 'todobajadesm' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobajadesm= $row['todobajadesm'];}?>
<!-- TOTAL BAJA DESMONTE-->

<!-- TOTAL GMTTO INT-->
<?php $query= "SELECT SUM(mtto_reaco) as 'todomtto_reaco' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto_reaco= $row['todomtto_reaco'];}?>
<!-- TOTAL MTTO INT-->

<!-- TOTAL GMTTO INT-->
<?php $query= "SELECT SUM(mtto_int) as 'todomtto_int' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto_int= $row['todomtto_int'];}?>
<!-- TOTAL MTTO INT-->

<!-- TOTAL MTTO EXT-->
<?php $query= "SELECT SUM(mtto_ext) as 'todomtto_ext' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto_ext= $row['todomtto_ext'];}?>
<!-- TOTAL MTTO EXT-->

<!-- TOTAL MTTO SAB-->
<?php $query= "SELECT SUM(tareasmtto) as 'todoms' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico' AND dia='Sabado'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto_sab= $row['todoms'];}?>
<!-- TOTAL MTTO SAB-->

<!-- TOTAL MTTO FER-->
<?php $query= "SELECT SUM(tareasmtto) as 'todomf' FROM produccion WHERE fecha like '%$mes%' AND tecnico='$tecnico' AND dia='Feriado'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todomtto_fer= $row['todomf'];}?>
<!-- TOTAL MTTO FER-->
	<table border="1" cellspacing="-1" align="center">
	
	<tbody>
		<tr bgcolor="#a3c4e8" align="center">
			<th width=70>TOTAL</th>		
			<th width=70><?php echo $todobajatec ?></th>
			<th width=100><?php echo $todobajadesm ?></th>
      <th width=70><?php echo $todomtto_reaco ?></th>      
			<th width=70><?php echo $todomtto_int ?></th>
			<th width=70><?php echo $todomtto_ext ?></th>
			<th width=70><?php echo $todomtto ?></th>			
		</tr>
	</tbody>
</table>

	<?php ;
}
else
{
	echo "";
}}?>
</h4>

	

<br>

<h4 align="center">
<?php $query= "SELECT COUNT(tecnico) as 'abc' FROM garantias WHERE tecnico='$tecnico' AND fecharep like '%$mes%' ORDER BY fecharep desc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$abc= $row['abc'];
if ($abc >= 1)
{
	echo "Garantias";
}
else
{
	echo "";
}}?>
</h4>

<table border="1" cellspacing="-1" align="center">
  <thead>
    <tr bgcolor="#fbfa84" align="center">
      <th width=80>Fecha intsalacion</th>
      <th width=80>Fecha reparacion</th>
      <th width=90>Reparado por</th>
      <th width=60>OT</th>
      <th width=80>Justificado</th>
      <th>Comentario</th>
    </tr>
  </thead>
  <tbody>
    <?php
			$result_tasks = mysqli_query($conn, "SELECT * FROM garantias WHERE tecnico='$tecnico' AND fecharep like '%$mes%' ORDER BY fecharep asc");    
			while($row = mysqli_fetch_assoc($result_tasks))
			{
				$fechaint_resumidaaa = Fecha7($row['fechaint']);
				$fecharep_resumidaaa = Fecha7($row['fecharep']);
		?>
      <tr bgcolor="#fdfdcd">     
        <td align=center><?php echo $fechaint_resumidaaa; ?></td>          
        <td align=center><?php echo $fecharep_resumidaaa; ?></td>
        <td align=center><?php echo $row['tecrep']; ?></td>
        <td align=center><?php echo $row['ot']; ?></td>
        <td align=center><?php echo $row['justificado']; ?></td>
        <td width=320><?php echo $row['coment']; ?></td>                           
      </tr>
    <?php } ?>
  </tbody>
</table>
<br>

<h4 align="center">
<?php $query= "SELECT COUNT(tecnico) as 'des' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha desc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$des= $row['des'];
if ($des >= 1)
{
	echo "Penalizaciones";
}
else
{
	echo "";
}}?>
</h4>

<table border="1" cellspacing="-1" align="center">
  <thead>
    <tr bgcolor="#fa6b6b" align="center">
      <th width=80>Fecha</th>
      <th width=60>OT</th>
      <th width=110>Falla</th>
      <th>Observaciones</th>
			<th>Monto</th>
    </tr>
  </thead>
  <tbody>
    <?php
			$result_tasks = mysqli_query($conn, "SELECT * FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha desc");    
			while($row = mysqli_fetch_assoc($result_tasks))
			{
				$fecha_resumidaaaa = Fecha7($row['fecha']);
		?>
      <tr bgcolor="#f3d1d8">               
        <td align=center><?php echo $fecha_resumidaaaa; ?></td>
        <td align=center><?php echo $row['ot']; ?></td>
        <td align=center><?php echo $row['falla']; ?></td>
        <td width=450><?php echo $row['obs']; ?></td>
				<td align=center width=30><?php
				switch ($row['falla'])
				{
					case 'Falta de EPP': echo '60%';
					break;
					case 'Instalacion': echo '50%';
					break;
					case 'Calidad': echo '25%';
					break;
					case 'Indumentaria': echo '25%';
					break;
					case 'Higiene': echo '25%';
					break;
					case 'TOA': echo '25%';
					break;
					case 'Falta de planillas': echo '100%';
					break;
					case 'Baja mal cerrada': echo '100%';
					break;
					case 'Descuento total': echo '100%';
					break;
					case 'Otro': echo '$' .$row['monto'];
					break;
				}
				 ?></td>                          
      </tr>
    <?php } ?>
  </tbody>
</table>
<br>








</div>


<?php
 $query = "SELECT * FROM precios";
$result_tasks = mysqli_query($conn, $query);    
while($row = mysqli_fetch_assoc($result_tasks)) {

$doble = $row['dosplay'];
$tripley = $row['tresplay'];
$stb = $row['stb'];
$mudint = $row['mudainter'];
$baj = $row['bajas'];
$garsi = $row['garaninterv'];
$garga = $row['garanjus'];
$garc = $row['garancomp'];
$sabfe = $row['sab'];
$fe = $row['fer'];
}
?>

<br>
<br>
<div border="0.1">
<h4 align="center">Precios</h4>
<table border="1" cellspacing="-1" align="center">
  <thead>
    <tr bgcolor="#a3c4e8" align="center">
    <th width=35 bgcolor="#005b96" width=60>Sab</th>                                  
      <th width=50>Doble play</th>
      <th width=50>Triple play</th>
      <th width=50>Set to Box</th>
      <th width=70>Equipos mud int</th>                  
      <th width=50>Bajas</th>      
      <th width=90>Garantias Justificadas</th>
      <th width=90>Garantia sin intervencion</th>
      <th width=90>Garantias de compañero</th>                     
      <th width=35>Sab</th>
      <th width=35>Fer</th>                             
    </tr>
  </thead>
  <tbody>            
      <tr bgcolor="#d1e1f3" align="center">   
      <td width=35 bgcolor="#008080">Fer</td>                                 
        <td>$<?php echo $doble ?></td>
        <td>$<?php echo $tripley ?></td>
        <td>$<?php echo $stb ?></td>
        <td>$<?php echo $mudint ?></td>
        <td>$<?php echo $baj ?></td>        
        <td>$<?php echo $garga ?></td>
        <td>$<?php echo $garsi ?></td>
        <td>$<?php echo $garc ?></td>                    
        <td>$<?php echo $sabfe ?></td>
        <td>$<?php echo $fe ?></td>                   
      </tr>                       
  </tbody>
</table> 
<br>
<table border="1" cellspacing="-1" align="center">
	<thead>
		<tr bgcolor="#fa6b6b" align="center">			 
			<th width=70>Reclamos</th>  
			<th width=80>Falta de planilla</th>
      <th width=40>EPP</th>
      <th width=80>Instalacion</th>
      <th width=50>Calidad</th>
      <th width=90>Indumentaria</th>
      <th width=60>Higiene</th>
      <th width=40>TOA</th>
      <th width=80>Descuento total</th>
      <th width=80>Baja mal cerrada</th>            
		</tr>
	</thead>
	<tbody>
		<tr bgcolor="#f3d1d8" align="center">			
			<td>-$<?php echo $doble ?></td>
			<td>-$<?php echo $baj ?></td>
			<td>-%60</td>
			<td>-%50</td>
			<td>-%25</td>
			<td>-%25</td>
			<td>-%25</td>

			<td>-%25</td>
			<td>-$<?php echo $doble ?></td>
			<td>-$<?php echo $baj ?></td>
		</tr>
	</tbody>
</table>
<br>





<h4 align="center">
<?php $query= "SELECT SUM(bajatec + mtto_int + mtto_ext + baja_desmonte) as 'mtto' FROM produccion WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha desc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$mtto= $row['mtto'];
if ($mtto >= 1)
{
?>
<?php 
$query= "SELECT * FROM precios "; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) {

$bajte = $row['bajatec'];
$mtt_reaco_pre = $row['mttoreacond'];
$mtt_int_pre = $row['mttointer'];
$mtt_ext_pre = $row['mttoexter'];
$baja_desmonte_pre = $row['bajadesmont'];
$sabmtto = $row['sabmtto'];
$fermtto = $row['fermtto'];
}
?>
<h4 align="center">Mantenimiento</h4>
<table border="1" cellspacing="-1" align="center">
  <thead>
    <tr bgcolor="#a3c4e8" align="center">
      <th width=70>Baja Tecnica</th>
      <th width=100>Baja con desmonte</th>
      <th width=70>Mtto Reacond</th>
      <th width=70>Mtto Interno</th>
      <th width=70>Mtto Externo</th>
      <th width=70>Sab mtto</th>
      <th width=70>Fer mtto</th>
    </tr>
  </thead>
  <tbody>
      <tr bgcolor="#d1e1f3" align="center">         
        <td>$<?php echo $bajte ?></td>
        <td>$<?php echo $baja_desmonte_pre ?></td>
        <td>$<?php echo $mtt_reaco_pre ?></td>
        <td>$<?php echo $mtt_int_pre ?></td>                   
        <td>$<?php echo $mtt_ext_pre ?></td> 
        <td>$<?php echo $sabmtto ?></td>
        <td>$<?php echo $fermtto ?></td>                   
      </tr>   
  </tbody>
</table> <?php ;
}
else
{
	echo "";
}}?>
</h4>

<br>






</div>

<br>
<div border="0.1">

<!-----Garantias Justificada------->
<?php $query= "SELECT COUNT(justificado) as 'ju' FROM garantias WHERE tecnico='$tecnico' AND fecharep like '%$mes%' AND tecrep='$tecnico' AND justificado='SI'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$ju= $row['ju'];
} ?>
<!-----Garantias Justificada------->

<!-----Falta de Planillas------->
<?php $query= "SELECT COUNT(tecnico) as 'plani' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Falta de planillas'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$plani= $row['plani'];
} ?>
<!-----Falta de Planillas------->

<!-----Falta de EPP------->
<?php $query= "SELECT COUNT(tecnico) as 'epp' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Falta de EPP'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$epp= $row['epp'];
} ?>
<!-----Falta de EPP------->

<!-----Falta en Instalacion------->
<?php $query= "SELECT COUNT(tecnico) as 'inst' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Instalacion'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$inst= $row['inst'];
} ?>
<!-----Falta en Instalacion------->

<!-----Calidad------->
<?php $query= "SELECT COUNT(tecnico) as 'cali' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Calidad'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$cali= $row['cali'];
} ?>
<!-----Calidad------->

<!-----Indumentaria------->
<?php $query= "SELECT COUNT(tecnico) as 'indu' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Indumentaria'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$indu= $row['indu'];
} ?>
<!-----Indumentaria------->

<!-----Higiene------->
<?php $query= "SELECT COUNT(tecnico) as 'higi' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Higiene'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$higi= $row['higi'];
} ?>
<!-----Higiene------->

<!-----TOA------->
<?php $query= "SELECT COUNT(tecnico) as 'toa' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='TOA'";

$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$toa= $row['toa'];
} ?>
<!-----TOA------->

<!-----descuento total------->
<?php $query= "SELECT COUNT(tecnico) as 'desto' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Descuento total'";

$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$desto= $row['desto'];
} ?>
<!-----descuento total------->

<!-----descuento baja------->
<?php $query= "SELECT COUNT(tecnico) as 'baba' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND falla='Baja mal cerrada'";

$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$baba= $row['baba'];
} ?>
<!-----descuento baja------->

<!-----descuento otros------->
<?php $query= "SELECT SUM(monto) as 'monto_to' FROM descuentos WHERE tecnico='$tecnico' AND fecha like '%$mes%' AND monto > 0";

$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$monto_to= $row['monto_to'];
} ?>
<!-----descuento otros------->

<!-----descuento baja------->
<?php $query= "SELECT SUM(gasto) as 'babarecla' FROM reclamos WHERE tecnico='$tecnico' AND fechamail like '%$mes%'";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$precio_recla= $row['babarecla'];
} ?>
<!-----descuento baja------->

<?php
$query= "SELECT * FROM precios";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 

$precio_epp = $doble / 100 * $row['desepp'];
$precio_inst = $doble / 100 * $row['desinst'];
$precio_cali = $doble / 100 * $row['descalidad'];

$precio_indu = $doble / 100 * $row['descalidad'];
$precio_higi = $doble / 100 * $row['descalidad'];

$precio_toa = $doble / 100 * $row['destoa'];
$precio_plani = $row['desplani'];
$precio_desto = $row['destotal'];
$precio_baja = $row['desbaja'];
}
?>


<h4 align="center">Total</h4>
	<table border="1" cellspacing="-1" align="center">
	<thead>
		<tr bgcolor="#a3c4e8" align="center">				
			<th width=60>Doble play</th>
			<th width=60>Triple play</th>
			<th width=50>Set to Box</th>
			<th width=70>Mudanzas internas</th>			
			<th width=45>Bajas</th>				
			<th width=70>Garantias justificada</th>
			<th width=90>Garantia sin intervencion</th>				
			<th width=80>Garantias compañero</th>
			<th width=40>Sab</th>
			<th width=40>Fer</th>	
			<th width=100>Total produccion</th>			
		</tr>
	</thead>
	<tbody>
		<tr bgcolor="#d1e1f3" align="center">				
			<th>$<?php $tod= $tododos * $doble; echo $tod ?></th>
			<th>$<?php $tot= $todotres * $tripley; echo $tot ?></th>
			<th>$<?php $tostb= $todostb * $stb; echo $tostb ?></th>
			<th>$<?php $tomu= $todomud * $mudint; echo $tomu ?></th>			
			<th>$<?php $toba= $todobaja * $baj; echo $toba ?></th>			
			<th>$<?php $togaju= $ju * $garga; echo $togaju ?></th>
			<th>$<?php $tobat= $todogaranint * $garsi; echo $tobat ?></th>						
			<th>$<?php $togac= $todogarancom * $garc; echo $togac ?></th>
			<th>$<?php $tosf= $sabfer * $sabfe; echo $tosf ?></th>
			<th>$<?php $tof= $feb * $fe; echo $tof ?></th>
			<th>$<?php $tototal= $tod + $tot + $tostb + $tomu + $toba + $tobat + $togaju + $togac + $tosf + $tof; echo $tototal ?></th>				
		</tr>
	</tbody>
</table>

<br>

	<table border="1" cellspacing="-1" align="center">
	<thead>
		<tr bgcolor="#fa6b6b" align="center">				
			<th bgcolor="#fa6b6b" width=70>Reclamos</th>
			<th bgcolor="#fa6b6b" width=60>Planillas</th>	
			<th bgcolor="#fa6b6b" width=50>EPP</th>	
			<th bgcolor="#fa6b6b" width=50>Inst</th>
			<th bgcolor="#fa6b6b" width=60>Calidad</th>
			<th bgcolor="#fa6b6b" width=50>Indum</th>
			<th bgcolor="#fa6b6b" width=60>Higiene</th>
			<th bgcolor="#fa6b6b" width=50>TOA</th>	
			<th bgcolor="#fa6b6b" width=80>Descuento total</th>	
			<th bgcolor="#fa6b6b" width=70>Baja mal cerrada</th>
			<th bgcolor="#fa6b6b" width=45>Otros</th>			
			<th bgcolor="#fa6b6b" width=80>Total descuentos</th>				
		</tr>
	</thead>
	<tbody>
		<tr bgcolor="#f3d1d8" align="center">	
			<th bgcolor="#f3d1d8">$<?php echo $precio_recla ?></th> <!-- PHP = $precla= $todoreclamos * $precio_recla ; echo $precla-->
			<th bgcolor="#f3d1d8">$<?php $pplani= $plani * $precio_plani; echo $pplani ?></th>			
			<th bgcolor="#f3d1d8">$<?php $pepp= $epp * $precio_epp; echo $pepp ?></th>	
			<th bgcolor="#f3d1d8">$<?php $pins= $inst * $precio_inst; echo $pins ?></th>
			<th bgcolor="#f3d1d8">$<?php $pcali= $cali * $precio_cali; echo $pcali ?></th>

			<th bgcolor="#f3d1d8">$<?php $pindu= $indu * $precio_indu; echo $pindu ?></th>
			<th bgcolor="#f3d1d8">$<?php $phigi= $higi * $precio_higi; echo $phigi ?></th>

			<th bgcolor="#f3d1d8">$<?php $ptoa= $toa * $precio_toa; echo $ptoa ?></th>	
			<th bgcolor="#f3d1d8">$<?php $pdesto= $desto * $precio_desto; echo $pdesto ?></th>	
			<th bgcolor="#f3d1d8">$<?php $pbaja= $baba * $precio_baja; echo $pbaja ?></th>
			<th bgcolor="#f3d1d8">$<?php echo $monto_to ?></th>	
			<th bgcolor="#f3d1d8">$<?php $ptotal= $precio_recla + $pepp + $pins + $pcali + $pindu + $phigi + $ptoa + $pplani + $pdesto + $pbaja + $monto_to; echo $ptotal ?></th>
		</tr>
	</tbody>
</table>
<br>

<h4 align="center">
<?php $query= "SELECT SUM(bajatec + mtto_int + mtto_ext + baja_desmonte + mtto_reaco) as 'mtto' FROM produccion WHERE tecnico='$tecnico' AND fecha like '%$mes%' ORDER BY fecha desc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$mtto= $row['mtto'];
if ($mtto >= 1)
{
?>

<h4 align="center">Mantenimiento</h4>
<table border="1" cellspacing="-1" align="center">
  <thead>
    <tr bgcolor="#a3c4e8" align="center">
      <th width=70>Baja Tecnica</th>
      <th width=100>Baja con desmonte</th>
      <th width=70>Mtto Reacond</th>
      <th width=70>Mtto Interno</th>      
      <th width=70>Mtto Externo</th>
      <th width=70>Sabado mtto</th>
      <th width=70>Feriado mtto</th>
      <th width=120>Total Mantenimiento</th>
    </tr>
  </thead>
  <tbody>
      <tr bgcolor="#d1e1f3" align="center">         
        <td>$<?php $babajatec = $todobajatec * $bajte; echo $babajatec; ?></td>
        <td>$<?php $babajades = $todobajadesm * $baja_desmonte_pre; echo $babajades; ?></td>
        <td>$<?php $babamtto_reaco = $todomtto_reaco * $mtt_reaco_pre; echo $babamtto_reaco ?></td>
        <td>$<?php $babamtto_int = $todomtto_int * $mtt_int_pre; echo $babamtto_int ?></td>                
        <td>$<?php $babamtto_ext = $todomtto_ext * $mtt_ext_pre; echo $babamtto_ext ?></td>
        <td>$<?php $sabsabmtto = $todomtto_sab * $sabmtto; echo $sabsabmtto ?></td>
        <td>$<?php $ferfermtto = $todomtto_fer * $fermtto; echo $ferfermtto ?></td> 
        <td>$<?php $babatotal = $babajatec + $babajades + $babamtto_reaco + $babamtto_int + $babamtto_ext + $sabsabmtto + $ferfermtto; echo $babatotal ?></td>                   
      </tr>   
  </tbody>
</table> <?php ;
}
else
{
	echo "";
}}?>
</h4>

<br>
<?php $tototales = $tototal + $babatotal ?>



<table border="0.1" cellspacing="-1" align="center">	
	<tbody>
		<tr bgcolor="#b6e9b9">
			<th align="center" width=180><h4>Total: $<?php $totaltotaltotal = $tototales - $ptotal; echo $totaltotaltotal ?></h4></th>
		</tr>
	</tbody>
</table>

<br>
</div>




	