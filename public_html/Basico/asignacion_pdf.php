<?php
  include("../db.php");
  require '../vendor/autoload.php';
  use Spipu\Html2Pdf\Html2Pdf;
	ob_start();
  $ttoken = $_GET['token'];
  $mm = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE token = '$ttoken' AND tipo = 'Asignacion' LIMIT 1");
  while($row = mysqli_fetch_assoc($mm))
  { 
    $tecnico =  $row['tecnico'];
    $fecha =  $row['fecha'];
    $nombreImagen = "../Image/logo.png";
    $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
?>
  <style>
    table, th, td {
    border: 1.5px solid black;
    border-collapse: collapse;
    }
    tbody.alt, tr:nth-child(even) {
    background-color: red;
    color: blue;
    }
    tbody.alt, tr:nth-child(odd) {
    background-color: green;
    color: red;
    }
    .header{
      color: #fff;
    }
  </style>
  <body>
    <img src="<?php echo $imagenBase64; ?>" width="120" height="60">
    <br>
    <br>
    <table>
        <tr bgcolor="#444" class="header">
          <th colspan="13"><?php echo $tecnico .' ( ' .Fecha7($fecha) .' )'; ?></th>
        </tr>
        <tr>
          <th>Materiales</th>
          <th align="center">Entregado</th>
          <th align="center" width="25">OT<br>1</th>
          <th align="center" width="25">OT<br>2</th>
          <th align="center" width="25">OT<br>3</th>
          <th align="center" width="25">OT<br>4</th>
          <th align="center" width="25">OT<br>5</th>
          <th align="center" width="25">OT<br>6</th>
          <th align="center" width="25">OT<br>7</th>
          <th align="center" width="25">OT<br>8</th>
          <th align="center" width="25">OT<br>9</th>
          <th align="center" width="25">OT<br>10</th>
          <th align="center" width="45">Total</th>
        </tr>
        <?php
          $mmm = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE token = '$ttoken' AND tipo = 'Asignacion'");
          while($roww = mysqli_fetch_assoc($mmm))
          { 
        ?>
          <tr>
            <td><?php if($roww['seriado'] == '') {echo utf8_decode($roww['material']);}else{echo $roww['seriado'];}; ?></td>
            <td align="center"><?php echo $roww['cantidad']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        <?php } ?>
    </table>
  </body>
<?php
  }
	$html = ob_get_clean();
  if (isset($_GET['token']))
  {
    $html2pdf = new Html2pdf('P', 'A4', 'es', 'true', 'UTF-8');
    $html2pdf->writeHTML($html);
    $html2pdf->output( $fecha . ' - ' .$tecnico .'.pdf');
  }
?>