<?php 
  include('../db.php');
  session_start();
  $nombre  = $_SESSION['nombre'];
  $apellido  = $_SESSION['apellido'];
  $quien_notas  = $nombre .' ' .$apellido;
  
  $data = array();
  $result  = mysqli_query($conn, "SELECT * FROM calendario WHERE quien  : '$quien_notas'");    
  while($row =$result->fetch_assoc())
  {
    echo "{";
    echo "title: '" .$row['titulo'] ."',";
    echo "start: '" .$row['inicio'] ."',";
    echo "end: '" .$row['fin'] ."',";
    echo "contenido: '" .$row['contenido'] ."',";
    echo "token: '" .$row['token'] ."',";
    echo "tecnico: '" .$row['quien'] ."',";
    echo "estado: '" .$row['estado'] ."',";
    echo "color: '" .$row['color'] ."',";
    echo "titulo: '" .$row['titulo'] ."',";
    echo "obs: '" .$row['obs'] ."',";
    echo "tarea: '" .$row['tarea'] ."',";
    echo "tecnico: '" .$row['tecnico'] ."',";
    echo "a_quien: '" .$row['a_quien'] ."',";
    echo "tomado_por: '" .$row['tomado_por'] ."',";
    echo "},";
  }