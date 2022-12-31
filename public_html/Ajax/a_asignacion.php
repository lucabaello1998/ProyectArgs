<?php
include("../db.php"); 
header('Content-Type: text/html; charset=utf-8');
mysqli_set_charset( $conn, 'utf8' );

if(isset($_POST['zona']))
{
  $zona = $_POST['zona'];
  $a = mysqli_query($conn,"SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = '$zona' ");
  while($roww = mysqli_fetch_assoc($a))
  {
    $materials = $roww['material'];
    $cantidads = $roww['cantidad'];
    $b = mysqli_query($conn,"SELECT *, SUM(cantidad) as 'cant_mat' FROM ingresomaterial WHERE material = '$materials' AND deposito = '$zona' ORDER BY material asc ");
    while($row = mysqli_fetch_assoc($b))
    {
      if($cantidads <= $row['cantidad'])
      {
        ?>
          <div class="form-row">
            <div class="form-group col-10">
              <input type="hidden" name="material[]" value="<?php echo $row['material']; ?>">
              <input type="hidden" name="sap[]" value="<?php echo $row['sap']; ?>">
              <label><?php echo utf8_decode($row['material']); ?></label>
            </div>
            <div class="form-group col-2">
              <input type="number" name="cantidad[]" min="1" max="<?php echo $row['cantidad']; ?>" class="form-control" value="<?php echo $cantidads; ?>">
            </div>
          </div>
        <?php
      }
      else
      {
        if($row['cantidad'] > 0)
        {
          ?>
            <div class="form-row">
              <div class="form-group col-10">
                <input type="hidden" name="material[]" value="<?php echo $row['material']; ?>">
                <input type="hidden" name="sap[]" value="<?php echo $row['sap']; ?>">
                <label><?php echo utf8_decode($row['material']); ?></label >
              </div>
              <div class="form-group col-2">
                <input type="number" name="cantidad[]" min="1" max="<?php echo $row['cantidad']; ?>" class="form-control" value="<?php echo $row['cantidad']; ?>">
              </div>
            </div>
          <?php
        }
        else
        {
          ?>
            <div class="form-row">
              <div class="form-group col-10">
                <label><?php echo utf8_decode($row['material']); ?></label >
              </div>
              <div class="form-group col-2">
                <span>Sin cantidad</span>
              </div>
            </div>
          <?php
        }
      }
    }
  }
}
else
{
  echo'';
}
