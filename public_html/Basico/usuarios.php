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
  if($tipo_us != "Administrador")
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

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="form-row justify-content-center">
            <h4 class="modal-title" text-center>Datos generales</h4>
          </div>
          <div class="col-12 col-sm-12">
            <div class="form-row justify-content-center">
              <div class="col-5 col-sm-5">
                <div class="row justify-content-center p-1 pr-3">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingreso">
                    +
                  </button> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal 1 -->
      <div class="modal fade" id="ingreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de usuarios</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Guardar/save_usuarios.php" method="POST">
                <div class="form-row align-items-end">
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Nombre</label>
                    <input type="text" name="nombre" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un nombre" autofocus required>
                  </div>            
                  <div class="form-group col-6 col-md-4">
                    <label for="exampleFormControlSelect1">Apellido</label>
                    <input type="text" name="apellido" maxlength="80" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese un apellido" required>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="exampleFormControlSelect1">Zona</label>
                    <select type="text" name="zona" class="form-control" required>
                      <option selected value="" disabled>Zona...</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="San Nicolas">San Nicolas</option>
                      <option value="Todo">Todo</option>
                    </select>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Email</label>
                    <input type="mail" name="mail"  class="form-control" placeholder="Ingrese un apellido" required>
                  </div>          
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Tipo</label>
                    <select type="text" name="tipo_us" class="form-control" required>
                      <option selected value="" disabled>Tipo...</option>
                      <option value="Administrador">Administrador</option>
                      <option value="ATC">ATC</option>
                      <option value="Despacho">Despacho</option>
                      <option value="Supervisor">Supervisor</option>
                      <option value="Deposito">Deposito</option>
                      <option value="Tecnico">Tecnico</option>
                    </select>
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Usuario</label>
                    <input type="text" name="usuario" pattern="[A-Za-z0-9_-.]{3-15}"  class="form-control" placeholder="Ingrese un usuario" required>
                  </div>
                  <div class="form-group col-6">
                    <label for="exampleFormControlSelect1">Contraseña</label>
                    <input type="text" name="pass" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" placeholder="Ingrese una contraseña" required>
                  </div>
                </div>
                <div class="form-row align-items-center">
                  <input type="submit" name="save_usuario" class="btn btn-success btn-block" value="Guardar usuario">
                </div>
              </form>
            </div>      
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Usuarios</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Mail</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Tipo</th>  
                <th>Zona</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result = mysqli_query($conn, "SELECT * FROM usuarios");
                while($row = mysqli_fetch_assoc($result))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_usuarios.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_usuarios.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['nombre']; ?></td>
                  <td><?php echo $row['apellido']; ?></td>
                  <td><?php echo $row['mail']; ?></td>
                  <td><?php echo $row['usuario']; ?></td>
                  <td><?php if($nombre_us == 'Damian' && $apellido_us == 'Duarte') {echo $row['pass'];} else {echo '*******';} ?></td>
                  <td><?php echo $row['tipo_us']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
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