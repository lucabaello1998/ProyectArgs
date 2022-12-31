<script type="text/javascript" charset="utf-8">
	///varios marcadores////   
	/////////PHP/////////
	var markers = ////////Se realiza consulta en PHP para crear un Array de los datos y se guarda en la variable ""points""////////
				   ////////["León", -34.892015, -58.704948, "Casa" ] Los string van entre ""; latutud y longitud van solos
	[
	  <?php
	  $query= "SELECT * FROM atcreportesgpon"; 
	  $result = mysqli_query($conn, $query);
	  while($row = mysqli_fetch_assoc($result))
	  {	 
	  	$tarea = $row['tarea'];
	  	$fecha = $row['fecha'];
	  	$partido = $row['partido'];
	  	$localidad = $row['localidad'];	
	    $latitud = $row['latitud'];
	    $longitud = $row['longitud'];
	    $relevador = $row['empleado'];
	    $direccion = $row['direccion'];
	    $prioridad = $row['prioridad'];
	    $obs = $row['observaciones'];
	    $hora = $row['hora'];
	    $diremanual = $row['direccion_manual'];
	    $fechaslider = $fecha;
		$valores = explode('/', $fecha);
		$dia = $valores[0];
		$mes = $valores[1];
		$anio = $valores[2];
		$date = $anio ."-" .$mes ."-" .$dia ;


	    $rele  = $relevador;             
		$solorele = explode(" ", $rele); // explota el string en " " espacios
		$nombre = $solorele[0];  // asigna un valor por el resultado del explotado
		$apellido = strtoupper(substr($solorele[1], 0, 3));
	    
		$queryy= "SELECT * FROM tecnicosatc WHERE nombre = '$nombre' AND apellido like '%$apellido%' "; 
		$resulta = mysqli_query($conn, $queryy);
		while($row = mysqli_fetch_assoc($resulta))
	  	{	
	  		$color = $row['color'];
	  	}		  		
	    
	    echo "[$latitud , $longitud , " .'"' .$tarea .'"' .',"' .$fecha .'"'  .',"' .$partido .'"' .',"' .$localidad .'"' .',"' .$relevador .'"' .',"' .$direccion .'"' .',"' .$prioridad .'"' .',"' .$obs .'"' .',"' .$hora .'"' .',"' .$diremanual .'"' .',"' .$color .'"' .',"' .$date .'"' ."],";

	  }
	  ?>
	];

	/////////PHP/////////

	for (var i = 0; i < markers.length; i++)  ////se repite el loop hasta completar el array////////
	{
		/////guardamos los resultados del Array en variables js////
		var php_latitud = markers[i][0];
		var php_longitud = markers[i][1];
		var php_tarea = markers[i][2];
		var php_fecha = markers[i][3];		
		var php_partido = markers[i][4];
		var php_localidad = markers[i][5];
		var php_relevador = markers[i][6];
		var php_direccion = markers[i][7];
		var php_prioridad = markers[i][8];
		var php_obs = markers[i][9];
		var php_hora = markers[i][10];
		var php_diremanual = markers[i][11];
		var php_color = markers[i][12];
		/////guardamos los resultados del Array en variables js////

		var circuloop = {
		// Borde
        color: php_color,
        weight: 1,
        opacity: 0.8,
        // Interior
        fillColor: php_color,
        fillOpacity: 0.4,
        // Radio
        radius: 5,
		};

	var marker = L.circleMarker([markers[i][0],markers[i][1]], circuloop, {time: '"' +markers[i][13] +' '+markers[i][10] +':00+01"' })   ////se crea la varable "marker" y se les pasa las coordenadas del array "markers"
	    .bindPopup(	
	    	'<b>Direccion: </b>'+php_direccion+'<br>'+
	    	'<b>Relevador: </b>'+php_relevador
				)
	    .addTo(map); ////se agregan marcadores al mapa  


     	const dat =
	    {				/////se crea una varaiable constante llamada "dat" donde se guardan los datos en varaibles
              primerDato: 	'<b>Fecha: </b>'+php_fecha+'<br>'+  ////encabezado mas datos del array///
              				'<b>Hora: </b>'+php_hora+'<br>'+
              				'<b>Relevador: </b>'+php_relevador+'<br>'+
					    	'<b>Partido: </b>'+php_partido+'<br>'+
					    	'<b>Localidad: </b>'+php_localidad+'<br>'+
					    	'<b>Direccion: </b>'+php_direccion+'<br>'+
					    	'<b>Direccion manual: </b>'+php_diremanual+'<br>'+
					    	'<b>Lat: </b>'+php_latitud+'<br>'+
					    	'<b>Long: </b>'+php_longitud+'<br>'+
					    	'<b>Prioridad: </b>'+php_prioridad+'<br>'+
					    	'<b>Observaciones: </b>'+php_obs,	/////primer dato llamdo "primerDato"

        }; 
 			
 		marker.on('click', enviarDatos); /////al hacer click sobre "MARKER" se ejecuta la funcion llamada "enviarDatos"
	    	
	    function enviarDatos(e)
		{   	
		    var primerId = document.querySelector('#informacion');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
		    primerId.innerHTML = dat['primerDato'];	////se le asigna a la variable "primerId" que traspase los nuevos datos por medio de la varaible "dat/primerDato"

		};
	};

///varios marcadores////
</script>