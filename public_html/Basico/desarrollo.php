<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<?php
  $fase_ver = mysqli_query($conn, "SELECT * FROM desarrollo order by id desc LIMIT 1");
  while($rof = mysqli_fetch_array($fase_ver))
  {	
    $fase = $rof['fase'];
    $version_dev = $rof['version_dev']+1;
  }
?>
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
    <div class="container-fluid">

    <?php if($nombre_us == 'Damian' && $apellido_us == 'Duarte') { ?>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <button type="button" class="btn btn-success shadow" data-toggle="modal" data-target="#desarrollo">
            +
          </button>
        </div>
      </div>

      <!-- Modal -->
        <div class="modal fade" id="desarrollo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Registro de cada desarrollo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card card-body">
                <form action="../Guardar/desarrollo.php" method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-group col-md-6 col-12">
                      <label>Fase</label>
                      <input type="number" name="fase" class="form-control" value="<?php echo $fase; ?>" required>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Version</label>
                      <input type="number" name="version_dev" class="form-control" value="<?php echo $version_dev; ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6 col-12">
                      <label>Titulo</label>
                      <input type="text" name="titulo" class="form-control" placeholder="Ingrese un titulo" required>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label for="fecha">Fecha</label>
                      <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label>Notas</label >
                      <textarea type="text" name="notas" class="form-control" ></textarea>
                    </div>
                  </div>
                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label>Subir 1° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                    </div>
                    <img id="mostrarImagen1" width="50%" height="50%"/>
                  </div>
                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label>Subir 2° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                    </div>
                    <img id="mostrarImagen2" width="50%" height="50%"/>
                  </div>
                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label>Subir 3° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                    </div>
                    <img id="mostrarImagen3" width="50%" height="50%"/>
                  </div>
                  <div class="form-row align-items-end">
                    <div class="form-group col">
                      <label>Subir 4° imagen</label>
                      <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                    </div>
                    <img id="mostrarImagen4" width="50%" height="50%"/>
                  </div>
                  <script type="text/javascript">
                    function previewImage(nb) {        
                      var reader = new FileReader();         
                      reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                      reader.onload = function (e) {             
                        document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                      };     
                    }
                  </script>
                  <br>
                  <input type="submit" name="save_dev" class="btn btn-success btn-block" value="Guardar desarrollo">
                </form>
              </div>
            </div>
          </div>
        </div>
    <?php } ?>

      <!-- Linea de tiempo -->
        <style>
          ul.timeline {
            list-style-type: none;
            position: relative;
            padding-left: 1.5rem;
            margin-top: 17px;
          }
          ul.timeline:before {
            content: ' ';
            background: #28a745;
            display: inline-block;
            position: absolute;
            left: 16px;
            width: 4px;
            height: 100%;
            z-index: 400;
            border-radius: 1rem;
          }
          li.timeline-item {
            margin: 20px 0;
          }
          .timeline-arrow {
            border-top: 0.5rem solid transparent;
            border-right: 0.5rem solid #fff;
            border-bottom: 0.5rem solid transparent;
            display: block;
            position: absolute;
            left: 2rem;
          }
          li.timeline-item::before {
            content: ' ';
            background: #28a745;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #fff;
            left: 11px;
            width: 14px;
            height: 14px;
            z-index: 400;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
          }
          .img_blur{
            position: relative;
            display: inline-block;
            text-align: center;
            cursor: pointer;
          }
          .text_img{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
          }
          .imagen_blur{
            max-width: 10rem;
            filter: grayscale(100%) blur(1px);
          }
          .imag_carro{
              max-height:85vh;
              max-width:115vh
            }
          @media(max-width: 990px) {
            .imag_carro{
              max-height:20vh;
              max-width:115vh
            }
          }
        </style>
        <ul class="timeline">
          <?php
            $devs = mysqli_query($conn, "SELECT * FROM desarrollo order by id desc");
            while($row = mysqli_fetch_array($devs))
            {
              $token = $row['token'];
          ?>
            <li class="timeline-item bg-white rounded m-3 p-3 shadow">
              <div class="timeline-arrow"></div>
              <h2 class="h5 mb-0"><?php echo $row['titulo']; ?></h2>
              <span class="text-gray" style="font-size: 1rem;"><i class="fa-regular fa-clock mr-1"></i><?php echo Fecha3($row['fecha']); ?></span>
              <br>
              <span class="text-gray" style="font-size: 0.8rem;"><i class="fa-solid fa-terminal mr-1"></i>V<?php echo $row['fase']; ?>.<?php echo $row['version_dev']; ?></span>
              <p class="text-small mt-2 font-weight-light"><?php echo $row['notas']; ?></p>
              <div class="img_blur" data-toggle="modal" data-target="#imgen<?php echo $row['token']; ?>">
                <img class="imagen_blur" src="../Archivos/desarrollo/<?php echo $row['imagenpri']; ?>" alt="<?php echo $row['titulo']; ?>"></img>
                  <?php
                  if($row['imagenpri'] == ''){$img_1 = 0;}else{$img_1 = 1;}
                  if($row['imagenseg'] == ''){$img_2 = 0;}else{$img_2 = 1;}
                  if($row['imagenter'] == ''){$img_3 = 0;}else{$img_3 = 1;}
                  if($row['imagencuar'] == ''){$img_4 = 0;}else{$img_4 = 1;}
                    $cant_img = $img_1+$img_2+$img_3+$img_4;
                  ?>
                  <div class="text_img h1 text-dark"><?php echo $cant_img; ?></div>
              </div>
              <div class="modal fade" id="imgen<?php echo $row['token']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"><?php echo $row['titulo']; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="card card-body p-0">
                      <div id="c_img<?php echo $row['token']; ?>" class="carousel slide" data-ride="carousel">
                        <div class="row justify-content-center">
                          <div class="col-auto">
                            <div class="carousel-inner" style="height:80vh;">
                              <?php if($row['imagenpri'] !== ''){ ?>
                                <div class="carousel-item active">
                                  <div class="row justify-content-center">
                                    <div class="col-auto">
                                      <img class="imag_carro" src="../Archivos/desarrollo/<?php echo $row['imagenpri']; ?>" alt="<?php echo $row['titulo']; ?>1">
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                              <?php if($row['imagenseg'] !== ''){ ?>
                                <div class="carousel-item">
                                  <div class="row justify-content-center">
                                    <div class="col-auto">
                                      <img class="imag_carro" src="../Archivos/desarrollo/<?php echo $row['imagenseg']; ?>" alt="<?php echo $row['titulo']; ?>2">
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                              <?php if($row['imagenter'] !== ''){ ?>
                                <div class="carousel-item">
                                  <div class="row justify-content-center">
                                    <div class="col-auto">
                                      <img class="imag_carro" src="../Archivos/desarrollo/<?php echo $row['imagenter']; ?>" alt="<?php echo $row['titulo']; ?>3">
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                              <?php if($row['imagencuar'] !== ''){ ?>
                                <div class="carousel-item">
                                  <div class="row justify-content-center">
                                    <div class="col-auto">
                                      <img class="imag_carro" src="../Archivos/desarrollo/<?php echo $row['imagencuar']; ?>" alt="<?php echo $row['titulo']; ?>4">
                                    </div>
                                  </div>
                                </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#c_img<?php echo $row['token']; ?>" data-slide="prev" style="opacity: 1 !important; width: 45%; background-color: rgb(255 255 255 / 0%) !important; border:none !important; justify-content: flex-start !important">
                          <i class="fa-solid fa-caret-left text-dark p-2"></i>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#c_img<?php echo $row['token']; ?>" data-slide="next" style="opacity: 1 !important; width: 45%; background-color: rgb(255 255 255 / 0%) !important; border:none !important; justify-content: flex-end !important">
                          <i class="fa-solid fa-caret-right text-dark p-2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          <?php } ?>
        </ul>
      <!-- Linea de tiempo -->
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
</body>
</html>