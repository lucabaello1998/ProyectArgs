<script type="text/javascript">
	//////cargar archivos GML///
	var style = {
	            color: 'green', ////color
	            opacity: 1.0, 	/////opacidad
	            fillOpacity: 1.0,
	            weight: 2,
	            clickable: false
	        	};
	L.Control.FileLayerLoad.LABEL = '<i class="fas fa-folder-open"></i>';  ////icono del boton
	 var control = L.Control.fileLayerLoad({	    
	    layer: L.geoJson,        
	    layerOptions: {
	            style: style,
	            pointToLayer: function (data, latlng) {
	                return L.circleMarker(
	                    latlng,
	                    { style: style }
	                );
	            }
	        },
	        position: 'topright',      
	    addToMap: true,        
	    fileSizeLimit: 1000000,  /////tamaño maximo del archivo       
	    formats: [  //////limita los formatos
	        '.geojson',
	        '.gpx',
	        '.kml'
	    		]
	}).addTo(map);
	    control.loader.on('data:loaded', function (event) {   
	  layerswitcher.addOverlay(event.layer, event.filename);
	});  
	control.loader.on('data:error', function (error) {
	   alert(error.error.message);
	});
//////cargar archivos GML///


///PANTALLA COMPLETA Y QUITAR BOTONES DE ZOMM//////
	map.addControl(new L.Control.Fullscreen({ position: 'bottomright' }));
	map.removeControl(map.zoomControl);
///PANTALLA COMPLETA Y QUITAR BOTONES DE ZOMM//////


///IMPRIMIR////
	L.control.browserPrint({
		printModes: [L.control.browserPrint.mode.landscape('<i class="fas fa-arrows-alt-h"></i>'),
		L.control.browserPrint.mode.portrait('<i class="fas fa-arrows-alt-v"></i>'),
		L.control.browserPrint.mode.custom('<i class="fas fa-expand-arrows-alt"></i>')],
		position: 'bottomright',
		title: 'Selecciona como imprimir',
		documentTitle: 'Mapa relevamiento',
	}).addTo(map);
///IMPRIMIR////

/////GEOCODER/////
L.Control.geocoder({position:'topleft', placeholder:'Buscar...'}).addTo(map);
/////GEOCODER/////

////MEDIR/////
L.control.polylineMeasure(
	{position:'topleft',
	unit:'metres',
	showBearings:false,
	clearMeasurementsOnStop: false,
	showClearControl: true,
	tooltipTextMove: 'Toca y arrastra para <b>mover el punto</b><br>',
	tooltipTextDelete: 'Presiona SHIFT y toca para <b>borrar el punto</b>',
	tooltipTextResume: '<br>Presiona CTRL y toca para <b>continuar el trazado</b>',
	tooltipTextAdd: 'Presiona CTRL y toca para <b>agregar un punto</b>',
	currentCircle: {
        color: '#000',
        weight: 1,
        fillColor: '#fb5607', 
        fillOpacity: 1,
        radius: 3
    },
	clearControlTitle: 'Limpiar medidas',
	measureControlTitleOn: 'Comenzar a medir',
	measureControlTitleOff: 'Terminar de medir'}).addTo(map);
////MEDIR/////

</script>


