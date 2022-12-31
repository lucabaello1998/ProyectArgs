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
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid p-4">
  <div class="row p-2">
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

      <div class="row justify-content-center">
        <h3>Precios</h3>
      </div>
      <div class="row justify-content-center">
        <?php 
          session_start();
          if(!$_SESSION['nombre'])
          {
          session_destroy();
          header("location: ../index.php");
          exit();
          }
          if(!$_SESSION['nombre']){
          $sinusuario = "si";
          }else{
          $tipo = $_SESSION['tipo_us'];

          }
            if($tipo == "Administrador")
          {
        ?>
        <p><a href="../Editar/edit_precios.php?id=1"><i class="fas fa-pen p-2"></i></a></p>
        <?php } ?>
      </div>
      <br>



      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Instalaciones</p>
            <table class="table table-responsive table-striped table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>2play</th>
                  <th>3play</th>
                  <th>STB</th>
                  <th>Mud int</th>             
                  <th>Bajas</th>
                  <th>Garant justif</th> 
                  <th>Garant sin interv</th>
                  <th>Garant comp</th>             
                  <th>Sab</th>
                  <th>Fer</th>
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  $result = mysqli_query($conn, "SELECT * FROM precios");
                  while($row = mysqli_fetch_assoc($result))
                  { 
                    $tarea = $row['dosplay'];
                ?>
                  <tr>
                    <td><?php echo $row['dosplay']; ?></td>
                    <td><?php echo $row['tresplay']; ?></td>
                    <td><?php echo $row['stb']; ?></td>
                    <td><?php echo $row['mudainter']; ?></td>                
                    <td><?php echo $row['bajas']; ?></td>
                    <td><?php echo $row['garanjus']; ?></td> 
                    <td><?php echo $row['garaninterv']; ?></td>
                    <td><?php echo $row['garancomp']; ?></td>
                    <td><?php echo $row['sab']; ?></td>
                    <td><?php echo $row['fer']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Mantenimiento</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Baja tec</th>
                <th>Baja con desm</th>
                <th>Mtto Reacond</th>
                <th>Mtto inter</th>
                <th>Mtto ext</th>             
                <th>Sab</th>
                <th>Fer</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result = mysqli_query($conn, "SELECT * FROM precios");
                while($row = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td><?php echo $row['bajatec']; ?></td>
                  <td><?php echo $row['bajadesmont']; ?></td>
                  <td><?php echo $row['mttoreacond']; ?></td>
                  <td><?php echo $row['mttointer']; ?></td>
                  <td><?php echo $row['mttoexter']; ?></td>                
                  <td><?php echo $row['sabmtto']; ?></td>
                  <td><?php echo $row['fermtto']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>


      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Descuentos</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Falta planilla</th>
                <th>EPP</th>
                <th>Instalaciones</th>
                <th>Calidad</th>
                <th>Indumentaria</th>
                <th>Higiene</th>           
                <th>TOA</th>
                <th>Baja mal cerrada</th> 
                <th>Total</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result = mysqli_query($conn, "SELECT * FROM precios");
                while($row = mysqli_fetch_assoc($result))
                { 
                $epp = $row['desepp'];
                $inst = $row['desinst'];
              ?>
                <tr>
                  <td><?php echo "- $" .$row['desplani']; ?></td>
                  <td><?php echo "- %" .$row['desepp']; ?></td>
                  <td><?php echo "- %" .$row['desinst']; ?></td>
                  <td><?php echo "- %" .$row['descalidad']; ?></td> 
                  <td><?php echo "- %" .$row['descalidad']; ?></td> 
                  <td><?php echo "- %" .$row['descalidad']; ?></td> 
                  <td><?php echo "- %" .$row['destoa']; ?></td>               
                  <td><?php echo "- $" .$row['desbaja']; ?></td>
                  <td><?php echo "- $" .$row['destotal']; ?></td>
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
</body>
</html>