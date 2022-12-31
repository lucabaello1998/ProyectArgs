<script type="text/javascript">
////capas///
var baseMaps =   //////////baseMaps RADIO BUTTON////////
{
"Satelital": satelital, /////nombre de la capa CAPA CONSTANTE/////
"Oscuro": oscuro, /////nombre de la capa CAPA CONSTANTE/////
"Transporte": transporte, /////nombre de la capa CAPA CONSTANTE/////	
"Monocormatico": monocromatico, /////nombre de la capa CAPA CONSTANTE/////
"Base": mapabase, /////nombre de la capa CAPA CONSTANTE/////	
};
var overlayMaps =   //////////overlayMapas CAPA APAGABLE////////
{
}; 

var layerswitcher= L.control.layers(baseMaps, overlayMaps,{collapsed:true}).addTo(map); /////switch de capas; colapsable//////
////capas///
//////Capas en cascada, arbol////////
var baseTree =
[
];

var overlaysTree =
{
    label: 'Trazas<div id="onlysel"></div>',
    children:   [
                

    {label: '<div class="leaflet-control-layers-separator"></div>'},
    {label: 'Lineal'},
    <?php
    $queryy= "SELECT * FROM atcmapas WHERE tarea = 'Lineal' GROUP BY zona"; 
    $resulta = mysqli_query($conn, $queryy);
    while($row = mysqli_fetch_array($resulta))
    {  
        $zona = $row['zona'];     

        echo " {label: ' " .$zona ." ', "
        ."selectAllCheckbox: true,"
        ."children: [";

            $queryyy= "SELECT * FROM atcmapas WHERE tarea = 'Lineal' AND zona = '$zona' GROUP BY partido"; 
            $resultad = mysqli_query($conn, $queryyy);
            while($row = mysqli_fetch_array($resultad))
            {  
                $partido = $row['partido'];     

                echo " {label: ' " .$partido ." ', "
                ."selectAllCheckbox: true,"
                ."children: [";

                    $queryyyy= "SELECT * FROM atcmapas WHERE tarea = 'Lineal' AND partido = '$partido'"; 
                    $resultado = mysqli_query($conn, $queryyyy);
                    while($row = mysqli_fetch_array($resultado))
                    {  
                        $nombre = $row['nombre'];
                        $enlace = $row['enlace'];
                        $color = $row['color'];

                        echo " {label: ' " .$nombre ." ', "
                            ."layer: omnivore.kml('Archivos/mapas/" .$enlace .".kml', null, L.geoJson(null, {style: function(feature) {return { color: ' " .$color ." ' };}})
                                )}, ";
                            
                    };
                echo "]},";

            }
        echo "]},";

    }
    ?>
    {label: '<div class="leaflet-control-layers-separator"></div>'},
    {label: 'Gpon'},
    <?php
        $query= "SELECT * FROM atcmapas WHERE tarea = 'Gpon' GROUP BY partido"; 
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {  
            $partido = $row['partido'];     

            echo " {label: ' " .$partido ." ', "
            ."selectAllCheckbox: true,"
            ."children: [";

                $queryyy= "SELECT * FROM atcmapas WHERE tarea = 'Gpon' AND partido = '$partido' GROUP BY localidad"; 
		        $resulta = mysqli_query($conn, $queryyy);
		        while($row = mysqli_fetch_array($resulta))
		        {  
		            $localidad = $row['localidad'];     

		            echo " {label: ' " .$localidad ." ', "
		            ."selectAllCheckbox: true,"
		            ."children: [";

		                $queryy= "SELECT * FROM atcmapas WHERE tarea = 'Gpon' AND localidad = '$localidad'"; 
		                $resultado = mysqli_query($conn, $queryy);
		                while($row = mysqli_fetch_array($resultado))
		                {  
		                    $nombre = $row['nombre'];
		                    $enlace = $row['enlace'];
                            $color = $row['color'];

		                    echo " {label: ' " .$nombre ." ', "
                            ."layer: omnivore.kml('Archivos/mapas/" .$enlace .".kml', null, L.geoJson(null, {style: function(feature) {return { color: ' " .$color ." ' };}})
                                )}, ";
		                        
		                };
		            echo "]},";
		   
		        }
            echo "]},";
   
        }
    ?>

                ]
}

var lay = L.control.layers.tree(baseTree, overlaysTree,
{
    namedToggle: true,
    selectorBack: false,
    closedSymbol: '<i class="fas fa-folder text-success"></i>',
    openedSymbol: '<i class="fas fa-folder-open text-success"></i>',
    collapsed: false,
});

var control =  lay.addTo(map).collapseTree().expandSelected().collapseTree(true);
L.DomEvent.on(L.DomUtil.get('onlysel'), 'click', function() {
    lay.collapseTree(true).expandSelected(true);
});

// Call the getContainer routine.
var htmlObject = control.getContainer();
// Get the desired parent node.
var a = document.getElementById('new-parent');

// Finally append that node to the new parent.
function setParent(el, newParent)
{
    newParent.appendChild(el);
}
setParent(htmlObject, a);
//////Capas en cascada, arbol//////// 
</script>