<?php
include("../db.php"); 
if(isset($_POST['zona']))
{
  $zona_mat = $_POST['zona'];
  $tecnico_mat = $_POST['tecnico'];
  $fecha_mat = $_POST['fecha'];
  $result = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$fecha_mat' AND tecnico = '$tecnico_mat' AND deposito = '$zona_mat' AND tipo = 'Asignacion' ORDER BY material asc ");
  if (mysqli_num_rows($result) >= 1)  /* SI HAY MAS DE UN ELEMENTO PARA MOSTRAR */
  {
    echo'<div class="row">
              <div class="col-8">
                <label><b>Material</b></label>
              </div>
              <div class="col-2">
                <label><b>Restante</b></label>
              </div>
              <div class="col-2">
                <label><b>Usado</b></label>
              </div>
            </div>';
    while($op_mat = mysqli_fetch_array($result))
    {	
      $sapll = $op_mat['sap'];
      $materiall = $op_mat['material'];
      $seriall = $op_mat['seriado'];
      $tokenll = $op_mat['token'];

      if($seriall == '')
      {
        $cc_m="SELECT SUM(usado) as 'resto_usado' FROM asignacion_material WHERE fecha = '$fecha_mat' AND tecnico = '$tecnico_mat' AND deposito = '$zona_mat' AND tipo = 'Descarga' AND material = '$materiall' ";
        $rrr = mysqli_query($conn, $cc_m);
        while($op = mysqli_fetch_array($rrr))
        {

          $restante_m = $op_mat['cantidad'] - $op['resto_usado'];
          
          echo'<div class="form-row">
                <div class="form-group col-8">
                  <input type="hidden" name="material[]" value="' .$materiall .'">
                  <input type="hidden" name="sap[]" value="' .$sapll .'">
                  <input type="hidden" name="seriado[]" value="' .$seriall .'">
                  <input type="hidden" name="token" value="' .$tokenll .'">
                  <label for="exampleFormControlSelect1">' .$materiall .'</label >
                </div>
                <div class="form-group col-2">
                  <span name="cantidad[]" class="form-control" readonly>' .$restante_m .'</span>
                </div>
                <div class="form-group col-2">
                  <input type="number" name="usado[]"'; if($restante_m == 0){echo 'readonly placeholder="' .$restante_m .'"' ;}  echo ' class="form-control" min="1" max="' .$restante_m .'" >
                </div>
              </div>';
        }
      }
      else
      {
        $cc_s="SELECT SUM(usado) as 'resto_usado_s' FROM asignacion_material WHERE fecha = '$fecha_mat' AND tecnico = '$tecnico_mat' AND deposito = '$zona_mat' AND tipo = 'Descarga' AND seriado = '$seriall' ";
        $rrr_s = mysqli_query($conn, $cc_s);
        while($ops = mysqli_fetch_array($rrr_s))
        {

          $restante_s = $op_mat['cantidad'] - $ops['resto_usado_s'];
          
          echo'<div class="form-row">
                <div class="form-group col-8">
                  <input type="hidden" name="material[]" value="' .$materiall .'">
                  <input type="hidden" name="sap[]" value="' .$sapll .'">
                  <input type="hidden" name="seriado[]" value="' .$seriall .'">
                  <input type="hidden" name="token" value="' .$tokenll .'">
                  <label for="exampleFormControlSelect1">' .$seriall .'</label >
                </div>
                <div class="form-group col-2">
                  <span name="cantidad[]" class="form-control" readonly>' .$restante_s .'</span>
                </div>
                <div class="form-group col-2">
                  <input type="number" name="usado[]"'; if($restante_s == 0){echo 'readonly placeholder="' .$restante_s .'"' ;}  echo ' class="form-control" min="1" max="' .$restante_s .'" >
                </div>
              </div>';
        }
      }      
    }
    echo '<div class="form-row p-2">
            <input type="submit" name="save_descarga" class="btn btn-success btn-block" value="Guardar descarga">
          </div>';
  }
  else
  {
    echo'No hay carga previa'; /* SI NO HAY ELEMENTOS PARA MOSTRAR */
  }
}
else
{
  echo'No hay carga previa';
}