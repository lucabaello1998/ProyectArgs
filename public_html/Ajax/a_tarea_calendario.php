<?php
include("../db.php");

$html = '';
$key = $_POST['key'];
 
$result = mysqli_query($conn,"SELECT * FROM garantias WHERE ot LIKE '%$key%' LIMIT 5");
if(mysqli_num_rows($result) > 0)
{
  while ($row = mysqli_fetch_assoc($result))
  {
    $id = $row['id'];
    $ot = $row['ot'];
    $tecnico = $row['tecnico'];
    $zona = $row['zona'];
    $direccion = $row['direccion'];
    $fechaint = $row['fechaint'];
    $fecharep = $row['fecharep'];
    $tecrep = $row['tecrep'];
    $coment = $row['coment'];

    $html .= '
              <div class="row justify-content-start p-1">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm">
                    <tbody class="thead-light">
                      <tr class="suggest-element" data="'.$id.'" id="equipo" style="cursor:pointer;">
                        <td>' .$tecnico .'</td>
                        <td>' .$ot .'</td>
                        <td>' .$direccion .'</td>
                        <td>' .Fecha7($fechaint).'</td>
                        <td>' .Fecha7($fecharep).'</td>
                        <td>' .$tecrep .'</td>
                        <td>' .$coment .'</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>';
  }
}
echo $html;
