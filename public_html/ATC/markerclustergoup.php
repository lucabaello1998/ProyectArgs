<script type="text/javascript">

	///varios marcadores////
	/////////PHP/////////
	var markers = ////////Se realiza consulta en PHP para crear un Array de los datos y se guarda en la variable ""points""////////
				   ////////["León", -34.892015, -58.704948, "Casa" ] Los string van entre ""; latutud y longitud van solos
	[
	  <?php
	  $query= "SELECT * FROM atcgpon"; 
	  $result = mysqli_query($conn, $query);
	  while($row = mysqli_fetch_assoc($result))
	  {	 
	  	$id = $row['id'];
	  	$fecha = $row['fecha'];
	  	$partido = $row['partido'];
	  	$localidad = $row['localidad'];	
	    $latitud = $row['latitud'];
	    $longitud = $row['longitud'];
	    $relevador = $row['relevador'];
	    $direccion = $row['direccion'];
	    $prioridad = $row['prioridad'];
	    $obs = $row['obs'];

	    echo "[$latitud , $longitud , " .'"' .$id .'"' .',"' .$fecha .'"'  .',"' .$partido .'"' .',"' .$localidad .'"' .',"' .$relevador .'"' .',"' .$direccion .'"' .',"' .$prioridad .'"' .',"' .$obs .'"' ."],";
	  }
	  ?>
	];

	/////////PHP/////////	
	var marcadores= L.markerClusterGroup(); /////se crea la variable "marcadores" para agrupar los marcadores


	for (var i = 0; i < markers.length; i++)  ////se repite el loop hasta completar el array////////
	{
		/////guardamos los resultados del Array en variables js////
		var php_latitud = markers[i][0];
		var php_longitud = markers[i][1];
		var php_id = markers[i][2];
		var php_fecha = markers[i][3];		
		var php_partido = markers[i][4];
		var php_localidad = markers[i][5];
		var php_relevador = markers[i][6];
		var php_direccion = markers[i][7];
		var php_prioridad = markers[i][8];
		var php_obs = markers[i][9];
		/////guardamos los resultados del Array en variables js////


	var marker = L.marker([markers[i][0],markers[i][1]])   ////se crea la varable "marker" y se les pasa las coordenadas del array "markers"
	    .bindPopup(	/////se crea el popup con la estructura en HTML
	    	'<b>Direccion: </b>'+php_direccion+'<br>'+
	    	'<b>Relevador: </b>'+php_relevador
				)
	    ; ////se agregan marcadores a la variable "marker"

    
	marcadores.addLayer( marker ); ////se agregan marcadores a "marcadores"
	


     	const dat =
	    {				/////se crea una varaiable constante llamada "dat" donde se guardan los datos en varaibles
              primerDato: 	'<b>Fecha: </b>'+php_fecha+'<br>'+  ////encabezado mas datos del array///
					    	'<b>Lat: </b>'+php_latitud+'<br>'+
					    	'<b>Long: </b>'+php_longitud+'<br>'+
					    	'<b>Direccion: </b>'+php_direccion+'<br>'+
					    	'<b>Partido: </b>'+php_partido+'<br>'+
					    	'<b>Localidad: </b>'+php_localidad+'<br>'+
					    	'<b>Relevador: </b>'+php_relevador+'<br>'+
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

map.addLayer(marcadores); ///se agregar los "marcadores" agrupados al mapa

</script>