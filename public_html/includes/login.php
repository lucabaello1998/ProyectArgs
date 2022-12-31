<?php
include("../db.php");
if(isset($_POST['iniciar']))
{
  $usuario = $_POST['usuario'];
  $pass = $_POST['pass'];
  $recordar = $_POST['recordar'];
	if(preg_match('/^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/',$_POST['usuario']))
	{
		if(preg_match('/^[0-9a-zA-Z]+$/',$_POST['pass']))
		{
      $query = "SELECT count(usuario) as 'uss' FROM usuarios WHERE BINARY usuario = '$usuario'";
      $result = mysqli_query($conn, $query);
      while($row = mysqli_fetch_array($result))
      { 
        $a = $row['uss'];
        if($a==1)
        {	
          $query_us = "SELECT count(pass) as 'pss', nombre, apellido, tipo_us, zona, tema, fuente, icono FROM usuarios WHERE BINARY usuario = '$usuario' AND BINARY pass = '$pass'";
          $result_us = mysqli_query($conn, $query_us);
          while($row = mysqli_fetch_array($result_us))
          {
            $b = $row['pss'];
            $c = $row['nombre'];
            $d = $row['apellido'];
            $e = $row['tipo_us'];
            $f = $row['zona'];
            $g = $row['tema'];
            $h = $row['fuente'];
            $i = $row['icono'];
            if($b==1)
            {
              $_SESSION['nombre'] = $c;
              $_SESSION['apellido'] = $d;
              $_SESSION['tipo_us'] = $e;
              $_SESSION['zona'] = $f;
              $_SESSION['tema'] = $g;
              $_SESSION['fuente'] = $h;
              $_SESSION['icono'] = $i;
              if($recordar == 'SI')
              {
                $_SESSION['recordar'] = 'SI';
                $_SESSION['user'] = $usuario;
                $_SESSION['password'] = $pass;
              }
              else
              {
                $_SESSION['recordar'] = 'NO';
              }
              if($e=='ATC')
              {header('Location: ../ATC/indexatc.php');}
              else
              {
                $_SESSION['nombre'] = $c;
                $_SESSION['apellido'] = $d;
                $_SESSION['tipo_us'] = $e;
                $_SESSION['zona'] = $f;
                $_SESSION['tema'] = $g;
                $_SESSION['fuente'] = $h;
                $_SESSION['icono'] = $i;

                if($e == 'Administrador')
                {
                  header('Location: ../inicio_administrador.php');
                }
                else
                {
                  if($e == 'Tecnico')
                  {
                    header('Location: /tecnico/index.php');
                  }
                  else
                  {
                    $quien_notas = $c .' ' .$d;
                    $hoy_es = date("Y-m-j");
                    $asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien LIKE '$quien_notas%' AND movimiento = 'Inicio' AND pag = '' AND inicio = '$hoy_es' ");
                    if(mysqli_num_rows($asis) > 0)
                    {
                      switch ($e)
                      {
                        case 'Despacho': header('Location: ../inicio_despacho.php');
                        break;
                        case 'Supervisor': header('Location: ../inicio_supervisor.php');
                        break;
                        case 'Deposito': header('Location: ../inicio_deposito.php');
                        break;
                      }
                    }
                    else
                    {
                      header('Location: ./asistencia.php');
                    }
                  }
                  
                }
              }
            }
            else
            {
              $_SESSION['mensaje'] = "Contraseña incorrecta";
              $_SESSION['colorus'] = "border-success";
              $_SESSION['colorpass'] = "border-danger";
              $_SESSION['usuario'] = $usuario;
              $_SESSION['pass'] = $pass;
              header('Location: ../index.php');
            }
          }
        }
        else
        {
          $_SESSION['mensaje'] = "Usuario incorrecto";
          $_SESSION['colorus'] = "border-danger";
          $_SESSION['colorpass'] = "border-danger";
          $_SESSION['usuario'] = $usuario;
          $_SESSION['pass'] = $pass;
          header('Location: ../index.php');	
        }
      }
		}
		else
		{
      $_SESSION['mensaje'] = "Caracteres no permitidos";
			$_SESSION['colorus'] = "border-danger";
			$_SESSION['colorpass'] = "border-danger";
			$_SESSION['usuario'] = $usuario;
			$_SESSION['pass'] = $pass;
			header ('Location: ../index.php');
		}
	}
	else
	{
    $_SESSION['mensaje'] = "Caracteres no permitidos";
		$_SESSION['colorus'] = "border-danger";
		$_SESSION['colorpass'] = "border-danger";
		$_SESSION['usuario'] = $usuario;
		$_SESSION['pass'] = $pass;
		header('Location: ../index.php');
	}
	$_SESSION['usuario'] = $usuario;
	$_SESSION['pass'] = $pass;
}
else
{
  $user = mysqli_query($conn, "SELECT * FROM usuarios");
  while($row = mysqli_fetch_assoc($user))
  {
    if($_COOKIE['U'] == sha1($row['usuario']) && $_COOKIE['P'] == sha1($row['pass']))
    {
      $_SESSION['nombre'] = $row['nombre'];
      $_SESSION['apellido'] = $row['apellido'];
      $_SESSION['tipo_us'] = $row['tipo_us'];
      $_SESSION['zona'] = $row['zona'];
      $_SESSION['tema'] = $row['tema'];
      $_SESSION['fuente'] = $row['fuente'];
      $_SESSION['icono'] = $row['icono'];
      if($row['tipo_us'] == 'ATC')
        {
          header('Location: ../ATC/indexatc.php');
        }
        else
        {
          if($row['tipo_us'] == 'Administrador')
          {
            header('Location: /inicio_administrador.php');
          }
          else
          {
            if($row['tipo_us'] == 'Tecnico')
            {
              header('Location:  /tecnico/index.php');
            }
            else
            {
              $quien_notas = $row['nombre'] .' ' .$row['apellido'];
              $hoy_es = date("Y-m-j");
              $asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien LIKE '$quien_notas%' AND movimiento = 'Inicio' AND pag = '' AND inicio = '$hoy_es' ");
              if(mysqli_num_rows($asis) > 0)
              {
                switch ($row['tipo_us'])
                {
                  case 'Despacho': header('Location: /inicio_despacho.php');
                  break;
                  case 'Supervisor': header('Location: /inicio_supervisor.php');
                  break;
                  case 'Deposito': header('Location: /inicio_deposito.php');
                  break;
                }
              }
              else
              {
                header('Location: ./asistencia.php');
              }
            }
          }
        }
    }
  }
}
?>