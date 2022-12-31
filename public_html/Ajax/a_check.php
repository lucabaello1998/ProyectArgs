<?php
  include("../db.php");
  header('Content-Type: text/html; charset=utf-8');
  mysqli_set_charset( $conn, 'utf8' );
  $token = $_GET['token'];
?>
    <?php 
      $sub_t = mysqli_query($conn, "SELECT * FROM tareas WHERE token = '$token' AND sub_tarea <> '' ORDER BY id desc");
      while($row_sub = mysqli_fetch_assoc($sub_t))
      {
        $id = $row_sub['id'];
    ?>
      <form onsubmit="check<?php echo $id; ?>(); return false" id="form<?php echo $id; ?>">
        <div class="input-group mb-1">
          <div class="input-group-prepend p-1">
            <?php if($row_sub['sub_estado'] == 'Pendiente'){ ?>
              <button class="btn p-0" type="submit" id="<?php echo 'sub' .$id; ?>"><i class="fa-solid fa-circle text-danger h5 m-0 p-0"></i></button>
            <?php } else { ?>
              <button class="btn p-0" type="submit" id="<?php echo 'sub' .$id; ?>"><i class="fa-regular fa-circle-check text-success h5 m-0 p-0"></i></button>
            <?php } ?>
          </div>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="row align-items-center">
            <div class="col">
              <span class="pl-2 align-items-center pb-2"><?php echo utf8_decode($row_sub['sub_tarea']); ?></span>
            </div>
          </div>
        </div>
      </form>
      <script>
        function check<?php echo $id; ?>()
        {	
          $.ajax({
          type: 'POST',
          url: '../Ajax/a_tarea_check.php',
          data: $('#form<?php echo $id; ?>').serialize(),
          success: function(data) {
            if(data=='checking')
            {
              $('#check<?php echo $row_sub['token']; ?>').load('../Ajax/a_check.php?token=<?php echo $row_sub['token']; ?>')
            }
          }
          });
        }
      </script>
    <?php } ?>
