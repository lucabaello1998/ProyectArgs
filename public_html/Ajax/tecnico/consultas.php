<?php
  include("../../db.php");
  session_start();
  $tipo_us = $_SESSION['tipo_us'];
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  $token_sesion = $_SESSION['token_sesion'];
?>
<div class="row justify-content-center p-1">
  <div class="col-12">
    <?php
      mysqli_query($conn, "UPDATE mensajes_tec set visto = 'SI' WHERE quien <> '$quien_notas' AND tecnico <> '$quien_notas' AND estado = 'Abierto' AND token_sesion = '$token_sesion' ");

      $consul = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE token_sesion = '$token_sesion' ORDER BY id desc");
      while($row = mysqli_fetch_assoc($consul))
      {
        $id = $row['id'];
        if($row['quien'] == $quien_notas)
        {
          ?>
            <div class="row justify-content-end p-2">
              <div class="col-8 align-self-end p-0">
                <div class="card card-body alert-info shadow-sm m-1 p-2">
                  <p class="text-right m-1"><?php echo $row['consulta']; ?></p>
                  <div class="row p-0 m-0 justify-content-between">
                    <div class="col-auto p-0 m-0 align-self-start">

                      <?php
                        if($row['visto'] == 'SI')
                        { 
                      ?>
                        <span class="text-left m-1" style="font-size:0.75rem;"><i class="fa-solid fa-check-double"></i></span>
                      <?php
                        } else {
                      ?>
                        <span class="text-left m-1" style="font-size:0.75rem;"><i class="fa-solid fa-check"></i></span>
                      <?php } ?>
                      
                    </div>
                    <div class="col-auto p-0 m-0 align-self-end">
                      <span class="text-right m-1" style="font-size:0.75rem;"><?php echo Fecha12($row['cuando']); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto p-1 m-1">
                <form onsubmit="borrar(); return false" id="delete">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <button class="btn p-1" type="submit"><i class="fa-regular fa-trash-can text-danger"></i></button>
                </form>
                <script>
                  function borrar()
                  {	
                    $.ajax({
                    type: 'POST',
                    url: '../Ajax/tecnico/consulta_borrar.php',
                    data: $('#delete').serialize(),
                    success: function(data) {
                      if(data=='ok')
                      {
                        $('#consulta_msj').load('../Ajax/tecnico/consultas.php')
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
                  <p class="text-left m-1"><?php echo utf8_decode($row['consulta']); ?></p>
                  <p class="text-left m-1" style="font-size:0.75rem;"><?php echo Fecha12($row['cuando']); ?></p>
                </div>
              </div>
            </div>
          <?php
        }
      }
    ?>
  </div>
</div>