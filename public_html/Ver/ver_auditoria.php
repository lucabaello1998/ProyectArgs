<?php include("../db.php"); ?>
<!-----Supervisor---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$supervisor = $nombre ." " .$apellido;
}

?>


<?php include('../includes/header.php'); ?>
<?php
$mes = "20" .date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = "20" .date ('y-m', strtotime($mes1));
}
?>

<?php 
if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM auditoria WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $identificador = $row['identificador'];
    $super = $row['supervisor'];
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $aire = $row['aire'];
    $alargue = $row['alargue'];
    $alcohol = $row['alcohol'];
    $alicate = $row['alicate'];
    $arnes = $row['arnes'];
    $campera = $row['campera'];
    $casco = $row['casco'];
    $celular = $row['celular'];
    $chomba = $row['chomba'];
    $pasacable = $row['pasacable'];
    $cleaver = $row['cleaver'];
    $conos = $row['conos'];
    $crimpeadora = $row['crimpeadora'];
    $dest_phillips = $row['dest_phillips'];
    $dest_plano = $row['dest_plano'];
    $tension = $row['tension'];
    $enduido = $row['enduido'];
    $escalera_chica = $row['escalera_chica'];
    $escalera_grande = $row['escalera_grande'];
    $escoba = $row['escoba'];
    $fibron = $row['fibron'];
    $gafas = $row['gafas'];
    $gorra = $row['gorra'];
    $alta_tension = $row['alta_tension'];
    $guante_trabajo = $row['guante_trabajo'];
    $lapiz_limpiador = $row['lapiz_limpiador'];
    $lapiz_optico = $row['lapiz_optico'];
    $linga = $row['linga'];
    $martillo = $row['martillo'];
    $mecha6 = $row['mecha6'];
    $mecha_pasante = $row['mecha_pasante'];
    $pala = $row['pala'];
    $pantalon = $row['pantalon'];
    $panos = $row['panos'];
    $peladora_fo = $row['peladora_fo'];
    $peladora_uni = $row['peladora_uni'];
    $percutora = $row['percutora'];
    $pinza = $row['pinza'];
    $silicona = $row['silicona'];
    $power = $row['power'];
    $tel = $row['tel'];
    $tester_rj = $row['tester_rj'];
    $tijera = $row['tijera'];
    $zapatos = $row['zapatos'];
    $bolso_kit = $row['bolso_kit'];
    $bolso_cleaver = $row['bolso_cleaver'];
    $caja = $row['caja'];
    $obs = $row['obs'];
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
    $imagentercera = $row['imagenter'];
    $imagencuarta = $row['imagencuar'];


  }
}
?>


<div class="container p-2">
  <div class="row">
    <div class="col-md">
      <div class="card card-body">
        <p class="h3 mb-4 text-center">Auditoria <?php echo $identificador; ?></p>
        <p class="h5 mb-4 text-center">el <?php echo $fecha ?></p>
        <p class="h6 mb-4 text-center">por <?php echo $super ?></p>
        <br>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Tecnico:</b> <?php echo $tecnico; ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Aire:</b> <?php if ($aire == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($aire == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Alargue:</b> <?php if ($alargue == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alargue == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Alcohol:</b> <?php if ($alcohol == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alcohol == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Alicate:</b> <?php if ($alicate == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alicate == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Celular:</b> <?php if ($celular == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($celular == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Pasacable:</b> <?php if ($pasacable == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pasacable == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Conos:</b> <?php if ($conos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($conos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Crimpeadora:</b> <?php if ($crimpeadora == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($crimpeadora == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Destornillador phillips:</b> <?php if ($dest_phillips == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($dest_phillips == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Destornillador plano:</b> <?php if ($dest_plano == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($dest_plano == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Detector de tension:</b> <?php if ($tension == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tension == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Enduido:</b> <?php if ($enduido == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($enduido == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Escalera chica:</b> <?php if ($escalera_chica == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escalera_chica == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Escalera grande:</b> <?php if ($escalera_grande == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escalera_grande == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Escoba:</b> <?php if ($escoba == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escoba == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Fibron:</b> <?php if ($fibron == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($fibron == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Linga:</b> <?php if ($linga == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($linga == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Martillo:</b> <?php if ($martillo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($martillo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Mecha de 6":</b> <?php if ($mecha6 == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($mecha6 == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Mecha pasante:</b> <?php if ($mecha_pasante == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($mecha_pasante == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Pala:</b> <?php if ($pala == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pala == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Peladora universal:</b> <?php if ($peladora_uni == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_uni == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Percutora:</b> <?php if ($percutora == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($percutora == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Pinza:</b> <?php if ($pinza == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pinza == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Silicona:</b> <?php if ($silicona == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($silicona == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Telefono de prueba:</b> <?php if ($tel == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tel == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Tester RJ45:</b> <?php if ($tester_rj == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tester_rj == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Tijera:</b> <?php if ($tijera == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tijera == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>


        <p class="h3 mb-4 text-center">FO</p>
        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Cleaver:</b> <?php if ($cleaver == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($cleaver == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Lapiz optico:</b> <?php if ($lapiz_optico == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($lapiz_optico == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Lapiz limpiador:</b> <?php if ($lapiz_limpiador == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($lapiz_limpiador == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Paños:</b> <?php if ($panos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($panos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>        

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Peladora de FO:</b> <?php if ($peladora_fo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_fo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Peladora universal:</b> <?php if ($peladora_uni == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_uni == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Power:</b> <?php if ($power == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($power == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        

        





        <p class="h3 mb-4 text-center">EPP e indumentaria</p>
        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Arnes:</b> <?php if ($arnes == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($arnes == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Campera:</b> <?php if ($campera == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($campera == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">          
          <div class="col-6">      
              <p class="h5 text-start"><b>Casco:</b> <?php if ($casco == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($casco == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Chomba:</b> <?php if ($chomba == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($chomba == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Gafas:</b> <?php if ($gafas == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($gafas == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Guantes de alta tension:</b> <?php if ($alta_tension == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alta_tension == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Guante de trabajo:</b> <?php if ($guante_trabajo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($guante_trabajo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Gorra:</b> <?php if ($gorra == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($gorra == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>          
        </div>        

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Pantalon:</b> <?php if ($pantalon == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pantalon == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Zapatos:</b> <?php if ($zapatos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($zapatos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-12">      
              <p class="h5 text-start"><b>Observaciones:</b> <?php echo $obs; ?></p>      
          </div>
        </div>
        <br>

        <?php if ($imagenprimera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/herramientas/" .$imagenprimera; ?>" alt="<?php echo $imagenpri; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagensegunda == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/herramientas/" .$imagensegunda; ?>" alt="<?php echo $imagenseg; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagentercera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/herramientas/" .$imagentercera; ?>" alt="<?php echo $imagenter; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagencuarta == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/herramientas/" .$imagencuarta; ?>" alt="<?php echo $imagencuar; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


      </div>
    </div>
  </div>
</div>
<br>




<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>