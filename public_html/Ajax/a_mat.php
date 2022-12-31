<?php
include("../db.php"); 
if(isset($_POST['zona']))
{
  $zona = $_POST['zona'];
  ?>
    <div class="form-group col-10">
      <select type="text" name="material" class="form-control" required>
        <option disabled selected value="">Material...</option>
        <?php
          $a = mysqli_query($conn,"SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = '$zona'");
          while($roww = mysqli_fetch_assoc($a))
          {
            $materials = $roww['material'];
            $cantidads = $roww['cantidad'];

            $b = mysqli_query($conn,"SELECT * FROM ingresomaterial WHERE material = '$materials' AND deposito = '$zona' AND cantidad > 1 GROUP BY material ORDER BY material desc");
            while($row = mysqli_fetch_assoc($b))
            {
        ?>
            <option value="<?php echo $row['material']; ?>"><?php echo utf8_encode(utf8_decode($row['material'])); ?></option>';
        <?php } } ?>
      </select>
    </div>
    <div class="form-group col-2">
      <input type="number" name="cantidad" min="1" class="form-control" required>
    </div>
  <?php
}
else
{
  echo'';
}
