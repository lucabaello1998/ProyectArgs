<?php
  include("../db.php");
  header('Content-Type: text/html; charset=utf-8');
  mysqli_set_charset( $conn, 'utf8' );
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $quien_notas = $nombre .' ' .$apellido;
  $token = $_GET['token'];
?>
<div class="row justify-content-center p-1">
    <div class="col-12">
    <?php
      $result_tasks = mysqli_query($conn, "SELECT * FROM tareas WHERE mensaje <> '' AND token = '$token' ORDER BY id desc");
      while($row = mysqli_fetch_assoc($result_tasks))
      {
        $id = $row['id'];
        if($row['quien'] == $quien_notas)
        {
          ?>
            <div class="row justify-content-end p-2">
              <div class="col-8 align-self-end p-0">
                <div class="card card-body alert-info shadow-sm m-1 p-2">
                  <p class="text-right m-1"><?php echo utf8_decode($row['mensaje']); ?></p>
                  <p class="text-left m-1" style="font-size:0.75rem;"><?php echo Fecha12($row['cuando']); ?></p>
                </div>
              </div>
              <div class="col-auto p-1 m-1">
                <form onsubmit="borrar<?php echo $id; ?>(); return false" id="form<?php echo $id; ?>">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button class="btn p-1" type="submit" id="button-borrar"><i class="fa-regular fa-trash-can text-danger"></i></button>
                </form>
                <script>
                  function borrar<?php echo $id; ?>()
                  {	
                    $.ajax({
                    type: 'POST',
                    url: '../Ajax/a_tarea_borrar.php',
                    data: $('#form<?php echo $id; ?>').serialize(),
                    success: function(data) {
                      if(data=='ok')
                      {
                        $('#msj<?php echo $row['token']; ?>').load('../Ajax/a_mensajes.php?token=<?php echo $row['token']; ?>')
                      }
                    }
                    });
                  }
                </script>
              </div>
            </div>
          <?php
        }
        else
        {
          ?>
            <div class="row justify-content-start p-2">
              <div class="col-8 align-self-start">
                <div class="card card-body alert-primary shadow-sm m-1 p-2" >
                  <p class="text-primary text-left m-1"><?php echo utf8_decode($row['quien']); ?></p>
                  <p class="text-left m-1"><?php echo utf8_decode($row['mensaje']); ?></p>
                  <p class="text-right m-1" style="font-size:0.75rem;"><?php echo Fecha12($row['cuando']); ?></p>
                </div>
              </div>
            </div>
          <?php
        }
      }
    ?>
    </div>
</div>