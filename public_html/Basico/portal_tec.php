<?php
  // Codigo parcialmente creado con inteligencia artificial
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: /index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $usuarios_permitidos = array("Administrador", "Despacho");
  if (in_array($tipo_us, $usuarios_permitidos))
  { $usu = 1; }
  else
  { $usu = 0; }

  if($usu != 1)
  {
    header("location: /index.php");
  }
?>
<!-- https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=thumbnail&sentity=1&eid=5991107&attr_id=144 -->
<!-- https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=download&sentity=1&eid=5991106&attr_id=143&fid=46335148&ts=1670934992098&sign=iVLkkOr5tkY2%2FsntrsZjxu%2FpRvJSTCHwpf2bsjXDnCk%3D -->
<!-- https://claro-ar.etadirect.com/r22.11.4.0.5/mobile/images/themeredwood/redwood_icons_sprite_01.svg -->
<!-- https://claro-ar.etadirect.com/?interface=mobility&force=logout&domain=claro-ar.etadirect.com -->
<!-- {login: "Angel.Duarte", name: "Angel Damian Duarte", mode: "password",…}
auth: "$fast$sha256$8fcb79832adfa8d5762cccaf06d24446d624fc118d17f1bbe7fa9a0f514c9b81.c47ce1849b2332df51f14b44737ccc2acea4c3d696411fc1ebb44e979e927495"
authTicket:"3fb3e3b08856c77b813a71bba10b8aa0"
hash: "$fast$sha256$.661ad9322d036531528f78cbe902968295836745c0fc42f4df121d57c02eb8dc"
key: "$fast$sha256$.4f66539051e1a6040bec049831ea7454"
ldapConnectionCheckUrl: "https://claro-ar.etadirect.com/auth/v1/ldap-availability"
login: "Angel.Duarte"
loginPortal: "claro-ar.etadirect.com"
logout: "https://claro-ar.etadirect.com/logout/?AuthId=toa_._claro-ar_.__._mobility&loginpolicy=default+policy&auth_ticket=3fb3e3b08856c77b813a71bba10b8aa0&instance_id=claro-ar&domain=claro-ar.etadirect.com"
mode: "password"
name: "Angel Damian Duarte"
reauthUrl: "https://claro-ar.etadirect.com/auth/v1/relogin"
timeout: 604800
trust: "$fast$sha256$.4f66539051e1a6040bec049831ea7454" -->
<!-- "https://claro-ar.etadirect.com/auth/v1/relogin" -->

<?php include('../includes/header.php');
include("./scraping/simple_html_dom.php");?>

<!-- MESSAGES -->
  <?php
    if ($_SESSION['card'] == 1) { ?>
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
          <?php switch($_SESSION['color_toast'])
            {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
            case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
            case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
          ?>
          <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
      </div>
    </div>
  <?php $_SESSION['card'] = 0; } ?>
  <script>
    $(document).ready(function(){
      $('.toast').toast('show');
    });
  </script>
<!-- MESSAGES -->
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <!-- <div class="text-center">
        <img src="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=thumbnail&sentity=1&eid=5991106&attr_id=143" class="rounded" alt="..." width="100%" height="100%" thumbnail-url="index.php?m=attribute&a=thumbnail&sentity=1&eid=5382098&attr_id=143&fid=41195470&ts=1670969976266&sign=GULueEFOP23WrvsxvQtdsQWFP1AcBI0%2BLLiwseJBPIw%3D">
        <img src="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=download&sentity=1&eid=5991106&attr_id=143" width="100%" height="100%" alt="" loading="lazy">
        <img options="" mime_types="image/jpeg,image/png" max_image_size_x="1000" max_image_size_y="1000" value="{&quot;name&quot;:&quot;capture_image.jpg, 96KB&quot;,&quot;file_id&quot;:41195470,&quot;entity_id&quot;:5382098,&quot;at&quot;:&quot;GULueEFOP23WrvsxvQtdsQWFP1AcBI0+LLiwseJBPIw=&quot;}" name="XA_FOTO1" area="index_1" form-element-title="Foto Niveles / Ancho de Banda" aria-label="Foto Niveles / Ancho de Banda" is-redwood-theme="true" is-online="true" identity="activity.XA_FOTO1" parent-id="16709699762-2243" file-download-name="143_foto_niveles_/_ancho_de_banda" thumbnail-url="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&amp;a=thumbnail&amp;sentity=1&amp;eid=5382098&amp;attr_id=143&amp;fid=41195470&amp;ts=1670969976266&amp;sign=GULueEFOP23WrvsxvQtdsQWFP1AcBI0%2BLLiwseJBPIw%3D" download-url="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&amp;a=download&amp;sentity=1&amp;eid=5382098&amp;attr_id=143&amp;fid=41195470&amp;ts=1670969976266&amp;sign=GULueEFOP23WrvsxvQtdsQWFP1AcBI0%2BLLiwseJBPIw%3D" file-name="captura_imagen.jpg, 96KB" error-file-name="" class="inline-image thumbnail" src="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&amp;a=download&amp;sentity=1&amp;eid=5382098&amp;attr_id=143&amp;fid=41195470&amp;ts=1670969976266&amp;sign=GULueEFOP23WrvsxvQtdsQWFP1AcBI0%2BLLiwseJBPIw%3D">
      </div>
      <a href="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=download&sentity=1&eid=5991106&attr_id=143">
        <img src="https://claro-ar.etadirect.com/mobility/index.php?m=attribute&a=thumbnail&sentity=1&eid=5991106&attr_id=143" alt="Paris">
      </a> -->

      <?php
        // Crear una función para mostrar el acordeón
        function mostrarAcordeon($padre)
        {
          global $conn;
          // Realizar la consulta a la base de datos
          $con_tec = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE padre = '$padre'");

          // Recorrer los resultados de la consulta
          while($row = mysqli_fetch_array($con_tec))
          {
            // Almacenar los datos de la fila en variables
            $token = $row['token'];
            $texto = $row['texto'];
            $tipo = $row['tipo'];
            $copiable = $row['copiable'];

            // Mostrar el título del acordeón
            echo "<div class='card border'>";
              echo "<div class='card-header p-1' id='$token'>";
                echo "<div class='row justify-content-between pl-1'>";
                  echo "<div class='col-10 pr-2 align-self-center btn btn-link btn-block text-left collapsed' style='text-decoration: none;' type='button' data-toggle='collapse' data-target='#co$token' aria-expanded='false' aria-controls='co$token'>";

                    // De acuerdo al tipo mostramos el que corresponda
                    switch($tipo)
                    {
                      case 'Boton':
                        echo "<button type='button' class='btn btn-primary'>$texto</button>";
                      break;
                      case 'Texto':
                        echo "<div class='text-dark'>";
                          if($copiable == 'Si')
                          {
                            echo "<i class='fa-regular fa-copy pr-2 text-primary'></i>";
                          }
                        echo $texto ."</div>";
                      break;
                      case 'Imagen':
                        echo "<img src='../Archivos/consultas/$texto' class='rounded' alt='$texto' style=' max-width: 30vh; max-height: 20vh; width: auto; height: auto;'>";
                      break;
                    };

                  echo "</div>";
                  echo "<div class='col-2 align-self-center'>";
                    echo "<div class='row justify-content-end pr-4'>";
                      echo "<div class='col-auto p-1'>";
                        echo "<button class='btn p-1' data-toggle='modal' data-target='#borrar$token'><i class='fa-regular fa-trash-can text-danger'></i></button>";
                        echo "<div class='modal fade' id='borrar$token' tabindex='-1' role='dialog' aria-labelledby='borrando' aria-hidden='true'>";
                          echo "<div class='modal-dialog modal-md' role='document'>";
                            echo "<div class='modal-content'>";
                              echo "<div class='modal-header'>";

                                switch($tipo)
                                {
                                  case 'Boton':
                                    echo "<h5 class='modal-title' id='borrando$token' text-center>Desea borrar el siguiente boton?</h5>";
                                  break;
                                  case 'Texto':
                                    echo "<h5 class='modal-title' id='borrando$token' text-center>Desea borrar el siguiente texto?</h5>";
                                  break;
                                  case 'Imagen':
                                    echo "<h5 class='modal-title' id='borrando$token' text-center>Desea borrar la siguiente imagen?</h5>";
                                  break;
                                };
                                
                                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                  echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                              echo "</div>";
                              echo "<form action='../Guardar/save_portal_tec.php' method='POST'>";
                                echo "<div class='card card-body'>";
                                  echo "<input type='hidden' name='token' value='$token'>";
                                  echo "<div class='form-row'>";


                                  switch($tipo)
                                  {
                                    case 'Boton':
                                      echo "<div class='form-group col-12'>";
                                        echo "<button type='button' class='btn btn-primary' disabled>$texto</button>";
                                      echo "</div>";
                                    break;
                                    case 'Texto':
                                      echo "<div class='form-group col-12'>";
                                        echo "<label>$texto</label>";
                                      echo "</div>";
                                    break;
                                    case 'Imagen':
                                      echo "<img src='../Archivos/consultas/$texto' class='rounded' alt='$texto' style=' max-width: 15vh; max-height: 10vh; width: auto; height: auto;'>";
                                    break;
                                  };

                                  echo "</div>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                  echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>No</button>";
                                  echo "<input type='submit' name='borrar' class='btn btn-success' value='Si'>";
                                echo "</div>";
                              echo "</form>";
                            echo "</div>";
                          echo "</div>";
                        echo "</div>";
                      echo "</div>";
                      echo "<div class='col-auto p-1'>";
                        echo "<button class='btn p-1' data-toggle='modal' data-target='#editar$token'><i class='fas fa-pen text-warning'></i></button>";
                        echo "<div class='modal fade' id='editar$token' tabindex='-1' role='dialog' aria-labelledby='editando' aria-hidden='true'>";
                          echo "<div class='modal-dialog modal-md' role='document'>";
                            echo "<div class='modal-content'>";
                              echo "<div class='modal-header'>";

                                switch($tipo)
                                  {
                                    case 'Boton':
                                      echo "<h5 class='modal-title' id='editando$token' text-center>Edita el siguiente boton</h5>";
                                    break;
                                    case 'Texto':
                                      echo "<h5 class='modal-title' id='editando$token' text-center>Edita el siguiente texto</h5>";
                                    break;
                                    case 'Imagen':
                                      echo "<h5 class='modal-title' id='editando$token' text-center>Edita la siguiente imagen</h5>";
                                    break;
                                  };
                                
                                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                  echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                              echo "</div>";
                              echo "<form action='../Guardar/save_portal_tec.php' method='POST' enctype='multipart/form-data'>";
                                echo "<div class='card card-body'>";
                                  echo "<input type='hidden' name='token' value='$token'>";
                                  echo "<div class='form-row'>";

                                    switch($tipo)
                                    {
                                      case 'Boton':
                                        echo "<div class='form-group col-12'>";
                                          echo "<label>Actualizar boton</label>";
                                          echo "<textarea type='text' name='texto' class='form-control'>$texto</textarea>";
                                        echo "</div>";
                                      break;
                                      case 'Texto':
                                        echo "<div class='form-group col-12'>";
                                          echo "<div class='custom-control custom-switch'>";
                                            echo "<input type='checkbox' class='custom-control-input' name='copiable' id='copy$token' value='Si'"; if($copiable == 'Si'){echo 'checked';}else{echo '';} echo ">";
                                            echo "<label class='custom-control-label' for='copy$token'>Texto para copiar</label>";
                                          echo "</div>";
                                        echo "</div>";
                                        echo "<div class='form-group col-12'>";
                                          echo "<label>Actualizar texto</label>";
                                          echo "<textarea type='text' name='texto' class='form-control'>$texto</textarea>";
                                        echo "</div>";
                                      break;
                                      case 'Imagen':
                                        echo "<img src='../Archivos/consultas/$texto' class='rounded' alt='$texto' style=' max-width: 15vh; max-height: 10vh; width: auto; height: auto;'>";
                                        echo "<br>";
                                        echo "<div class='form-group col-12'>";
                                          echo "<label>Actualizar imagen</label>";
                                          echo "<input type='file' accept='image/*' class='form-control-file' name='archivo'>";
                                        echo "</div>";
                                      break;
                                    };

                                  echo "</div>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                  echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>Cancelar</button>";
                                  echo "<input type='submit' name='editar' class='btn btn-success' value='Editar'>";
                                echo "</div>";
                              echo "</form>";
                            echo "</div>";
                          echo "</div>";
                        echo "</div>";
                      echo "</div>";
                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";

              // Si es un boton permite agregar mas campos
              if($tipo == 'Boton')
              {
                echo "<div id='co$token' class='collapse' aria-labelledby='$token' data-parent='#acor$token'>";
                  echo "<div class='card-body p-1 m-2'>";

                    // Mostrar el contenido del acordeón
                    echo "<div class='accordion' id='acor$token'>";

                      // Llamar a la función de nuevo con el nivel siguiente
                      mostrarAcordeon($token);

                    echo "</div>";
                  echo "</div>";
                echo "</div>";
              }

            echo "</div>";
          }
          echo "<div class='row justify-content-center p-1 mt-2'>";
            echo "<div class='col-auto'>";
              echo "<button type='button' class='btn btn-success shadow tomar_token' data-toggle='modal' data-target='#consultas' data-token='$padre'>+</button>";
            echo "</div>";
          echo "</div>";
        }
      ?>


      <div class="row justify-content-center p-1">
        <div class="col-12">
          <p class="h4 mb-4 text-center">Consultas</p>
            <div class="accordion border" id="639746d5ca618">
              <?php
                // Parametros iniciales
                $padre = '639746d5ca618';

                //Usamos la funcion y le pasamos la variable inicial
                mostrarAcordeon($padre);
              ?>
            </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="consultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Nuevo texto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../Guardar/save_portal_tec.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" id="token" name="padre">
            <div class="form-row">
              <div class="form-group col-12">
                <label class="text-muted">Tipo</label>
                <div class="form-row">
                  <div class="form-check form-check-inline col">
                    <input class="form-check-input tipo" type="radio" name="tipo" id="Texto" value="Texto" checked>
                    <label class="form-check-label" for="Texto">Texto</label>
                  </div>
                  <div class="form-check form-check-inline col">
                    <input class="form-check-input tipo" type="radio" name="tipo" id="Boton" value="Boton">
                    <label class="form-check-label" for="Boton">Boton</label>
                  </div>
                  <div class="form-check form-check-inline col">
                    <input class="form-check-input tipo" type="radio" name="tipo" id="Imagen" value="Imagen">
                    <label class="form-check-label" for="Imagen">Imagen</label>
                  </div>
                </div>
              </div>
              <div class="form-group col-12" id="texCopiar">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" name="copiable" id="copiable" value="Si">
                  <label class="custom-control-label" for="copiable">Texto para copiar</label>
                </div>
              </div>
              <div class="form-group col-12" id="textarea">
                <label>Texto</label>
                <textarea type="text" name="texto" class="form-control"></textarea>
              </div>
                <div class="form-group col-12" hidden id="upImagen">
                  <label>Subir imagen</label>
                  <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                </div>
                <img id="mostrarImagen1" width="50%" height="50%" hidden/>
                <script type="text/javascript">
                  function previewImage(nb) {
                    var reader = new FileReader();
                    reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);
                    reader.onload = function (e) {
                      document.getElementById('mostrarImagen'+nb).src = e.target.result;
                    };     
                  }
                </script>
              
            </div>
            <br>
            <input type="submit" name="guardar" class="btn btn-primary" value="Guardar">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  window.onload=()=>{
    const botones= document.querySelectorAll('.tomar_token');
    botones.forEach( el=>el.addEventListener('click',evt=>{
      var token=evt.target.getAttribute('data-token');
      document.getElementById('token').value =token;
    }))
  };
</script>
<script>
  $(function(){
    $(".tipo").click(function(){
      if($(this).val()=='Imagen')
      {
        $("#upImagen").removeAttr('hidden');
        $("#mostrarImagen1").removeAttr('hidden'); 
        $("#textarea").attr('hidden','hidden');
        $("#texCopiar").attr('hidden','hidden');
      }
        else
      {
        if($(this).val()=='Texto')
        {
          $("#textarea").removeAttr('hidden');
          $("#texCopiar").removeAttr('hidden');
          $("#upImagen").attr('hidden','hidden');
          $("#mostrarImagen1").attr('hidden','hidden');
        }
        else
        {
          $("#textarea").removeAttr('hidden');
          $("#texCopiar").attr('hidden','hidden');
          $("#upImagen").attr('hidden','hidden');
          $("#mostrarImagen1").attr('hidden','hidden');
        }
      }
    })
  })
</script>
</body>
</html>