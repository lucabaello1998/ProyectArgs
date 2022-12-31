<?php
  include("../../db.php");
  // Archivo PHP para procesar la solicitud y devolver la respuesta
  // Recibir el ID del botón seleccionado
  if(isset($_POST["id"]))
  {
    $id = $_POST["id"];
  }
  if(isset($_POST["response"]))
  {
    $id = $_POST["response"];
  }

  // Consultar la base de datos para obtener la respuesta apropiada
  $con_tecnica = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE id = '$id'");
  while($row = mysqli_fetch_array($con_tecnica))
  {
    $token = $row['token'];
  }
  echo "<div class='row justify-content-center p-1 mt-2 mb-2'>";
    echo "<i class='fa-solid fa-sort-down fa-bounce' style='--fa-animation-duration: 3s;'></i>";
  echo "</div>";
  echo "<div class='row justify-content-start p-1 border-top border-bottom mt-2 mb-2 deshab'>";

    $con_tec = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE padre = '$token'");
    while($row = mysqli_fetch_array($con_tec))
    {
      $texto = $row['texto'];
      $id = $row['id'];
      $tipo = $row['tipo'];
      $copiable = $row['copiable'];
      $new_token = $row['token'];
      
      // Devolver la respuesta al cliente
      switch($tipo)
      {
        case 'Texto':
          if($copiable == 'Si')
          {
            echo "<div class='col-12 align-self-start p-1'>";
              echo "<p class='h6 text-info text-left copiar' data-copy='$texto' style='cursor: pointer;'>$texto</p>";
            echo "</div>";
          }
          else
          {
            echo "<div class='col-12 align-self-start p-1'>";
              echo "<p class='h6 text-muted text-left'>$texto</p>";
            echo "</div>";
          }
        break;
        case 'Boton':
          echo "<div class='col-auto p-1 align-self-start mt-2'>";
            echo "<button class='row rounded alert-primary shadow m-1 border' style='text-decoration: none;' data-id='$id'>";
              echo "<div class='col-12 p-2'>";
                echo "<p class='h6 text-muted text-center'>$texto</p>";
              echo "</div>";
            echo "</button>";
          echo "</div>";
        break;
        case 'Imagen':
          echo "<div class='col-auto p-1 mx-auto'>";
            echo '<img src="../../Archivos/consultas/' .$texto .'" class="rounded" alt="' .$texto .'" style=" max-width: 100%; max-height: 90vh; width: auto; height: auto;">';
          echo "</div>";
        break;
      }

      
    }
  echo "</div>";

  // Si no hay mas padres volvemos al inicio
  $con_tec_tok = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE padre = '$new_token'");

  // Si no hay mas opciones muestra los botones iniciales
  if(mysqli_num_rows($con_tec_tok) == 0)
  {
    echo "<div class='row justify-content-center p-1 mt-2 mb-2'>";
      echo "<i class='fa-solid fa-sort-down fa-bounce' style='--fa-animation-duration: 3s;'></i>";
    echo "</div>";
    echo "<div class='row justify-content-center p-1 border-top border-bottom mt-2 mb-2'>";
      echo "<div class='col-12 align-self-start p-1'>";
        echo "<p class='h6 text-muted text-left'>¿Desea realizar otra consulta?</p>";
      echo "</div>";
      $con_tec_inicial = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE nivel = 'Inicial'");
      while($row_inicial = mysqli_fetch_array($con_tec_inicial))
      {
        $texto_inicial = $row_inicial['texto'];
        $id_inicial = $row_inicial['id'];
        echo "<div class='col-auto align-self-start p-4 inicial'>";
          echo "<button class='row rounded alert-success shadow m-1 border' style='text-decoration: none;' data-id='$id_inicial'>";
            echo "<div class='col-12 p-2'>";
              echo "<p class='h6 text-muted text-left'>$texto_inicial</p>";
            echo "</div>";
          echo "</button>";
        echo "</div>";
      }
    echo "</div>";
  }  
?>