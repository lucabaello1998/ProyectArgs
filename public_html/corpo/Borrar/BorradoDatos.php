<?php include("../../db.php"); ?>
<?php include('../include/header.php'); ?>
<!-----Deposito---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../indexcorpo.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
?>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">

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

<tbody align="center">
          <?php
          $query = "SELECT * FROM corpo WHERE ID ORDER BY ID DESC"; /* CONSULTA EDITADA "WHERE INICIOtareas[columna de la tabla donde aplicar filtro] = 'Alta'" */ /* "CLIENTE descendiente" ORDER BY CERTIFICACION[columna en cual CLIENTEar] DESC  */
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>
              <td align="center">
                <a href="../Editar/edit_altas.php?id=<?php echo $row['id']?>">
                  <i class="fas fa-pen p-2"></i>
                </a>
                <a href="BorradoDatos.php?id=<?php echo $row['id']?>">
                  <i class="far fa-trash-alt p-2"></i>
                </a>
              </td>
              <td><?php echo $row['ID']; ?></td>         
              <td><?php echo $row['CT']; ?></td>
              <td><?php echo $row['FECHA']; ?></td>
              <td><?php echo $row['TAREA']; ?></td>
              <td><?php echo $row['CLIENTE']; ?></td>
              <td><?php echo $row['ORDEN']; ?></td>
              <td><?php echo $row['ENLACE']; ?></td>
              <td><?php echo $row['ASIGNADO']; ?></td>
              <td><?php echo $row['CERTIFICACION']; ?></td>
              <td><?php echo $row['LINK_SYTEX']; ?></td>
          <?php } ?>
        </tbody>
