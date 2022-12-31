<?php
/* agrega una , en un post enviado como array */
  $uno = implode(",", $_POST['array']);
/* agrega una , en un post enviado como array */

/* separa un concatenacion por un valor dado, quedando $explotado['0'], $explotado['1'], $explotado['2'], $explotado['3'] */
  $explotado = explode(",", $valor_x);
/* separa un concatenacion por un valor dado, quedando $explotado['0'], $explotado['1'], $explotado['2'], $explotado['3'] */

/* cuenta los resultados de una consulta */
	$r = mysqli_query($conn, "SELECT * FROM usuarios WHERE token = '$tokenId'");
	$num = mysqli_num_rows($r);
/* cuenta los resultados de una consulta */

/* resultado de una consulta en un array */
  $r = mysqli_query($conn, "SELECT * FROM usuarios WHERE token = '$tokenId'");
  while($row = mysqli_fetch_assoc($r))
  {
    $nuevo_array[] = $row['seriado'] ;
  }
/* resultado de una consulta en un array */

/* comparar 2 tablas */
  $q = "SELECT valor_a_comparar,count(*) as total FROM
  (SELECT valor_a_comparar FROM tabla1 WHERE valor_a_comparar LIKE '%$term%' UNION ALL SELECT valor_a_comparar FROM tabla2) as list
  GROUP BY valor_a_comparar
  HAVING total = 1 ";
/* comparar 2 tablas */

/* recorrer ARRAY con EXPLODE y FOREACH */
  $r = mysqli_query($conn, "SELECT * FROM tabla1");
  if (mysqli_num_rows($r) == 1)
  {
    $row = mysqli_fetch_array($r);
    $referencia = utf8_decode($row['columna']);
    $explode = explode(";", $referencia);
  }
  ?>
  <?php foreach ($explode as $opciones){ ?>
    <option value="<?php echo $opciones ?>"><?php echo $opciones ?></option>
  <?php } 
/* recorrer ARRAY con EXPLODE y FOREACH */
/* Select autocompletado con AJAX */
  /* HTML */
    ?>
      <div class="form-row">
        <div class="col-12">
          <input class="search_query form-control selec_equipo" type="text" name="seriado" placeholder="Buscar equipo..." required>
        </div>
        <div class="sugerido" id="suggestions"></div>
      </div>
    <?php
  /* HTML */
  /* SCRIPT */
    ?>
    <script>
      $(document).ready(function()
      {
        $('.selec_equipo').on('keyup', function() /* CUANDO EN LA CLASE "selec_equipo" */
        {
          var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_equipo" */
          var dato = $(this); /* GUARDAR EN LA VARIABLE "dato" EL ELEMENTO "selec_equipo" */
          var dataString = 'key='+key;
          if(key == "")
          {
            //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
            $('.sugerido').fadeOut(500);
          }
          else
          {
            $.ajax({
              type: "POST",
              //Ruta del ajax
              url: "../Ajax/a_seriados.php",
              data: dataString,
              success: function(data)
              {
                //Escribimos las sugerencias que nos manda la consulta
                $('.sugerido').fadeIn(500).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                  //Obtenemos la id unica de la sugerencia pulsada
                  var id = $(this).attr('id');
                  //Editamos el valor del input con data de la sugerencia pulsada
                  dato.val($('#'+id).attr('data'));
                  //Hacemos desaparecer el resto de sugerencias
                  $('.sugerido').fadeOut(500);
                  return false;
                });
              }
            });
          };
        });
      });
    </script>
    <?php
  /* SCRIPT */
  /* SCRIPT OPCION BORRAR */
    ?>
    <script>
      $(document).ready(function()
      {
        $('.selec_equipo_nuevo').on('keyup', function() /* CUANDO EN LA CLASE "selec_equipo_nuevo" */
        {
          var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_equipo_nuevo" */
          var dato = $(this); /* GUARDAR EN LA VARIABLE "dato" EL ELEMENTO "selec_equipo_nuevo" */
          var dataString = 'key='+key;
          if(key == "")
          {
            //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
            $('.nuevo').fadeOut(500);
          }
          else
          {
            $.ajax({
              type: "POST",
              url: "../Ajax/a_seriados.php",
              data: dataString,
              success: function(data)
              {
                //Escribimos las sugerencias que nos manda la consulta
                $('.nuevo').fadeIn(500).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                  //Obtenemos la id unica de la sugerencia pulsada
                  var id = $(this).attr('id');
                  //Editamos el valor del input con data de la sugerencia pulsada
                  dato.val($('#'+id).attr('data'));

                  $("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla").removeAttr('autofocus'); //// esta linea solo duplica el input
                  dato.val(''); ////limpia el input 

                  //Hacemos desaparecer el resto de sugerencias
                  $('.nuevo').fadeOut(500);
                  return false;
                });
              }
            });
          };
        });

        $(document).on("click",".eliminar",function(){
          var parent = $(this).parents().get(0);
          if ($('.eliminar').length > 1) /* SI LA CANTIDAD DE LA CLASE "eliminar" ES MAYOR A 1 SE REMUEVE EL PADRE */ 
          {
            $(parent).remove();
          }
        });

      }); 
    </script>
    <?php
  /* SCRIPT OPCION BORRAR */
  /* AJAX */
    $html = '';
    $key = $_POST['key'];
    
    $result = mysqli_query($conn,"SELECT seriado FROM ingresomaterial WHERE seriado LIKE '%$key%' AND cantidad = '1' LIMIT 15");
    if(mysqli_num_rows($result) > 0)
    {
      while ($row = mysqli_fetch_assoc($result))
      {
        $html .= '<div><a class="suggest-element" data="'.utf8_encode($row['seriado']).'" id="equipo">'.utf8_encode($row['seriado']).'</a></div>';
      }
    }
    echo $html;
  /* AJAX */
/* Select autocompletado con AJAX */
?>