<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo = $_SESSION['tipo_us'];
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<!-- FECHA -->
  <?php
    $mes = date ('Y-m', strtotime('-0 month'));
    if(isset($_GET['mes']))
    {
      $desencriptado = $_GET['mes'];
      $mes = base64_decode($desencriptado);
    }

    $b = explode("-", $mes);
    switch ($b[1])
    {
      case '12': $mes_nom = "Diciembre";
      break;
      case '11': $mes_nom = "Noviembre";
      break;
      case '10': $mes_nom = "Octubre";
      break;
      case '09': $mes_nom = "Septiembre";
      break;
      case '08': $mes_nom = "Agosto";
      break;
      case '07': $mes_nom = "Julio";
      break;
      case '06': $mes_nom = "Junio";
      break;
      case '05': $mes_nom = "Mayo";
      break;
      case '04': $mes_nom = "Abril";
      break;
      case '03': $mes_nom = "Marzo";
      break;
      case '02': $mes_nom = "Febrero";
      break;
      case '01': $mes_nom = "Enero";
      break;
    }
  ?>
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/mtto.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/mtto.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <!-- MESSAGES -->
            <?php session_start();      
            if ($_SESSION['card'] == 1) { ?>
            <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
              <?= $_SESSION['message']?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php $_SESSION['card'] = 0; } ?>
          <!-- MESSAGES -->
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_mtto.php" method="POST">
              <p class="h4 mb-4 text-center">Carga de Mantenimientos</p>
              <div class="form-row">
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">
                    <option selected="0">Tecnicos...</option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="number" name="ot" pattern="([0-9])" maxlength="11" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                </div>
                <div class="form-group col-md-4 col-12">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" maxlength="80"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>
                <div class="form-group col-md-6 col-6">
                  <label for="exampleFormControlSelect1">Zona</label >
                  <select type="text" name="zona" class="form-control">
                    <option selected>Zona...</option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
                <div class="form-group col-md-6 col-6">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="fecha" class="form-control" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC ONT</label >
                  <input type="text" name="ont_mac" maxlength="25"  class="form-control" placeholder="Ingrese la MAC del modem" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN ONT</label >
                  <input type="text" name="ont_sn" maxlength="25"  class="form-control" placeholder="Ingrese el numero de serie del modem" autofocus>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 1</label >
                  <input type="text" name="stb_mac_uno" maxlength="25"  class="form-control" placeholder="Ingrese la MAC del primer deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 1</label >
                  <input type="text" name="stb_sn_uno" maxlength="25"  class="form-control" placeholder="Ingrese el numero de serie del primer deco" autofocus>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 2</label >
                  <input type="text" name="stb_mac_dos" maxlength="25"  class="form-control" placeholder="Ingrese la MAC del segundo deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 2</label >
                  <input type="text" name="stb_sn_dos" maxlength="25"  class="form-control" placeholder="Ingrese el numero de serie del segundo deco" autofocus>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">MAC STB 3</label >
                  <input type="text" name="stb_mac_tres" maxlength="25"  class="form-control" placeholder="Ingrese la MAC del tercer deco" autofocus>
                </div>
                <div class="form-group col-md-6">
                  <label for="exampleFormControlSelect1">SN STB 3</label >
                  <input type="text" name="stb_sn_tres" maxlength="25"  class="form-control" placeholder="Ingrese el numero de serie del tercer deco" autofocus>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Motivo de cierre</label >
                  <textarea type="text" name="motivo" maxlength="120"  class="form-control" placeholder="Ingrese un motivo" autofocus required></textarea>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Observaciones</label >
                  <textarea type="text" name="obs" maxlength="255"  class="form-control" placeholder="Ingrese una observacion" autofocus required></textarea>
                </div>
              </div>

              <input type="submit" name="save_mtto" class="btn btn-success btn-block" value="Guardar mantenimiento">
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <a class="btn btn-info" href="../BaseDatos/dtmtto.php" role="button">Ver todas los mantenimientos</a>
        </div>
      </div>

      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimos mantenimientos cargados</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Direccion</th>
                <th>Zona</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Observaciones</th>
                <th>MAC ONT</th>
                <th>SN ONT</th>            
                <th>MAC STB 1</th>
                <th>SN STB 1</th>           
                <th>MAC STB 2</th>
                <th>SN STB 2</th>           
                <th>MAC STB 3</th>
                <th>SN STB 3</th>   
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM mtto WHERE fecha LIKE '%$mes%' ORDER BY id desc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_mtto.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_mtto.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                  <td><?php echo Fecha7($row['fecha']); ?></td>
                  <td><?php echo $row['motivo']; ?></td>
                  <td><?php echo $row['obs']; ?></td>
                  <td><?php echo $row['ont_mac']; ?></td>
                  <td><?php echo $row['ont_sn']; ?></td>
                  <td><?php echo $row['stb_mac_uno']; ?></td>
                  <td><?php echo $row['stb_sn_uno']; ?></td>
                  <td><?php echo $row['stb_mac_dos']; ?></td>
                  <td><?php echo $row['stb_sn_dos']; ?></td>
                  <td><?php echo $row['stb_mac_tres']; ?></td>
                  <td><?php echo $row['stb_sn_tres']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>     
        </div>
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
</body>
</html>
